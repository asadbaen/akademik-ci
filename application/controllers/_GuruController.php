<?php
defined('BASEPATH') or exit('No direct script access allowed');


class _GuruController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('GuruModel');
        $this->load->library('form_validation');
    }

    public function index()
    {

        $data['data'] = $this->GuruModel->tampilGuru();

        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php');
        $this->load->view('_partials/sidebar.php');
        $this->load->view('dashboard/guru/index.php', $data);
        $this->load->view('_partials/footer.php');
    }


    public function createGuru()
    {
        $data['enum_values'] = $this->GuruModel->getEnumValues();

        // var_dump($data);
        // die();
        // $this->load->view('dropdown_view', $data);

        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php');
        $this->load->view('_partials/sidebar.php');
        $this->load->view('dashboard/guru/tambah_guru.php', $data);
        $this->load->view('_partials/footer.php');
    }


    public function saveCreateGuru()
    {
        $this->form_validation->set_rules('nip', 'nip', 'trim|required');
        $this->form_validation->set_rules('nama_guru', 'nama_guru Lengkap', 'trim|required');
        $this->form_validation->set_rules('Jabatan', 'Jabatan', 'trim|required');
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
            redirect('gurucontroller/createGuru');
        } else {
            $dataGuru = [
                'nip' => $this->input->post('nip'),
                'nama_guru' => $this->input->post('nama_guru'),
                'Jabatan' => $this->input->post('Jabatan'),
                'Jenis_kelamin' => $this->input->post('Jenis_kelamin'),
                'Tanggal_lahir' => $this->input->post('Tanggal_lahir'),
                'Tempat_lahir' => $this->input->post('Tempat_lahir'),
                'alamat' => $this->input->post('alamat'),
                'Agama' => $this->input->post('Agama'),
                'No_telpon' => $this->input->post('No_telpon'),
                'Kode_guru' => $this->input->post('Kode_guru')
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
                    redirect('gurucontroller/createGuru');
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

            redirect('gurucontroller');
        }
    }

    public function detail($id_guru)
    {
        $data['guru'] = $this->GuruModel->tampilGuruId($id_guru);
        $data['enum_values'] = $this->GuruModel->getEnumValues();
        // var_dump($data);
        // die();


        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php');
        $this->load->view('_partials/sidebar.php');
        $this->load->view('dashboard/guru/detail_guru.php', $data);
        $this->load->view('_partials/footer.php');
    }

    public function edit($id_guru)
    {
        $data['guru'] = $this->GuruModel->tampilGuruId($id_guru);
        $data['enum_values'] = $this->GuruModel->getEnumValues();
        // var_dump($data);
        // die();


        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php');
        $this->load->view('_partials/sidebar.php');
        $this->load->view('dashboard/guru/edit_guru.php', $data);
        $this->load->view('_partials/footer.php');
    }

    public function saveUpdate()
    {
        $this->form_validation->set_rules('nip', 'nip', 'trim|required');
        $this->form_validation->set_rules('nama_guru', 'nama_guru Lengkap', 'trim|required');
        $this->form_validation->set_rules('Jabatan', 'Jabatan', 'trim|required');
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
            redirect('gurucontroller');
        } else {
            $id_guru = $this->input->post('id_guru');
            $dataGuru = [
                'id_guru' => $id_guru,
                'nip' => $this->input->post('nip'),
                'nama_guru' => $this->input->post('nama_guru'),
                'Jabatan' => $this->input->post('Jabatan'),
                'Jenis_kelamin' => $this->input->post('Jenis_kelamin'),
                'Tanggal_lahir' => $this->input->post('Tanggal_lahir'),
                'Tempat_lahir' => $this->input->post('Tempat_lahir'),
                'alamat' => $this->input->post('alamat'),
                'Agama' => $this->input->post('Agama'),
                'No_telpon' => $this->input->post('No_telpon'),
                'Kode_guru' => $this->input->post('Kode_guru')
            ];


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

            // var_dump($id_guru, $dataguru);
            // die();
            $this->GuruModel->updateGuru($id_guru, $dataGuru);



            // var_dump($cek);
            // die();

            redirect('guruController');
        }
    }

    public function delete($id_guru)
    {
        $delete_foto = $this->get_image_byId($id_guru);
        unlink('uploads/' . $delete_foto->foto_guru);
        $result = $this->GuruModel->deleteById($id_guru);

        if ($result) {
            $this->session->set_flashdata('message', 'Data Siswa Deleted Sucessfully');
            redirect('gurucontroller');
        } else {
            $this->session->set_flashdata('message', 'Data Siswa Deleted Failed');
            redirect('gurucontroller');
        }


        redirect('gurucontroller');
    }

    private function get_image_byId($id_guru)
    {
        $this->db->select('foto_guru');
        $this->db->from('tbl_guru');
        $this->db->where('tbl_guru.Id_guru', $id_guru);
        $info = $this->db->get();
        return $info->row();
    }
}
