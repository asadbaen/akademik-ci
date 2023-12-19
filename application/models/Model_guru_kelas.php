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

    public function get_detail_data($id_kelas_siswa)
    {
        return $this->db->get_where('tbl_kelas_siswa', ['id_kelas_siswa' => $id_kelas_siswa])->row_array();
    }


    public function get_count_pengampu($id_guru, $tahun)
    {
        $id_tahun = ($tahun) ? $tahun['id_tahun'] : 'null';
        $query = $this->db->query("
            select
                tm.jabatan ,count(tm.jumlah_kelas) as 'jumlah_kelas'
            from
                (
                select
                    tp.jabatan,
                    count(tp.kelas_id) as 'jumlah_kelas'
                from
                    tbl_jadwal_pelajaran tp
                where
                    tp.guru_id = $id_guru
                    and tp.id_tahun = $id_tahun
                group by
                    tp.kelas_id) tm");
        return $query->row_array();
    }

    public function get_count_siswa($id_guru, $tahun)
    {
        $tahun_ajaran = ($tahun) ? $tahun['nama'] : 'null';
        $query = $this->db->query("
        select 
            count(tm.jumlah_siswa) as 'jumlah_siswa'
        from (
            select 
                count(td.id_siswa) as 'jumlah_siswa' 
            from tbl_jadwal_pelajaran tp
            inner join tbl_kelas tk 
                on tk.id_kelas = tp.kelas_id 
            inner join tbl_kelas_siswa td 
                on td.id_kelas = tk.id_kelas 
            where tp.guru_id = $id_guru
                and td.tahun_ajaran = '$tahun_ajaran'
            group by td.id_siswa) tm");
        return $query->row_array();
    }

    public function get_mapel_pengampu($id_guru, $id_kelas = NULL, $id_mapel = NULL, $id_tahun = NULL)
    {
        $this->db->select('*');
        $this->db->from('tbl_jadwal_pelajaran tp');
        $this->db->join('tbl_kelas tk', 'tk.id_kelas = tp.kelas_id', 'left');
        $this->db->join('tbl_matapelajaran tm', 'tm.id_mapel = tp.mapel_id', 'left');
        $this->db->join('tb_tahunajaran tt', 'tt.id_tahun = tp.id_tahun', 'left');
        $this->db->where('tp.guru_id', $id_guru);
        $this->db->group_by('tk.id_kelas');
        $this->db->order_by('tk.nama_kelas', 'asc');

        if ($id_tahun) {
            $this->db->where('tt.id_tahun', $id_tahun);
        } else {
            $this->db->where('tt.status', '1');
        }

        if ($id_kelas) {
            $this->db->where('tp.kelas_id', $id_kelas);
        }

        if ($id_mapel) {
            $this->db->where('tp.mapel_id', $id_mapel);
        }

        return $this->db->get()->result();
        // $query = $this->db->get()->result();
        // var_dump($id_mapel);
        // die();
    }

    public function get_detail_data_with_kelas_and_mapel($id_kelas, $id_mapel)
    {
        $this->db->select('tp.id_jadwal, tg.id_guru, tg.nama_guru');
        $this->db->from('tbl_guru tg');
        $this->db->join('tbl_jadwal_pelajaran tp', 'tp.guru_id = tg.id_guru', 'inner');
        $this->db->join('tbl_kelas tk', 'tk.id_kelas = tp.kelas_id', 'inner');
        $this->db->join('tbl_matapelajaran tm', 'tm.id_mapel = tp.mapel_id', 'inner');
        $this->db->where('tm.id_mapel', $id_mapel);
        $this->db->where('tk.id_kelas', $id_kelas);
        return $this->db->get()->row_array();
    }

    public function get_allkelas_peserta($id_siswa)
    {
        $this->db->select('td.tahun_ajaran');
        $this->db->from('tbl_kelas_siswa td');
        $this->db->where('td.id_siswa', $id_siswa);
        return $this->db->get()->result();
    }

    public function get_data_with_tahun($id_tahun)
    {
        $this->db->select('tk.*, tt.nama as tahun');
        $this->db->from('tbl_jadwal_pelajaran tp');
        $this->db->join('tbl_guru tg', 'tp.guru_id = tg.id_guru', 'left');
        $this->db->join('tbl_matapelajaran tm', 'tp.mapel_id = tm.id_mapel', 'left');
        $this->db->join('tbl_kelas tk', 'tp.kelas_id  = tk.id_kelas', 'left');
        $this->db->join('tb_tahunajaran tt', 'tp.id_tahun = tt.id_tahun', 'left');
        $this->db->where('tt.id_tahun', $id_tahun);
        $this->db->group_by('tk.id_kelas');
        $this->db->order_by('tk.nama_kelas', 'asc');

        // $query = $this->db->get();

        // var_dump($query->result_array());
        // die();
        return $this->db->get();
    }
}
