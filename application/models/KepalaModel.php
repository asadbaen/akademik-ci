<?php

defined('BASEPATH') or exit('No direct script allow access');

class KepalaModel extends CI_Model
{
    public function getKepala()
    {
        $this->db->select('*');
        $this->db->from('tbl_kepala_sekolah');

        $query = $this->db->get();

        return $query->result_array();
    }

    public function getKepalaByid($id_kepala)
    {
        $this->db->select('*');
        $this->db->from('tbl_kepala_sekolah');
        $this->db->where('Id_kepala_sekolah', $id_kepala);

        $query = $this->db->get();
        return $query->row_array();
    }
    public function create_kepala($dataKepala)
    {
        $this->db->insert('tbl_kepala_sekolah', $dataKepala);

        $query = $this->db->insert_id();

        return $query;
    }

    public function getEnumValues()
    {

        $query = $this->db->query("SHOW COLUMNS FROM tbl_kepala_sekolah WHERE Field = 'Jenis_kelamin'");

        $row = $query->row();
        $enum_values = explode("','", substr($row->Type, 6, -2));

        return $enum_values;
    }

    public function updateKepala($id_kepala, $dataKepala)
    {
        $this->db->where('Id_kepala_sekolah', $id_kepala);
        $this->db->update('tbl_kepala_sekolah', $dataKepala);
    }

    public function deleteById($id_kepala)
    {
        $this->db->where('Id_kepala_sekolah', $id_kepala);
        return $this->db->delete('tbl_kepala_sekolah');
    }
}
