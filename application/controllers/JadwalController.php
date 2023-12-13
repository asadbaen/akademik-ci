<?php
defined('BASEPATH') or exit('No direct script access allowed');

class JadwalController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('JadwalModel');
        $this->load->model('MapelModel');
        $this->load->model('GuruModel');
        $this->load->model('KelasModel');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['dataJadwal'] = $this->JadwalModel->getJadwal();
        $data['dataMapel'] = $this->MapelModel->getMapel();
        $data['dataGuru'] = $this->GuruModel->tampilGuru();
        $data['dataKelas'] = $this->KelasModel->tampilKelas();

        // var_dump($data['dataGuru']);
        // die();

        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php');
        $this->load->view('_partials/sidebar.php');
        $this->load->view('dashboard/jadwal/index.php', $data);
        $this->load->view('_partials/footer.php');
    }

    public function create()
    {
        $data['dataMapel'] = $this->MapelModel->getMapel();
        $data['dataGuru'] = $this->GuruModel->tampilGuru();
        $data['dataKelas'] = $this->KelasModel->tampilKelas();

        // var_dump($data);
        // die();
        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php');
        $this->load->view('_partials/sidebar.php');
        $this->load->view('dashboard/jadwal/tambah.php', $data);
        $this->load->view('_partials/footer.php');
    }

    public function saveJadwal()
    {
        $this->form_validation->set_rules('mapel_id', 'Mata Pelajaran', 'trim|required');
        $this->form_validation->set_rules('guru_id', 'Kode Guru', 'trim|required');
        $this->form_validation->set_rules('hari', 'Hari', 'trim|required');
        $this->form_validation->set_rules('kelas_id', 'kelas_id', 'trim|required');
        $this->form_validation->set_rules('Tahun_ajaran', 'Tahun Ajaran', 'trim|required');

        if ($this->form_validation->run() == false) {

            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Form Tidak  lengkap ! Mohon Lengkapi Terlebih Dahulu !!!</div>');

            // kembalikan ke halaman user
            redirect('jadwal-create');
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
                'hari' => $this->input->post('hari'),
                'awal' => $jam_awal,
                'akhir' => $jam_akhir,
                'kelas_id' => $this->input->post('kelas_id'),
                'Tahun_ajaran' => $this->input->post('Tahun_ajaran')
            ];

            // var_dump($data);
            // die();
            $this->JadwalModel->createJadwal($data);



            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data berhasil ditambahkan! </div>');

            redirect('jadwal');
        }
    }

    public function edit($id_jadwal = null)
    {
        $data['jadwal'] = $this->JadwalModel->getById($id_jadwal);

        $data['dataMapel'] = $this->MapelModel->getMapel();
        $data['dataGuru'] = $this->GuruModel->tampilGuru();
        $data['dataKelas'] = $this->KelasModel->tampilKelas();


        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php');
        $this->load->view('_partials/sidebar.php');
        $this->load->view('dashboard/jadwal/edit.php', $data);
        $this->load->view('_partials/footer.php');
    }

    public function saveUpdate()
    {
        $this->form_validation->set_rules('mapel_id', 'Mata Pelajaran', 'trim|required');
        $this->form_validation->set_rules('guru_id', 'Kode Guru', 'trim|required');
        $this->form_validation->set_rules('hari', 'Hari', 'trim|required');
        $this->form_validation->set_rules('kelas_id', 'kelas_id', 'trim|required');
        $this->form_validation->set_rules('Tahun_ajaran', 'Tahun Ajaran', 'trim|required');

        if ($this->form_validation->run() == false) {

            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Form Tidak  lengkap ! Mohon Lengkapi Terlebih Dahulu !!!</div>');

            // kembalikan ke halaman user
            redirect('jadwal');
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
                'hari' => $this->input->post('hari'),
                'kelas_id' => $this->input->post('kelas_id'),
                'Tahun_ajaran' => $this->input->post('Tahun_ajaran'),
                'awal' => $jam_awal,
                'akhir' => $jam_akhir
            ];


            $this->JadwalModel->updateJadwal($id_jadwal, $data);



            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data berhasil di Update! </div>');

            redirect('jadwal');
        }
    }

    public function detail($id_jadwal)
    {
        $data['jadwal'] = $this->JadwalModel->getById($id_jadwal);
        $data['dataMapel'] = $this->MapelModel->getMapel();
        $data['dataGuru'] = $this->GuruModel->tampilGuru();
        $data['dataKelas'] = $this->KelasModel->tampilKelas();


        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php');
        $this->load->view('_partials/sidebar.php');
        $this->load->view('dashboard/jadwal/detail.php', $data);
        $this->load->view('_partials/footer.php');
    }

    public function delete($id_jadwal)
    {

        $result = $this->JadwalModel->deleteById($id_jadwal);

        if ($result) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Delete gagal! </div>');
            redirect('jadwal');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Delete Berhasil! </div>');
            redirect('jadwal');
        }


        redirect('jadwal');
    }
}
