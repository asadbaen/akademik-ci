<?php
defined('BASEPATH') or exit('No direct script access allowed');

class _Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('AdminModel');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['data'] = $this->AdminModel->getAdmin();
        $data['enum_values'] = $this->AdminModel->getEnumValues();

        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php');
        $this->load->view('_partials/sidebar.php');
        $this->load->view('dashboard/admin/index.php', $data);
        $this->load->view('_partials/footer.php');
    }

    public function createAdmin()
    {
        $data['enum_values'] = $this->AdminModel->getEnumValues();

        // var_dump($data);
        // die();
        // $this->load->view('dropdown_view', $data);

        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php');
        $this->load->view('_partials/sidebar.php');
        $this->load->view('dashboard/admin/tambah.php', $data);
        $this->load->view('_partials/footer.php');
    }


    public function saveCreateAdmin()
    {
        $this->form_validation->set_rules('nip', 'nip', 'trim|required');
        $this->form_validation->set_rules('Nama', 'Nama Lengkap', 'trim|required');
        $this->form_validation->set_rules('Jabatan', 'Jabatan', 'trim|required');
        $this->form_validation->set_rules('Jenis_kelamin', 'Jeniskelamin ', 'trim|required');
        $this->form_validation->set_rules('Tanggal_lahir', 'Tanggal lahir ', 'trim|required');
        $this->form_validation->set_rules('Tempat_lahir', 'Tempat lahir ', 'trim|required');
        $this->form_validation->set_rules('alamat', 'Alamat ', 'trim|required');
        $this->form_validation->set_rules('agama', 'agama ', 'trim|required');
        $this->form_validation->set_rules('No_telpon', 'No telpon ', 'trim|required');
        $this->form_validation->set_rules('email', 'No telpon ', 'trim|required');

        if ($this->form_validation->run() == false) {

            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Form Tidak  lengkap ! Mohon Lengkapi Terlebih Dahulu !!!</div>');

            // kembalikan ke halaman user
            redirect('admincontroller/createAdmin');
        } else {
            $dataAdmin = [
                'nip' => $this->input->post('nip'),
                'Nama' => $this->input->post('Nama'),
                'Jabatan' => $this->input->post('Jabatan'),
                'Jenis_kelamin' => $this->input->post('Jenis_kelamin'),
                'Tanggal_lahir' => $this->input->post('Tanggal_lahir'),
                'Tempat_lahir' => $this->input->post('Tempat_lahir'),
                'alamat' => $this->input->post('alamat'),
                'agama' => $this->input->post('agama'),
                'No_telpon' => $this->input->post('No_telpon'),
                'email' => $this->input->post('email')
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
                    redirect('admincontroller/createAdmin');
                } else {
                    $post_image = $this->upload->data();

                    // Generate new file name with current date
                    $new_file_name = date('YmdHis') . '_' . date('Y') . '_' . date('D') . '.' . pathinfo($post_image['file_name'], PATHINFO_EXTENSION);

                    // Rename the uploaded file
                    rename($post_image['full_path'], $post_image['file_path'] . $new_file_name);

                    $dataAdmin['foto'] = $new_file_name;
                }
            }

            $this->AdminModel->create_admin($dataAdmin);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data berhasil ditambahkan! </div>');

            redirect('admincontroller');
        }
    }

    public function detail($id_Admin)
    {
        $data['admin'] = $this->AdminModel->getAdminById($id_Admin);
        $data['enum_values'] = $this->AdminModel->getEnumValues();
        // var_dump($data);
        // die();


        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php');
        $this->load->view('_partials/sidebar.php');
        $this->load->view('dashboard/admin/detail.php', $data);
        $this->load->view('_partials/footer.php');
    }

    public function edit($id_Admin)
    {
        $data['admin'] = $this->AdminModel->getAdminById($id_Admin);
        $data['enum_values'] = $this->AdminModel->getEnumValues();
        // var_dump($data);
        // die();


        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php');
        $this->load->view('_partials/sidebar.php');
        $this->load->view('dashboard/admin/edit.php', $data);
        $this->load->view('_partials/footer.php');
    }

    public function saveUpdate()
    {
        $this->form_validation->set_rules('nip', 'nip', 'trim|required');
        $this->form_validation->set_rules('Nama', 'Nama Lengkap', 'trim|required');
        $this->form_validation->set_rules('Jabatan', 'Jabatan', 'trim|required');
        $this->form_validation->set_rules('Jenis_kelamin', 'Jeniskelamin ', 'trim|required');
        $this->form_validation->set_rules('Tanggal_lahir', 'Tanggal lahir ', 'trim|required');
        $this->form_validation->set_rules('Tempat_lahir', 'Tempat lahir ', 'trim|required');
        $this->form_validation->set_rules('alamat', 'Alamat ', 'trim|required');
        $this->form_validation->set_rules('agama', 'agama ', 'trim|required');
        $this->form_validation->set_rules('No_telpon', 'No telpon ', 'trim|required');
        $this->form_validation->set_rules('email', 'No telpon ', 'trim|required');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Form Tidak  lengkap ! Mohon Lengkapi Terlebih Dahulu !!!</div>');

            // kembalikan ke halaman user
            redirect('admincontroller');
        } else {
            $id_Admin = $this->input->post('Id_admin');
            $dataAdmin = [
                'Id_admin' => $id_Admin,
                'nip' => $this->input->post('nip'),
                'Nama' => $this->input->post('Nama'),
                'Jabatan' => $this->input->post('Jabatan'),
                'Jenis_kelamin' => $this->input->post('Jenis_kelamin'),
                'Tanggal_lahir' => $this->input->post('Tanggal_lahir'),
                'Tempat_lahir' => $this->input->post('Tempat_lahir'),
                'alamat' => $this->input->post('alamat'),
                'agama' => $this->input->post('agama'),
                'No_telpon' => $this->input->post('No_telpon'),
                'email' => $this->input->post('email')
            ];


            $delete_foto = $this->input->post('delete_foto');
            $delete_foto = substr($delete_foto, strlen(base_url()));

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
                    redirect('admincontroller');
                } else {
                    $post_image = $this->upload->data();
                    $post_image['file_name'];

                    $file_name = $post_image['file_name'];
                    $dataAdmin['foto'] = $file_name;

                    unlink($delete_foto);
                }
            }

            // var_dump($id_Admin, $dataAdmin);
            // die();
            $this->AdminModel->updateAdmin($id_Admin, $dataAdmin);



            // var_dump($cek);
            // die();

            redirect('admincontroller');
        }
    }

    public function delete($id_Admin)
    {
        $delete_foto = $this->get_image_byId($id_Admin);
        unlink('uploads/' . $delete_foto->foto);
        $result = $this->AdminModel->deleteById($id_Admin);

        if ($result) {
            $this->session->set_flashdata('message', 'Data Deleted Sucessfully');
            redirect('admincontroller');
        } else {
            $this->session->set_flashdata('message', 'Data Deleted Failed');
            redirect('admincontroller');
        }


        redirect('admincontroller');
    }

    private function get_image_byId($id_Admin)
    {
        $this->db->select('foto');
        $this->db->from('tbl_tu_admin');
        $this->db->where('tbl_tu_admin.id_tu_admin', $id_Admin);
        $info = $this->db->get();
        return $info->row();
    }
}
