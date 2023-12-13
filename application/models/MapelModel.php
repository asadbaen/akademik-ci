<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MapelModel extends CI_Model
{
    protected $table_maple = "tbl_matapelajaran";

    public function getMapel()
    {
        $this->db->select('*');
        $this->db->from($this->table_maple);

        $query = $this->db->get();

        return $query->result_array();
    }

    public function createMapel()
    {
        // $this->db->insert($this->table_maple, $dataMapel);
        // $query = $this->db->insert_id();

        // return $query;

        $data = array(
            'nama_mapel'    => $this->input->post('nama_mapel', TRUE),
            'kode_mapel'    => $this->input->post('kode_mapel', TRUE)
        );

        $this->db->insert('tbl_matapelajaran', $data);

        $last_idmapel = $this->db->insert_id();
        $komp_dasar = $this->input->post('kd', TRUE);
        if (!empty($komp_dasar)) {
            foreach ($komp_dasar as $kd) {
                $data_kd_pts = array(
                    'nama_kd'           => $kd,
                    'id_mapel'          => $last_idmapel,
                    'jenis_penilaian'   => 'PTS'
                );

                $data_kd_pas = array(
                    'nama_kd'           => $kd,
                    'id_mapel'          => $last_idmapel,
                    'jenis_penilaian'   => 'PAS'
                );

                $this->db->insert('tb_kd', $data_kd_pts);
                $this->db->insert('tb_kd', $data_kd_pas);
            }
        }
    }

    public function getById($id_mapel)
    {
        $this->db->select('*');
        $this->db->from($this->table_maple);
        $this->db->where('id_mapel', $id_mapel);

        $query = $this->db->get();

        return $query->row_array();
    }

    public function updateMapel($id_mapel, $dataMapel)
    {
        $this->db->where('id_mapel', $id_mapel);
        $this->db->update($this->table_maple, $dataMapel);
    }

    public function deleteById($id_mapel)
    {
        $this->db->where('id_mapel', $id_mapel);

        return $this->db->delete($this->table_maple);
    }


    // nilai

    public function get_data()
    {
        return $this->db->get($this->table_maple)->result();
    }

    public function get_detail_data($id)
    {
        return $this->db->get_where($this->table_maple, ['id_mapel' => $id])->row_array();
    }

    public function get_mapel_with_kd_detail($id_mapel, $id_kelas)
    {
        $this->db->select('*');
        $this->db->from('tbl_matapelajaran tm');
        $this->db->join('tb_kd tk', 'tm.id_mapel = tk.id_mapel', 'inner');
        $this->db->join('tb_pengajar tp', 'tm.id_mapel = tp.id_mapel', 'inner');
        $this->db->where('tm.id_mapel', $id_mapel);
        $this->db->where('tp.id_kelas', $id_kelas);
        return $this->db->get()->result();
    }

    public function get_mapel_with_kd_nilai($id_mapel, $id_kelas, $jenis_nilai)
    {
        $this->db->select('*');
        $this->db->from('tbl_matapelajaran tm');
        $this->db->join('tb_kd tk', 'tm.id_mapel = tk.id_mapel', 'inner');
        $this->db->join('tb_pengajar tp', 'tm.id_mapel = tp.id_mapel', 'inner');
        $this->db->where('tm.id_mapel', $id_mapel);
        $this->db->where('tp.id_kelas', $id_kelas);
        $this->db->where('tk.jenis_penilaian', $jenis_nilai);
        $this->db->order_by('tk.nama_kd', 'asc');
        return $this->db->get()->result();
    }

    public function get_kd_permapel($id_mapel)
    {
        $this->db->select('*');
        $this->db->from('tb_kd');
        $this->db->where('id_mapel', $id_mapel);
        $this->db->order_by('nama_kd', 'asc');
        return $this->db->get()->result();
    }

    public function get_kd_detail($id_kd)
    {
        return $this->db->get_where('tb_kd', ['id_kd' => $id_kd])->row_array();
    }

    public function input_kd_inmapel($id_mapel)
    {
        $komp_dasar = $this->input->post('kd', TRUE);
        if (!empty($komp_dasar)) {
            foreach ($komp_dasar as $kd) {
                $data_kd_pts = array(
                    'nama_kd'           => $kd,
                    'id_mapel'          => $id_mapel,
                    'jenis_penilaian'   => 'PTS'
                );

                $data_kd_pas = array(
                    'nama_kd'           => $kd,
                    'id_mapel'          => $id_mapel,
                    'jenis_penilaian'   => 'PAS'
                );

                $this->db->insert('tb_kd', $data_kd_pts);
                $this->db->insert('tb_kd', $data_kd_pas);
            }
        }
    }

    public function get_mapel_with_kelas($id_kelas, $id_guru = NULL)
    {
        $this->db->select('tm.id_mapel, tm.nama_mapel');
        $this->db->from('tbl_matapelajaran tm');
        $this->db->join('tb_pengajar tp', 'tm.id_mapel = tp.id_mapel', 'left');
        $this->db->join('tbl_kelas tk', 'tp.id_kelas = tk.id_kelas', 'left');
        $this->db->where('tk.id_kelas', $id_kelas);
        if ($id_guru) {
            $this->db->where('tp.id_guru', $id_guru);
        }

        return $this->db->get();
    }

    public function input_data()
    {
        $data = array(
            'nama_mapel'    => $this->input->post('nama_mapel', TRUE),
            'level'         => $this->input->post('level', TRUE),
        );

        $this->db->insert('tbl_matapelajaran', $data);

        $last_idmapel = $this->db->insert_id();
        $komp_dasar = $this->input->post('kd', TRUE);
        if (!empty($komp_dasar)) {
            foreach ($komp_dasar as $kd) {
                $data_kd_pts = array(
                    'nama_kd'           => $kd,
                    'id_mapel'          => $last_idmapel,
                    'jenis_penilaian'   => 'PTS'
                );

                $data_kd_pas = array(
                    'nama_kd'           => $kd,
                    'id_mapel'          => $last_idmapel,
                    'jenis_penilaian'   => 'PAS'
                );

                $this->db->insert('tb_kd', $data_kd_pts);
                $this->db->insert('tb_kd', $data_kd_pas);
            }
        }
    }

    public function edit_data($id)
    {
        $data = array(
            'nama_mapel'    => $this->input->post('nama_mapel', TRUE),
            'level'         => $this->input->post('level', TRUE),
        );

        $this->db->where('id_mapel', $id);
        $this->db->update('tbl_matapelajaran', $data);
    }

    public function delete_data($id)
    {
        $this->db->delete('tbl_matapelajaran', ['id_mapel' => $id]);
    }

    public function delete_kd($kd, $id_mapel)
    {
        $this->db->delete('tb_kd', ['id_mapel' => $id_mapel, 'nama_kd' => $kd]);
    }

    var $column_order = array(null, 'nama_mapel', 'level'); //Sesuaikan dengan field
    var $column_search = array('nama_mapel', 'level'); //field yang diizin untuk pencarian 
    var $order = array('tbl_matapelajaran.level' => 'asc'); // default order 

    private function _get_datatables_query()
    {

        $this->db->from('tbl_matapelajaran');

        $i = 0;

        foreach ($this->column_search as $item) // looping awal
        {
            if ($_POST['search']['value']) // jika datatable mengirimkan pencarian dengan metode POST
            {

                if ($i === 0) // looping awal
                {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from('tbl_matapelajaran');
        return $this->db->count_all_results();
    }
}
