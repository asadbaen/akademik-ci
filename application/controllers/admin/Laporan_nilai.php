<?php

class Laporan_nilai extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Tahun_model');
        $this->load->model('Pengajar_model');
        $this->load->model('KelasModel');
        $this->load->model('User_model');
        $this->load->model('Laporan_model');
        // 'mypdf', 'myexcel'
        $this->load->library('myexcel');
        $this->load->library('mypdf');


        if (!isset($this->session->userdata['username'])) {
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
            'foto'     => $data['foto'] != null ? $data['foto'] : 'user-placeholder.jpg',
            'level'     => $data['level'],
            'tahun'     => $this->Tahun_model->get_data(),
            'menu'      => 'laporan_nilai',
            'breadcrumb' => [
                0 => (object)[
                    'name' => 'Dashboard',
                    'link' => 'admin'
                ],
                1 => (object)[
                    'name' => 'Laporan Daftar Nilai',
                    'link' => NULL
                ]
            ]
        );

        // var_dump($data);
        // die();

        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php', $data);
        $this->load->view('_partials/sidebar.php', $data);
        $this->load->view('dashboard/laporan/nilai.php', $data);
        $this->load->view('_partials/footer.php');
    }

    public function get_kelas()
    {
        $id_tahun   = $this->input->post('id_tahun');
        $data       =  $this->Pengajar_model->get_data_with_tahun($id_tahun);



        if ($data->num_rows() > 0) {
            echo '<option value="">--Pilih Kelas--</option>';
            foreach ($data->result() as $pe) {
                echo "<option value=" . $pe->id_kelas . ">$pe->nama_kelas</option>";
            }
        } else {
            echo '<option value="">--Tidak Tersedia--</option>';
        }
    }

    public function data_all_nilai()
    {
        $id_tahun = $this->input->post('id_tahun', true);
        $id_kelas = $this->input->post('id_kelas', true);
        $nilai = $this->input->post('nilai', true);
        $html = '';

        if ($id_tahun == null || $id_kelas == null) {
            //id not found
            $html = $html . '<div class="card">
                                <div class="card-body">
                                    <h6 class="text-center">Laporan Daftar Nilai Siswa Tidak Tersedia, Silahkan Masukan Data Yang Diperlukan</h6>
                                </div>
                            </div>';
        } else {
            $tahun = $this->Tahun_model->get_detail_data($id_tahun);
            $kelas = $this->KelasModel->get_detail_data($id_kelas);
            $daftar_mapel = $this->Laporan_model->get_mapel_pertahun($id_tahun, $id_kelas)->result();
            $result = $this->Laporan_model->get_data_nilai($id_tahun, $id_kelas, 'default', $nilai);
            $result_min = $this->Laporan_model->get_data_nilai($id_tahun, $id_kelas, 'min', $nilai);

            $result_max = $this->Laporan_model->get_data_nilai($id_tahun, $id_kelas, 'max', $nilai);
            $result_jumlah = $this->Laporan_model->get_data_nilai($id_tahun, $id_kelas, 'jumlah', $nilai);
            $result_rerata = $this->Laporan_model->get_data_nilai($id_tahun, $id_kelas, 'rerata', $nilai);



            if ($result) {
                $html .= '
                <div class="card">
                    <div class="card-body">
                        <div>
                            <h1 class="h1 text-center">LAPORAN DAFTAR NILAI SISWA ' . $nilai . '</h1>
                            <h1 class="text-center">SMP AL - GHUROBA</h1>
                            <h3 class="text-center">Tahun Ajaran ' . $tahun['nama'] . ' Semester ' . $tahun['semester'] . '</h3>
                            <h3 class="text-center">Kelas ' . $kelas['nama_kelas'] . '</h3>
                        </div>
                        <a href="' . base_url('Laporan_nilai/excel_laporan?id_tahun=' . $id_tahun . '&id_kelas=' . $id_kelas . '&nilai=' . $nilai) . '" class="btn btn-success mb-2"><i class="fas fa-file-excel" aria-hidden="true"></i> Print Excel</a>
                        <a href="' . base_url('Laporan_nilai/pdf_laporan?id_tahun=' . $id_tahun . '&id_kelas=' . $id_kelas . '&nilai=' . $nilai) . '" class="btn btn-danger mb-2"><i class="fas fa-file-pdf" aria-hidden="true"></i> Print PDF</a>
                        <table class="table table-responsive-sm table-bordered table-striped table-sm w-100 d-block d-md-table" id="table-laporansiswa">
                            <thead>
                                <tr class="text-center">
                                    <th width="10px">NO</th>
                                    <th width="10px">NIS</th>
                                    <th>NAMA</th>';
                // daftar mapel
                foreach ($daftar_mapel as $key => $value) {
                    $html .= "<th>$value->nama_mapel</th>";
                }

                $html .= '<th>Jumlah</th>
                            <th>Rata-rata</th>
                            </tr></thead><tbody>';

                // data siswa
                foreach ($result as $key => $value) {
                    $html .= '
                    <tr>
                        <td class="text-center">' . ++$key . '</td>
                        <td>' . $value['nis'] . '</td>
                        <td>' . $value['nama_siswa'] . '</td>';

                    foreach ($daftar_mapel as $kd => $mapel) {
                        $html .= '<td>' . $value[$mapel->nama_mapel] . '</td>';
                    }

                    $html = $html . '
                        <td>' . $value['jumlah'] . '</td>
                        <td>' . $value['rerata'] . '</td>
                    </tr>';
                }


                // body table min
                foreach ($result_min as $key => $value) {
                    $html = $html . '<tr><td colspan="100%"></td></tr>';

                    $html = $html . '<tr>
                    <td colspan="3">MIN</td>';
                    foreach ($daftar_mapel as $kd => $mapel) {
                        $html = $html . '<td>' . $value[$mapel->nama_mapel] . '</td>';
                    }

                    $html = $html . "<td>{$value['jumlah']}</td><td>{$value['rerata']}</td></tr>";
                }

                // body table max
                foreach ($result_max as $key => $value) {
                    $html = $html . '<tr>
                    <td colspan="3">MAX</td>';
                    foreach ($daftar_mapel as $kd => $mapel) {
                        $html = $html . '<td>' . $value[$mapel->nama_mapel] . '</td>';
                    }

                    $html = $html . "<td>{$value['jumlah']}</td><td>{$value['rerata']}</td></tr>";
                }

                // body table jumlah
                foreach ($result_jumlah as $key => $value) {
                    $html = $html . '<tr>
                    <td colspan="3">Jumlah</td>';
                    foreach ($daftar_mapel as $kd => $mapel) {
                        $html = $html . '<td>' . $value[$mapel->nama_mapel] . '</td>';
                    }

                    $html = $html . "<td>{$value['jumlah']}</td><td>{$value['rerata']}</td></tr>";
                }

                // body table rerata
                foreach ($result_rerata as $key => $value) {
                    $html = $html . '<tr>
                    <td colspan="3">Rata-Rata</td>';
                    foreach ($daftar_mapel as $kd => $mapel) {
                        $html = $html . '<td>' . $value[$mapel->nama_mapel] . '</td>';
                    }

                    $html = $html . "<td>{$value['jumlah']}</td><td>{$value['rerata']}</td></tr>";
                }

                $html = $html . '<tr></tr>';

                $html = $html . '
                            </tbody>
                        </table>
                    </div>
                </div>';
            } else {
                $html .= '<div class="card">
                        <div class="card-body">
                            <h6 class="text-center">Laporan Daftar Nilai Siswa Tidak Tersedia, Silahkan Masukan Data Yang Diperlukan</h6>
                        </div>
                    </div>';
            }
        }

        echo $html;
    }

    public function pdf_laporan()
    {
        $id_tahun = $this->input->get('id_tahun', TRUE);
        $id_kelas = $this->input->get('id_kelas', TRUE);
        $nilai = $this->input->get('nilai', TRUE);

        // Pastikan parameter telah diberikan
        if (empty($id_tahun) || empty($id_kelas) || empty($nilai)) {
            echo "Parameter id_tahun, id_kelas, dan nilai diperlukan.";
            return;
        }

        $data['tahun'] = $this->Tahun_model->get_detail_data($id_tahun);
        $data['kelas'] = $this->KelasModel->get_detail_data($id_kelas);
        $data['mapel'] = $this->Laporan_model->get_mapel_pertahun($id_tahun, $id_kelas)->result();

        $data['result'] = $this->Laporan_model->get_data_nilai($id_tahun, $id_kelas, 'default', $nilai);
        $data['min'] = $this->Laporan_model->get_data_nilai($id_tahun, $id_kelas, 'min', $nilai);
        $data['max'] = $this->Laporan_model->get_data_nilai($id_tahun, $id_kelas, 'max', $nilai);
        $data['jumlah'] = $this->Laporan_model->get_data_nilai($id_tahun, $id_kelas, 'jumlah', $nilai);
        $data['rerata'] = $this->Laporan_model->get_data_nilai($id_tahun, $id_kelas, 'rerata', $nilai);

        $this->generate_pdf('/dashboard/pdf/laporan_allnilai.php', $data, 'Laporan Data Siswa', 'A4', 'landscape');
        // $this->load->view('/dashboard/pdf/laporan_allnilai.php');
    }

    private function generate_pdf($view, $data = array(), $filename = 'Laporan', $paper = 'A4', $orientation = 'portrait')
    {
        $this->load->library('Mypdf');
        $this->mypdf->generate($view, $data, $filename, $paper, $orientation);
    }






    public function excel_laporan()
    {
        $id_tahun       = $this->input->get('id_tahun', TRUE);
        $id_kelas       = $this->input->get('id_kelas', TRUE);
        $nilai          = $this->input->get('nilai', TRUE);

        $tahun          = $this->Tahun_model->get_detail_data($id_tahun);
        $kelas          = $this->KelasModel->get_detail_data($id_kelas);

        $daftar_mapel   = $this->Laporan_model->get_mapel_pertahun($id_tahun, $id_kelas)->result();

        $result         = $this->Laporan_model->get_data_nilai($id_tahun, $id_kelas, 'default', $nilai);
        $result_min     = $this->Laporan_model->get_data_nilai($id_tahun, $id_kelas, 'min', $nilai);
        $result_max     = $this->Laporan_model->get_data_nilai($id_tahun, $id_kelas, 'max', $nilai);
        $result_jumlah  = $this->Laporan_model->get_data_nilai($id_tahun, $id_kelas, 'jumlah', $nilai);
        $result_rerata  = $this->Laporan_model->get_data_nilai($id_tahun, $id_kelas, 'rerata', $nilai);

        $this->myexcel->generate('Admin', $nilai, $tahun, $kelas, $daftar_mapel, $result, $result_min, $result_max, $result_jumlah, $result_rerata);
    }
}
