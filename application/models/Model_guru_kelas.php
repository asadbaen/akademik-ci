<?php
defined('BASEPATH') or exit('No direct script access allowes');

class Model_guru_kelas extends CI_Model
{


    public function getAllKelasSiswa()
    {
        $this->db->select('*'); // Memilih seluruh kolom dari tbl_kelas_siswa
        $this->db->from('tbl_kelas_siswa');
        $this->db->join('tbl_siswa', 'tbl_siswa.id_siswa = tbl_kelas_siswa.id_siswa');
        $this->db->join('tbl_kelas', 'tbl_kelas.id_kelas = tbl_kelas_siswa.id_kelas');

        $query = $this->db->get();
        return $query->result_array();
    }


    public function tambah_siswa_kelas($data_kelas_siswa)
    {
        $nis = $data_kelas_siswa['id_siswa'];
        $id_kelas = $data_kelas_siswa['id_kelas'];

        // Check if NIS is available for the given class
        if ($this->isNISAvailable($nis, $id_kelas)) {
            $this->db->insert('tbl_kelas_siswa', $data_kelas_siswa);
            $insert_id = $this->db->insert_id();

            return $insert_id; // Berhasil menambahkan siswa ke kelas
        } else {
            return false; // NIS sudah terdaftar di kelas lain
        }
    }

    // Fungsi untuk mendapatkan ID siswa berdasarkan NIS
    public function getSiswaIdByNIS($nis)
    {
        $this->db->select('tbl_siswa.id_siswa');  // Pilih dari tbl_siswa
        $this->db->from('tbl_siswa');
        $this->db->where('nis', $nis);

        $query = $this->db->get();
        $result = $query->row();

        return $result ? $result->id_siswa : null;
    }


    // Fungsi untuk memeriksa apakah NIS tersedia untuk kelas tertentu
    public function isNISAvailable($nis, $kelas_id)
    {
        $this->db->from('tbl_kelas_siswa');
        $this->db->join('tbl_siswa', 'tbl_siswa.id_siswa = tbl_kelas_siswa.id_siswa');
        $this->db->where('tbl_siswa.nis', $nis);
        $this->db->where('tbl_kelas_siswa.id_kelas !=', $kelas_id);

        $query = $this->db->get();

        return $query->num_rows() == 0;
    }

    public function getKelasSiswaById($id_kelas_siswa)
    {
        $this->db->select('*');
        $this->db->from('tbl_kelas_siswa');
        $this->db->where('id_kelas_siswa', $id_kelas_siswa);

        $query = $this->db->get();

        return $query->row_array();
    }

    public function updateKelasSiswa($id_kelas_siswa, $data_kelas_siswa)
    {
        $this->db->where('id_kelas_siswa', $id_kelas_siswa);
        $this->db->update('tbl_kelas_siswa', $data_kelas_siswa);
    }

    public function isNISAvailableForUpdate($id_kelas_siswa, $nis, $id_kelas)
    {
        $this->db->select('*');
        $this->db->from('tbl_kelas_siswa');
        $this->db->join('tbl_siswa', 'tbl_siswa.id_siswa = tbl_kelas_siswa.id_siswa');
        $this->db->where('tbl_kelas_siswa.id_kelas_siswa', $id_kelas_siswa);
        $this->db->where('tbl_siswa.nis', $nis);
        $this->db->where('tbl_kelas_siswa.id_kelas', $id_kelas);

        $query = $this->db->get();

        return $query->num_rows() == 0 || $this->isNISInCurrentClass($id_kelas_siswa, $nis, $id_kelas);
    }

    private function isNISInCurrentClass($id_kelas_siswa, $nis, $id_kelas)
    {
        $this->db->where('id_kelas_siswa', $id_kelas_siswa);
        $this->db->where('nis', $nis);
        $this->db->where('id_kelas', $id_kelas);
        $query = $this->db->get('tbl_kelas_siswa');

        return $query->num_rows() > 0;
    }

    public function deleteById($id_kelas_siswa)
    {
        $this->db->where('id_kelas_siswa', $id_kelas_siswa);
        return $this->db->delete('tbl_kelas_siswa');
    }
}
