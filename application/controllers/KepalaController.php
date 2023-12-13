<?php
defined('BASEPATH') or exit('No direct script access allowed');

class KepalaController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('KepalaModel');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['data'] = $this->KepalaModel->getKepala();
        $data['enum_values'] = $this->KepalaModel->getEnumValues();

        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php');
        $this->load->view('_partials/sidebar.php');
        $this->load->view('dashboard/kepala_sekolah/index.php', $data);
        $this->load->view('_partials/footer.php');
    }

    public function createKepala()
    {
        $data['enum_values'] = $this->KepalaModel->getEnumValues();

        // var_dump($data);
        // die();
        // $this->load->view('dropdown_view', $data);

        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php');
        $this->load->view('_partials/sidebar.php');
        $this->load->view('dashboard/kepala_sekolah/tambah.php', $data);
        $this->load->view('_partials/footer.php');
    }


    public function saveCreateKepala()
    {
        $this->form_validation->set_rules('nip', 'nip', 'trim|required');
        $this->form_validation->set_rules('Nama', 'Nama Lengkap', 'trim|required');
        $this->form_validation->set_rules('Jabatan', 'Jabatan', 'trim|required');
        $this->form_validation->set_rules('Jenis_kelamin', 'Jeniskelamin ', 'trim|required');
        $this->form_validation->set_rules('Tanggal_lahir', 'Tanggal lahir ', 'trim|required');
        $this->form_validation->set_rules('Tempat_lahir', 'Tempat lahir ', 'trim|required');
        $this->form_validation->set_rules('alamat', 'Alamat ', 'trim|required');
        $this->form_validation->set_rules('agama', 'agama ', 'trim|required');


        if ($this->form_validation->run() == false) {

            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Form Tidak  lengkap ! Mohon Lengkapi Terlebih Dahulu !!!</div>');

            // kembalikan ke halaman user
            redirect('kepalacontroller/createKepala');
        } else {
            $dataKepala = [
                'nip' => $this->input->post('nip'),
                'Nama' => $this->input->post('Nama'),
                'Jabatan' => $this->input->post('Jabatan'),
                'Jenis_kelamin' => $this->input->post('Jenis_kelamin'),
                'Tanggal_lahir' => $this->input->post('Tanggal_lahir'),
                'Tempat_lahir' => $this->input->post('Tempat_lahir'),
                'alamat' => $this->input->post('alamat'),
                'agama' => $this->input->post('agama')
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
                    redirect('kepalacontroller/createKepala');
                } else {
                    $post_image = $this->upload->data();

                    // Generate new file name with current date
                    $new_file_name = date('YmdHis') . '_' . date('Y') . '_' . date('D') . '.' . pathinfo($post_image['file_name'], PATHINFO_EXTENSION);

                    // Rename the uploaded file
                    rename($post_image['full_path'], $post_image['file_path'] . $new_file_name);

                    $dataKepala['foto'] = $new_file_name;
                }
            }

            $this->KepalaModel->create_kepala($dataKepala);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data berhasil ditambahkan! </div>');

            redirect('kepalacontroller');
        }
    }

    public function detail($id_kepala)
    {
        $data['kepala'] = $this->KepalaModel->getKepalaById($id_kepala);
        $data['enum_values'] = $this->KepalaModel->getEnumValues();
        // var_dump($data);
        // die();


        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php');
        $this->load->view('_partials/sidebar.php');
        $this->load->view('dashboard/kepala_sekolah/detail.php', $data);
        $this->load->view('_partials/footer.php');
    }

    public function edit($id_kepala)
    {
        $data['kepala'] = $this->KepalaModel->getKepalaById($id_kepala);
        $data['enum_values'] = $this->KepalaModel->getEnumValues();
        // var_dump($data);
        // die();


        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php');
        $this->load->view('_partials/sidebar.php');
        $this->load->view('dashboard/kepala_sekolah/edit.php', $data);
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

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Form Tidak  lengkap ! Mohon Lengkapi Terlebih Dahulu !!!</div>');

            // kembalikan ke halaman user
            redirect('kepalacontroller');
        } else {
            $id_kepala = $this->input->post('Id_kepala_sekolah');
            $dataKepala = [
                'Id_kepala_sekolah' => $id_kepala,
                'nip' => $this->input->post('nip'),
                'Nama' => $this->input->post('Nama'),
                'Jabatan' => $this->input->post('Jabatan'),
                'Jenis_kelamin' => $this->input->post('Jenis_kelamin'),
                'Tanggal_lahir' => $this->input->post('Tanggal_lahir'),
                'Tempat_lahir' => $this->input->post('Tempat_lahir'),
                'alamat' => $this->input->post('alamat'),
                'agama' => $this->input->post('agama')
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
                    redirect('kepalacontroller');
                } else {
                    $post_image = $this->upload->data();
                    $post_image['file_name'];

                    $file_name = $post_image['file_name'];
                    $dataKepala['foto'] = $file_name;

                    unlink($delete_foto);
                }
            }

            // var_dump($id_kepala, $dataKepala);
            // die();
            $this->KepalaModel->updateKepala($id_kepala, $dataKepala);



            // var_dump($cek);
            // die();

            redirect('kepalacontroller');
        }
    }

    public function delete($id_kepala)
    {
        $delete_foto = $this->get_image_byId($id_kepala);
        unlink('uploads/' . $delete_foto->foto);
        $result = $this->KepalaModel->deleteById($id_kepala);

        if ($result) {
            $this->session->set_flashdata('message', 'Data Siswa Deleted Sucessfully');
            redirect('kepalacontroller');
        } else {
            $this->session->set_flashdata('message', 'Data Siswa Deleted Failed');
            redirect('kepalacontroller');
        }


        redirect('kepalacontroller');
    }

    private function get_image_byId($id_kepala)
    {
        $this->db->select('foto');
        $this->db->from('tbl_kepala_sekolah');
        $this->db->where('tbl_kepala_sekolah.id_kepala', $id_kepala);
        $info = $this->db->get();
        return $info->row();
    }
}
