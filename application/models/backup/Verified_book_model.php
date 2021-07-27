<?php 

class Verified_book_model extends CI_model {
    
    // API
    public function getAllVerifiedBooks($page, $limit, $id_user)
    {
        $is_login = $this->User_model->getById($id_user)['is_login'];
        if($is_login == 1) {
            $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]".'/upload/book/';
            $this->db->select("*, verified_books.id AS id_verified_book, concat('$url', book_identities.cover_image) AS url_cover_image, concat('$url', book_identities.file_uploaded) AS url_file_uploaded");
            $this->db->from('verified_books');
            $this->db->where('verified_books.id_user', $id_user);
            // $this->db->where('verified_books.is_verified', 1);
            $this->db->order_by('verified_books.id','ASC');
            $this->db->join('book_identities', 'book_identities.id = verified_books.id_book');
            $this->db->join('users', 'users.id = verified_books.id_user');
            
            if ($limit != null && $page != null) {
                if($page == 1) {
                    $offset = 0;
                } else {
                    $offset = ($page-1) * $limit;
                }
                $this->db->limit($limit, $offset);
            }
            $query = $this->db->get()->result();
            return $query;
        }
    }

    public function getVerifiedBook($id_user, $id_book)
    {
        $is_login = $this->User_model->getById($id_user)['is_login'];
        if($is_login == 1) {
            $this->db->select('*, verified_books.id AS id_verified_book');
            $this->db->from('verified_books');
            $this->db->where('verified_books.id_user', $id_user);
            $this->db->where('verified_books.id_book', $id_book);
            $this->db->order_by('verified_books.id','ASC');
            $this->db->join('book_identities', 'book_identities.id = verified_books.id_book');
            $this->db->join('users', 'users.id = verified_books.id_user');
            
            $query = $this->db->get()->row_array();
            return $query;
        }
    }

    public function getCheckSerialNumber($serial_number)
    {
        $this->db->select('*, verified_books.id AS id_verified_book');
        $this->db->from('verified_books');
        $this->db->where('verified_books.serial_number', $serial_number);
        $this->db->order_by('verified_books.id','ASC');
        $this->db->join('book_identities', 'book_identities.id = verified_books.id_book');
        
        $query = $this->db->get()->row_array();
        return $query;
    }

    public function verified($id_user, $id_book, $serial_number)
    {
        $is_login = $this->User_model->getById($id_user)['is_login'];
        if($is_login == 1) {
            $this->db->select('*, verified_books.id AS id_verified_book');
            $this->db->from('verified_books');
            $this->db->where('verified_books.id_user', $id_user);
            $this->db->where('verified_books.id_book', $id_book);
            $this->db->where('verified_books.serial_number', $serial_number);
            $this->db->order_by('verified_books.id','ASC');
            $this->db->join('book_identities', 'book_identities.id = verified_books.id_book');
            $this->db->join('users', 'users.id = verified_books.id_user');
            
            $query = $this->db->get()->row_array();
            
            if($query == null) {
                return null;
            } else {
                date_default_timezone_set('Asia/Jakarta');
        $date_time = date('y-m-d H:i:s');
                $data = [
                    "is_verified" => 1,
                    "updated_at" => $date_time,
                ];
                $this->db->where('serial_number', $serial_number);
                $this->db->update('verified_books', $data);
                $verified_book = $this->Verified_book_model->getVerifiedBook($id_user, $id_book);
                return $verified_book;
            }
            
        }
    }


    // Dashboard
    public function getAll()
    {
        $this->db->order_by('verified_books.created_at','DESC');
        $query = $this->db->get('verified_books');
        return $query->result_array();
    }

    public function getAllDigitalBookSoldOut()
    {
        $query = $this->db->get_where('verified_books', ['book_type' => 1]);
        return $query->result_array();
    }

    public function getAllPrintedBookSoldOut()
    {
        $query = $this->db->get_where('verified_books', ['book_type' => 2]);
        return $query->result_array();
    }

    public function getBySerialNumber($serial_number, $id_book)
    {
        $query = $this->db->where('serial_number', $serial_number)
        ->where('id_user', $this->session->userdata('id'))->where('id_book', $id_book)->get('verified_books');
        return $query->row_array();
    }

    public function getUser($id_user)
    {
        $this->db->from('users');
        $this->db->where('users.id', $id_user);
        $this->db->join('user_identities', 'user_identities.id_user = users.id');
        return $this->db->get()->row_array();
    }

    public function getBook($id_book)
    {
        $query = $this->db->get_where('book_identities', ['id' => $id_book]);
        return $query->row_array();
    }

    public function verifySerialNumber($id_book)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date_time = date('y-m-d H:i:s');
        $data = [
            "is_verified" => 1,
            "updated_at" => $date_time,
        ];
        $this->db->where('serial_number', $this->input->post('serial_number'));
        $this->db->update('verified_books', $data);
    }

    public function addVerifiedBook($id_purchase)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date_time = date('y-m-d H:i:s');
        $purchase = $this->db->get_where('purchases', ['id' => $id_purchase])->row_array();
        $email_reader = $this->db->get_where('email_readers', ['id_transaction' => $purchase['id_transaction']])->row_array();
        $id_verify_book = NULL;
        if(isset($email_reader)) {
            for($i=0; $i<$purchase['quantity']; $i++) {
                $data = [
                    "id_book" => $this->Purchase_model->getBook($purchase['id'])['id'],
                    "book_type" => 1,
                    "email" => $email_reader['email'],
                    "id_user" => $email_reader['id_user'],
                    "serial_number" => rand(),
                    "is_verified" => 0,
                    "created_at" => $date_time,
                    "updated_at" => $date_time,
                ];
                $this->db->insert('verified_books', $data);
                $id_verify_book = $this->db->insert_id();
            }
            
        } else {
            for($i=0; $i<$purchase['quantity']; $i++) {
                $data = [
                    "id_book" => $this->Purchase_model->getBook($purchase['id'])['id'],
                    "book_type" => 2,
                    "id_user" => $this->session->userdata('id'),
                    "serial_number" => rand(),
                    "is_verified" => 1,
                    "created_at" => $date_time,
                    "updated_at" => $date_time,
                ];
                $this->db->insert('verified_books', $data);
                $id_verify_book = $this->db->insert_id();
            }
        }

        return $id_verify_book;
        // date_default_timezone_set('Asia/Jakarta');
        // $date_time = date('y-m-d H:i:s');
        // $email_reader = $this->db->get_where('email_readers', ['id' => $id_email_reader])->row_array();
        // $purchases = $this->db->get_where('purchases', ['id_transaction' => $email_reader['id_transaction']])->result_array();
        // foreach($purchases as $purchase) {
        //     $data = [
        //         "id_book" => $this->Purchase_model->getBook($purchase['id'])['id'],
        //         "email" => $email_reader['email'],
        //         "user" => $email_reader['id_user'],
        //         "created_at" => $date_time,
        //         "updated_at" => $date_time,
        //     ];
        //     $this->db->insert('verified_books', $data);
        // }
    }

    // public function create()
    // {
    //     date_default_timezone_set('Asia/Jakarta');
        // $date_time = date('y-m-d H:i:s');
    //     $data = [
    //         "category" => $this->input->post('category', true),
    //         "created_at" => $date_time,
    //         "updated_at" => $date_time,
    //     ];
    //     $this->db->insert('verified_books', $data);
    // }

    // public function update($id)
    // {
    //     date_default_timezone_set('Asia/Jakarta');
        // $date_time = date('y-m-d H:i:s');
    //     $data = [
    //         "category" => $this->input->post('category', true),
    //         "updated_at" => $date_time,
    //     ];
    //     $this->db->where('id', $id);
    //     $this->db->update('verified_books', $data);
    // }
    

    // public function delete($id)
    // {
    //     $this->db->where('id', $id);
    //     $this->db->delete('verified_books'); 
    // }

    public function getById($id)
    {
        // $query = $this->db->get_where('verified_books', ['id' => $id]);
        // return $query->row_array();

        $this->db->select('*, verified_books.id AS id_verified_book');
        $this->db->from('verified_books');
        $this->db->where('verified_books.id', $id);
        $this->db->join('book_identities', 'book_identities.id = verified_books.id_book');
        $this->db->join('users', 'users.id = verified_books.id_user');
        return $this->db->get()->row_array();
    }

    public function getByEmailIdBook($email, $id_book)
    {
        $this->db->select('*, verified_books.id AS id_verified_book');
        $this->db->from('verified_books');
        $this->db->where('verified_books.email', $email);
        $this->db->where('verified_books.id_book', $id_book);
        $this->db->join('book_identities', 'book_identities.id = verified_books.id_book');
        $this->db->join('users', 'users.id = verified_books.id_user');
        $this->db->join('user_identities', 'user_identities.id = verified_books.id_user');
        return $this->db->get()->row_array();
    }

    public function getAllEmailReaderHaveNotSend()
    {
        $this->db->select('*, verified_books.id AS id_verified_book');
        $this->db->from('verified_books');
        $this->db->where('have_sent',0);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function updateEmailHaveSent($id)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date_time = date('y-m-d H:i:s');
        $data = [
            "have_sent" => 1,
            "updated_at" => $date_time,
        ];
        $this->db->where('id', $id);
        $this->db->update('verified_books', $data);
        return $data;
    }
}

?>