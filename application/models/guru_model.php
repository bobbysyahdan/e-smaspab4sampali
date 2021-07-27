<?php 

class Guru_model extends CI_model {
    
    public function getAll()
    {
        $query = $this->db->get('guru');
        return $query->result_array();
    }

    public function create()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date_time = date('y-m-d H:i:s');
        $data = [
            "nip" => $this->input->post('nip', true),
            "nama_lengkap" => $this->input->post('nama_lengkap', true),
            "alamat" => $this->input->post('alamat', true),
            "tanggal_lahir" => $this->input->post('tanggal_lahir', true),
            "tempat_lahir" => $this->input->post('tempat_lahir', true),
            "jenis_kelamin" => $this->input->post('jenis_kelamin', true),
            "no_handphone" => $this->input->post('no_handphone', true),
            "created_at" => $date_time,
            "updated_at" => $date_time,
        ];
        $this->db->insert('guru', $data);
    }

    public function update($id)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date_time = date('y-m-d H:i:s');
        $data = [
            "nip" => $this->input->post('nip', true),
            "nama_lengkap" => $this->input->post('nama_lengkap', true),
            "alamat" => $this->input->post('alamat', true),
            "tanggal_lahir" => $this->input->post('tanggal_lahir', true),
            "tempat_lahir" => $this->input->post('tempat_lahir', true),
            "jenis_kelamin" => $this->input->post('jenis_kelamin', true),
            "no_handphone" => $this->input->post('no_handphone', true),
            "updated_at" => $date_time,
        ];
        $this->db->where('id', $id);
        $this->db->update('guru', $data);
    }
    

    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('guru'); 
    }

    public function getById($id)
    {
        $query = $this->db->get_where('guru', ['id' => $id]);
        return $query->row_array();
    }
}

?>