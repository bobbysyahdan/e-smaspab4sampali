<?php 

class Book_stock_model extends CI_model {

    public function getAll()
    {
        $this->db->order_by('book_stocks.created_at','DESC');
        $query = $this->db->get('book_stocks');
        return $query->result_array();
    }

    public function create()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date_time = date('y-m-d H:i:s');
        $data = [
            "id" => $this->input->post('id_book', true),
            "id_book" => $this->input->post('id_book', true),
            "stock" => $this->input->post('stock', true),
            "weight" => $this->input->post('weight', true),
            "is_available" => $this->input->post('is_available', true),
            "price" => $this->input->post('price', true),
            "created_at" => $date_time,
            "updated_at" => $date_time,
        ];
        $this->db->insert('book_stocks', $data);
    }

    public function update($id)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date_time = date('y-m-d H:i:s');
        $data = [
            // "id_book" => $this->input->post('id_book', true),
            "stock" => $this->input->post('stock', true),
            "weight" => floatval($this->input->post('weight', true)),
            // "book_type" => $this->input->post('book_type', true),
            "is_available" => $this->input->post('is_available', true),
            "price" => $this->input->post('price', true),
            "updated_at" => $date_time,
        ];
        $this->db->where('id', $id);
        $this->db->update('book_stocks', $data);
    }

    public function getByBookIdentity($id_book)
    {
        $this->db->select('*');
        $this->db->from('book_stocks');
        $this->db->where('book_stocks.id_book', $id_book);
        $query = $this->db->get()->result_array();
        return $query;
    }
    

    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('book_stocks'); 
    }

    public function getById($id)
    {
        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]".'/upload/book/';
        $this->db->select("*, book_stocks.id AS id, concat('$url', book_identities.cover_image) AS url_cover_image, concat('$url', book_identities.file_uploaded) AS url_file_uploaded");
        $this->db->from('book_stocks');
        $this->db->where('book_stocks.id', $id);
        $this->db->join('book_identities', 'book_identities.id = book_stocks.id_book');
        $this->db->join('ref_book_categories', 'ref_book_categories.id = book_identities.id_category');
        return $this->db->get()->row_array();
    }

    // public function getBookTypes()
    // {
    //     $book_types = [
    //         [
    //             'id' => 1,
    //             'name' => 'Digital Book',
    //         ],
    //         [
    //             'id' => 2,
    //             'name' => 'Printed Book'
    //         ]
    //     ];
    //     return $book_types;
    // }

    public function getAvailableStatus()
    {
        $status = [
            [
                "id" => 1,
                "name" => "Available",
            ],
            [
                "id" => 0,
                "name" => "Not Available",
            ],
        ];
        
        return $status;   
    }

    public function getBook($id)
    {
        $query = $this->Book_identity_model->getById($id);
        return $query;
    }

    public function updateAmountBuyer($id_purchase)
    {
        $purchase = $this->db->get_where('purchases', ['id' => $id_purchase])->row_array();
        $book_stock = $this->db->get_where('book_stocks', ['id' => $purchase['id_book_stock']])->row_array();
        $date = date('y-m-d');
        if($purchase['book_type'] == 1) {
            $data = [
                "amount_digital_buyer" => $book_stock['amount_digital_buyer'] + $purchase['quantity'],
            ];
        } else {
            $data = [
                "amount_printed_buyer" => $book_stock['amount_printed_buyer'] + $purchase['quantity'],
            ];
        }
        
        $this->db->where('id', $book_stock['id']);
        $this->db->update('book_stocks', $data);
    }
}

?>