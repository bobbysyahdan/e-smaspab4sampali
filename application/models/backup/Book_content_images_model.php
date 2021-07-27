<?php 

class Book_content_images_model extends CI_model {

    public function getAll()
    {
        $query = $this->db->get('book_content_images');
        return $query->result_array();
    }

    public function create($id_book_identity)
    {
        $timestamp = time();
        date_default_timezone_set('Asia/Jakarta');
        $date_time = date('y-m-d H:i:s');
        $book_identity = $this->Book_identity_model->getById($id_book_identity);
        $pdf_file = "./upload/content_book/$id_book_identity/test.pdf";
        $save_to = "./upload/content_book/$id_book_identity/test.jpg";
        $imagick = new Imagick();
        $imagick->readImage($pdf_file);
        $imagick->writeImages($save_to, false);

        $data = [
            "file_image" => $id_book_identity,
            "id_book_identities" => $id_book_identity,
            "created_at" => $date_time,
            "updated_at" => $date_time,
        ];
        $this->db->insert('book_content_images', $data);
    }

    public function update($id)
    {
        $timestamp = time();
        date_default_timezone_set('Asia/Jakarta');
        $date_time = date('y-m-d H:i:s');
        $data = [
            "id_book_identities" => $this->input->post('id_book_identities', true),
            "updated_at" => $date_time,
        ];
        $this->db->where('id', $id);
        $this->db->update('book_content_images', $data);
    }
    

    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('book_content_images'); 
    }

    public function getById($id)
    {
        $query = $this->db->get_where('book_content_images', ['id' => $id]);
        return $query->row_array();
    }

    public function getAllByBookIdentity($id_book_identity)
    {
        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]".'/upload/content_book/';
        $this->db->select("*, book_content_images.id AS id, concat('$url', book_content_images.file_image) AS url_content_book");
        $this->db->from('book_content_images');
        $this->db->order_by('book_content_images.id','ASC');
        $this->db->where('id_book_identity', $id_book_identity);
        return $this->db->get()->result_array();
    }
}

?>