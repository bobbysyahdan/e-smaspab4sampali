<?php 

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;


class Transaction_model extends CI_model {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Midtrans_model');
        $this->load->model('Purchase_model');
        $this->load->model('Transaction_model');
        $this->load->model('Email_reader_model');
        $this->load->model('Shipping_book_model');
    }

    // API
    public function getAllTransaction($page, $limit, $id_user)
    {
        $is_login = $this->User_model->getById($id_user)['is_login'];
        if($is_login == 1) {
            // $this->db->select('transactions.id AS id_transaction, transactions.no_order, transactions.total_price, transactions.book_type, SUM(book_stocks.weight) AS total_weight, transactions.mid_token');
            $this->db->select('transactions.id AS id_transaction, transactions.no_order, transactions.total_price, transactions.book_type, transactions.mid_token');
            $this->db->from('transactions');
            $this->db->join('purchases', 'purchases.id_transaction = transactions.id');
            $this->db->join('book_stocks', 'book_stocks.id = purchases.id_book_stock');
            // $this->db->where('purchases.id_user', $id_user);
            $this->db->order_by('transactions.id','ASC');

            if ($limit != null && $page != null) {
                if($page == 1) {
                    $offset = 0;
                } else {
                    $offset = ($page-1) * $limit;
                }
                $this->db->limit($limit, $offset);
            }
            $get_transactions = $this->db->get()->result_array();
            $data = [];
            $transactions = [];
            $purchases = [];
            $shipping_book = [];
            $email_reader = [];
            $arr_transactions = [];
            
            if(count($get_transactions) > 0) {
                $first_id = 0;
                foreach($get_transactions as $transaction) {
                    if($first_id != $transaction['id_transaction']) {
                        $get_purchases = $this->Purchase_model->getByIdTransactions($transaction['id_transaction']);
                  
                        if(count($get_purchases) > 0) {
                            foreach($get_purchases as $purchase) {
                                // if($purchase['id_user'] == $id_user) {
                                array_push($purchases, $purchase);
                                // }
                            }
                        }
                        $count = 0;
                        if(count($purchases) > 0) {
                            $arr_purchases = [];
                            
                            foreach($purchases as $purchase) {                            
                                if($purchase['id_transaction'] == $transaction['id_transaction']) {
                                    array_push($arr_purchases, $purchase);
                                }
                            }

                            $transaction['purchase_books'] = $arr_purchases;

                            if($count < 1) {
                                $count += 1;  
                                if($transaction['book_type'] == 1) {
                                    $email_reader = $this->Email_reader_model->getByIdTransaction($transaction['id_transaction']);
                                    // array_push($transactions, $email_reader);
                                    $transaction['email_reader'] = $email_reader;

                                }
                                if($transaction['book_type'] == 2) {
                                    $shipping_book = $this->Shipping_book_model->getByIdTransaction($transaction['id_transaction']);
                                    // array_push($transactions, $shipping_book);
                                    $transaction['shipping_book'] = $shipping_book;

                                }
                                array_push($transactions, $transaction);
                            }
                        }
                    }

                    $first_id = $transaction['id_transaction'];
                }
            }
            return $transactions;
        }
    }

    public function updateStatusCancel($id)
    {
        $timestamp = time();
        date_default_timezone_set('Asia/Jakarta');
        $date_time = date('y-m-d H:i:s');
        $data = [
            "id_status" => 3,
            "updated_at" => $date_time,
        ];
        $this->db->where('id', $id);
        $this->db->update('transactions', $data);
    }


    // Dashboard
    public function updateMidToken($id)
    {
        $midtrans = $this->Midtrans_model->paymentMidtrans($id);
        $data_update = [
            "mid_token" => $midtrans->token,
        ];
        $this->db->where('id', $id);
        $this->db->update('transactions', $data_update);
        return $midtrans;
    }

    public function getAll()
    {
        $this->db->select("*, DATE_FORMAT(transactions.updated_at,'%d-%m-%Y %H:%i:%s') AS waktu");
        $this->db->order_by('transactions.created_at','DESC');
        $query = $this->db->get('transactions');
        return $query->result_array();
    }

    public function create()
    {
        $timestamp = time();
        date_default_timezone_set('Asia/Jakarta');
        $date_time = date('y-m-d H:i:s');
        $data = [
            "no_order" => $this->input->post('no_order', true),
            "created_at" => $date_time,
            "updated_at" => $date_time,
        ];
        $this->db->insert('transactions', $data);
    }

    public function update($id)
    {
        $timestamp = time();
        date_default_timezone_set('Asia/Jakarta');
        $date_time = date('y-m-d H:i:s');
        $data = [
            "no_order" => $this->input->post('no_order', true),
            "updated_at" => $date_time,
        ];
        $this->db->where('id', $id);
        $this->db->update('transactions', $data);
    }

    public function updateNoOrder($id)
    {
        $timestamp = time();
        date_default_timezone_set('Asia/Jakarta');
        $date_time = date('y-m-d H:i:s');
        $data = [
            "no_order" => rand(),
            "updated_at" => $date_time,
        ];
        $this->db->where('id', $id);
        $this->db->update('transactions', $data);
    }

    public function receiptNumber($id)
    {
        $timestamp = time();
        date_default_timezone_set('Asia/Jakarta');
        $date_time = date('y-m-d H:i:s');
        $data = [
            "no_resi" => $this->input->post('no_resi'),
            "updated_at" => $date_time,
        ];
        $this->db->where('id', $id);
        $this->db->update('transactions', $data);
    }

    public function updateStatus($id, $data_update)
    {
        $this->db->where('id', $id);
        $this->db->update('transactions', $data_update);
    }
    
    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('transactions'); 
    }

    public function getById($id)
    {
        $this->db->select("*, transactions.id AS id, transactions.created_at AS created_at");
        $this->db->from('transactions');
        $this->db->where('transactions.id', $id);
        $this->db->join('ref_transaction_status', 'ref_transaction_status.id = transactions.id_status');
        $query = $this->db->get()->row_array();
        return $query;
    }

    public function getByIdJoinPurchase($id_transaction, $id_user)
    {
        $this->db->select('transactions.id AS id_transaction, transactions.no_order, transactions.total_price, transactions.book_type, transactions.mid_token');
        $this->db->from('transactions');
        $this->db->join('purchases', 'purchases.id_transaction = transactions.id');
        $this->db->join('ref_transaction_status', 'ref_transaction_status.id = transactions.id_status');
        $this->db->where('transactions.id', $id_transaction);
        $this->db->where('purchases.id_user', $id_user);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getStatus($id_status)
    {
        $query = $this->db->get_where('ref_transaction_status', ['id' => $id_status]);
        return $query->row_array();
    }

    public function getAllSettlement()
    {
        $query = $this->db->get_where('transactions', ['id_status' => 5]);
        return $query->result_array();
    }

    public function getAllCanceled()
    {
        $query = $this->db->get_where('transactions', ['id_status' => 3]);
        return $query->result_array();
    }

    public function getShippingBook($id_transaction)
    {
        $query = $this->db->get_where('shipping_books', ['id_transaction' => $id_transaction]);
        return $query->row_array();
    }
    
    public function getEmailReader($id_transaction)
    {
        $query = $this->db->get_where('email_readers', ['id_transaction' => $id_transaction]);
        return $query->row_array();
    }

    public function getPurchases($id_transaction)
    {
        $query = $this->db->get_where('purchases', ['id_transaction' => $id_transaction]);
        return $query->result_array();
    }
}

?>