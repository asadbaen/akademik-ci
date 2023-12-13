<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mapel extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('MapelModel');
        $this->load->model('GuruModel');
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
            'dataMapel' => $this->MapelModel->getMapel(),
            'menu'      => 'mapel',
            'breadcrumb' => [
                0 => (object)[
                    'name' => 'Dashboard',
                    'link' => 'admin'
                ],
                1 => (object)[
                    'name' => 'Data tables',
                    'link' => NULL
                ]
            ]
        );
        // $data['dataMapel'] = $this->MapelModel->getMapel();
        // $data['dataGuru'] = $this->GuruModel->tampilGuru();

        // var_dump($data['dataGuru']);
        // die();

        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php', $data);
        $this->load->view('_partials/sidebar.php', $data);
        $this->load->view('dashboard/mapel/index.php', $data);
        $this->load->view('_partials/footer.php');
    }

    public function kd()
    {
        $id   = $this->input->get('id_mapel', TRUE);

        var_dump($id);
        die();
        if (!$id) {
            redirect('admin/mapel');
        }

        $mapel = $this->MapelModel->get_detail_data($id);
        if (!isset($mapel)) {
            redirect('error_404');
        }

        $data = array(
            'mapel'     => $mapel,
            'komp_dasar' => $this->MapelModel->get_kd_permapel($id),

        );

        $this->_rules_kd();

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('_partials/header.php');
            $this->load->view('_partials/navbar.php', $data);
            $this->load->view('_partials/sidebar.php', $data);
            $this->load->view('dashboard/mapel/mapel_kd.php', $data);
            $this->load->view('_partials/footer.php');
        } else {
            $this->MapelModel->input_kd_inmapel($id);
            $this->session->set_flashdata('message', 'Data Kompetensi Dasar Berhasil Ditambahkan!');
            redirect('admin/mapel/kd?id_mapel=' . $id);
        }
    }

    public function create()
    {
        $data = $this->User_model->get_detail_admin($this->session->userdata['id_user'], $this->session->userdata['level']);
        $data = array(
            'id_user'   => $data['id_user'],
            'nama'      => $data['nama'],
            'foto'     => $data['foto'] != null ? $data['foto'] : 'user-placeholder.jpg',
            'level'     => $data['level'],
            'menu'      => 'mapel',
            'breadcrumb' => [
                0 => (object)[
                    'name' => 'Dashboard',
                    'link' => 'admin'
                ],
                1 => (object)[
                    'name' => 'Mapel',
                    'link' => 'admin/mapel'
                ],
                2 => (object)[
                    'name' => 'Create',
                    'link' => NULL
                ]
            ]
        );
        // $data['dataGuru'] = $this->GuruModel->tampilGuru();

        // var_dump($data);
        // die();
        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php', $data);
        $this->load->view('_partials/sidebar.php', $data);
        $this->load->view('dashboard/mapel/tambah.php', $data);
        $this->load->view('_partials/footer.php');
    }

    public function saveCreate()
    {

        $this->_rules();

        if (
            $this->form_validation->run() == FALSE
        ) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Form Tidak  lengkap ! Mohon Lengkapi Terlebih Dahulu !!!</div>');

            // kembalikan
            redirect('admin/mapel/create');
        } else {
            $this->MapelModel->createMapel();
            $this->session->set_flashdata('message', 'Data Mata Pelajaran Berhasil Ditambahkan!');
            redirect('admin/mapel');
        }
    }

    public function edit($id_mapel)
    {
        $id_mapel           = $this->uri->segment(4);
        if (!$id_mapel) {
            redirect('admin/admin');
        }

        $mapel = $this->MapelModel->getById($id_mapel);
        if (!isset($mapel)) {
            redirect('error_404');
        }
        $data = $this->User_model->get_detail_admin($this->session->userdata['id_user'], $this->session->userdata['level']);
        $data = array(
            'id_user'       => $data['id_user'],
            'nama'          => $data['nama'],
            'level'         => $data['level'],
            'foto'          => $data['foto'] != null ? $data['foto'] : 'user-placeholder.jpg',
            'mapel'         => $mapel,
            'guru'      => $this->GuruModel->tampilGuru(),
            'menu'          => 'mapel',
            'breadcrumb'    => [
                0 => (object)[
                    'name' => 'Dashboard',
                    'link' => 'admin'
                ],
                1 => (object)[
                    'name' => 'Mapel',
                    'link' => 'admin/mapel'
                ],
                2 => (object)[
                    'name' => 'Edit',
                    'link' => NULL
                ]
            ]
        );
        // $data['mapel'] = $this->MapelModel->getById($id_mapel);
        // $data['guru'] = $this->GuruModel->tampilGuru();


        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php', $data);
        $this->load->view('_partials/sidebar.php', $data);
        $this->load->view('dashboard/mapel/edit.php', $data);
        $this->load->view('_partials/footer.php');
    }

    public function saveUpdate()
    {
        $this->form_validation->set_rules('nama_mapel', 'Mata Pelajaran', 'trim|required');
        $this->form_validation->set_rules('kode_mapel', 'Kode Mapel', 'trim|required');
        $this->form_validation->set_rules('guru_id', 'Kode Guru', 'trim|required');

        if ($this->form_validation->run() == false) {

            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Form Tidak  lengkap ! Mohon Lengkapi Terlebih Dahulu !!!</div>');

            // kembalikan ke halaman user
            redirect('admin/mapel');
        } else {
            $id_mapel = $this->input->post('id_mapel');
            $dataMapel = [
                'id_mapel' => $id_mapel,
                'nama_mapel' => $this->input->post('nama_mapel'),
                'kode_mapel' => $this->input->post('kode_mapel')
            ];

            $this->MapelModel->updateMapel($id_mapel, $dataMapel);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data berhasil ditambahkan! </div>');

            redirect('admin/mapel');
        }
    }

    public function detail($id_mapel)
    {
        $id_mapel           = $this->uri->segment(4);
        if (!$id_mapel) {
            redirect('admin/admin');
        }

        $mapel = $this->MapelModel->getById($id_mapel);
        if (!isset($mapel)) {
            redirect('error_404');
        }
        $data = $this->User_model->get_detail_admin($this->session->userdata['id_user'], $this->session->userdata['level']);
        $data = array(
            'id_user'       => $data['id_user'],
            'nama'          => $data['nama'],
            'level'         => $data['level'],
            'foto'          => $data['foto'] != null ? $data['foto'] : 'user-placeholder.jpg',
            'mapel'         => $mapel,
            'menu'          => 'mapel',
            'breadcrumb'    => [
                0 => (object)[
                    'name' => 'Dashboard',
                    'link' => 'admin'
                ],
                1 => (object)[
                    'name' => 'Mapel',
                    'link' => 'admin/mapel'
                ],
                2 => (object)[
                    'name' => 'Edit',
                    'link' => NULL
                ]
            ]
        );
        // $data['mapel'] = $this->MapelModel->getById($id_mapel);
        // $data['dataGuru'] = $this->GuruModel->tampilGuru();


        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php', $data);
        $this->load->view('_partials/sidebar.php', $data);
        $this->load->view('dashboard/mapel/detail.php', $data);
        $this->load->view('_partials/footer.php');
    }

    public function delete($id_mapel)
    {

        $result = $this->MapelModel->deleteById($id_mapel);

        if ($result) {
            $this->session->set_flashdata('message', 'Data Deleted Sucessfully');
            redirect('admin/mapel');
        } else {
            $this->session->set_flashdata('message', 'Data Deleted Failed');
            redirect('admin/mapel');
        }


        redirect('admin/mapel');
    }

    private function _rules()
    {
        $this->form_validation->set_rules('nama_mapel', 'Nama Mata Pelajaran', 'required|max_length[100]');
        $this->form_validation->set_rules('kode_mapel', 'kode mapel', 'required');
    }

    private function _rules_kd()
    {
        $this->form_validation->set_rules('kd[]', 'Kompetensi Dasar', 'required');
    }
}
