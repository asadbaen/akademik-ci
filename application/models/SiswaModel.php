<?php

defined('BASEPATH') or exit('No direct script allow access');

class SiswaModel extends CI_Model
{
    public function getSiswa()
    {
        $this->db->select('*');
        $this->db->from('tbl_siswa');

        $query = $this->db->get();

        return $query->result_array();
    }

    public function getSiswaByid($id_siswa)
    {
        $this->db->select('*');
        $this->db->from('tbl_siswa');
        $this->db->where('id_siswa', $id_siswa);

        $query = $this->db->get();
        return $query->row_array();
    }

    public function get_detail_data($id_siswa)
    {
        $this->db->select('*');
        $this->db->from('tbl_siswa');
        $this->db->where('id_siswa', $id_siswa);
        return $this->db->get()->row_array();
    }

    public function create_siswa($dataSiswa)
    {
        $this->db->insert('tbl_siswa', $dataSiswa);

        $query = $this->db->insert_id();

        return $query;
    }

    public function getEnumValues()
    {

        $query = $this->db->query("SHOW COLUMNS FROM tbl_siswa WHERE Field = 'Jenis_kelamin'");

        $row = $query->row();
        $enum_values = explode("','", substr($row->Type, 6, -2));

        return $enum_values;
    }

    public function updateSiswa($id_siswa, $dataSiswa)
    {
        $this->db->where('id_siswa', $id_siswa);
        $this->db->update('tbl_siswa', $dataSiswa);
    }

    public function deleteById($id_siswa)
    {
        $this->db->where('id_siswa', $id_siswa);
        return $this->db->delete('tbl_siswa');
    }

    // nilai

    public function get_data_perkelas($id_kelas, $tahun)
    {
        $tahun = ($tahun) ? $tahun['nama'] : 'null';
        return $this->_get_data_perkelas($id_kelas, $tahun)->result();
    }

    public function get_count_perkelas($id_kelas, $tahun)
    {
        $tahun = ($tahun) ? $tahun['nama'] : 'null';
        return $this->_get_data_perkelas($id_kelas, $tahun)->num_rows();
    }

    private function _get_data_perkelas($id_kelas, $tahun)
    {
        $this->db->select('*');
        $this->db->from('tbl_siswa ts');
        $this->db->join('tbl_kelas_siswa td', 'ts.id_siswa = td.id_siswa', 'left');
        $this->db->where('td.id_kelas', $id_kelas);
        $this->db->where('td.tahun_ajaran', $tahun);
        return $this->db->get();
    }

    public function get_count_allsiswa($tahun)
    {
        $tahun_ajaran = ($tahun) ? $tahun['nama'] : 'null';
        $this->db->select('*');
        $this->db->from('tbl_siswa');
        $this->db->join('tbl_kelas_siswa', 'tbl_kelas_siswa.id_siswa = tbl_siswa.id_siswa', 'inner');
        $this->db->where('tbl_kelas_siswa.tahun_ajaran', $tahun_ajaran);
        return $this->db->get()->num_rows();
    }
}
