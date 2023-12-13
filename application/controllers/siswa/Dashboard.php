<?php
class Dashboard extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Tahun_model');
        $this->load->model('User_model');
        $this->load->model('KelasModel');

        if (!isset($this->session->userdata['username']) && $this->session->userdata['level'] != 'siswa') {
            $this->session->set_flashdata('message', 'Anda Belum Login!');
            redirect('login');
        }

        if ($this->session->userdata['level'] != 'siswa') {
            $this->session->set_flashdata('message', 'Anda Belum Login!');
            redirect('login');
        }
    }

    public function index()
    {
        $tahun      = $this->Tahun_model->get_active_stats();
        $data       = $this->User_model->get_detail_siswa($this->session->userdata['id_user'], $this->session->userdata['level']);
        $data = array(
            'id_user'   => $data['id_user'],
            'nama'      => $data['nama_siswa'],
            'foto'     => $data['foto'] != null ? $data['foto'] : 'user-placeholder.jpg',
            'level'     => $data['level'],
            'kelas'     => $this->KelasModel->get_detail_siswa($data['id_siswa'], $tahun),
            'menu'      => 'dashboard',
            'tahun'     => $tahun,
            'breadcrumb' => [
                0 => (object)[
                    'name' => 'Dashboard',
                    'link' => NULL
                ]
            ]
        );
        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php', $data);
        $this->load->view('_partials/sidebar.php', $data);
        $this->load->view('siswa/dashboard.php', $data);
        $this->load->view('_partials/footer.php');

        // $this->load->view('templates/header');
        // $this->load->view('templates_siswa/sidebar', $data);
        // $this->load->view('siswa/dashboard', $data);
        // $this->load->view('templates/footer');
    }
}
