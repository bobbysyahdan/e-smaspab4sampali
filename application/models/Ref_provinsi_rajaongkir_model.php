<?php 

class Ref_provinsi_rajaongkir_model extends CI_model {

    public function getAll()
    {
        $query = $this->db->get('ref_provinsi_rajaongkir');
        return $query->result_array();
    }

    public function getById($id)
    {
        $query = $this->db->get_where('ref_provinsi_rajaongkir', ['id' => $id]);
        return $query->row_array();
    }
}

?>