<?php 

class Voucher_model extends CI_model {
     // API
    public function getAllAvailable($page, $limit)
    {
        $date = date('Y-m-d');
        $this->db->select("*");
        $this->db->from('vouchers');
        $this->db->where('start_date <=', $date);
        $this->db->where('end_date >=', $date);
        $this->db->order_by('created_at','ASC');
        
        if ($limit != null && $page != null) {
            if($page == 1) {
                $offset = 0;
            } else {
                $offset = ($page-1) * $limit;
            }
            $this->db->limit($limit, $offset);
        }
        $query = $this->db->get()->result_array();
        return $query;
    }
    

    // Dashboard
    public function getAll()
    {
        $this->db->from('vouchers');
        $this->db->order_by("created_at", "ASC");
        $query = $this->db->get(); 
        return $query->result_array();
    }

    public function create()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date_time = date('y-m-d H:i:s');
        $data = [
            "voucher_code" => $this->input->post('voucher_code', true),
            "percentage_discount" => $this->input->post('percentage_discount', true),
            "start_date" => $this->input->post('start_date', true),
            "end_date" => $this->input->post('end_date', true),
            "created_at" => $date_time,
            "updated_at" => $date_time,
        ];
        $this->db->insert('vouchers', $data);
    }

    public function update($id)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date_time = date('y-m-d H:i:s');
        $data = [
            "voucher_code" => $this->input->post('voucher_code', true),
            "percentage_discount" => $this->input->post('percentage_discount', true),
            "start_date" => $this->input->post('start_date', true),
            "end_date" => $this->input->post('end_date', true),
            "updated_at" => $date_time,
        ];
        $this->db->where('id', $id);
        $this->db->update('vouchers', $data);
    }
    
    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('vouchers'); 
    }

    public function getById($id)
    {
        $query = $this->db->get_where('vouchers', ['id' => $id]);
        return $query->row_array();
    }

    public function getByVoucherCode($voucher_code)
    {
        $query = $this->db->get_where('vouchers', ['voucher_code' => $voucher_code]);
        return $query->row_array();
    }
}

?>