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
        $this->load->model('Model_guru_kelas');
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
            'dataJadwal' => $this->JadwalModel->getJadwal(),
            'dataMapel' => $this->MapelModel->getMapel(),
            'dataGuru' => $this->GuruModel->tampilGuru(),
            'dataKelas' => $this->KelasModel->tampilKelas(),
            'tahun'     => $this->Tahun_model->get_active_stats(),
            'menu'      => 'jadwal',
            'breadcrumb' => [
                0 => (object)[
                    'name' => 'Dashboard',
                    'link' => 'admin'
                ],
                1 => (object)[
                    'name' => 'Input',
                    'link' => NULL
                ]
            ]
        );
        // $data['dataJadwal'] = $this->JadwalModel->getJadwal();
        // $data['dataMapel'] = $this->MapelModel->getMapel();
        // $data['dataGuru'] = $this->GuruModel->tampilGuru();
        // $data['dataKelas'] = $this->KelasModel->tampilKelas();

        // var_dump($data['dataGuru']);
        // die();

        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php', $data);
        $this->load->view('_partials/sidebar.php', $data);
        $this->load->view('dashboard/jadwal/index.php', $data);
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
            'dataMapel' => $this->MapelModel->getMapel(),
            'dataGuru' => $this->GuruModel->tampilGuru(),
            'dataKelas' => $this->KelasModel->tampilKelas(),
            'tahun'     => $this->Tahun_model->get_active_stats(),
            'menu'      => 'jadwal',
            'breadcrumb' => [
                0 => (object)[
                    'name' => 'Dashboard',
                    'link' => 'admin'
                ],
                1 => (object)[
                    'name' => 'Jadwal',
                    'link' => 'admin/jadwal'
                ],
                2 => (object)[
                    'name' => 'Create',
                    'link' => NULL
                ]
            ]
        );
        // $data['dataMapel'] = $this->MapelModel->getMapel();
        // $data['dataGuru'] = $this->GuruModel->tampilGuru();
        // $data['dataKelas'] = $this->KelasModel->tampilKelas();

        // var_dump($data);
        // die();
        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php', $data);
        $this->load->view('_partials/sidebar.php', $data);
        $this->load->view('dashboard/jadwal/tambah.php', $data);
        $this->load->view('_partials/footer.php');
    }

    public function saveCreate()
    {
        $this->form_validation->set_rules('mapel_id', 'Mata Pelajaran', 'trim|required');
        $this->form_validation->set_rules('guru_id', 'Kode Guru', 'trim|required');
        $this->form_validation->set_rules('hari', 'Hari', 'trim|required');
        $this->form_validation->set_rules('kelas_id', 'kelas_id', 'trim|required');
        $this->form_validation->set_rules('tahun', 'kelas_id', 'trim|required');

        if ($this->form_validation->run() == false) {

            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Form Tidak  lengkap ! Mohon Lengkapi Terlebih Dahulu !!!</div>');

            // kembalikan ke halaman user
            redirect('admin/jadwal/create');
        } else {
            $awalj = $this->input->post("awalj");
            $akhirm = $this->input->post("akhirm");
            $jam_awal = $awalj . ":" . $akhirm;

            $awalj2 = $this->input->post("awalj2");
            $akhirm2 = $this->input->post("akhirm2");
            $jam_akhir = $awalj2 . ":" . $akhirm2;

            $data = [
                'mapel_id' => $this->input->post('mapel_id'),
                'guru_id' => $this->input->post('guru_id'),
                'jabatan' => $this->input->post('jabatan'),
                'hari' => $this->input->post('hari'),
                'awal' => $jam_awal,
                'akhir' => $jam_akhir,
                'kelas_id' => $this->input->post('kelas_id'),
                'id_tahun' => $this->input->post('tahun')
            ];

            // var_dump($data);
            // die();
            $this->JadwalModel->createJadwal($data);



            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data berhasil ditambahkan! </div>');

            redirect('admin/jadwal');
        }
    }

    public function edit($id_jadwal = null)
    {
        $id_jadwal           = $this->uri->segment(4);
        if (!$id_jadwal) {
            redirect('admin/admin');
        }

        $jadwal = $this->JadwalModel->getById($id_jadwal);
        if (!isset($jadwal)) {
            redirect('error_404');
        }
        $data = $this->User_model->get_detail_admin($this->session->userdata['id_user'], $this->session->userdata['level']);
        $data = array(
            'id_user'       => $data['id_user'],
            'nama'          => $data['nama'],
            'level'         => $data['level'],
            'foto'          => $data['foto'] != null ? $data['foto'] : 'user-placeholder.jpg',
            'jadwal'         => $jadwal,
            'dataMapel' => $this->MapelModel->getMapel(),
            'dataGuru' => $this->GuruModel->tampilGuru(),
            'dataKelas' => $this->KelasModel->tampilKelas(),
            'tahun'     => $this->Tahun_model->get_active_stats(),
            'pengajar'      => $this->Model_guru_kelas->get_detail_data($id_jadwal),
            'jabatan'   => ['Guru Kelas', 'Kepala Sekolah', 'TU', 'Guru BK'],
            'menu'          => 'jadwal',
            'breadcrumb'    => [
                0 => (object)[
                    'name' => 'Dashboard',
                    'link' => 'admin'
                ],
                1 => (object)[
                    'name' => 'Jadwal',
                    'link' => 'admin/jadwal'
                ],
                2 => (object)[
                    'name' => 'Edit',
                    'link' => NULL
                ]
            ]
        );

        // $data['jadwal'] = $this->JadwalModel->getById($id_jadwal);

        // $data['dataMapel'] = $this->MapelModel->getMapel();
        // $data['dataGuru'] = $this->GuruModel->tampilGuru();
        // $data['dataKelas'] = $this->KelasModel->tampilKelas();


        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php', $data);
        $this->load->view('_partials/sidebar.php', $data);
        $this->load->view('dashboard/jadwal/edit.php', $data);
        $this->load->view('_partials/footer.php');
    }

    public function saveUpdate()
    {
        $this->form_validation->set_rules('mapel_id', 'Mata Pelajaran', 'trim|required');
        $this->form_validation->set_rules('guru_id', 'Kode Guru', 'trim|required');
        $this->form_validation->set_rules('hari', 'Hari', 'trim|required');
        $this->form_validation->set_rules('kelas_id', 'kelas_id', 'trim|required');
        $this->form_validation->set_rules('tahun', 'Tahun Ajaran', 'trim|required');

        if ($this->form_validation->run() == false) {

            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Form Tidak  lengkap ! Mohon Lengkapi Terlebih Dahulu !!!</div>');

            // kembalikan ke halaman user
            redirect('admin/jadwal');
        } else {
            $id_jadwal = $this->input->post('id_jadwal');
            $awalj = $this->input->post("awalj");
            $akhirm = $this->input->post("akhirm");
            $jam_awal = $awalj . ":" . $akhirm;

            $awalj2 = $this->input->post("awalj2");
            $akhirm2 = $this->input->post("akhirm2");
            $jam_akhir = $awalj2 . ":" . $akhirm2;
            $data = [
                'id_jadwal' => $id_jadwal,
                'mapel_id' => $this->input->post('mapel_id'),
                'guru_id' => $this->input->post('guru_id'),
                'jabatan' => $this->input->post('jabatan'),
                'hari' => $this->input->post('hari'),
                'kelas_id' => $this->input->post('kelas_id'),
                'id_tahun' => $this->input->post('tahun'),
                'awal' => $jam_awal,
                'akhir' => $jam_akhir
            ];


            $this->JadwalModel->updateJadwal($id_jadwal, $data);



            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data berhasil di Update! </div>');

            redirect('admin/jadwal');
        }
    }

    public function detail($id_jadwal)
    {
        $data['jadwal'] = $this->JadwalModel->getById($id_jadwal);
        $data['dataMapel'] = $this->MapelModel->getMapel();
        $data['dataGuru'] = $this->GuruModel->tampilGuru();
        $data['dataKelas'] = $this->KelasModel->tampilKelas();


        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php', $data);
        $this->load->view('_partials/sidebar.php', $data);
        $this->load->view('dashboard/jadwal/detail.php', $data);
        $this->load->view('_partials/footer.php');
    }

    public function delete($id_jadwal)
    {

        $result = $this->JadwalModel->deleteById($id_jadwal);

        if ($result) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Delete gagal! </div>');
            redirect('admin/jadwal');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Delete Berhasil! </div>');
            redirect('admin/jadwal');
        }


        redirect('admin/jadwal');
    }
}
