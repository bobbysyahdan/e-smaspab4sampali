<?php 

class Ref_kota_rajaongkir_model extends CI_model {

    public function getAll()
    {
        $query = $this->db->get('ref_kota_rajaongkir');
        return $query->result_array();
    }

    public function getById($id)
    {
        $query = $this->db->get_where('ref_kota_rajaongkir', ['id' => $id]);
        return $query->row_array();
    }

    public function getByIdProvinsi($id_provinsi)
    {
        $query = $this->db->get_where('ref_kota_rajaongkir', ['id_provinsi' => $id_provinsi]);
        return $query->result_array();
    }
}

?>