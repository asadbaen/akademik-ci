<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_siswa_kelas extends CI_Model
{
    protected $table = "tbl_siswa";
    protected $table_kelas = "tbl_kelas";
    protected $table_kelas_siswa = "tbl_kelas_siswa";

    public function all($where = array())
    {
        if (!empty($where)) {
            $this->db->where($where);
        }

        return $this->db->join($this->table_kelas_siswa, "$this->table.id_siswa=$this->table_kelas_siswa.id_siswa")
            ->join($this->table_kelas, "$this->table_kelas_siswa.id_kelas=$this->table_kelas.id_kelas")
            ->where("$this->table_kelas_siswa.id_kelas", '1')
            ->limit(25)
            ->get($this->table)
            ->result();
    }



    public function getKelasSiswa($kelas_id)
    {
        $this->db->select('tbl_siswa.*, tbl_kelas.*');
        $this->db->from('tbl_siswa');
        $this->db->join('tbl_kelas_siswa', 'tbl_siswa.id_siswa = tbl_kelas_siswa.id_siswa');
        $this->db->join('tbl_kelas', 'tbl_kelas.id_kelas = tbl_kelas_siswa.id_kelas');
        $this->db->where('tbl_kelas_siswa.id_kelas', $kelas_id);

        $query = $this->db->get();

        // var_dump($query->result());
        // die();
        return $query->result();
    }
}
