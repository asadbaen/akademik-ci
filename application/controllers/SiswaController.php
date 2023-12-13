<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SiswaController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('SiswaModel');
        $this->load->model('KelasModel');
        $this->load->library('form_validation');
    }

    public function index()
    {

        $data['dataSiswa'] = $this->SiswaModel->getSiswa();

        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php');
        $this->load->view('_partials/sidebar.php');
        $this->load->view('dashboard/siswa/index.php', $data);
        $this->load->view('_partials/footer.php');
    }
    public function createSiswa()
    {
        $data['enum_values'] = $this->SiswaModel->getEnumValues();
        $data['kelas'] = $this->KelasModel->tampilKelas();
        // var_dump($data);
        // die();
        // $this->load->view('dropdown_view', $data);

        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php');
        $this->load->view('_partials/sidebar.php');
        $this->load->view('dashboard/siswa/tambah_siswa.php', $data);
        $this->load->view('_partials/footer.php');
    }

    public function saveCreateSiswa()
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
            redirect('SiswaController/createSiswa');
        } else {
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
                'Pekerjaan_ibu' => $this->input->post('Pekerjaan_ibu')
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
                    redirect('HomeController');
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

            redirect('siswacontroller');
        }
    }

    public function detail($id_siswa)
    {
        $data['siswa'] = $this->SiswaModel->getSiswaByid($id_siswa);
        $data['kelas'] = $this->KelasModel->tampilKelas();
        $data['enum_values'] = $this->SiswaModel->getEnumValues();
        // var_dump($data);
        // die();


        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php');
        $this->load->view('_partials/sidebar.php');
        $this->load->view('dashboard/siswa/detail_siswa.php', $data);
        $this->load->view('_partials/footer.php');
    }

    public function edit($id_siswa)
    {
        $data['siswa'] = $this->SiswaModel->getSiswaByid($id_siswa);
        $data['kelas'] = $this->KelasModel->tampilKelas();
        $data['enum_values'] = $this->SiswaModel->getEnumValues();
        // var_dump($data);
        // die();


        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php');
        $this->load->view('_partials/sidebar.php');
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
            redirect('siswacontroller');
        } else {
            $id_siswa = $this->input->post('id_siswa');
            $dataSiswa = [
                'id_siswa' => $id_siswa,
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
                'Pekerjaan_ibu' => $this->input->post('Pekerjaan_ibu')
            ];

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
                    redirect('SiswaController');
                } else {
                    $post_image = $this->upload->data();

                    // Generate new file name based on date, year, day, and role_id
                    // $file_name = date('Ymd') . '_' . date('Y') . '_' . date('D') . '.' . $post_image['file_name'];

                    $file_name = $post_image['file_name'];

                    // Rename the uploaded file
                    // rename($post_image['full_path'], $post_image['file_path'] . $file_name);

                    $dataSiswa['foto'] = $file_name;

                    unlink($delete_foto);
                }
            }

            // var_dump($id_siswa, $dataSiswa);
            // die();
            $this->SiswaModel->updateSiswa($id_siswa, $dataSiswa);



            // var_dump($cek);
            // die();

            redirect('SiswaController');
        }
    }

    public function delete($id_siswa)
    {

        $delete_foto = $this->get_image_byId($id_siswa);
        unlink('uploads/' . $delete_foto->foto);
        $result = $this->SiswaModel->deleteById($id_siswa);

        if ($result) {
            $this->session->set_flashdata('message', 'Data Siswa Deleted Sucessfully');
            redirect('siswacontroller');
        } else {
            $this->session->set_flashdata('message', 'Data Siswa Deleted Failed');
            redirect('siswacontroller');
        }


        redirect('SiswaController');
    }

    private function get_image_byId($id_siswa)
    {
        $this->db->select('foto');
        $this->db->from('tbl_siswa');
        $this->db->where('tbl_siswa.Id_siswa', $id_siswa);
        $info = $this->db->get();
        return $info->row();
    }
}
