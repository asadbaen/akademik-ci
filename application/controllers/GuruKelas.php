<?php
defined('BASEPATH') or exit('No direct script access allowes');

class GuruKelas extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_guru_kelas');
        $this->load->model('KelasModel');
        $this->load->model('SiswaModel');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['kelas_siswa'] = $this->Model_guru_kelas->getAllKelasSiswa();

        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php');
        $this->load->view('_partials/sidebar.php');
        $this->load->view('dashboard/kelas/guru/guru_kelas_siswa.php', $data);
        $this->load->view('_partials/footer.php');
    }


    public function tambah_kelas_siswa()
    {

        $data['kelas'] = $this->KelasModel->tampilKelas();
        $data['siswa'] = $this->SiswaModel->getSiswa();

        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php');
        $this->load->view('_partials/sidebar.php');
        $this->load->view('dashboard/kelas/guru/tambah.php', $data);
        $this->load->view('_partials/footer.php');
    }

    // public function simpan_kelas_siswa()
    // {
    //     $this->form_validation->set_rules('id_kelas', 'Pilih Kelas', 'trim|required');
    //     $this->form_validation->set_rules('id_siswa', 'Pilih Siswa', 'trim|required');

    //     if ($this->form_validation->run() == false) {

    //         $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Form Tidak  lengkap ! Mohon Lengkapi Terlebih Dahulu !!!</div>');

    //         // kembalikan ke halaman user
    //         redirect('guru-kelas');
    //     } else {
    //         $id_kelas = $this->input->post('id_kelas');
    //         $id_siswa = $this->input->post('id_siswa');
    //         $data_kelas_siswa = [
    //             'id_kelas' => $id_kelas,
    //             'id_siswa' => $id_siswa,
    //         ];

    //         $this->Model_guru_kelas->tambah_siswa_kelas($data_kelas_siswa);

    //         $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data berhasil ditambahkan! </div>');

    //         redirect('guru-kelas');
    //     }
    // }

    public function simpan_kelas_siswa()
    {
        $this->form_validation->set_rules('id_kelas', 'Pilih Kelas', 'trim|required');
        $this->form_validation->set_rules('id_siswa', 'Pilih Siswa', 'trim|required');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Form Tidak lengkap! Mohon Lengkapi Terlebih Dahulu !!!</div>');

            // kembalikan ke halaman user
            redirect('tambah_kelas_siswa');
        } else {
            $id_kelas = $this->input->post('id_kelas');
            $id_siswa = $this->input->post('id_siswa');
            $data_kelas_siswa = [
                'id_kelas' => $id_kelas,
                'id_siswa' => $id_siswa,
            ];

            // Check if NIS is available for the given class
            if ($this->Model_guru_kelas->isNISAvailable($this->getNISByIdSiswa($id_siswa), $id_kelas)) {
                $this->Model_guru_kelas->tambah_siswa_kelas($data_kelas_siswa);

                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data berhasil ditambahkan! </div>');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Maaf, NIS sudah digunakan pada kelas lain.</div>');
                redirect('tambah-guru-kelas');
            }

            redirect('guru-kelas');
        }
    }

    public function edit_kelas_siswa($id_kelas_siswa)
    {
        $data['kelas_siswa'] = $this->Model_guru_kelas->getKelasSiswaByid($id_kelas_siswa);

        // var_dump($data['kelas_siswa']);
        // die();
        $data['data_kelas'] = $this->KelasModel->tampilKelas();
        $data['data_siswa'] = $this->SiswaModel->getSiswa();

        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php');
        $this->load->view('_partials/sidebar.php');
        $this->load->view('dashboard/kelas/guru/edit.php', $data);
        $this->load->view('_partials/footer.php');
    }

    public function update_kelas_siswa()
    {
        $this->form_validation->set_rules('id_kelas', 'Pilih Kelas', 'trim|required');
        $this->form_validation->set_rules('id_siswa', 'Pilih Siswa', 'trim|required');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Form Tidak lengkap! Mohon Lengkapi Terlebih Dahulu !!!</div>');

            // kembalikan ke halaman user
            redirect('guru-kelas');
        } else {
            $id_kelas_siswa = $this->input->post('id_kelas_siswa');
            $id_kelas = $this->input->post('id_kelas');
            $id_siswa = $this->input->post('id_siswa');

            // Tangkap nilai checkbox
            $pindah_kelas = $this->input->post('pindah_kelas');

            // Update data siswa sesuai dengan opsi pindah kelas
            if ($pindah_kelas) {
                // Check if NIS is available for the given class
                if ($this->Model_guru_kelas->isNISAvailableForUpdate($id_kelas_siswa, $this->getNISByIdSiswa($id_siswa), $id_kelas)) {
                    $data_kelas_siswa = [
                        'id_kelas' => $id_kelas,
                        'id_siswa' => $id_siswa,
                    ];

                    $this->Model_guru_kelas->updateKelasSiswa($id_kelas_siswa, $data_kelas_siswa);

                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data berhasil diupdate! </div>');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Maaf, NIS sudah digunakan pada kelas lain.</div>');
                }
            } else {
                $data_kelas_siswa = [
                    'id_kelas_siswa' => $id_kelas_siswa,
                    'id_kelas' => $id_kelas,
                    'id_siswa' => $id_siswa,
                ];

                // Check if NIS is available for the given class
                if ($this->Model_guru_kelas->isNISAvailable($this->getNISByIdSiswa($id_siswa), $id_kelas)) {
                    $this->Model_guru_kelas->tambah_siswa_kelas($data_kelas_siswa);

                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data berhasil diupdate! </div>');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Maaf, NIS sudah digunakan pada kelas lain.</div>');
                }
            }

            redirect('guru-kelas');
        }
    }





    // Fungsi untuk mendapatkan NIS berdasarkan ID siswa
    private function getNISByIdSiswa($id_siswa)
    {
        $siswa = $this->db->get_where('tbl_siswa', ['id_siswa' => $id_siswa])->row();

        return $siswa ? $siswa->nis : null;
    }
}
