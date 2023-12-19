<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Guru extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('GuruModel');
        $this->load->model('User_model');
        $this->load->model('Model_guru_kelas');
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
            'data' => $this->GuruModel->tampilGuru(),
            'foto'     => $data['foto'] != null ? $data['foto'] : 'user-placeholder.jpg',
            'level'     => $data['level'],
            'menu'      => 'guru',
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
        // $data['data'] = $this->GuruModel->tampilGuru();
        // var_dump($data);
        // die();
        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php', $data);
        $this->load->view('_partials/sidebar.php', $data);
        $this->load->view('dashboard/guru/index.php', $data);
        $this->load->view('_partials/footer.php');
    }


    public function create()
    {
        $data = $this->User_model->get_detail_admin($this->session->userdata['id_user'], $this->session->userdata['level']);
        $data = array(
            'id_user'   => $data['id_user'],
            'nama'      => $data['nama'],
            'foto'     => $data['foto'] != null ? $data['foto'] : 'user-placeholder.jpg',
            'level'     => $data['level'],
            'enum_values' => $this->GuruModel->getEnumValues(),
            'menu'      => 'guru',
            'breadcrumb' => [
                0 => (object)[
                    'name' => 'Dashboard',
                    'link' => 'admin'
                ],
                1 => (object)[
                    'name' => 'Guru',
                    'link' => 'admin/guru'
                ],
                2 => (object)[
                    'name' => 'Create',
                    'link' => NULL
                ]
            ]
        );
        // $data['enum_values'] = $this->GuruModel->getEnumValues();

        // var_dump($data);
        // die();
        // $this->load->view('dropdown_view', $data);

        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php', $data);
        $this->load->view('_partials/sidebar.php', $data);
        $this->load->view('dashboard/guru/tambah_guru.php', $data);
        $this->load->view('_partials/footer.php');
    }


    public function saveCreate()
    {
        $this->form_validation->set_rules('nip', 'nip', 'trim|required');
        $this->form_validation->set_rules('nama_guru', 'nama_guru Lengkap', 'trim|required');
        $this->form_validation->set_rules('Jenis_kelamin', 'Jeniskelamin ', 'trim|required');
        $this->form_validation->set_rules('Tanggal_lahir', 'Tanggal lahir ', 'trim|required');
        $this->form_validation->set_rules('Tempat_lahir', 'Tempat lahir ', 'trim|required');
        $this->form_validation->set_rules('alamat', 'Alamat ', 'trim|required');
        $this->form_validation->set_rules('Agama', 'Agama ', 'trim|required');
        $this->form_validation->set_rules('No_telpon', 'No telpon ', 'trim|required');
        $this->form_validation->set_rules('Kode_guru', 'Kode Guru ', 'trim|required');


        if ($this->form_validation->run() == false) {

            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Form Tidak  lengkap ! Mohon Lengkapi Terlebih Dahulu !!!</div>');

            // kembalikan ke halaman user
            redirect('admin/guru');
        } else {
            $id_user = $this->_input_user();
            $dataGuru = [
                'nip' => $this->input->post('nip'),
                'nama_guru' => $this->input->post('nama_guru'),
                'email' => $this->input->post('email'),
                'Jenis_kelamin' => $this->input->post('Jenis_kelamin'),
                'Tanggal_lahir' => $this->input->post('Tanggal_lahir'),
                'Tempat_lahir' => $this->input->post('Tempat_lahir'),
                'alamat' => $this->input->post('alamat'),
                'Agama' => $this->input->post('Agama'),
                'No_telpon' => $this->input->post('No_telpon'),
                'Kode_guru' => $this->input->post('Kode_guru'),
                'id_user'       => $id_user
            ];

            if (!empty($_FILES['foto_guru']['name'])) {
                $config['upload_path']   = './uploads/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['max_size']      = 4096;
                $config['max_width']     = 2000;
                $config['max_height']    = 2000;

                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if (!$this->upload->do_upload('foto_guru')) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('message', $error);
                    redirect('admin/guru/createGuru');
                } else {
                    $post_image = $this->upload->data();

                    // Generate new file name with current date
                    $new_file_name = date('YmdHis') . '_' . date('Y') . '_' . date('D') . '.' . pathinfo($post_image['file_name'], PATHINFO_EXTENSION);

                    // Rename the uploaded file
                    rename($post_image['full_path'], $post_image['file_path'] . $new_file_name);

                    $dataGuru['foto_guru'] = $new_file_name;
                }
            }

            $this->GuruModel->tambahGuru($dataGuru);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data berhasil ditambahkan! </div>');

            redirect('admin/guru');
        }
    }

    public function detail($id_guru)
    {
        $id_guru           = $this->uri->segment(4);
        if (!$id_guru) {
            redirect('admin/guru');
        }

        $guru = $this->GuruModel->get_detail_data($id_guru);
        if (!isset($guru)) {
            redirect('error_404');
        }

        $data = $this->User_model->get_detail_admin($this->session->userdata['id_user'], $this->session->userdata['level']);
        $data = array(
            'id_user'       => $data['id_user'],
            'nama'          => $data['nama'],
            'level'         => $data['level'],
            'foto'         => $data['foto'] != null ? $data['foto'] : 'user-placeholder.jpg',
            'guru'          => $guru,
            'enum_values' => $this->GuruModel->getEnumValues(),

            'menu'          => 'guru',
            'breadcrumb'    => [
                0 => (object)[
                    'name' => 'Dashboard',
                    'link' => 'admin'
                ],
                1 => (object)[
                    'name' => 'Guru',
                    'link' => 'admin/guru'
                ],
                2 => (object)[
                    'name' => 'Edit',
                    'link' => NULL
                ]
            ]
        );
        // $data['guru'] = $this->GuruModel->tampilGuruId($id_guru);
        // $data['enum_values'] = $this->GuruModel->getEnumValues();
        // var_dump($data);
        // die();


        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php', $data);
        $this->load->view('_partials/sidebar.php', $data);
        $this->load->view('dashboard/guru/detail_guru.php', $data);
        $this->load->view('_partials/footer.php');
    }

    public function edit($id_guru)
    {
        $id_guru           = $this->uri->segment(4);
        if (!$id_guru) {
            redirect('admin/guru');
        }

        $guru = $this->GuruModel->get_detail_data($id_guru);
        if (!isset($guru)) {
            redirect('error_404');
        }

        $data = $this->User_model->get_detail_admin($this->session->userdata['id_user'], $this->session->userdata['level']);

        $data = array(
            'id_user'       => $data['id_user'],
            'nama'          => $data['nama'],
            'level'         => $data['level'],
            'foto'         => $data['foto'] != null ? $data['foto'] : 'user-placeholder.jpg',
            'guru'          => $guru,
            'enum_values' => $this->GuruModel->getEnumValues(),
            'menu'          => 'guru',
            'breadcrumb'    => [
                0 => (object)[
                    'name' => 'Dashboard',
                    'link' => 'admin'
                ],
                1 => (object)[
                    'name' => 'Guru',
                    'link' => 'admin/guru'
                ],
                2 => (object)[
                    'name' => 'Edit',
                    'link' => NULL
                ]
            ]
        );

        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php', $data);
        $this->load->view('_partials/sidebar.php', $data);
        $this->load->view('dashboard/guru/edit_guru.php', $data);
        $this->load->view('_partials/footer.php');
    }

    public function saveUpdate()
    {
        $this->form_validation->set_rules('nip', 'nip', 'trim|required');
        $this->form_validation->set_rules('nama_guru', 'nama_guru Lengkap', 'trim|required');
        $this->form_validation->set_rules('Jenis_kelamin', 'Jeniskelamin ', 'trim|required');
        $this->form_validation->set_rules('Tanggal_lahir', 'Tanggal lahir ', 'trim|required');
        $this->form_validation->set_rules('Tempat_lahir', 'Tempat lahir ', 'trim|required');
        $this->form_validation->set_rules('alamat', 'Alamat ', 'trim|required');
        $this->form_validation->set_rules('Agama', 'Agama ', 'trim|required');
        $this->form_validation->set_rules('No_telpon', 'No telpon ', 'trim|required');
        $this->form_validation->set_rules('Kode_guru', 'Kode Guru ', 'trim|required');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Form Tidak  lengkap ! Mohon Lengkapi Terlebih Dahulu !!!</div>');

            // kembalikan ke halaman user
            redirect('admin/guru');
        } else {

            $id_guru = $this->input->post('id_guru');
            $dataDetail = $this->get_detail_data($id_guru);


            $dataGuru = [
                'id_guru' => $id_guru,
                'nip' => $this->input->post('nip'),
                'nama_guru' => $this->input->post('nama_guru'),
                'email' => $this->input->post('email'),
                'Jenis_kelamin' => $this->input->post('Jenis_kelamin'),
                'Tanggal_lahir' => $this->input->post('Tanggal_lahir'),
                'Tempat_lahir' => $this->input->post('Tempat_lahir'),
                'alamat' => $this->input->post('alamat'),
                'Agama' => $this->input->post('Agama'),
                'No_telpon' => $this->input->post('No_telpon'),
                'Kode_guru' => $this->input->post('Kode_guru')
            ];

            $dataUser = array(
                'username'  => $this->input->post('email'),
            );

            $delete_foto_guru = $this->input->post('delete_foto_guru');
            $delete_foto = substr($delete_foto_guru, strlen(base_url()));

            if (!empty($_FILES['foto_guru']['name'])) {
                $config['upload_path']   = './uploads/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['max_size']      = 4096;
                $config['max_width']     = 2000;
                $config['max_height']    = 2000;

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('foto_guru')) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('message', $error);
                    redirect('guruController');
                } else {
                    $post_image = $this->upload->data();
                    $post_image['file_name'];

                    $file_name = $post_image['file_name'];
                    $dataGuru['foto_guru'] = $file_name;

                    unlink($delete_foto);
                }
            }



            $this->GuruModel->updateGuru($id_guru, $dataGuru);

            $this->db->where('username', $dataDetail['email']);
            $this->db->update('tb_user', $dataUser);



            $this->session->set_flashdata('message', 'Data Siswa Sucessfully');
            redirect('admin/guru');
        }
    }

    public function delete($id_guru)
    {
        $item         = $this->GuruModel->get_detail_data($id_guru);
        $delete_foto = $this->get_image_byId($id_guru);
        unlink('uploads/' . $delete_foto->foto_guru);
        $this->User_model->delete_data($item['id_user']);
        $result = $this->GuruModel->deleteById($id_guru);

        if ($result) {
            $this->session->set_flashdata('message', 'Data Siswa Deleted Sucessfully');
            redirect('admin/guru');
        } else {
            $this->session->set_flashdata('message', 'Data Siswa Deleted Failed');
            redirect('admin/guru');
        }



        redirect('admin/guru');
    }

    private function get_image_byId($id_guru)
    {
        $this->db->select('foto_guru');
        $this->db->from('tbl_guru');
        $this->db->where('tbl_guru.Id_guru', $id_guru);
        $info = $this->db->get();
        return $info->row();
    }

    private function _input_user()
    {
        // $date = date_create($this->input->post('Tanggal_lahir', TRUE));
        // $dateFormat = date_format($date, "mY");
        // $nip = $this->input->post('nip', TRUE);
        $data = array(
            'username'  => $this->input->post('email', TRUE),
            'password'  => MD5($this->input->post('nip', TRUE)),
            'level'     => 'guru',
            'status'    => '1'
        );

        $this->db->insert('tb_user', $data);
        return $this->db->insert_id();
    }

    private function get_detail_data($id_guru, $id_user = NULL, $name = NULL)
    {
        if ($id_user) {
            return $this->db->get_where('tbl_guru', ['id_user' => $id_user])->row_array();
        } elseif ($name) {
            return $this->db->get_where('tbl_guru', ['nama_guru' => $name])->row_array();
        } else {
            return $this->db->get_where('tbl_guru', ['id_guru' => $id_guru])->row_array();
        }
    }
}
