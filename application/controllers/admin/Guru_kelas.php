<?php
defined('BASEPATH') or exit('No direct script access allowes');

class Guru_kelas extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_guru_kelas');
        $this->load->model('KelasModel');
        $this->load->model('SiswaModel');
        $this->load->model('User_model');
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
            'kelas_siswa' => $this->Model_guru_kelas->getAllKelasSiswa(),
            'foto'     => $data['foto'] != null ? $data['foto'] : 'user-placeholder.jpg',
            'level'     => $data['level'],
            'menu'      => 'guru_kelas',
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
        // $data['kelas_siswa'] = $this->Model_guru_kelas->getAllKelasSiswa();

        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php', $data);
        $this->load->view('_partials/sidebar.php', $data);
        $this->load->view('dashboard/kelas/guru/guru_kelas_siswa.php', $data);
        $this->load->view('_partials/footer.php');
    }


    public function tambah_kelas_siswa()
    {
        $data = $this->User_model->get_detail_admin($this->session->userdata['id_user'], $this->session->userdata['level']);
        $data = array(
            'id_user'   => $data['id_user'],
            'nama'      => $data['nama'],
            'foto'     => $data['foto'] != null ? $data['foto'] : 'user-placeholder.jpg',
            'level'     => $data['level'],
            'kelas' => $this->KelasModel->tampilKelas(),
            'siswa' => $this->SiswaModel->getSiswa(),
            'tahun'     => $this->Tahun_model->get_active_stats(),
            'menu'      => 'guru_kelas',
            'breadcrumb' => [
                0 => (object)[
                    'name' => 'Dashboard',
                    'link' => 'admin'
                ],
                1 => (object)[
                    'name' => 'Guru Kelas',
                    'link' => 'admin/guru_kelas'
                ],
                2 => (object)[
                    'name' => 'Create',
                    'link' => NULL
                ]
            ]
        );

        // $data['kelas'] = $this->KelasModel->tampilKelas();
        // $data['siswa'] = $this->SiswaModel->getSiswa();

        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php', $data);
        $this->load->view('_partials/sidebar.php', $data);
        $this->load->view('dashboard/kelas/guru/tambah.php', $data);
        $this->load->view('_partials/footer.php');
    }

    public function simpan_kelas_siswa()
    {
        $this->form_validation->set_rules('id_kelas', 'Pilih Kelas', 'trim|required');
        $this->form_validation->set_rules('id_siswa', 'Pilih Siswa', 'trim|required');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Form Tidak lengkap! Mohon Lengkapi Terlebih Dahulu !!!</div>');

            // kembalikan ke halaman user
            redirect('admin/guru_kelas/tambah_kelas_siswa');
        } else {
            $id_kelas = $this->input->post('id_kelas');
            $id_siswa = $this->input->post('id_siswa');
            $data_kelas_siswa = [
                'id_kelas' => $id_kelas,
                'id_siswa' => $id_siswa,
                'tahun_ajaran' => $this->input->post('tahun'),
            ];

            // Check if NIS is available for the given class
            if ($this->Model_guru_kelas->isNISAvailable($this->getNISByIdSiswa($id_siswa), $id_kelas)) {
                $this->Model_guru_kelas->tambah_siswa_kelas($data_kelas_siswa);

                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data berhasil ditambahkan! </div>');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Maaf, NIS sudah digunakan pada kelas lain.</div>');
                redirect('admin/guru_kelas/tambah_kelas_siswa');
            }

            redirect('admin/guru_kelas');
        }
    }

    public function edit_kelas_siswa($id_kelas_siswa)
    {
        $id_kelas_siswa           = $this->uri->segment(4);
        if (!$id_kelas_siswa) {
            redirect('admin/guru_kelas');
        }

        $guru_kelas = $this->Model_guru_kelas->getKelasSiswaByid($id_kelas_siswa);
        if (!isset($guru_kelas)) {
            redirect('error_404');
        }

        $data = $this->User_model->get_detail_admin($this->session->userdata['id_user'], $this->session->userdata['level']);

        $data = array(
            'id_user'       => $data['id_user'],
            'nama'          => $data['nama'],
            'level'         => $data['level'],
            'foto'         => $data['foto'] != null ? $data['foto'] : 'user-placeholder.jpg',
            'kelas_siswa'          => $guru_kelas,
            'data_kelas' => $this->KelasModel->tampilKelas(),
            'data_siswa' => $this->SiswaModel->getSiswa(),
            'tahun'     => $this->Tahun_model->get_active_stats(),
            'menu'          => 'guru_kelas',
            'breadcrumb'    => [
                0 => (object)[
                    'name' => 'Dashboard',
                    'link' => 'admin'
                ],
                1 => (object)[
                    'name' => 'Guru Kelas',
                    'link' => 'admin/guru_kelas'
                ],
                2 => (object)[
                    'name' => 'Edit',
                    'link' => NULL
                ]
            ]
        );
        // $data['kelas_siswa'] = $this->Model_guru_kelas->getKelasSiswaByid($id_kelas_siswa);

        // var_dump($data['kelas_siswa']);
        // die();
        // $data['data_kelas'] = $this->KelasModel->tampilKelas();
        // $data['data_siswa'] = $this->SiswaModel->getSiswa();

        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php', $data);
        $this->load->view('_partials/sidebar.php', $data);
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
            redirect('admin/guru_kelas');
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
                        'tahun_ajaran' => $this->input->post('tahun'),
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

            redirect('admin/guru_kelas');
        }
    }

    public function delete($id_kelas_siswa)
    {
        $result = $this->Model_guru_kelas->deleteById($id_kelas_siswa);

        if ($result) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data Siswa Deleted Sucessfully </div>');
            redirect('admin/guru_kelas');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data Siswa Deleted Failed </div>');
            redirect('admin/guru_kelas');
        }


        redirect('admin/guru_kelas');
    }





    // Fungsi untuk mendapatkan NIS berdasarkan ID siswa
    private function getNISByIdSiswa($id_siswa)
    {
        $siswa = $this->db->get_where('tbl_siswa', ['id_siswa' => $id_siswa])->row();

        return $siswa ? $siswa->nis : null;
    }
}
