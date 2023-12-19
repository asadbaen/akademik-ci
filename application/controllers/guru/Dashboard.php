<?php
class Dashboard extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Tahun_model');
        $this->load->model('User_model');
        $this->load->model('KelasModel');
        $this->load->model('GuruModel');
        $this->load->model('Model_guru_kelas');
        if (!isset($this->session->userdata['username'])) {
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
        $data       = $this->User_model->get_detail_guru($this->session->userdata['id_user'], $this->session->userdata['level']);
        $guru       = $this->GuruModel->get_detail_data(NULL, $data['id_user']);
        $tahun      = $this->Tahun_model->get_active_stats();
        $data = array(
            'id_user'   => $data['id_user'],
            'nama'      => $data['nama_guru'],
            'foto'     => $data['foto_guru'] != null ? $data['foto_guru'] : 'user-placeholder.jpg',
            'level'     => $data['level'],
            'menu'      => 'dashboard',
            'tahun'     => $tahun,
            'pengajar'  => $this->Model_guru_kelas->get_count_pengampu($guru['id_guru'], $tahun),
            'siswa'     => $this->Model_guru_kelas->get_count_siswa($guru['id_guru'], $tahun),
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
        $this->load->view('guru/dashboard.php', $data);
        $this->load->view('_partials/footer.php');
    }
}
