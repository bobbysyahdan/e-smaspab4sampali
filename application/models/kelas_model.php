<?php 

class Kelas_model extends CI_model {
    
    public function getAll()
    {
        $query = $this->db->get('kelas');
        return $query->result_array();
    }

    public function create()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date_time = date('y-m-d H:i:s');
        $data = [
            "nama_kelas" => $this->input->post('nama_kelas', true),
            "wali_kelas" => $this->input->post('wali_kelas', true),
            "tahun_ajaran" => $this->input->post('tahun_ajaran', true),
            "created_at" => $date_time,
            "updated_at" => $date_time,
        ];
        $this->db->insert('kelas', $data);
    }

    public function update($id)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date_time = date('y-m-d H:i:s');
        $data = [
            "nama_kelas" => $this->input->post('nama_kelas', true),
            "wali_kelas" => $this->input->post('wali_kelas', true),
            "tahun_ajaran" => $this->input->post('tahun_ajaran', true),
            "updated_at" => $date_time,
        ];
        $this->db->where('id', $id);
        $this->db->update('kelas', $data);
    }
    

    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('kelas'); 
    }

    public function getById($id)
    {
        $query = $this->db->get_where('kelas', ['id' => $id]);
        return $query->row_array();
    }

    public function getAllByWaliKelas($id_guru)
    {
        $this->db->select("*, kelas.id AS id,");
        $this->db->from('kelas');
        $this->db->where('kelas.wali_kelas', $id_guru);
        $this->db->join('guru', 'guru.id = kelas.wali_kelas');
        $this->db->order_by('kelas.id','ASC');
        return $this->db->get()->result_array();
    }
}

?>