<?php 

class Ref_book_category_model extends CI_model {
    
    public function getAll()
    {
        $query = $this->db->get('ref_book_categories');
        return $query->result_array();
    }

    public function create()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date_time = date('y-m-d H:i:s');
        $data = [
            "category" => $this->input->post('category', true),
            "created_at" => $date_time,
            "updated_at" => $date_time,
        ];
        $this->db->insert('ref_book_categories', $data);
    }

    public function update($id)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date_time = date('y-m-d H:i:s');
        $data = [
            "category" => $this->input->post('category', true),
            "updated_at" => $date_time,
        ];
        $this->db->where('id', $id);
        $this->db->update('ref_book_categories', $data);
    }
    

    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('ref_book_categories'); 
    }

    public function getById($id)
    {
        $query = $this->db->get_where('ref_book_categories', ['id' => $id]);
        return $query->row_array();
    }
}

?>