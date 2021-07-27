<?php 

class Ref_transaction_status_model extends CI_model {

    public function getAll()
    {
        // $query = $this->db->get('ref_transaction_status');
        // return $query->result_array();
        $this->db->from('ref_transaction_status');
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
        $this->db->insert('ref_transaction_status', $data);
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
        $this->db->update('ref_transaction_status', $data);
    }
    
    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('ref_transaction_status'); 
    }

    public function getById($id)
    {
        $query = $this->db->get_where('ref_transaction_status', ['id' => $id]);
        return $query->row_array();
    }

    public function getByLevel($level)
    {
        $query = $this->db->get_where('ref_transaction_status', ['level' => $level]);
        return $query->row_array();
    }
}

?>