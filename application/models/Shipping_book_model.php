<?php 

class Shipping_book_model extends CI_model {

    // API
    public function getAllShippingBook($page, $limit, $id_user)
    {
        $is_login = $this->User_model->getById($id_user)['is_login'];
        if($is_login == 1) {
            $this->db->select('*, shipping_books.id AS id_email');
            $this->db->from('shipping_books');
            $this->db->where('shipping_books.id_user', $id_user);
            $this->db->order_by('shipping_books.id','ASC');
            $this->db->join('transactions', 'transactions.id = shipping_books.id_transaction');
            $this->db->join('users', 'users.id = shipping_books.id_user');
            $this->db->join('ref_provinsi_rajaongkir', 'ref_provinsi_rajaongkir.id = shipping_books.id_provinsi');
            $this->db->join('ref_kota_rajaongkir', 'ref_kota_rajaongkir.id = shipping_books.id_kota');
            
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

    public function getReferenceShippingBook($page, $limit, $id_user)
    {
        $is_login = $this->User_model->getById($id_user)['is_login'];
        if($is_login == 1) {
            $this->db->select('*, shipping_books.id AS id_email');
            $this->db->from('shipping_books');
            $this->db->where('shipping_books.id_user', $id_user);
            $this->db->order_by('shipping_books.id','ASC');
            $this->db->group_by('shipping_books.alamat');
            $this->db->group_by('shipping_books.id_provinsi');
            $this->db->group_by('shipping_books.id_kota');
            $this->db->join('transactions', 'transactions.id = shipping_books.id_transaction');
            $this->db->join('users', 'users.id = shipping_books.id_user');
            $this->db->join('ref_provinsi_rajaongkir', 'ref_provinsi_rajaongkir.id = shipping_books.id_provinsi');
            $this->db->join('ref_kota_rajaongkir', 'ref_kota_rajaongkir.id = shipping_books.id_kota');
            
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

    public function addShippingBookAPI($id_user, $id_transaction)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date_time = date('y-m-d H:i:s');
        $data_shipping_book = [
            "id_user" => $id_user,
            "alamat" => $this->input->post('alamat', true),
            "id_provinsi" => $this->input->post('id_provinsi', true),
            "id_kota" => $this->input->post('id_kota', true),
            "kode_pos" => $this->input->post('kode_pos', true),
            "no_handphone" => $this->input->post('no_handphone', true),
            "shipping_price" => $this->input->post('shipping_price', true),
            "courier_service" => $this->input->post('courier_service', true),
            "courier" => $this->input->post('courier', true),
            "etd" => $this->input->post('etd', true),
            "total_weight" => $this->input->post('total_weight', true),
            "id_transaction" => $id_transaction,
            "created_at" => $date_time,
            "updated_at" => $date_time,
        ];
        $this->db->insert('shipping_books', $data_shipping_book);
        return $data_shipping_book;
    }

    // Dashboard
    public function getAll()
    {
        $query = $this->db->get('shipping_books');
        return $query->result_array();
    }

    public function addShippingBook($id_transaction)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date_time = date('y-m-d H:i:s');
        $data_shipping_book = [
            "id_user" => $this->session->userdata('id'),
            "alamat" => $this->input->post('alamat', true),
            "id_provinsi" => $this->input->post('id_provinsi', true),
            "id_kota" => $this->input->post('id_kota', true),
            "kode_pos" => $this->input->post('kode_pos', true),
            "no_handphone" => $this->input->post('no_handphone', true),
            "shipping_price" => $this->input->post('shipping_price', true),
            "courier_service" => $this->input->post('courier_service', true),
            "courier" => $this->input->post('courier', true),
            "etd" => $this->input->post('etd', true),
            "total_weight" => $this->input->post('total_weight', true),
            "id_transaction" => $id_transaction,
            "created_at" => $date_time,
            "updated_at" => $date_time,
        ];
        $this->db->insert('shipping_books', $data_shipping_book);

        // date_default_timezone_set('Asia/Jakarta');
        // $date_time = date('y-m-d H:i:s');
        // $data_transaction = [
        //     "total_price" => $this->input->post('total_price_all', true),
        //     "shipping_price" => $this->input->post('shipping_price', true),
        //     "updated_at" => $date_time,
        // ];
        // $this->db->where('id', $id_transaction);
        // $this->db->update('transactions', $data_transaction);
    }

    // public function create()
    // {
    //     date_default_timezone_set('Asia/Jakarta');
        // $date_time = date('y-m-d H:i:s');
    //     $data = [
    //         "email" => $this->input->post('email', true),
    //         "created_at" => $date_time,
    //         "updated_at" => $date_time,
    //     ];
    //     $this->db->insert('shipping_book', $data);
    // }

    // public function update($id)
    // {
    //     date_default_timezone_set('Asia/Jakarta');
        // $date_time = date('y-m-d H:i:s');
    //     $data = [
    //         "email" => $this->input->post('email', true),
    //         "updated_at" => $date_time,
    //     ];
    //     $this->db->where('id', $id);
    //     $this->db->update('shipping_book', $data);
    // }
    

    // public function delete($id)
    // {
    //     $this->db->where('id', $id);
    //     $this->db->delete('shipping_book'); 
    // }

    public function getById($id)
    {
        $query = $this->db->get_where('shipping_books', ['id' => $id]);
        return $query->row_array();
    }

    public function getByIdTransaction($id_transaction)
    {
        $query = $this->db->get_where('shipping_books', ['id_transaction' => $id_transaction]);
        return $query->row_array();
    }
}

?>