<?php
class DataDiri extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('SiswaModel');
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
        $data = $this->User_model->get_detail_siswa($this->session->userdata['id_user'], $this->session->userdata['level']);
        $siswa      = $this->SiswaModel->get_detail_data($data['id_siswa']);
        $data = array(
            'siswa'      => $siswa,
            'id_user'   => $data['id_user'],
            'nama'      => $data['nama_siswa'],
            'foto'     => $data['foto'] != null ? $data['foto'] : 'user-placeholder.jpg',
            'level'     => $data['level'],
            'menu'      => 'datadiri',
            'breadcrumb' => [
                0 => (object)[
                    'name' => 'Dashboard',
                    'link' => 'siswa'
                ],
                1 => (object)[
                    'name' => 'Data Diri',
                    'link' => NULL
                ]
            ]
        );

        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php', $data);
        $this->load->view('_partials/sidebar.php', $data);
        $this->load->view('siswa/profile.php', $data);
        $this->load->view('_partials/footer.php');
    }

    public function password()
    {
        $data = $this->User_model->get_detail_siswa($this->session->userdata['id_user'], $this->session->userdata['level']);
        $data = array(
            'id_user'   => $data['id_user'],
            'nama'      => $data['nama_siswa'],
            'foto'     => $data['foto'] != null ? $data['foto'] : 'user-placeholder.jpg',
            'level'     => $data['level'],
            'menu'      => 'password',
            'breadcrumb' => [
                0 => (object)[
                    'name' => 'Dashboard',
                    'link' => 'siswa'
                ],
                1 => (object)[
                    'name' => 'Data Diri',
                    'link' => 'siswa/datadiri'
                ],
                2 => (object)[
                    'name' => 'Password',
                    'link' => NULL
                ]
            ]
        );

        $this->_rules_password();

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('_partials/header.php');
            $this->load->view('_partials/navbar.php', $data);
            $this->load->view('_partials/sidebar.php', $data);
            $this->load->view('siswa/profile_password.php', $data);
            $this->load->view('_partials/footer.php');
        } else {
            $this->User_model->edit_password($this->session->userdata['id_user']);
            $this->session->set_flashdata('message', 'Password Berhasil Diupdate!');
            redirect('siswa/datadiri');
        }
    }

    private function _rules_password()
    {
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|max_length[50]');
        $this->form_validation->set_rules('konfirmasi', 'Konfirmasi Password', "required|min_length[6]|matches[password]|max_length[50]");
    }
}
