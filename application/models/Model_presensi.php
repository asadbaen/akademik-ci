<?php
defined('BASEPATH') or exit('No direct scipt access allowed');

class Model_presensi extends CI_Model
{
    protected $table = "tbl_jadwal_pelajaran";
    protected $table_kelas = "tbl_kelas";
    protected $table_mapel = "tbl_matapelajaran";
    protected $table_guru = "tbl_guru";
    protected $table_absensi = "tbl_absensi";
    protected $table_siswa = "tbl_siswa";

    public function all($where = array())
    {
        $this->db->join("$this->table_kelas", "$this->table.kelas=$this->table_kelas.Id_kelas", "LEFT");
        $this->db->join("$this->table_mapel", "$this->table.nama_mapel=$this->table_mapel.id_mapel", "LEFT");
        $this->db->join("$this->table_guru", "$this->table.kode_guru=$this->table_guru.Id_guru", "LEFT");
        if (!empty($where)) {
            $this->db->where($where);
        }
        // $query = 
        return $this->db->order_by("id_jadwal_pelajaran", "DESC")->get($this->table)->result();

        // var_dump($query);
        // die();
    }


    // public function absensi($where = array())
    // {
    //     $this->db->join("$this->table_kelas", "$this->table.kelas=$this->table_kelas.Id_kelas", "LEFT");
    //     $this->db->join("$this->table_mapel", "$this->table.nama_mapel=$this->table_mapel.id_mapel", "LEFT");
    //     $this->db->join("$this->table_guru", "$this->table.kode_guru=$this->table_guru.Id_guru", "LEFT");
    //     if (!empty($where)) {
    //         $this->db->where($where);
    //     }

    //     return $this->db->order_by("id_jadwal_pelajaran", "DESC")->get($this->table)->row();
    // }

    public function absensi($where = array())
    {
        $this->db->join("$this->table_kelas", "$this->table.kelas=$this->table_kelas.Id_kelas", "LEFT");
        $this->db->join("$this->table_mapel", "$this->table.nama_mapel=$this->table_mapel.id_mapel", "LEFT");
        $this->db->join("$this->table_guru", "$this->table.kode_guru=$this->table_guru.Id_guru", "LEFT");

        if (!empty($where)) {
            $this->db->where($where);
        }

        $result = $this->db->order_by("id_jadwal_pelajaran", "DESC")->get($this->table)->row();

        // Tambahkan penanganan jika hasil tidak ditemukan
        if (empty($result)) {
            // Misalnya, set nilai default atau kirim pesan bahwa data tidak ditemukan
            return (object) array(
                'kelas_id' => '',
                'mapel_id' => '',
                'siswa_id' => '',
                'jadwal_id' => '',
                // tambahkan properti lain sesuai kebutuhan
            );
        }

        return $result;
    }


    public function getAbsensi($where, $dateNow = null)
    {
        if (!empty($where)) {
            $this->db->where($where);
        }
        if ($dateNow == null) {
            $dateStart = date("Y-m-d") . " 00:00:00";
            $dateEnd = date("Y-m-d") . " 23:59:59";
            $this->db->join($this->table_siswa, "$this->table_absensi.siswa_id=$this->table_siswa.Id_siswa")->where("$this->table_absensi.created_at BETWEEN '$dateStart' AND '$dateEnd'");
        }
        return $this->db->get($this->table_absensi)->result();
    }



    public function save_absensi($params = array())
    {
        $this->db->insert($this->table_absensi, $params);
        // $query = $this->db->insert_id();
        return true;
    }

    public function updateMapel($id_mapel, $dataMapel)
    {
        $this->db->where('id_mapel', $id_mapel);
        $this->db->update($this->table_maple, $dataMapel);
    }

    public function update_absensi($where = array(), $params = array())
    {
        $this->db->where('absensi_id', $where);
        $this->db->update($this->table_absensi, $params);
        return true;
    }

    public function getDaftarPresensi()
    {
        // Sesuaikan nama tabel dan kolom sesuai dengan struktur database Anda
        $this->db->select('id_presensi, id_siswa, tanggal, hadir, keterangan');
        $this->db->from('tbl_presensi');

        $query = $this->db->get();
        return $query->result();
    }
}
