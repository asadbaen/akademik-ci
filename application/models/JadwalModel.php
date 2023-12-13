<?php
defined('BASEPATH') or exit('No direct script access allowed');


class JadwalModel extends CI_Model
{
    protected $table = 'tbl_jadwal_pelajaran';


    public function getJadwal()
    {
        $this->db->select('*');
        $this->db->from($this->table);

        $query = $this->db->get();

        return $query->result_array();
    }

    public function createJadwal($data)
    {
        $this->db->insert($this->table, $data);

        $query = $this->db->insert_id();

        return $query;
    }

    public function getById($id_jadwal)
    {
        $this->db->select('*');
        $this->db->from($this->table);

        $this->db->where('id_jadwal', $id_jadwal);

        $query = $this->db->get();

        return $query->row_array();
    }


    public function updateJadwal($id_jadwal, $data)
    {
        $this->db->where('id_jadwal', $id_jadwal);
        $this->db->update($this->table, $data);
    }

    public function deleteById($id_jadwal)
    {
        $this->db->where('id_jadwal', $id_jadwal);
        $this->db->delete($this->table);
    }
}
