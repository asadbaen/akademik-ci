<?php
class Nilai_model extends CI_Model
{
    public function get_nilai_perkd($id_kelas, $id_mapel, $id_kd, $tahun)
    {
        $kelas = $id_kelas != null ? $id_kelas : 'null';
        $mapel = $id_mapel != null ? $id_mapel : 'null';
        $kd = $id_kd != null ? $id_kd : 'null';
        $tahun = $tahun != null ? $tahun : 'null';
        $jenis_nilai = $this->get_jenis_nilai_in_perkd($id_kelas, $id_mapel, $id_kd, $tahun);
        $query_select = "";

        // var_dump($kelas);
        // var_dump($mapel);
        // var_dump($kd);
        // var_dump($tahun);
        // die();

        foreach ($jenis_nilai as $jn => $value) {
            $query_select = $query_select . "sum( if ( nilai.jenis = '$value->jenis', nilai.nilai, null)) as '$value->jenis', ";
        }

        $query_select = substr($query_select, 0, -2);

        // var_dump($query_select);
        // die();

        if ($query_select != null) {
            $query = $this->db->query("select ts.nis ,ts.nama_siswa, $query_select, jm.jumlah, jm.rerata from tbl_siswa ts
                inner join (
                    select td.id_siswa, tn.nilai, tn.jenis from tb_nilai tn  
                        left join tb_kd tk 
                            on tn.id_kd = tk.id_kd 
                        left join tbl_matapelajaran tm 
                            on tk.id_mapel = tm.id_mapel
                        left join tbl_jadwal_pelajaran tp 
                            on tm.id_mapel = tp.mapel_id
                        left join tbl_kelas tk2 
                            on tp.kelas_id =tk2.id_kelas
                        left join tbl_kelas_siswa td 
                            on tn.id_kelas_siswa = td.id_kelas_siswa
                        left join tb_tahunajaran tt 
                            on tp.id_tahun = tt.id_tahun 
                    where tt.status = '1'
                        and tm.id_mapel = $mapel
                        and tk.id_kd = $kd
                        and tk2.id_kelas = $kelas
                        and td.tahun_ajaran = '$tahun') nilai on nilai.id_siswa = ts.id_siswa    
                inner join (
                    select td.id_siswa, sum(tn.nilai) as jumlah, round(avg(tn.nilai)) as rerata 
                    from tb_nilai tn 
                        inner join tbl_kelas_siswa td 
                            on tn.id_kelas_siswa = td.id_kelas_siswa 
                        inner join tb_kd tk 
                            on tn.id_kd = tk.id_kd
                        inner join tbl_matapelajaran tm 
                            on tk.id_mapel = tm.id_mapel
                    where 
                        tm.id_mapel = $mapel
                        and tk.id_kd = $kd
                        and td.id_kelas = $kelas
                    group by td.id_siswa) jm on jm.id_siswa = ts.id_siswa
                group by ts.nis");
            return $query->result_array();
            // var_dump($query);
            // die();
        } else {
            return null;
        }
    }

    public function get_jenis_nilai_in_perkd($id_kelas = null, $id_mapel = null, $id_kd = null, $tahun = null)
    {
        $query = $this->_get_jenis_nilai_inperkd($id_kelas, $id_mapel, $id_kd, $tahun);
        return $query->result();
    }

    public function get_jenis_nilai_in_perkd_array($id_kelas = null, $id_mapel = null, $id_kd = null, $tahun = null)
    {
        $query = $this->_get_jenis_nilai_inperkd($id_kelas, $id_mapel, $id_kd, $tahun);
        return $query->result_array();
    }

    private function _get_jenis_nilai_inperkd($id_kelas = null, $id_mapel = null, $id_kd = null, $tahun = null)
    {
        $kelas = $id_kelas != null ? $id_kelas : 'null';
        $mapel = $id_mapel != null ? $id_mapel : 'null';
        $tahun = $tahun != null ? $tahun : 'null';
        $kd = $id_kd != null ? $id_kd : 'null';
        $query = $this->db->query("select tn.jenis from tb_nilai tn  
            left join tb_kd tk 
                on tn.id_kd = tk.id_kd 
            left join tbl_matapelajaran tm 
                on tk.id_mapel = tm.id_mapel
            left join tbl_kelas_siswa td 
                on tn.id_kelas_siswa = td.id_kelas_siswa
            left join tbl_siswa ts 
                on td.id_siswa = ts.id_siswa
            left join tbl_jadwal_pelajaran tp 
                on td.id_kelas = tp.kelas_id
            left join tb_tahunajaran tt 
                on tp.id_tahun = tt.id_tahun  
            where
                tt.status = '1' 
                and tm.id_mapel = $mapel
                and tk.id_kd = $kd
                and td.id_kelas = $kelas
                and td.tahun_ajaran = '$tahun'
            group by tn.jenis");
        return $query;

        // var_dump($query->result_array());
        // die();
    }

    public function get_nilai_permapel($id_mapel, $id_kelas, $view, $id_tahun = NULL, $jenis_nilai = null)
    {
        $kelas          = $id_kelas != null ? $id_kelas : 'null';
        $mapel          = $id_mapel != null ? $id_mapel : 'null';
        $jenis_nilai    = $jenis_nilai != null ? $jenis_nilai : 'null';
        $kd             = $this->get_kd_permapel_result($mapel, $kelas, $jenis_nilai);
        $kd_row         = $this->get_kd_permapel_numrow($mapel, $kelas, $jenis_nilai);
        $query_select   = "";
        $query_join     = "";

        foreach ($kd as $key => $value) {
            switch ($view) {
                case 'min':
                    $query_select = $query_select . "min(round(kd$key.rerata)) as '$value->nama_kd', ";
                    break;
                case 'max':
                    $query_select = $query_select . "max(round(kd$key.rerata)) as '$value->nama_kd', ";
                    break;
                case 'jumlah':
                    $query_select = $query_select . "sum(round(kd$key.rerata)) as '$value->nama_kd', ";
                    break;
                case 'rerata':
                    $query_select = $query_select . "round(avg(kd$key.rerata)) as '$value->nama_kd', ";
                    break;
                default:
                    $query_select = $query_select . "round(kd$key.rerata) as '$value->nama_kd', ";
                    break;
            }

            $query_join = $query_join . "
                inner join (
                    select ts.id_siswa, ts.nis, ts.nama_siswa, sum(tn.nilai) as jumlah, avg(tn.nilai) as rerata 
                    from tb_nilai tn
                    inner join tbl_kelas_siswa td 
                        on tn.id_kelas_siswa = td.id_kelas_siswa 
                    inner join tbl_siswa ts 
                        on td.id_siswa = ts.id_siswa 
                    inner join tb_kd tk 
                        on tn.id_kd = tk.id_kd
                    inner join tbl_matapelajaran tm 
                        on tk.id_mapel = tm.id_mapel
                    inner join tbl_jadwal_pelajaran tp 
                        on tm.id_mapel = tp.mapel_id
                    inner join tb_tahunajaran tt 
                        on tp.id_tahun = tt.id_tahun
                    where tk.jenis_penilaian = '$jenis_nilai' and";
            if ($id_tahun) {
                $query_join = $query_join . " tt.id_tahun = $id_tahun";
            } else {
                $query_join = $query_join . " tt.status = '1'";
            }

            $query_join = $query_join . "
                        and tm.id_mapel = $mapel
                        and tk.id_kd = {$value->id_kd}
                        and td.id_kelas = $kelas
                    group by ts.id_siswa ) kd$key on ts.id_siswa = kd$key.id_siswa";
        }

        switch ($view) {
            case 'min':
                $query_select = $query_select . "min(round(nm.jumlah)) as jumlah, min(nm.rerata) as rerata";
                break;
            case 'max':
                $query_select = $query_select . "max(round(nm.jumlah)) as jumlah, max(nm.rerata) as rerata";
                break;
            case 'jumlah':
                $query_select = $query_select . "sum(round(nm.jumlah)) as jumlah, sum(nm.rerata) as rerata";
                break;
            case 'rerata':
                $query_select = $query_select . "round(avg(nm.jumlah)) as jumlah, round(avg(nm.rerata)) as rerata";
                break;
            default:
                $query_select = $query_select . "nm.jumlah as jumlah, nm.rerata as rerata";
                break;
        }

        if ($query_select != null || $query_join != null) {
            $query_join = $query_join . "
                inner join(
                        select ts.id_siswa, ts.nis, ts.nama_siswa, round(sum(tn.nilai)/$kd_row) as jumlah, round(avg(tn.nilai)) as rerata 
                        from tb_nilai tn
                        inner join tbl_kelas_siswa td 
                            on tn.id_kelas_siswa = td.id_kelas_siswa 
                        inner join tbl_siswa ts 
                            on td.id_siswa = ts.id_siswa 
                        inner join tb_kd tk 
                            on tn.id_kd = tk.id_kd
                        inner join tbl_matapelajaran tm 
                            on tk.id_mapel = tm.id_mapel
                        where 
                            tm.id_mapel = $mapel
                            and td.id_kelas = $kelas
                            and tk.jenis_penilaian = '$jenis_nilai'
                        group by ts.id_siswa) nm on ts.id_siswa = nm.id_siswa";

            $query = $this->db->query("select ts.id_siswa, ts.nis, ts.nama_siswa, $query_select from tbl_siswa ts $query_join order by ts.nis asc");
            return $query->result_array();
        } else {
            return null;
        }
    }

    public function get_kd_permapel_numrow($id_mapel = null, $id_kelas = null, $jenis_nilai = null)
    {
        return $this->_get_kd_permapel($id_mapel, $id_kelas, $jenis_nilai)->num_rows();
    }

    public function get_kd_permapel_result($id_mapel = null, $id_kelas = null, $jenis_nilai = null)
    {
        return $this->_get_kd_permapel($id_mapel, $id_kelas, $jenis_nilai)->result();
    }

    public function get_kd_permapel_array($id_mapel = null, $id_kelas = null, $jenis_nilai = null)
    {
        return $this->_get_kd_permapel($id_mapel, $id_kelas, $jenis_nilai)->result_array();;
    }

    private function _get_kd_permapel($id_mapel = null, $id_kelas = null, $jenis_nilai = null)
    {
        $this->db->select('tk.*');
        $this->db->from('tb_kd tk');
        $this->db->join('tb_nilai tn', 'tk.id_kd = tn.id_kd', 'inner');
        $this->db->join('tbl_kelas_siswa td', 'tn.id_kelas_siswa = td.id_kelas_siswa', 'inner');
        $this->db->join('tbl_siswa ts', 'td.id_siswa = ts.id_siswa', 'inner');
        $this->db->where('tk.id_mapel', $id_mapel);
        $this->db->where('tk.jenis_penilaian', $jenis_nilai);
        $this->db->where('td.id_kelas', $id_kelas);
        $this->db->group_by('tk.id_kd');
        $this->db->order_by('tk.nama_kd', 'asc');
        return $this->db->get();
    }

    public function input_nilai($data_murid, $id_kd)
    {
        foreach ($data_murid as $key => $value) {
            $data = array(
                'id_kelas_siswa'      => $value->id_kelas_siswa,
                'id_kd'         => $id_kd,
                'jenis'         => $this->input->post('jenis', TRUE),
                'nilai'         => $this->input->post('nilai' . $key, TRUE),
            );
            $this->db->insert('tb_nilai', $data);
        }
    }

    public function update_nilai($data_murid, $id_kd, $jenis)
    {
        foreach ($data_murid as $key => $value) {
            $data = array(
                'nilai'         => $this->input->post('nilai' . $key, TRUE),
            );
            $this->db->where('id_kelas_siswa', $value->id_kelas_siswa);
            $this->db->where('id_kd', $id_kd);
            $this->db->where('jenis', $jenis);
            $this->db->update('tb_nilai', $data);
        }
    }

    public function delete_nilai($id_kelas, $id_kd, $jenis, $tahun)
    {
        $this->db->query("delete tn from tb_nilai tn 
            inner join tbl_kelas_siswa td on tn.id_kelas_siswa = td.id_kelas_siswa
            where tn.id_kd = $id_kd
            and td.id_kelas = $id_kelas
            and td.tahun_ajaran = '$tahun'
            and tn.jenis = '$jenis'");
    }

    public function detail_nilai_perkd($id_kelas, $id_mapel, $id_kd, $jenis, $tahun)
    {
        $query = $this->db->query("select td.id_kelas_siswa, ts.id_siswa, ts.nis, ts.nama_siswa, tn.nilai, tn.jenis, tk.id_kd 
            from tb_nilai tn  
                left join tb_kd tk 
                    on tn.id_kd = tk.id_kd 
                left join tbl_matapelajaran tm 
                    on tk.id_mapel = tm.id_mapel
                left join tbl_kelas_siswa td
                    on tn.id_kelas_siswa = td.id_kelas_siswa 
                left join tbl_siswa ts 
                    on td.id_siswa = ts.id_siswa
            where 
                tm.id_mapel = $id_mapel
                and tk.id_kd = $id_kd
                and td.id_kelas = $id_kelas
                and tn.jenis = '$jenis'
                and td.tahun_ajaran = '$tahun'");

        return $query->result();
    }

    public function nilai_persiswa($id_siswa, $id_kelas, $id_tahun)
    {
        $query = $this->db->query("
            select
                tm.nama_mapel,
                coalesce(pts.nilai, 0) as pts,
                coalesce(pas.nilai, 0) as pas,
                coalesce(pts.nilai, 0) + coalesce(pas.nilai, 0) as 'jumlah',
                round((coalesce(pts.nilai, 0) + coalesce(pas.nilai, 0))/2) as 'rerata'
            from
                tbl_matapelajaran tm
            left join (
                select
                    ts.id_siswa,
                    ts.nis,
                    ts.nama_siswa,
                    round(avg(tn.nilai)) as nilai,
                    tm.id_mapel,
                    tm.nama_mapel
                from
                    tb_nilai tn
                inner join tbl_kelas_siswa td on
                    tn.id_kelas_siswa = td.id_kelas_siswa
                inner join tbl_siswa ts on
                    td.id_siswa = ts.id_siswa
                inner join tb_kd tk on
                    tn.id_kd = tk.id_kd
                inner join tbl_matapelajaran tm on
                    tk.id_mapel = tm.id_mapel
                inner join tbl_jadwal_pelajaran tp on
                    tp.mapel_id = tm.id_mapel
                inner join tb_tahunajaran tt on
                    tp.id_tahun = tt.id_tahun
                where
                    td.id_kelas = $id_kelas
                    and tk.jenis_penilaian = 'PTS'
                    and tt.id_tahun = $id_tahun
                    and td.id_siswa = $id_siswa
                group by
                    tm.id_mapel) pts on
                pts.id_mapel = tm.id_mapel
            left join (
                select
                    ts.id_siswa,
                    ts.nis,
                    ts.nama_siswa,
                    round(avg(tn.nilai)) as nilai,
                    tm.id_mapel,
                    tm.nama_mapel
                from
                    tb_nilai tn
                inner join tbl_kelas_siswa td on
                    tn.id_kelas_siswa = td.id_kelas_siswa
                inner join tbl_siswa ts on
                    td.id_siswa = ts.id_siswa
                inner join tb_kd tk on
                    tn.id_kd = tk.id_kd
                inner join tbl_matapelajaran tm on
                    tk.id_mapel = tm.id_mapel
                inner join tbl_jadwal_pelajaran tp on
                    tp.mapel_id = tm.id_mapel
                inner join tb_tahunajaran tt on
                    tp.id_tahun = tt.id_tahun
                where
                    td.id_kelas = $id_kelas
                    and tk.jenis_penilaian = 'PAS'
                    and tt.id_tahun = $id_tahun
                    and td.id_siswa = $id_siswa
                group by
                    tm.id_mapel) pas on
                pas.id_mapel = tm.id_mapel
            left join tbl_jadwal_pelajaran tp2 on
                tp2.mapel_id = tm.id_mapel
            where
                tp2.kelas_id = $id_kelas
            group by
                tm.id_mapel
        ");

        return $query->result();

        // var_dump($query->result());
        // die();
    }

    public function total_nilai_persiswa($id_siswa, $id_kelas, $id_tahun)
    {
        $query = $this->db->query("
            select
                sum(round((coalesce(pts.nilai, 0) + coalesce(pas.nilai, 0))/2)) as 'jumlah',
                round(avg(round((coalesce(pts.nilai, 0) + coalesce(pas.nilai, 0))/2))) as 'rerata'
            from
                tbl_matapelajaran tm
            left join (
                select
                    ts.id_siswa,
                    ts.nis,
                    ts.nama_siswa,
                    round(avg(tn.nilai)) as nilai,
                    tm.id_mapel,
                    tm.nama_mapel
                from
                    tb_nilai tn
                inner join tbl_kelas_siswa td on
                    tn.id_kelas_siswa = td.id_kelas_siswa
                inner join tbl_siswa ts on
                    td.id_siswa = ts.id_siswa
                inner join tb_kd tk on
                    tn.id_kd = tk.id_kd
                inner join tbl_matapelajaran tm on
                    tk.id_mapel = tm.id_mapel
                inner join tbl_jadwal_pelajaran tp on
                    tp.mapel_id = tm.id_mapel
                inner join tb_tahunajaran tt on
                    tp.id_tahun = tt.id_tahun
                where
                    td.id_kelas = $id_kelas
                    and tk.jenis_penilaian = 'PTS'
                    and tt.id_tahun = $id_tahun
                    and td.id_siswa = $id_siswa
                group by
                    tm.id_mapel) pts on
                pts.id_mapel = tm.id_mapel
            left join (
                select
                    ts.id_siswa,
                    ts.nis,
                    ts.nama_siswa,
                    round(avg(tn.nilai)) as nilai,
                    tm.id_mapel,
                    tm.nama_mapel
                from
                    tb_nilai tn
                inner join tbl_kelas_siswa td on
                    tn.id_kelas_siswa = td.id_kelas_siswa
                inner join tbl_siswa ts on
                    td.id_siswa = ts.id_siswa
                inner join tb_kd tk on
                    tn.id_kd = tk.id_kd
                inner join tbl_matapelajaran tm on
                    tk.id_mapel = tm.id_mapel
                inner join tbl_jadwal_pelajaran tp on
                    tp.mapel_id = tm.id_mapel
                inner join tb_tahunajaran tt on
                    tp.id_tahun = tt.id_tahun
                where
                    td.id_kelas = $id_kelas
                    and tk.jenis_penilaian = 'PAS'
                    and tt.id_tahun = $id_tahun
                    and td.id_siswa = $id_siswa
                group by
                    tm.id_mapel) pas on
                pas.id_mapel = tm.id_mapel
            left join tbl_jadwal_pelajaran tp2 on
                tp2.mapel_id = tm.id_mapel
            where
                tp2.kelas_id = $id_kelas
        ");

        return $query->row_array();
    }
}
