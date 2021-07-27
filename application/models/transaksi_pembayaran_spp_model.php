<?php 

class Transaksi_pembayaran_spp_model extends CI_model {
    
    public function getAll()
    {
        $this->db->select("*, transaksi_pembayaran_spp.id AS id, DATE_FORMAT(transaksi_pembayaran_spp.created_at,'%d-%m-%Y %H:%i:%s') AS tanggal_pembayaran");
        $this->db->from('transaksi_pembayaran_spp');
        $this->db->order_by('transaksi_pembayaran_spp.id','created_at');
        return $this->db->get()->result_array();
    }

    public function create()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date_time = date('y-m-d H:i:s');
        $data = [
            "siswa" => $this->input->post('siswa', true),
            "kode_pembayaran" => $this->input->post('kode_pembayaran', true),
            "jumlah_pembayaran" => $this->input->post('jumlah_pembayaran', true),
            "tanggal_pembayaran" => $this->input->post('tanggal_pembayaran', true),
            "created_at" => $date_time,
            "updated_at" => $date_time,
        ];
        $this->db->insert('transaksi_pembayaran_spp', $data);
    }

    public function update($id)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date_time = date('y-m-d H:i:s');
        $data = [
            "siswa" => $this->input->post('siswa', true),
            "kode_pembayaran" => $this->input->post('kode_pembayaran', true),
            "jumlah_pembayaran" => $this->input->post('jumlah_pembayaran', true),
            "tanggal_pembayaran" => $this->input->post('tanggal_pembayaran', true),
            "updated_at" => $date_time,
        ];
        $this->db->where('id', $id);
        $this->db->update('transaksi_pembayaran_spp', $data);
    }
    

    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('transaksi_pembayaran_spp'); 
    }

    public function getById($id)
    {
        $query = $this->db->get_where('transaksi_pembayaran_spp', ['id' => $id]);
        return $query->row_array();
    }

    public function getAllByKelas($id_kelas)
    {
        $this->db->select("*, transaksi_pembayaran_spp.id AS id");
        $this->db->from('transaksi_pembayaran_spp');
        $this->db->where('transaksi_pembayaran_spp.kelas', $id_kelas);
        $this->db->join('siswa', 'siswa.id = transaksi_pembayaran_spp.siswa');
        $this->db->join('kelas', 'kelas.id = siswa.kelas');
        $this->db->join('guru', 'guru.id = kelas.wali_kelas');
        $this->db->order_by('transaksi_pembayaran_spp.id','ASC');
        return $this->db->get()->result_array();
    }
}

?>