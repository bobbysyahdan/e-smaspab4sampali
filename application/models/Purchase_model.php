<?php 

class Purchase_model extends CI_model {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Book_stock_model');
        $this->load->model('Midtrans_model');
        $this->load->model('Cart_model');
        $this->load->model('Voucher_model');
        $this->load->model('Ref_transaction_status_model');
    }
    
    // API
    public function getAllPurchase($page, $limit, $id_user)
    {
        $is_login = $this->User_model->getById($id_user)['is_login'];
        if($is_login == 1) {
            $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]".'/upload/book/';
            $this->db->select("
            book_identities.title AS title,
            book_identities.id AS id_book,
            book_identities.content AS content,
            purchases.book_type AS book_type,
            purchases.id_status AS id_status,
            purchases.id AS id_purchase,
            purchases.quantity AS quantity,
            transactions.total_price AS total_price,
            purchases.id_transaction AS id_transaction,
            purchases.created_at AS created_at,
            concat('$url', book_identities.cover_image) AS url_cover_image");
            $this->db->from('purchases');
            $this->db->where('purchases.id_user', $id_user);
            $this->db->order_by('purchases.id','ASC');
            $this->db->join('book_stocks', 'book_stocks.id = purchases.id_book_stock');
            $this->db->join('book_identities', 'book_identities.id = purchases.id_book_stock');
            $this->db->join('transactions', 'transactions.id = purchases.id_transaction');
            $this->db->join('ref_purchase_status', 'ref_purchase_status.id = purchases.id_status');
            
            if ($limit != null && $page != null) {
                if($page == 1) {
                    $offset = 0;
                } else {
                    $offset = ($page-1) * $limit;
                }
                $this->db->limit($limit, $offset);
            }
            $query = $this->db->get()->result_array();
            return $query;
        }
    }

    public function getCheckAllPurchase()
    {
        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]".'/upload/book/';
        $this->db->select("*, 
        purchases.id AS id,
        purchases.id_status AS id_status_purchase,
        transactions.id_status AS id_status_transaction,
        purchases.id AS id_purchase, concat('$url', book_identities.cover_image) AS url_cover_image, concat('$url', book_identities.file_uploaded) AS url_file_uploaded");
        $this->db->from('purchases');
        $this->db->order_by('purchases.id','ASC');
        $this->db->join('book_stocks', 'book_stocks.id = purchases.id_book_stock');
        $this->db->join('book_identities', 'book_identities.id = purchases.id_book_stock');
        $this->db->join('transactions', 'transactions.id = purchases.id_transaction');
        $this->db->join('ref_purchase_status', 'ref_purchase_status.id = purchases.id_status');
        
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function addPurchaseBookAPI($id_user)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date_time = date('y-m-d H:i:s');
        $total_price = 0;
        foreach ($this->input->post() as $key => $id_cart) {
            if($key != "book_type" && $key != "id_user"  && $key != "voucher_code") {
                $cart = $this->db->where('id', $id_cart)->where('id_user', $id_user)->get('carts')->row_array();
                $book_stock = $this->db->get_where('book_stocks', ['id' => $cart['id_book_stock']])->row_array();
                $total_price += $cart['price'];
            }
        }
        $price = $total_price;

        $voucher_code = $this->input->post('voucher_code');
        if(isset($voucher_code)) {
            $voucher = $this->Voucher_model->getByVoucherCode($voucher_code);
            if($voucher) {
                $discount = ($voucher['percentage_discount'] / 100) * $total_price;
                $total_price = $total_price - $discount;
                $data_transaction = [
                    "no_order" => rand(),
                    "id_status" => 1,
                    "total_price" => $total_price,
                    "price" => $price,
                    "discount" => $discount,
                    "id_voucher" => $voucher['id'],
                    "book_type" => $this->input->post()['book_type'],
                    "created_at" => $date_time,
                    "updated_at" => $date_time,
                    "dibaca_user" => 1,
                    "dibaca_admin" => 0,
                ];
            } else {
                $data_transaction = [
                    "no_order" => rand(),
                    "id_status" => 1,
                    "total_price" => $total_price,
                    "price" => $price,
                    "book_type" => $this->input->post()['book_type'],
                    "created_at" => $date_time,
                    "updated_at" => $date_time,
                    "dibaca_user" => 1,
                    "dibaca_admin" => 0,
                ];
            }
        } else {
            $data_transaction = [
                "no_order" => rand(),
                "id_status" => 1,
                "total_price" => $total_price,
                "price" => $price,
                "book_type" => $this->input->post()['book_type'],
                "created_at" => $date_time,
                "updated_at" => $date_time,
                "dibaca_user" => 1,
                "dibaca_admin" => 0,
            ];
        }

        $this->db->insert('transactions', $data_transaction);
        $id_transaction = $this->db->insert_id();
        foreach($this->input->post() as $key => $id_cart) {
            if($key != "book_type" && $key != "id_user" && $key != "voucher_code") {
                $cart = $this->db->where('id', $id_cart)->where('id_user', $id_user)->get('carts')->row_array();
                if(isset($cart)) {
                    $data_purchase = [
                        "id_transaction" => $id_transaction,
                        "id_book_stock" => $cart['id_book_stock'],
                        "id_user" => $id_user,
                        "quantity" => $cart['quantity'],
                        "price" => $cart['price'],
                        "purchase_date" => date('y-m-d'),
                        "book_type" => $this->input->post()['book_type'],
                        "id_status" => 1,
                        "created_at" => $date_time,
                        "updated_at" => $date_time,
                        "dibaca_user" => 1,
                        "dibaca_admin" => 0,
                    ];
                    $this->db->insert('purchases', $data_purchase);
                    $id_purchase = $this->db->insert_id();
                    if(isset($id_purchase)) {
                        $this->Cart_model->delete($id_cart);
                    }
                }
            }
        }
        return $id_transaction;
    }


    // Dashboard
    public function getAll()
    {
        $this->db->select("*, DATE_FORMAT(purchases.updated_at,'%d-%m-%Y %H:%i:%s') AS waktu");
        $this->db->order_by('purchases.created_at','DESC');
        $query = $this->db->get('purchases');
        return $query->result_array();
        // $query = $this->db->select('*')->group_by('id_transaction')->order_by('total', 'desc')->get('purchases');
        // echo "<pre>";
        // print_r($query->result_array());
        // echo "</pre>";
        // exit();
    }

    public function getAllSettlement()
    {
        $query = $this->db->get_where('purchases', ['id_status' => 3]);
        return $query->result_array();
    }

    public function getAllCanceled()
    {
        $query = $this->db->get_where('purchases', ['id_status' => 4]);
        return $query->result_array();
    }

    public function addPurchaseBook()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date_time = date('y-m-d H:i:s');
        $total_price = 0;
        // $total_weight = 0;
        foreach ($this->input->post() as $key => $post_cart) {
            if($key != "book_type") {
                $cart = $this->db->get_where('carts', ['id' => $post_cart])->row_array();
                $book_stock = $this->db->get_where('book_stocks', ['id' => $cart['id_book_stock']])->row_array();
                $total_price += $cart['price'];
                // $total_weight += $book_stock['weight'] * $cart['quantity'];
            }
        }

        $data_transaction = [
            "no_order" => rand(),
            "id_status" => 1,
            "total_price" => $total_price,
            // "total_weight" => $total_weight,
            "book_type" => $this->input->post()['book_type'],
            "created_at" => $date_time,
            "updated_at" => $date_time,
        ];
        
        $this->db->insert('transactions', $data_transaction);
        $id_transaction = $this->db->insert_id();
        foreach($this->input->post() as $key => $id_cart) {
            if($key != "book_type") {
                $cart = $this->db->get_where('carts', ['id' => $id_cart])->row_array();
                $data_purchase = [
                    "id_transaction" => $id_transaction,
                    "id_book_stock" => $cart['id_book_stock'],
                    "id_user" => $this->session->userdata('id'),
                    "quantity" => $cart['quantity'],
                    "price" => $cart['price'],
                    "purchase_date" => date('y-m-d'),
                    "book_type" => $this->input->post()['book_type'],
                    "id_status" => 1,
                    "created_at" => $date_time,
                    "updated_at" => $date_time,
                ];
                $this->db->insert('purchases', $data_purchase);
                $this->Cart_model->delete($id_cart);

            }
        }
        return $id_transaction;
    }

    public function create()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date_time = date('y-m-d H:i:s');
        $data = [
            "id_user" => $this->input->post('id_user', true),
            "id_book_stock" => $this->input->post('id_book_stock', true),
            "quantity" => $this->input->post('quantity', true),
            "price" => $this->input->post('price', true),
            "created_at" => $date_time,
            "updated_at" => $date_time,
        ];
        $this->db->insert('purchases', $data);
    }

    public function updateDeliveryProgress($id)
    {
        $date = date('y-m-d');
        $data = [
            "id_status" => 2,
            "purchase_date" => $date,
            "dibaca_user" => 0,
            "dibaca_admin" => 0,
        ];
        $this->db->where('id', $id);
        $this->db->update('purchases', $data);
    }

    public function updateDelivered($id)
    {
        $date = date('y-m-d');
        $data = [
            "id_status" => 3,
            "purchase_date" => $date,
            "dibaca_user" => 0,
            "dibaca_admin" => 0,
        ];
        $this->db->where('id', $id);
        $this->db->update('purchases', $data);
    }

    public function updatePayment($id)
    {
        $data = [
            "id_status" => 1,
        ];
        $this->db->where('id', $id);
        $this->db->update('purchases', $data);
    }

    public function updateCanceled($id)
    {
        $data = [
            "id_status" => 4,
        ];
        $this->db->where('id', $id);
        $this->db->update('purchases', $data);
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('purchases'); 
    }

    public function cancel($id)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date_time = date('y-m-d H:i:s');
        $data = [
            "id_user" => $this->input->post('id_user', true),
            "updated_at" => $date_time,
        ];
        $this->db->where('id', $id);
        $this->db->update('purchases', $data);
    }

    public function getById($id)
    {
        $this->db->select('*, purchases.id AS id_purchase');
        $this->db->from('purchases');
        $this->db->where('purchases.id', $id);
        $this->db->order_by('purchases.id','ASC');
        $this->db->join('book_stocks', 'book_stocks.id = purchases.id_book_stock');
        $this->db->join('book_identities', 'book_identities.id = purchases.id_book_stock');
        $query = $this->db->get()->row_array();
        return $query;
    }

    public function getBookStock($id)
    {
        $purchase = $this->db->get_where('purchases', ['id' => $id])->row_array();
        $query = $this->db->get_where('book_stocks', ['id' => $purchase['id_book_stock']]);
        return $query->row_array();
    }

    public function getBook($id)
    {
        $purchase = $this->db->get_where('purchases', ['id' => $id])->row_array();
        $book_stock = $this->db->get_where('book_stocks', ['id' => $purchase['id_book_stock']])->row_array();
        $book = $this->db->get_where('book_identities', ['id' => $book_stock['id_book']])->row_array();
        return $book;
    }

    // public function getBookType($id)
    // {
    //     $book_stock = $this->db->get_where('book_stocks', ['id' => $id])->row_array();
    //     $book_type = $this->Book_stock_model->getBookTypes()[$book_stock['book_type']-1];
    //     return $book_type;
    // }

    public function getByIdUserIdBookIdStatus($id_user,$id_book,$id_status)
    {
        $this->db->select('*, purchases.id AS id_purchase');
        $this->db->from('purchases');
        $this->db->where('purchases.id_user', $id_user);
        $this->db->where('purchases.id_book_stock', $id_book);
        $this->db->where('purchases.id_status', $id_status);
        $this->db->join('book_stocks', 'book_stocks.id = purchases.id_book_stock');
        $this->db->join('book_identities', 'book_identities.id = purchases.id_book_stock');
        $this->db->join('transactions', 'transactions.id = purchases.id_transaction');
        $query = $this->db->get()->row_array();
        return $query;
    }

    public function getTransactionLevelStatus($id)
    {
        $transaction = $this->db->get_where('transactions', ['id' => $id])->row_array();
        $transaction_status = $this->db->get_where('ref_transaction_status', ['id' => $transaction['id_status']]);
        return $transaction_status->row_array();
    }

    public function getShippingBook($id_transaction)
    {
        $query = $this->db->get_where('shipping_books', ['id_transaction' => $id_transaction]);
        return $query->row_array();
    }

    public function getStatus($id_status)
    {
        $query = $this->db->get_where('ref_purchase_status', ['id' => $id_status]);
        return $query->row_array();
    }

    public function getEmailReader($id_transaction)
    {
        $query = $this->db->get_where('email_readers', ['id_transaction' => $id_transaction]);
        return $query->row_array();
    }

    public function getTransaction($id_transaction)
    {
        $query = $this->db->get_where('transactions', ['id' => $id_transaction]);
        return $query->row_array();
    }
    
    public function getByIdTransactions($id_transaction)
    {
        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]".'/upload/book/';
        $this->db->select("*,
        DATE_FORMAT(purchases.updated_at,'%d-%m-%Y %H:%i:%s') AS waktu,
        purchases.id_status AS status_purchase, purchases.id AS id_purchase, concat('$url', book_identities.cover_image) AS url_cover_image, concat('$url', book_identities.file_uploaded) AS url_file_uploaded");
        $this->db->from('purchases');
        $this->db->where('id_transaction', $id_transaction);
        $this->db->join('book_stocks', 'book_stocks.id = purchases.id_book_stock');
        $this->db->join('transactions', 'transactions.id = purchases.id_transaction');
        $this->db->join('book_identities', 'book_identities.id = purchases.id_book_stock');
        $this->db->order_by('transactions.created_at','DESC');
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getByIdTransaction($id_transaction)
    {
        $query = $this->db->get_where('purchases', ['id_transaction' => $id_transaction]);
        return $query->row_array();
    }

    public function getTotalBookWeight($id_transaction)
    {
        $purchases = $this->Purchase_model->getByIdTransactions($id_transaction);
        $total_weight = 0;
        
        foreach($purchases as $purchase) {
            $book_stock = $this->Book_stock_model->getById($purchase['id_book']);
            $total_weight += $book_stock['weight'] * $purchase['quantity'];
        }
        
        return $total_weight;
    }

    public function getTotalBookPrice($id_transaction)
    {
        $purchases = $this->Purchase_model->getByIdTransactions($id_transaction);
        $total_price = 0;
        
        foreach($purchases as $purchase) {
            $book_stock = $this->Purchase_model->getBookStock($purchase['id']);
            $total_price += $book_stock['price'] * $purchase['quantity'];
        }
        return $total_price;
    }

    public function getNotificationAdmin()
    {
        $this->db->select('*, purchases.id AS id_purchase,
        DATE_FORMAT(purchases.updated_at, "%d-%m-%Y %H:%i:%s") AS waktu');
        $this->db->from('purchases');
        $this->db->where('purchases.id_status !=', 1);
        $this->db->where('purchases.id_status !=', 4);
        $this->db->where('purchases.dibaca_admin', 0);
        $this->db->order_by('purchases.id','ASC');
        $this->db->join('book_stocks', 'book_stocks.id = purchases.id_book_stock');
        $this->db->join('users', 'users.id = purchases.id_user');
        $this->db->join('book_identities', 'book_identities.id = purchases.id_book_stock');
        $this->db->order_by('purchases.updated_at','DESC');
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function updateDibaca()
    {
        $purchases = $this->Purchase_model->getAll();
        foreach($purchases as $purchase) {
            date_default_timezone_set('Asia/Jakarta');
            $date_time = date('y-m-d H:i:s');
            $data = [
                "dibaca_admin" => 1,
                "updated_at" => $date_time,
            ];
            $this->db->where('id', $purchase['id']);
            $this->db->update('purchases', $data);
        }
    }
}

?>