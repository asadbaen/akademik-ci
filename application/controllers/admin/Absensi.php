<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Absensi extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_absensi');
        $this->load->model('Model_siswa_kelas');
        $this->load->model('User_model');

        $this->output->set_header('Cache-Control: no-cache, must-revalidate');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0', false);
        $this->output->set_header('Pragma: no-cache');

        if (!isset($this->session->userdata['username']) && $this->session->userdata['level'] != 'admin') {
            $this->session->set_flashdata('message', 'Anda Belum Login!');
            redirect('login');
        }

        if ($this->session->userdata['level'] != 'admin') {
            $this->session->set_flashdata('message', 'Anda Belum Login!');
            redirect('login');
        }
    }
    public function index()
    {
        if ($this->input->get("hari") != "") {
            $hari = $this->input->get("hari");
        } else {
            $getDay = date("l");
            $hari = getDay($getDay);
        }
        $data = $this->User_model->get_detail_admin($this->session->userdata['id_user'], $this->session->userdata['level']);
        $data = array(
            'id_user'       => $data['id_user'],
            'nama'          => $data['nama'],
            'foto'          => $data['foto'] != null ? $data['foto'] : 'user-placeholder.jpg',
            'level'         => $data['level'],
            'active'        => 'absensi',
            'title'         => 'absensi',
            'jadwal'        => $this->Model_absensi->all(array("hari" => $hari)),
            'menu'          => 'guru',
            'breadcrumb'    => [
                0 => (object)[
                    'name' => 'Dashboard',
                    'link' => 'admin'
                ],
                1 => (object)[
                    'name' => 'Absensi',
                    'link' => 'admin/absensi'
                ],
                2 => (object)[
                    'name' => 'Absensi',
                    'link' => NULL
                ]
            ]
        );

        // $data["active"] = "absensi";
        // $data["title"] = "absensi";
        // $data["jadwal"] = $this->Model_absensi->all(array("hari" => $hari));
        // $data["page"] = "jadwal/absensi";
        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php', $data);
        $this->load->view('_partials/sidebar.php', $data);
        $this->load->view('dashboard/absensi/index.php', array("contents" => $data));
        $this->load->view('_partials/footer.php');
    }

    public function isi_absensi($jadwal_id = null, $kelas_id = null, $mapel_id = null)
    {
        $getDay = date("l");
        $hari = getDay($getDay);

        $data = $this->User_model->get_detail_admin($this->session->userdata['id_user'], $this->session->userdata['level']);


        $data = array(
            'id_user'       => $data['id_user'],
            'nama'          => $data['nama'],
            'foto'          => $data['foto'] != null ? $data['foto'] : 'user-placeholder.jpg',
            'level'         => $data['level'],
            'active'        => 'absensi',
            'title'         => 'Isi Absensi',
            'absensi'        => $this->Model_absensi->absensi(array("id_jadwal" => $jadwal_id, "tbl_jadwal_pelajaran.kelas_id" => $kelas_id)),
            'detail_absensi'        =>  $this->Model_absensi->getAbsensi(array("jadwal_id" => $jadwal_id)),
            'menu'          => 'absensi',
            'breadcrumb'    => [
                0 => (object)[
                    'name' => 'Dashboard',
                    'link' => 'admin'
                ],
                1 => (object)[
                    'name' => 'Isi_absensi',
                    'link' => 'admin/isi_absensi'
                ],
                2 => (object)[
                    'name' => 'Isi Absensi',
                    'link' => NULL
                ]
            ]
        );



        if (empty($data["detail_absensi"])) {
            $data["edit"] = TRUE;
            $data["detail_absensi"] = $this->Model_siswa_kelas->getKelasSiswa($kelas_id);
        }

        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php', $data);
        $this->load->view('_partials/sidebar.php', $data);
        $this->load->view('dashboard/absensi/isi_absensi.php', array("contents" => $data));
        $this->load->view('_partials/footer.php');
    }

    public function save_absensi()
    {
        $siswa_id = $this->input->post("siswa_id");
        $absensi = $this->input->post("absensi");
        $kelas_id = $this->input->post("kelas_id");
        $mapel_id = $this->input->post("mapel_id");
        $jadwal_id = $this->input->post("jadwal_id");
        $keterangan = $this->input->post("keterangan");
        foreach ($siswa_id as $key => $value) {
            $params = array(
                "jadwal_id" => $jadwal_id,
                "kelas_id" => $kelas_id,
                "mapel_id" => $mapel_id,
                "siswa_id" => $siswa_id[$key],
                "absensi" => $absensi[$key],
                "keterangan" => $keterangan[$key],
                "created_at" => date("Y-m-d H:i:s")
            );

            $this->Model_absensi->save_absensi($params);
        }
        $this->session->set_flashdata("success", "Anda telah berhasil melakukan absensi");
        redirect("admin/absensi");
    }

    public function update_absensi()
    {
        $siswa_id = $this->input->post("siswa_id");
        $absensi = $this->input->post("absensi");
        $kelas_id = $this->input->post("kelas_id");
        $mapel_id = $this->input->post("mapel_id");
        $jadwal_id = $this->input->post("jadwal_id");
        $keterangan = $this->input->post("keterangan");
        foreach ($siswa_id as $key => $value) {
            $params = array(
                "jadwal_id" => $jadwal_id,
                "kelas_id" => $kelas_id,
                "mapel_id" => $mapel_id,
                "siswa_id" => $siswa_id[$key],
                "absensi" => $absensi[$key],
                "keterangan" => $keterangan[$key],
            );
            $where = array("absensi_id" => $this->input->post("absensi_id")[$key]);
            // var_dump($params, $where);
            // die();



            $this->Model_absensi->update_absensi($params, $where);
        }
        $this->session->set_flashdata("success", "Anda telah berhasil melakukan Edit absensi");
        redirect("admin/absensi");
    }
}
