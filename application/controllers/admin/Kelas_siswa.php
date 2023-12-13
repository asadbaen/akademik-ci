<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kelas_siswa extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_siswa_kelas');
        $this->load->model('User_model');
        $this->load->model('KelasModel');
        $this->load->library('form_validation');

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

    public function kelasId($kelas_id)
    {
        $data = $this->User_model->get_detail_admin($this->session->userdata['id_user'], $this->session->userdata['level']);
        $data_siswa_kelas = $this->Model_siswa_kelas->getKelasSiswa($kelas_id);
        $get_kelas = $this->KelasModel->getNamaKelasById($kelas_id);

        // foreach ($get_kelas as $siswa) {
        //     $nama_kelas_array[] = $siswa->nama_kelas; // Sesuaikan dengan nama kolom yang sesuai
        // }
        // $nama_kelas = $get_kelas;
        // var_dump($get_kelas);
        // die();
        $data = array(
            'id_user'   => $data['id_user'],
            'nama'      => $data['nama'],
            'foto'     => $data['foto'] != null ? $data['foto'] : 'user-placeholder.jpg',
            'level'     => $data['level'],
            'students_by_class' => $data_siswa_kelas,
            'nama_kelas' => $get_kelas,
            'menu'      => 'kelas_siswa',
            'breadcrumb' => [
                0 => (object)[
                    'name' => 'Dashboard',
                    'link' => 'admin'
                ],
                1 => (object)[
                    'name' => 'admin/siswa_kelas/kelas/',
                    'link' => NULL
                ]
            ]
        );
        // $data['students_by_class'] = $this->Model_siswa_kelas->getKelasSiswa($kelas_id);

        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php', $data);
        $this->load->view('_partials/sidebar.php', $data);
        $this->load->view('dashboard/kelas/siswa/students_by_class_view.php', $data);
        $this->load->view('_partials/footer.php');
    }
}
