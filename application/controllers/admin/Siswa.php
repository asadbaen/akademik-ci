<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Siswa extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('SiswaModel');
        $this->load->model('KelasModel');
        $this->load->model('User_model');
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
        // $data['dataSiswa'] = $this->SiswaModel->getSiswa();
        $data = $this->User_model->get_detail_admin($this->session->userdata['id_user'], $this->session->userdata['level']);
        $data = array(
            'id_user'   => $data['id_user'],
            'nama'      => $data['nama'],
            'foto'     => $data['foto'] != null ? $data['foto'] : 'user-placeholder.jpg',
            'level'     => $data['level'],
            'dataSiswa' => $this->SiswaModel->getSiswa(),
            'menu'      => 'siswa',
            'breadcrumb' => [
                0 => (object)[
                    'name' => 'Dashboard',
                    'link' => 'admin'
                ],
                1 => (object)[
                    'name' => 'Siswa',
                    'link' => NULL
                ]
            ]
        );

        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php', $data);
        $this->load->view('_partials/sidebar.php', $data);
        $this->load->view('dashboard/siswa/index.php', $data);
        $this->load->view('_partials/footer.php');
    }

    public function createSiswa()
    {
        $data = $this->User_model->get_detail_admin($this->session->userdata['id_user'], $this->session->userdata['level']);
        $data = array(
            'id_user'       => $data['id_user'],
            'nama'          => $data['nama'],
            'foto'         => $data['foto'] != null ? $data['foto'] : 'user-placeholder.jpg',
            'level'         => $data['level'],
            'enum_values'   => $this->SiswaModel->getEnumValues(),
            'kelas'         => $this->KelasModel->tampilKelas(),
            'menu'          => 'siswa',
            'breadcrumb'    => [
                0 => (object)[
                    'name' => 'Dashboard',
                    'link' => 'admin'
                ],
                1 => (object)[
                    'name' => 'Siswa',
                    'link' => 'admin/siswa'
                ],
                2 => (object)[
                    'name' => 'Input',
                    'link' => NULL
                ]
            ]
        );
        // $data['enum_values'] = $this->SiswaModel->getEnumValues();
        // $data['kelas'] = $this->KelasModel->tampilKelas();
        // var_dump($data);
        // die();
        // $this->load->view('dropdown_view', $data);

        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php', $data);
        $this->load->view('_partials/sidebar.php', $data);
        $this->load->view('dashboard/siswa/tambah_siswa.php', $data);
        $this->load->view('_partials/footer.php');
    }

    public function saveCreate()
    {
        $this->form_validation->set_rules('nis', 'Nis Siswa', 'trim|required');
        $this->form_validation->set_rules('nik', 'Nik Siswa', 'trim|required');
        $this->form_validation->set_rules('nama_siswa', 'Nama Siswa', 'trim|required');
        $this->form_validation->set_rules('Jenis_kelamin', 'Jeniskelamin Siswa', 'trim|required');
        $this->form_validation->set_rules('Tanggal_lahir', 'Tanggal lahir Siswa', 'trim|required');
        $this->form_validation->set_rules('Tempat_lahir', 'Tempat lahir Siswa', 'trim|required');
        $this->form_validation->set_rules('alamat', 'Alamat Siswa', 'trim|required');
        $this->form_validation->set_rules('Agama', 'Agama Siswa', 'trim|required');
        $this->form_validation->set_rules('No_telpon', 'No telpon Siswa', 'trim|required');
        $this->form_validation->set_rules('Nama_ayah', 'Nama ayah Siswa', 'trim|required');
        $this->form_validation->set_rules('Nama_ibu', 'Nama ibu Siswa', 'trim|required');
        $this->form_validation->set_rules('Pekerjaan_ayah', 'Pekerjaan ayah Siswa', 'trim|required');
        $this->form_validation->set_rules('Pekerjaan_ibu', 'Pekerjaan ibu Siswa', 'trim|required');

        if ($this->form_validation->run() == false) {

            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Form Tidak  lengkap ! Mohon Lengkapi Terlebih Dahulu !!!</div>');

            // kembalikan ke halaman user
            redirect('admin/siswa');
        } else {
            $id_user = $this->_input_user();
            $dataSiswa = [
                'nis' => $this->input->post('nis'),
                'nik' => $this->input->post('nik'),
                'nama_siswa' => $this->input->post('nama_siswa'),
                'Jenis_kelamin' => $this->input->post('Jenis_kelamin'),
                'Tanggal_lahir' => $this->input->post('Tanggal_lahir'),
                'Tempat_lahir' => $this->input->post('Tempat_lahir'),
                'alamat' => $this->input->post('alamat'),
                'Agama' => $this->input->post('Agama'),
                'No_telpon' => $this->input->post('No_telpon'),
                'Nama_ayah' => $this->input->post('Nama_ayah'),
                'Nama_ibu' => $this->input->post('Nama_ibu'),
                'Pekerjaan_ayah' => $this->input->post('Pekerjaan_ayah'),
                'Pekerjaan_ibu' => $this->input->post('Pekerjaan_ibu'),
                'id_user' => $id_user
            ];

            if (!empty($_FILES['foto']['name'])) {
                $config['upload_path']   = './uploads/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['max_size']      = 4096;
                $config['max_width']     = 2000;
                $config['max_height']    = 2000;

                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if (!$this->upload->do_upload('foto')) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('message', $error);
                    redirect('admin');
                } else {
                    $post_image = $this->upload->data();

                    // Generate new file name with current date
                    $new_file_name = date('YmdHis') . '_' . date('Y') . '_' . date('D') . '.' . pathinfo($post_image['file_name'], PATHINFO_EXTENSION);

                    // Rename the uploaded file
                    rename($post_image['full_path'], $post_image['file_path'] . $new_file_name);

                    $dataSiswa['foto'] = $new_file_name;
                }
            }
            // var_dump($dataSiswa);
            // die();
            $this->SiswaModel->create_siswa($dataSiswa);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data berhasil ditambahkan! </div>');

            redirect('admin/siswa');
        }
    }

    public function detail($id_siswa)
    {
        $id_siswa           = $this->uri->segment(4);
        if (!$id_siswa) {
            redirect('admin/siswa');
        }

        $siswa = $this->get_detail_data($id_siswa);
        if (!isset($siswa)) {
            redirect('error_404');
        }

        $data = $this->User_model->get_detail_admin($this->session->userdata['id_user'], $this->session->userdata['level']);
        $data = array(
            'id_user'       => $data['id_user'],
            'nama'          => $data['nama'],
            'level'         => $data['level'],
            'foto'         => $data['foto'] != null ? $data['foto'] : 'user-placeholder.jpg',
            'siswa'         => $siswa,
            'kelas'         => $this->KelasModel->tampilKelas(),
            'enum_values' => $this->SiswaModel->getEnumValues(),
            'menu'          => 'siswa',
            'breadcrumb'    => [
                0 => (object)[
                    'name' => 'Dashboard',
                    'link' => 'admin'
                ],
                1 => (object)[
                    'name' => 'Siswa',
                    'link' => 'admin/siswa'
                ],
                2 => (object)[
                    'name' => 'Edit',
                    'link' => NULL
                ]
            ]
        );
        // $data['siswa'] = $this->SiswaModel->getSiswaByid($id_siswa);
        // $data['kelas'] = $this->KelasModel->tampilKelas();
        // $data['enum_values'] = $this->SiswaModel->getEnumValues();
        // var_dump($data);
        // die();


        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php', $data);
        $this->load->view('_partials/sidebar.php', $data);
        $this->load->view('dashboard/siswa/detail_siswa.php', $data);
        $this->load->view('_partials/footer.php');
    }

    public function edit($id_siswa)
    {
        $id_siswa           = $this->uri->segment(4);
        if (!$id_siswa) {
            redirect('admin/siswa');
        }

        $siswa = $this->SiswaModel->get_detail_data($id_siswa);
        if (!isset($siswa)) {
            redirect('error_404');
        }

        $data = $this->User_model->get_detail_admin($this->session->userdata['id_user'], $this->session->userdata['level']);
        $data = array(
            'id_user'       => $data['id_user'],
            'nama'          => $data['nama'],
            'level'         => $data['level'],
            'foto'         => $data['foto'] != null ? $data['foto'] : 'user-placeholder.jpg',
            'siswa'         => $siswa,
            'kelas'         => $this->KelasModel->tampilKelas(),
            'enum_values' => $this->SiswaModel->getEnumValues(),
            'menu'          => 'siswa',
            'breadcrumb'    => [
                0 => (object)[
                    'name' => 'Dashboard',
                    'link' => 'admin'
                ],
                1 => (object)[
                    'name' => 'Siswa',
                    'link' => 'admin/siswa'
                ],
                2 => (object)[
                    'name' => 'Edit',
                    'link' => NULL
                ]
            ]
        );
        // $data['siswa'] = $this->SiswaModel->getSiswaByid($id_siswa);
        // $data['kelas'] = $this->KelasModel->tampilKelas();
        // $data['enum_values'] = $this->SiswaModel->getEnumValues();
        // var_dump($data);
        // die();


        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php', $data);
        $this->load->view('_partials/sidebar.php', $data);
        $this->load->view('dashboard/siswa/edit_siswa.php', $data);
        $this->load->view('_partials/footer.php');
    }

    public function saveUpdate()
    {
        $this->form_validation->set_rules('nis', 'Nis Siswa', 'trim|required');
        $this->form_validation->set_rules('nik', 'Nik Siswa', 'trim|required');
        $this->form_validation->set_rules('nama_siswa', 'Nama Siswa', 'trim|required');
        $this->form_validation->set_rules('Jenis_kelamin', 'Jeniskelamin Siswa', 'trim|required');
        $this->form_validation->set_rules('Tanggal_lahir', 'Tanggal lahir Siswa', 'trim|required');
        $this->form_validation->set_rules('Tempat_lahir', 'Tempat lahir Siswa', 'trim|required');
        $this->form_validation->set_rules('alamat', 'Alamat Siswa', 'trim|required');
        $this->form_validation->set_rules('Agama', 'Agama Siswa', 'trim|required');
        $this->form_validation->set_rules('No_telpon', 'No telpon Siswa', 'trim|required');
        $this->form_validation->set_rules('Nama_ayah', 'Nama ayah Siswa', 'trim|required');
        $this->form_validation->set_rules('Nama_ibu', 'Nama ibu Siswa', 'trim|required');
        $this->form_validation->set_rules('Pekerjaan_ayah', 'Pekerjaan ayah Siswa', 'trim|required');
        $this->form_validation->set_rules('Pekerjaan_ibu', 'Pekerjaan ibu Siswa', 'trim|required');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Form Tidak  lengkap ! Mohon Lengkapi Terlebih Dahulu !!!</div>');

            // kembalikan ke halaman user
            redirect('admin/siswa');
        } else {
            $id_siswa = $this->input->post('id_siswa');
            $dataDetail = $this->get_detail_data($id_siswa);


            $dataSiswa = [
                'id_siswa' => $id_siswa,
                'nis' => $this->input->post('nis', TRUE),
                'nik' => $this->input->post('nik'),
                'nama_siswa' => $this->input->post('nama_siswa'),
                'Jenis_kelamin' => $this->input->post('Jenis_kelamin'),
                'Tanggal_lahir' => $this->input->post('Tanggal_lahir'),
                'Tempat_lahir' => $this->input->post('Tempat_lahir'),
                'alamat' => $this->input->post('alamat'),
                'Agama' => $this->input->post('Agama'),
                'No_telpon' => $this->input->post('No_telpon'),
                'Nama_ayah' => $this->input->post('Nama_ayah'),
                'Nama_ibu' => $this->input->post('Nama_ibu'),
                'Pekerjaan_ayah' => $this->input->post('Pekerjaan_ayah'),
                'Pekerjaan_ibu' => $this->input->post('Pekerjaan_ibu')
            ];

            $dataUser = array(
                'username'       => $this->input->post('nis', TRUE),
            );

            $delete_foto_siswa = $this->input->post('delete_foto_siswa');
            $delete_foto = substr($delete_foto_siswa, strlen(base_url()));

            if (!empty($_FILES['foto']['name'])) {
                $config['upload_path']   = './uploads/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['max_size']      = 4096;
                $config['max_width']     = 2000;
                $config['max_height']    = 2000;

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('foto')) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('message', $error);
                    redirect('admin/siswa');
                } else {
                    $post_image = $this->upload->data();

                    $file_name = $post_image['file_name'];


                    $dataSiswa['foto'] = $file_name;

                    unlink($delete_foto);
                }
            }

            // var_dump($id_siswa, $dataSiswa);
            // die();
            $this->SiswaModel->updateSiswa($id_siswa, $dataSiswa);

            $this->db->where('username', $dataDetail['nis']);
            $this->db->update('tb_user', $dataUser);


            // var_dump($cek);
            // die();

            redirect('admin/siswa');
        }
    }

    public function delete($id_siswa)
    {
        $item         = $this->get_detail_data($id_siswa);
        $delete_foto = $this->get_image_byId($id_siswa);
        unlink('uploads/' . $delete_foto->foto);
        $this->User_model->delete_data($item['id_user']);
        $result = $this->SiswaModel->deleteById($id_siswa);

        if ($result) {
            $this->session->set_flashdata('message', 'Data Siswa Deleted Sucessfully');
            redirect('admin/siswa');
        } else {
            $this->session->set_flashdata('message', 'Data Siswa Deleted Failed');
            redirect('admin/siswa');
        }


        redirect('admin/siswa');
    }

    private function get_image_byId($id_siswa)
    {
        $this->db->select('foto');
        $this->db->from('tbl_siswa');
        $this->db->where('tbl_siswa.Id_siswa', $id_siswa);
        $info = $this->db->get();
        return $info->row();
    }

    private function _input_user()
    {

        $data = array(
            'username'  => $this->input->post('nis', TRUE),
            'password'  => MD5($this->input->post('nis', TRUE)),
            'level'     => 'siswa',
            'status'    => '1'
        );

        $this->db->insert('tb_user', $data);
        return $this->db->insert_id();
    }

    private function get_detail_data($id_siswa, $id_user = NULL, $name = NULL)
    {
        if ($id_user) {
            return $this->db->get_where('tbl_siswa', ['id_user' => $id_user])->row_array();
        } elseif ($name) {
            return $this->db->get_where('tbl_siswa', ['nama_siswa' => $name])->row_array();
        } else {
            return $this->db->get_where('tbl_siswa', ['id_siswa' => $id_siswa])->row_array();
        }
    }
}
