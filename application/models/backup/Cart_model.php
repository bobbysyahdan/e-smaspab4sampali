<?php 

class Cart_model extends CI_model {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Book_stock_model');
        $this->load->model('User_model');
    }

    // API
    public function getAllCart($page = NULL, $limit = NULL, $id_user)
    {
        $is_login = $this->User_model->getById($id_user)['is_login'];
        if($is_login == 1) {
            $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]".'/upload/book/';
            $this->db->select("
            carts.quantity AS quantity,
            carts.id AS id_cart,
            carts.price AS price,
            book_identities.title AS title,
            book_identities.id AS id_book,
            concat('$url', book_identities.cover_image) AS url_cover_image");
            $this->db->from('carts');
            $this->db->where('carts.id_user', $id_user);
            $this->db->order_by('carts.id','ASC');
            $this->db->join('book_stocks', 'book_stocks.id = carts.id_book_stock');
            $this->db->join('book_identities', 'book_identities.id = carts.id_book_stock');
            
            if ($limit != NULL && $page != NULL) {
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
    
    public function addToCart($id_user)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date_time = date('y-m-d H:i:s');
        $data = [
            "id_user" => $id_user,
            "id_book_stock" => $this->input->post('id_book', true),
            "quantity" => $this->input->post('quantity', true),
            "price" => $this->input->post('price', true) * $this->input->post('quantity', true),
            "created_at" => $date_time,
            "updated_at" => $date_time,
        ];
        $this->db->insert('carts', $data);
        return $data;
    }


    // Dashboard
    public function getAll()
    {
        $query = $this->db->get('carts');
        return $query->result_array();
    }

    public function addBookToCart()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date_time = date('y-m-d H:i:s');
        $data = [
            "id_user" => $this->session->userdata('id'),
            "id_book_stock" => $this->input->post('id_book_stock', true),
            "quantity" => $this->input->post('quantity', true),
            "price" => $this->input->post('price', true),
            "created_at" => $date_time,
            "updated_at" => $date_time,
        ];
        $this->db->insert('carts', $data);
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
        $this->db->insert('carts', $data);
    }

    public function update($id)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date_time = date('y-m-d H:i:s');
        $data = [
            "id_user" => $this->input->post('id_user', true),
            "id_book_stock" => $this->input->post('id_book_stock', true),
            "amout" => $this->input->post('amout', true),
            "price" => $this->input->post('price', true),
            "updated_at" => $date_time,
        ];
        $this->db->where('id', $id);
        $this->db->update('carts', $data);
    }
    

    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('carts'); 
    }

    public function getById($id)
    {
        $this->db->select('*, carts.id AS id_cart');
        $this->db->from('carts');
        $this->db->where('carts.id', $id);
        $this->db->order_by('carts.id','ASC');
        $this->db->join('book_stocks', 'book_stocks.id = carts.id_book_stock');
        $this->db->join('book_identities', 'book_identities.id = carts.id_book_stock');
        $query = $this->db->get()->row_array();
        return $query;
    }

    public function getByIdAndUser($id, $id_user)
    {
        $this->db->select('*, carts.id AS id_cart');
        $this->db->from('carts');
        $this->db->where('carts.id', $id);
        $this->db->where('carts.id_user', $id_user);
        $this->db->join('book_stocks', 'book_stocks.id = carts.id_book_stock');
        $this->db->join('book_identities', 'book_identities.id = carts.id_book_stock');
        $query = $this->db->get()->row_array();
        return $query;
    }

    public function getBookStock($id)
    {
        $query = $this->db->get_where('book_stocks', ['id' => $id]);
        return $query->row_array();
    }

    public function getBook($id)
    {
        $book_stock = $this->db->get_where('book_stocks', ['id' => $id])->row_array();
        $book = $this->db->get_where('book_identities', ['id' => $book_stock['id_book']])->row_array();
        return $book;
    }

    // public function getBookType($id)
    // {
    //     $book_stock = $this->db->get_where('book_stocks', ['id' => $id])->row_array();
    //     $book_type = $this->Book_stock_model->getBookTypes()[$book_stock['book_type']-1];
    //     return $book_type;
    // }
}

?>