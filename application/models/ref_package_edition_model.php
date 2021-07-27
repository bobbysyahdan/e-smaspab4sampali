<?php 

class Ref_package_edition_model extends CI_model {

    public function getAll()
    {
        $query = $this->db->get('ref_package_editions');
        return $query->result_array();
    }

    public function create()
    {
        $timestamp = time();
        date_default_timezone_set('Asia/Jakarta');
        $date_time = date('y-m-d H:i:s');
        $data = [
            "package_edition" => $this->input->post('package_edition', true),
            "created_at" => $date_time,
            "updated_at" => $date_time,
        ];
        $this->db->insert('ref_package_editions', $data);
    }

    public function update($id)
    {
        $timestamp = time();
        date_default_timezone_set('Asia/Jakarta');
        $date_time = date('y-m-d H:i:s');
        $data = [
            "package_edition" => $this->input->post('package_edition', true),
            "updated_at" => $date_time,
        ];
        $this->db->where('id', $id);
        $this->db->update('ref_package_editions', $data);
    }
    

    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('ref_package_editions'); 
    }

    public function getById($id)
    {
        $query = $this->db->get_where('ref_package_editions', ['id' => $id]);
        return $query->row_array();
    }
}

?>