<?php

defined('BASEPATH') or exit('No direct script allow access');

class AdminModel extends CI_Model
{
    public function getAdmin()
    {
        $this->db->select('*');
        $this->db->from('tbl_tu_admin');

        $query = $this->db->get();

        return $query->result_array();
    }

    public function getAdminByid($id_admin)
    {
        $this->db->select('*');
        $this->db->from('tbl_tu_admin');
        $this->db->where('id_tu_admin', $id_admin);

        $query = $this->db->get();
        return $query->row_array();
    }
    public function create_admin($dataAdmin)
    {
        $this->db->insert('tbl_tu_admin', $dataAdmin);

        $query = $this->db->insert_id();

        return $query;
    }

    public function getEnumValues()
    {

        $query = $this->db->query("SHOW COLUMNS FROM tbl_tu_admin WHERE Field = 'Jenis_kelamin'");

        $row = $query->row();
        $enum_values = explode("','", substr($row->Type, 6, -2));

        return $enum_values;
    }

    public function updateAdmin($id_admin, $dataAdmin)
    {
        $this->db->where('id_tu_admin', $id_admin);
        $this->db->update('tbl_tu_admin', $dataAdmin);
    }

    public function deleteById($id_admin)
    {
        $this->db->where('id_tu_admin', $id_admin);
        return $this->db->delete('tbl_tu_admin');
    }
}
