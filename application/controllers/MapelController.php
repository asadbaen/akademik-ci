<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MapelController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('MapelModel');
        $this->load->model('GuruModel');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['dataMapel'] = $this->MapelModel->getMapel();
        $data['dataGuru'] = $this->GuruModel->tampilGuru();

        // var_dump($data['dataGuru']);
        // die();

        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php');
        $this->load->view('_partials/sidebar.php');
        $this->load->view('dashboard/mapel/index.php', $data);
        $this->load->view('_partials/footer.php');
    }

    public function kd()
    {
        $id   = $this->input->get('id_mapel', TRUE);
        if (!$id) {
            redirect('MapelController');
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
            $this->load->view('_partials/navbar.php');
            $this->load->view('_partials/sidebar.php');
            $this->load->view('dashboard/mapel/mapel_kd.php', $data);
            $this->load->view('_partials/footer.php');
        } else {
            $this->MapelModel->input_kd_inmapel($id);
            $this->session->set_flashdata('message', 'Data Kompetensi Dasar Berhasil Ditambahkan!');
            redirect('MapelController/kd?id_mapel=' . $id);
        }
    }

    public function create()
    {
        $data['dataGuru'] = $this->GuruModel->tampilGuru();

        // var_dump($data);
        // die();
        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php');
        $this->load->view('_partials/sidebar.php');
        $this->load->view('dashboard/mapel/tambah.php', $data);
        $this->load->view('_partials/footer.php');
    }

    // public function saveMapel()
    // {
    //     $this->form_validation->set_rules('nama_mapel', 'Mata Pelajaran', 'trim|required');
    //     $this->form_validation->set_rules('guru_id', 'Kode Guru', 'trim|required');
    //     $this->form_validation->set_rules('kode_mapel', 'Kode Mapel', 'trim|required');
    //     if ($this->form_validation->run() == false) {

    //         $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Form Tidak  lengkap ! Mohon Lengkapi Terlebih Dahulu !!!</div>');

    //         // kembalikan ke halaman user
    //         redirect('MapelController/createMapel');
    //     } else {
    //         $dataMapel = [
    //             'nama_mapel' => $this->input->post('nama_mapel'),
    //             'kode_mapel' => $this->input->post('kode_mapel'),
    //             'guru_id' => $this->input->post('guru_id'),
    //         ];

    //         $this->MapelModel->createMapel($dataMapel);

    //         $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data berhasil ditambahkan! </div>');

    //         redirect('mapel');
    //     }
    // }

    public function saveMapel()
    {

        $this->_rules();

        if (
            $this->form_validation->run() == FALSE
        ) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Form Tidak  lengkap ! Mohon Lengkapi Terlebih Dahulu !!!</div>');

            // kembalikan
            redirect('MapelController/createMapel');
        } else {
            $this->MapelModel->createMapel();
            $this->session->set_flashdata('message', 'Data Mata Pelajaran Berhasil Ditambahkan!');
            redirect('MapelController');
        }
    }

    public function edit($id_mapel)
    {
        $data['mapel'] = $this->MapelModel->getById($id_mapel);
        $data['guru'] = $this->GuruModel->tampilGuru();


        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php');
        $this->load->view('_partials/sidebar.php');
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
            redirect('MapelController/createMapel');
        } else {
            $id_mapel = $this->input->post('id_mapel');
            $dataMapel = [
                'id_mapel' => $id_mapel,
                'nama_mapel' => $this->input->post('nama_mapel'),
                'kode_mapel' => $this->input->post('kode_mapel'),
                'guru_id' => $this->input->post('guru_id'),
            ];

            $this->MapelModel->updateMapel($id_mapel, $dataMapel);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data berhasil ditambahkan! </div>');

            redirect('mapel');
        }
    }

    public function detail($id_mapel)
    {
        $data['mapel'] = $this->MapelModel->getById($id_mapel);
        $data['dataGuru'] = $this->GuruModel->tampilGuru();


        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php');
        $this->load->view('_partials/sidebar.php');
        $this->load->view('dashboard/mapel/detail.php', $data);
        $this->load->view('_partials/footer.php');
    }

    public function delete($id_mapel)
    {

        $result = $this->MapelModel->deleteById($id_mapel);

        if ($result) {
            $this->session->set_flashdata('message', 'Data Deleted Sucessfully');
            redirect('mapel');
        } else {
            $this->session->set_flashdata('message', 'Data Deleted Failed');
            redirect('mapel');
        }


        redirect('mapel');
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
