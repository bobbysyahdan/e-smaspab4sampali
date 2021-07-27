<?php 

class User_identity_model extends CI_model {

    public function hasIdentity($id_user)
    {
        $query = $this->db->get_where('user_identities', ['id_user' => $id_user]);
        return $query->row_array();
    }

    public function getAll()
    {
        $query = $this->db->get('user_identities');
        return $query->result_array();
    }

    public function create($id_user)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date_time = date('y-m-d H:i:s');
        
        $data = [
            'id' => $id_user,
            'id_user' => $id_user,
            "fullname" => $this->input->post('fullname', true),
            // "date_of_birth" => $this->input->post('date_of_birth', true),
            "no_handphone" => $this->input->post('no_handphone', true),
            // "gender" => $this->input->post('gender', true),
            "created_at" => $date_time,
            "updated_at" => $date_time,
        ];
        $this->db->insert('user_identities', $data);
        return $data;
    }

    public function update($id_user)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date_time = date('y-m-d H:i:s');
        $data = [
            'id_user' => $id_user,
            "fullname" => $this->input->post('fullname', true),
            "date_of_birth" => $this->input->post('date_of_birth', true),
            "no_handphone" => $this->input->post('no_handphone', true),
            "gender" => $this->input->post('gender', true),
            "updated_at" => $date_time,
        ];
        $this->db->where('id', $id_user);
        $this->db->update('user_identities', $data);
        return $data;
    }
    
    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('user_identities');
    }

    public function getById($id)
    {
        $query = $this->db->get_where('user_identities', ['id' => $id]);
        return $query->row_array();
    }

    public function getGender()
    {
        $gender = [
            [
                "id" => 1,
                "name" => "Male",
            ],
            [
                "id" => 2,
                "name" => "Female",
            ],
        ];
        
        return $gender;   
    }
}

?>