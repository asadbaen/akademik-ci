<?php
defined('BASEPATH') or exit('No direct script access allowed');

class KelasModel extends CI_Model
{
    public function tampilKelas()
    {
        $this->db->select('*');
        $this->db->from('tbl_kelas');

        $query = $this->db->get();

        return $query->result_array();
    }

    public function create_kelas($dataKelas)
    {
        $this->db->insert('tbl_kelas', $dataKelas);

        $query = $this->db->insert_id();

        return $query;
    }

    public function getKelasById($id_kelas)
    {
        $this->db->select('*');
        $this->db->from('tbl_kelas');
        $this->db->where('id_kelas', $id_kelas);

        $query = $this->db->get();

        return $query->row_array();
    }

    public function updateKelas($id_kelas, $dataKelas)
    {
        $this->db->where('id_kelas', $id_kelas);
        $this->db->update('tbl_kelas', $dataKelas);
    }

    public function deleteById($id_kelas)
    {
        $this->db->where('id_kelas', $id_kelas);
        return $this->db->delete('tbl_kelas');
    }

    public function get_count()
    {
        return $this->db->get('tbl_kelas')->num_rows();
    }

    public function getNamaKelasById($id_kelas)
    {
        $this->db->select('nama_kelas'); // Pilih hanya kolom nama_kelas
        $this->db->from('tbl_kelas');
        $this->db->where('id_kelas', $id_kelas);

        $query = $this->db->get();

        // Mengembalikan nilai tunggal, bukan array
        return $query->row('nama_kelas');
    }

    public function get_detail_siswa($id, $tahun)
    {
        $tahun = ($tahun) ? $tahun['nama'] : 'null';
        $this->db->from('tbl_kelas_siswa tks');
        $this->db->join('tbl_kelas tk', 'tk.id_kelas = tks.id_kelas', 'inner');
        $this->db->where('tks.id_siswa', $id);
        $this->db->where('tks.tahun_ajaran', $tahun);
        return $this->db->get()->row_array();
    }


    // Nilai
    public function get_data()
    {
        $this->db->from('tbl_kelas');
        $this->db->order_by('nama_kelas', 'asc');
        return $this->db->get()->result();
    }

    public function get_detail_data($id)
    {
        return $this->db->get_where('tbl_kelas', ['id_kelas' => $id])->row_array();
    }
}
