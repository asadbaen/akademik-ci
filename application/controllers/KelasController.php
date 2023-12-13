<?php
defined('BASEPATH') or exit('No direct script access allowed');

class KelasController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('KelasModel');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['dataKelas'] = $this->KelasModel->tampilKelas();

        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php');
        $this->load->view('_partials/sidebar.php');
        $this->load->view('dashboard/kelas/index.php', $data);
        $this->load->view('_partials/footer.php');
    }

    public function createKelas()
    {

        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php');
        $this->load->view('_partials/sidebar.php');
        $this->load->view('dashboard/kelas/tambah.php');
        $this->load->view('_partials/footer.php');
    }

    public function saveCreateKelas()
    {
        $this->form_validation->set_rules('Tahun_ajaran', 'Tahun Ajar', 'trim|required');
        $this->form_validation->set_rules('nama_kelas', 'Kelas', 'trim|required');
        $this->form_validation->set_rules('jumlah_siswa', 'Jumlah Siswa', 'trim|required');

        if ($this->form_validation->run() == false) {

            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Form Tidak  lengkap ! Mohon Lengkapi Terlebih Dahulu !!!</div>');

            // kembalikan ke halaman user
            redirect('kelascontroller/createKelas');
        } else {
            $dataKelas = [
                'Tahun_ajaran' => $this->input->post('Tahun_ajaran'),
                'nama_kelas' => $this->input->post('nama_kelas'),
                'jumlah_siswa' => $this->input->post('jumlah_siswa'),
            ];

            // var_dump($dataKelas);
            // die();

            $this->KelasModel->create_kelas($dataKelas);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data berhasil ditambahkan! </div>');

            redirect('kelascontroller');
        }
    }

    public function detail($id_kelas)
    {
        $data['kelas'] = $this->KelasModel->getKelasById($id_kelas);
        // var_dump($data);
        // die();


        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php');
        $this->load->view('_partials/sidebar.php');
        $this->load->view('dashboard/kelas/detail.php', $data);
        $this->load->view('_partials/footer.php');
    }

    public function edit($id_kelas)
    {
        $data['kelas'] = $this->KelasModel->getKelasByid($id_kelas);
        // var_dump($data);
        // die();


        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php');
        $this->load->view('_partials/sidebar.php');
        $this->load->view('dashboard/kelas/edit.php', $data);
        $this->load->view('_partials/footer.php');
    }

    public function saveUpdate()
    {
        $this->form_validation->set_rules('Tahun_ajaran', 'Tahun ajaran Siswa', 'trim|required');
        $this->form_validation->set_rules('nama_kelas', 'kelas', 'trim|required');
        $this->form_validation->set_rules('jumlah_siswa', 'Jumlah Siswa', 'trim|required');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Form Tidak  lengkap ! Mohon Lengkapi Terlebih Dahulu !!!</div>');

            // kembalikan ke halaman user
            redirect('kelascontroller');
        } else {
            $id_kelas = $this->input->post('id_kelas');
            $dataKelas = [
                'id_kelas' => $id_kelas,
                'Tahun_ajaran' => $this->input->post('Tahun_ajaran'),
                'nama_kelas' => $this->input->post('nama_kelas'),
                'jumlah_siswa' => $this->input->post('jumlah_siswa')
            ];

            $this->KelasModel->updateKelas($id_kelas, $dataKelas);



            redirect('kelascontroller');
        }
    }

    public function delete($id_kelas)
    {
        $result = $this->KelasModel->deleteById($id_kelas);

        if ($result) {
            $this->session->set_flashdata('message', 'Data Siswa Deleted Sucessfully');
            redirect('kelascontroller');
        } else {
            $this->session->set_flashdata('message', 'Data Siswa Deleted Failed');
            redirect('kelascontroller');
        }


        redirect('kelascontroller');
    }

    public function kelasSatu()
    {
    }

    public function kelasDua()
    {
    }

    public function kelasTiga()
    {
    }
}
