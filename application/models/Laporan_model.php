<?php
class Laporan_model extends CI_Model
{

    public function get_data_nilai($id_tahun, $id_kelas, $view = 'default', $jenis = null, $id_guru = NULL)
    {
        $id_tahun       = ($id_tahun != null) ? $id_tahun : 'null';
        $id_kelas       = ($id_kelas != null) ? $id_kelas : 'null';
        $tahun          = $this->_get_detail_tahun($id_tahun);
        $name_tahun     = $tahun['nama'];
        $get_mapel      = $this->get_mapel_pertahun($id_tahun, $id_kelas, $id_guru);
        $mapel          = ($get_mapel->num_rows() > 0) ? $get_mapel->result() : null;
        $guru           = ($id_guru != null) ? " and tp.id_guru = $id_guru " : '';
        $query_join     = "";
        $query_select   = "";
        $query_select_injoin = "";

        if (!isset($mapel)) {
            return null;
        }

        foreach ($mapel as $key => $value) {
            $query_select_injoin .= "sum(if (nilai.nama_mapel = '$value->nama_mapel', nilai.nilai, 0)) as nilai$key, ";

            switch ($view) {
                case 'min':
                    $query_select .= "min(hasil.nilai$key) as '$value->nama_mapel', ";
                    break;
                case 'max':
                    $query_select .= "max(hasil.nilai$key) as '$value->nama_mapel', ";
                    break;
                case 'jumlah':
                    $query_select .= "sum(hasil.nilai$key) as '$value->nama_mapel', ";
                    break;
                case 'rerata':
                    $query_select .= "round(avg(hasil.nilai$key)) as '$value->nama_mapel', ";
                    break;
                default:
                    $query_select .= "hasil.nilai$key as '$value->nama_mapel', ";
                    break;
            }
        }

        switch ($view) {
            case 'min':
                $query_select .= "min(hasil.jumlah) as 'jumlah', min(hasil.rerata) as 'rerata'";
                break;
            case 'max':
                $query_select .= "max(hasil.jumlah) as 'jumlah', max(hasil.rerata) as 'rerata'";
                break;
            case 'jumlah':
                $query_select .= "sum(hasil.jumlah) as 'jumlah', sum(hasil.rerata) as 'rerata'";
                break;
            case 'rerata':
                $query_select .= "round(avg(hasil.jumlah)) as 'jumlah', round(avg(hasil.rerata)) as 'rerata'";
                break;
            default:
                $query_select .= "hasil.jumlah as 'jumlah', hasil.rerata as 'rerata'";
                break;
        }

        $query_join = "select ts.nis, ts.nik, ts.nama_siswa, $query_select_injoin round(sum(nilai.nilai)) as 'jumlah', round(avg(nilai.nilai)) as 'rerata' from tbl_siswa ts 
            inner join (
                select ts.id_siswa, ts.nis, ts.nama_siswa, round(avg(tn.nilai)) as nilai, tm.id_mapel, tm.nama_mapel 
                from tb_nilai tn 
                inner join tbl_kelas_siswa td on 
                    tn.id_kelas_siswa = td.id_kelas_siswa 
                inner join tbl_siswa ts on
                    td.id_siswa = ts.id_siswa
                inner join tb_kd tk on
                    tn.id_kd = tk.id_kd
                inner join tbl_matapelajaran tm on
                    tk.id_mapel = tm.id_mapel
                inner join tb_pengajar tp on
                    tp.id_mapel = tm.id_mapel 
                where td.id_kelas = $id_kelas
                    and td.tahun_ajaran = '$name_tahun'
                    and tk.jenis_penilaian = '$jenis' $guru
                group by ts.nis, tm.id_mapel) nilai on nilai.id_siswa = ts.id_siswa
                group by ts.nis";

        // var_dump($query_select);
        // die();

        if ($query_select != null || $query_join != null) {
            $query = "select ts.nis, ts.nik, ts.nama_siswa, $query_select from tbl_siswa ts
                inner join ($query_join) hasil on
                hasil.nis = ts.nis";
            // var_dump($this->db->query($query)->result_array());
            // die();
            return $this->db->query($query)->result_array();
        } else {
            return null;
        }
    }


    private function _get_detail_tahun($id)
    {
        return $this->db->get_where('tb_tahunajaran', ['id_tahun' => $id])->row_array();
    }

    public function get_mapel_pertahun($id_tahun, $id_kelas, $id_guru = NULL)
    {
        $this->db->select('tm.*');
        $this->db->from('tbl_matapelajaran tm');
        $this->db->join('tb_pengajar tp', 'tm.id_mapel = tp.id_mapel', 'left');
        $this->db->where('tp.id_tahun', $id_tahun);
        $this->db->where('tp.id_kelas', $id_kelas);
        if ($id_guru != null) {
            $this->db->where('tp.id_guru', $id_guru);
        }
        return $this->db->get();
    }
}
