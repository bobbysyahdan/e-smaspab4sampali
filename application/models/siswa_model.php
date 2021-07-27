<?php 

class Siswa_model extends CI_model {
    
    public function getAll()
    {
        $query = $this->db->get('siswa');
        return $query->result_array();
    }

    public function create()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date_time = date('y-m-d H:i:s');
        $data = [
            "nis" => $this->input->post('nis', true),
            "kelas" => $this->input->post('kelas', true),
            "nama_lengkap" => $this->input->post('nama_lengkap', true),
            "alamat" => $this->input->post('alamat', true),
            "tanggal_lahir" => $this->input->post('tanggal_lahir', true),
            "tempat_lahir" => $this->input->post('tempat_lahir', true),
            "jenis_kelamin" => $this->input->post('jenis_kelamin', true),
            "nama_orangtua" => $this->input->post('nama_orangtua', true),
            "no_handphone" => $this->input->post('no_handphone', true),
            "created_at" => $date_time,
            "updated_at" => $date_time,
        ];
        $this->db->insert('siswa', $data);
    }

    public function update($id)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date_time = date('y-m-d H:i:s');
        $data = [
            "nis" => $this->input->post('nis', true),
            "kelas" => $this->input->post('kelas', true),
            "nama_lengkap" => $this->input->post('nama_lengkap', true),
            "alamat" => $this->input->post('alamat', true),
            "tanggal_lahir" => $this->input->post('tanggal_lahir', true),
            "tempat_lahir" => $this->input->post('tempat_lahir', true),
            "jenis_kelamin" => $this->input->post('jenis_kelamin', true),
            "nama_orangtua" => $this->input->post('nama_orangtua', true),
            "no_handphone" => $this->input->post('no_handphone', true),
            "updated_at" => $date_time,
        ];
        $this->db->where('id', $id);
        $this->db->update('siswa', $data);
    }
    

    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('siswa'); 
    }

    public function getById($id)
    {
        $query = $this->db->get_where('siswa', ['id' => $id]);
        return $query->row_array();
    }

    public function getAllByKelas($id_kelas)
    {
        $this->db->select("*, siswa.id AS id, 
        siswa.tempat_lahir AS tempat_lahir,
        siswa.tanggal_lahir AS tanggal_lahir,
        siswa.no_handphone AS no_handphone,
        siswa.jenis_kelamin AS jenis_kelamin,
        siswa.nama_lengkap AS nama_lengkap,");
        $this->db->from('siswa');
        $this->db->where('siswa.kelas', $id_kelas);
        $this->db->join('kelas', 'kelas.id = siswa.kelas');
        $this->db->join('guru', 'guru.id = kelas.wali_kelas');
        $this->db->order_by('siswa.id','ASC');
        return $this->db->get()->result_array();
    }
}

?>