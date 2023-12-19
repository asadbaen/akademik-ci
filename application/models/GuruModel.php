<?php

class GuruModel extends CI_Model
{
    public function getEnumValues()
    {

        $query = $this->db->query("SHOW COLUMNS FROM tbl_guru WHERE Field = 'Jenis_kelamin'");

        $row = $query->row();
        $enum_values = explode("','", substr($row->Type, 6, -2));

        return $enum_values;
    }

    public function tampilGuru()
    {
        $this->db->select('*');
        $this->db->from('tbl_guru');

        $query = $this->db->get();

        return $query->result_array();
    }

    public function tambahGuru($dataGuru)
    {
        $this->db->insert('tbl_guru', $dataGuru);

        $query = $this->db->insert_id();

        return $query;
    }


    public function tampilGuruId($id_guru)
    {
        $this->db->select('*');
        $this->db->from('tbl_guru');
        $this->db->where('id_guru', $id_guru);

        $query = $this->db->get();
        return $query->row_array();
    }

    public function updateGuru($id_guru, $dataGuru)
    {
        $this->db->where('id_guru', $id_guru);
        $this->db->update('tbl_guru', $dataGuru);
    }

    public function deleteById($id_guru)
    {
        $this->db->where('id_guru', $id_guru);
        return $this->db->delete('tbl_guru');
    }


    public function get_count($tahun)
    {
        $tahun_ajaran = ($tahun) ? $tahun['nama'] : 'null';
        $this->db->from('tbl_guru tg');
        $this->db->join('tbl_jadwal_pelajaran tp', 'tp.guru_id = tg.id_guru', 'inner');
        $this->db->join('tb_tahunajaran tt', 'tt.id_tahun = tp.id_tahun', 'inner');
        $this->db->where('tt.nama', $tahun_ajaran);
        $this->db->group_by('tg.id_guru');
        return $this->db->get()->num_rows();
    }


    public function get_detail_data($id_guru, $id_user = NULL, $name = NULL)
    {
        if ($id_user) {
            return $this->db->get_where('tbl_guru', ['id_user' => $id_user])->row_array();
        } elseif ($name) {
            return $this->db->get_where('tbl_guru', ['nama_guru' => $name])->row_array();
        } else {
            return $this->db->get_where('tbl_guru', ['id_guru' => $id_guru])->row_array();
        }
    }
}
