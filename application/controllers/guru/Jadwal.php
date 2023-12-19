<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jadwal extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('JadwalModel');
        $this->load->model('MapelModel');
        $this->load->model('GuruModel');
        $this->load->model('User_model');
        $this->load->model('KelasModel');
        $this->load->model('Tahun_model');
        $this->load->library('form_validation');

        $this->output->set_header('Cache-Control: no-cache, must-revalidate');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0', false);
        $this->output->set_header('Pragma: no-cache');

        if (!isset($this->session->userdata['username']) && $this->session->userdata['level'] != 'admin') {
            $this->session->set_flashdata('message', 'Anda Belum Login!');
            redirect('login');
        }

        if ($this->session->userdata['level'] != 'guru') {
            $this->session->set_flashdata('message', 'Anda Belum Login!');
            redirect('login');
        }
    }

    public function index()
    {

        $data = $this->User_model->get_detail_guru($this->session->userdata['id_user'], $this->session->userdata['level']);
        $data = array(
            'id_user'   => $data['id_user'],
            'nama'      => $data['nama_guru'],
            'foto'     => $data['foto_guru'] != null ? $data['foto_guru'] : 'user-placeholder.jpg',
            'level'     => $data['level'],
            'dataJadwal' => $this->JadwalModel->getJadwal(),
            'dataMapel' => $this->MapelModel->getMapel(),
            'dataGuru' => $this->GuruModel->tampilGuru(),
            'dataKelas' => $this->KelasModel->tampilKelas(),
            'tahun'     => $this->Tahun_model->get_active_stats(),
            'menu'      => 'jadwal',
            'breadcrumb' => [
                0 => (object)[
                    'name' => 'Dashboard',
                    'link' => 'guru'
                ],
                1 => (object)[
                    'name' => 'Jadwal Pelajaran',
                    'link' => NULL
                ]
            ]
        );

        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php', $data);
        $this->load->view('_partials/sidebar.php', $data);
        $this->load->view('guru/jadwal.php', $data);
        $this->load->view('_partials/footer.php');
    }
}
