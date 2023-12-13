<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kelas extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('KelasModel');
        $this->load->model('User_model');
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

    public function index()
    {
        $data = $this->User_model->get_detail_admin($this->session->userdata['id_user'], $this->session->userdata['level']);
        $data = array(
            'id_user'   => $data['id_user'],
            'nama'      => $data['nama'],
            'foto'     => $data['foto'] != null ? $data['foto'] : 'user-placeholder.jpg',
            'level'     => $data['level'],
            'dataKelas' => $this->KelasModel->tampilKelas(),
            'menu'      => 'siswa',
            'breadcrumb' => [
                0 => (object)[
                    'name' => 'Dashboard',
                    'link' => 'admin'
                ],
                1 => (object)[
                    'name' => 'Kelas',
                    'link' => NULL
                ]
            ]
        );
        // $data['dataKelas'] = $this->KelasModel->tampilKelas();

        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php', $data);
        $this->load->view('_partials/sidebar.php', $data);
        $this->load->view('dashboard/kelas/index.php', $data);
        $this->load->view('_partials/footer.php');
    }

    public function create()
    {
        $data = $this->User_model->get_detail_admin($this->session->userdata['id_user'], $this->session->userdata['level']);
        $data = array(
            'id_user'   => $data['id_user'],
            'nama'      => $data['nama'],
            'foto'     => $data['foto'] != null ? $data['foto'] : 'user-placeholder.jpg',
            'level'     => $data['level'],
            'menu'      => 'kelas',
            'breadcrumb' => [
                0 => (object)[
                    'name' => 'Dashboard',
                    'link' => 'admin'
                ],
                1 => (object)[
                    'name' => 'Kelas',
                    'link' => 'admin/kelas'
                ],
                2 => (object)[
                    'name' => 'Create',
                    'link' => NULL
                ]
            ]
        );

        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php', $data);
        $this->load->view('_partials/sidebar.php', $data);
        $this->load->view('dashboard/kelas/tambah.php', $data);
        $this->load->view('_partials/footer.php');
    }

    public function saveCreate()
    {
        $this->form_validation->set_rules('Tahun_ajaran', 'Tahun Ajar', 'trim|required');
        $this->form_validation->set_rules('nama_kelas', 'Kelas', 'trim|required');

        if ($this->form_validation->run() == false) {

            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Form Tidak  lengkap ! Mohon Lengkapi Terlebih Dahulu !!!</div>');

            // kembalikan ke halaman user
            redirect('admin/kelas');
        } else {
            $dataKelas = [
                'Tahun_ajaran' => $this->input->post('Tahun_ajaran'),
                'nama_kelas' => $this->input->post('nama_kelas'),
            ];

            // var_dump($dataKelas);
            // die();

            $this->KelasModel->create_kelas($dataKelas);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data berhasil ditambahkan! </div>');

            redirect('admin/kelas');
        }
    }



    public function edit($id_kelas)
    {
        $id_kelas           = $this->uri->segment(4);
        if (!$id_kelas) {
            redirect('admin/admin');
        }

        $kelas = $this->KelasModel->getKelasByid($id_kelas);
        if (!isset($kelas)) {
            redirect('error_404');
        }
        $data = $this->User_model->get_detail_admin($this->session->userdata['id_user'], $this->session->userdata['level']);
        $data = array(
            'id_user'       => $data['id_user'],
            'nama'          => $data['nama'],
            'level'         => $data['level'],
            'foto'         => $data['foto'] != null ? $data['foto'] : 'user-placeholder.jpg',
            'kelas'          => $kelas,
            'menu'          => 'kelas',
            'breadcrumb'    => [
                0 => (object)[
                    'name' => 'Dashboard',
                    'link' => 'admin'
                ],
                1 => (object)[
                    'name' => 'Kelas',
                    'link' => 'admin/kelas'
                ],
                2 => (object)[
                    'name' => 'Edit',
                    'link' => NULL
                ]
            ]
        );
        // $data['kelas'] = $this->KelasModel->getKelasByid($id_kelas);
        // var_dump($data);
        // die();


        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php', $data);
        $this->load->view('_partials/sidebar.php', $data);
        $this->load->view('dashboard/kelas/edit.php', $data);
        $this->load->view('_partials/footer.php');
    }

    public function saveUpdate()
    {
        $this->form_validation->set_rules('nama_kelas', 'kelas', 'trim|required');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Form Tidak  lengkap ! Mohon Lengkapi Terlebih Dahulu !!!</div>');

            // kembalikan ke halaman user
            redirect('admin/kelas');
        } else {
            $id_kelas = $this->input->post('id_kelas');
            $dataKelas = [
                'id_kelas' => $id_kelas,
                'nama_kelas' => $this->input->post('nama_kelas')
            ];

            $this->KelasModel->updateKelas($id_kelas, $dataKelas);



            redirect('admin/kelas');
        }
    }

    public function delete($id_kelas)
    {
        $result = $this->KelasModel->deleteById($id_kelas);

        if ($result) {
            $this->session->set_flashdata('message', 'Data Siswa Deleted Sucessfully');
            redirect('admin/kelas');
        } else {
            $this->session->set_flashdata('message', 'Data Siswa Deleted Failed');
            redirect('admin/kelas');
        }


        redirect('admin/kelas');
    }
}
