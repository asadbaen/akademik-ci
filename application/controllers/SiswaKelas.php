<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SiswaKelas extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_siswa_kelas');
        $this->load->library('form_validation');
    }

    public function students_by_class($kelas_id)
    {
        $data['students_by_class'] = $this->Model_siswa_kelas->getKelasSiswa($kelas_id);

        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php');
        $this->load->view('_partials/sidebar.php');
        $this->load->view('dashboard/kelas/siswa/students_by_class_view.php', $data);
        $this->load->view('_partials/footer.php');
    }
}
