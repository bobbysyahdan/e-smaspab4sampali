<?php 

class Ref_purchase_status_model extends CI_model {

    public function getAll()
    {
        $this->db->from('ref_purchase_status');
        $this->db->order_by("level", "asc");
        $query = $this->db->get(); 
        return $query->result_array();
    }

    public function create()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date_time = date('y-m-d H:i:s');
        $data = [
            "level" => $this->input->post('level', true),
            "status" => $this->input->post('status', true),
            "created_at" => $date_time,
            "updated_at" => $date_time,
        ];
        $this->db->insert('ref_purchase_status', $data);
    }

    public function update($id)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date_time = date('y-m-d H:i:s');
        $data = [
            "level" => $this->input->post('level', true),
            "status" => $this->input->post('status', true),
            "updated_at" => $date_time,
        ];
        $this->db->where('id', $id);
        $this->db->update('ref_purchase_status', $data);
    }
    
    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('ref_purchase_status'); 
    }

    public function getById($id)
    {
        $query = $this->db->get_where('ref_purchase_status', ['id' => $id]);
        return $query->row_array();
    }

    public function getByLevel($level)
    {
        $query = $this->db->get_where('ref_purchase_status', ['level' => $level]);
        return $query->row_array();
    }
}

?>