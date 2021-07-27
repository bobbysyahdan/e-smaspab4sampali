<?php 

class Subscribe_model extends CI_model {

    public function subscribeBook()
    {
        $date_time = date('y-m-d H:i:s');
        $subscribe_package = $this->db->get_where('ref_subscribe_packages', 
        ['id' => $this->input->post('id_subscribe_package', true)]);
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
            "id_subscribe_package" => $this->input->post('id_subscribe_package', true),
            "id_book" => $this->input->post('id_book', true),
            "id_user" => $this->session->userdata('id'),
            "created_at" => $date_time,
            "updated_at" => $date_time,
        ];
        $this->db->insert('subscribes', $data_subscribe);
    }

    public function updateActive($id)
    {
        $date = date('y-m-d');
        $data = [
            "id_subscribe_status" => 1,
            "start_date" => $date,
        ];
        $this->db->where('id', $id);
        $this->db->update('subscribes', $data);
    }

    public function updateNonActive($id)
    {
        $data = [
            "id_subscribe_status" => 0,
        ];
        $this->db->where('id', $id);
        $this->db->update('subscribes', $data);
    }

    public function getAll()
    {
        $query = $this->db->get('subscribes');
        return $query->result_array();
    }

    public function create()
    {
        $date_time = date('y-m-d H:i:s');
        $subscribe_package = $this->db->get_where('ref_subscribe_packages', 
        ['id' => $this->input->post('id_subscribe_package', true)]);
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
            "id_subscribe_package" => $this->input->post('id_subscribe_package', true),
            "id_user" => $this->input->post('id_user', true),
            "created_at" => $date_time,
            "updated_at" => $date_time,
        ];
        $this->db->insert('subscribes', $data_subscribe);
    }

    public function update($id)
    {
        $date_time = date('y-m-d H:i:s');
        $data = [
            "id_subscribe_package" => $this->input->post('id_subscribe_package', true),
            // "id_book" => $this->input->post('id_book', true),
            "updated_at" => $date_time,
        ];
        $this->db->where('id', $id);
        $this->db->update('subscribes', $data);
    }
    
    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('subscribes'); 
    }

    public function getById($id)
    {
        $query = $this->db->get_where('subscribes', ['id' => $id]);
        return $query->row_array();
    }
    
    public function getUser($id)
    {
        $query = $this->db->get_where('users', ['id' => $id]);
        return $query->row_array();
    }

    public function getBook($id)
    {
        $query = $this->db->get_where('book_identities', ['id' => $id]);
        return $query->row_array();
    }

    public function getSubscribePackage($id)
    {
        $query = $this->db->get_where('ref_subscribe_packages', ['id' => $id]);
        return $query->row_array();
    }

    public function getTransaction($id)
    {
        $query = $this->db->get_where('transactions', ['id' => $id]);
        return $query->row_array();
    }

    public function getTransactionLevelStatus($id)
    {
        $transaction = $this->db->get_where('transactions', ['id' => $id])->row_array();
        $transaction_status = $this->db->get_where('ref_transaction_status', ['id' => $transaction['id_status']]);
        return $transaction_status->row_array();
    }

    public function getValidDate($id_subscribe)
    {
        $subscribe = $this->subscribe_model->getById($id_subscribe);
        $package_days = $this->ref_subscribe_package_model->getById($subscribe['id_subscribe_package'])['days'];
        $valid_date = date('Y-m-d', strtotime("+".$package_days."days", strtotime($subscribe['start_date'])));
        $date_now = date('Y-m-d');
        if($valid_date >= $date_now) {
            $is_valid = 1;
        } else {
            $is_valid = 0;
        }   
        
        return $is_valid;
    }
}

?>