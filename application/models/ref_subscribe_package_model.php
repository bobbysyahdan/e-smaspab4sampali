<?php 

class Ref_subscribe_package_model extends CI_model {

    public function getAll()
    {
        $query = $this->db->get('ref_subscribe_packages');
        return $query->result_array();
    }

    public function create()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date_time = date('y-m-d H:i:s');
        $data = [
            "id_package_edition" => $this->input->post('id_package_edition', true),
            "package" => $this->input->post('package', true),
            "days" => $this->input->post('days', true),
            "price" => $this->input->post('price', true),
            "created_at" => $date_time,
            "updated_at" => $date_time,
        ];
        $this->db->insert('ref_subscribe_packages', $data);
    }

    public function update($id)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date_time = date('y-m-d H:i:s');
        $data = [
            "id_package_edition" => $this->input->post('id_package_edition', true),
            "package" => $this->input->post('package', true),
            "days" => $this->input->post('days', true),
            "price" => $this->input->post('price', true),
            "updated_at" => $date_time,
        ];
        $this->db->where('id', $id);
        $this->db->update('ref_subscribe_packages', $data);
    }
    
    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('ref_subscribe_packages'); 
    }

    public function getById($id)
    {
        $query = $this->db->get_where('ref_subscribe_packages', ['id' => $id]);
        return $query->row_array();
    }

    public function userSubscribePackage($id_package)
    {
        $date_time = date('y-m-d H:i:s');
        $subscribe_package = $this->db->get_where('ref_subscribe_packages', 
        ['id' => $id_package]);
        $subscribe_package = $subscribe_package->row_array();
        $data_transaction = [
            "no_order" => rand(),
            "id_status" => 1,
            "total_price" => $subscribe_package['price'],
            "created_at" => $date_time,
            "updated_at" => $date_time,
        ];
        $this->db->insert('transactions', $data_transaction);
        $id_transaction = $this->db->insert_id();

        $data_subscribe = [
            "id_transaction" => $id_transaction,
            "id_subscribe_package" => $id_package,
            "id_user" => $this->session->userdata('id'),
            "created_at" => $date_time,
            "updated_at" => $date_time,
        ];
        $this->db->insert('subscribes', $data_subscribe);
    }
}

?>