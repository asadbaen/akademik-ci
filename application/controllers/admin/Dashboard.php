<?php
class Dashboard extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Tahun_model');
        $this->load->model('User_model');
        $this->load->model('SiswaModel');
        $this->load->model('KelasModel');
        $this->load->model('GuruModel');


        if (!isset($this->session->userdata['username'])) {
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
        $tahun = $this->Tahun_model->get_active_stats();
        // var_dump($tahun);
        // die();
        $data = $this->User_model->get_detail_admin($this->session->userdata['id_user'], $this->session->userdata['level']);
        $data = array(
            'id_user'   => $data['id_user'],
            'nama'      => $data['nama'],
            'jabatan'      => $data['Jabatan'],
            'foto'     => $data['foto'] != null ? $data['foto'] : 'user-placeholder.jpg',
            'level'     => $data['level'],
            'menu'      => 'dashboard',
            'tahun'     => $tahun,
            'siswa'     => $this->SiswaModel->get_count_allsiswa($tahun),
            'kelas'     => $this->KelasModel->get_count(),
            'guru'      => $this->GuruModel->get_count($tahun),
            'breadcrumb' => [
                0 => (object)[
                    'name' => 'Dashboard',
                    'link' => NULL
                ]
            ]
        );
        // var_dump($data['foto']);
        // die();
        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php', $data);
        $this->load->view('_partials/sidebar.php', $data);
        $this->load->view('dashboard/admin/dashboard.php', $data);
        $this->load->view('_partials/footer.php');

        // $this->load->view('templates/header');
        // $this->load->view('templates_admin/sidebar', $data);
        // $this->load->view('admin/dashboard', $data);
        // $this->load->view('templates/footer');
    }
}
