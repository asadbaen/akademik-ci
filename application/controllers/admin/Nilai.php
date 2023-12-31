<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Nilai extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('MapelModel');
        $this->load->model('KelasModel');
        $this->load->model('SiswaModel');
        $this->load->model('Nilai_model');
        $this->load->model('Tahun_model');
        $this->load->model('User_model');
        $this->load->model('Model_guru_kelas');


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
            'foto'     => $data['foto'] != null ? $data['foto'] : 'user-placeholder.jpg',
            'level'     => $data['level'],
            'mapel'     => $this->MapelModel->get_data(),
            'kelas'     => $this->KelasModel->get_data(),
            'tahun'     => $this->Tahun_model->get_active_stats(),
            'menu'      => 'nilai',
            'breadcrumb' => [
                0 => (object)[
                    'name' => 'Dashboard',
                    'link' => 'admin'
                ],
                1 => (object)[
                    'name' => 'Data tables',
                    'link' => NULL
                ]
            ]
        );

        // $data = array(
        //     'mapel'     => $this->MapelModel->get_data(),
        //     'kelas'     => $this->KelasModel->get_data(),
        //     'tahun'     => $this->Tahun_model->get_active_stats(),
        //     'menu'      => 'nilai',
        // );
        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php', $data);
        $this->load->view('_partials/sidebar.php', $data);
        $this->load->view('dashboard/nilai/index.php', $data);
        $this->load->view('_partials/footer.php');
    }

    public function get_mapel()
    {
        $id_kelas   = $this->input->post('id_kelas', TRUE);
        $data       = $this->MapelModel->get_mapel_with_kelas($id_kelas);

        if ($data->num_rows() > 0) {
            echo '<option value="">--Pilih Mata Pelajaran--</option>';
            foreach ($data->result() as $mp) {
                echo "<option value=$mp->id_mapel>$mp->nama_mapel</option>";
            }
        } else {
            echo '<option value="">--Tidak Tersedia--</option>';
        }
    }

    public function kd()
    {
        $id_kelas = $this->input->get('id_kelas', TRUE);
        $id_mapel = $this->input->get('id_mapel', TRUE);
        $nilai    = $this->input->get('nilai', TRUE);

        if (!isset($id_kelas) || !isset($id_mapel) || !isset($nilai)) {
            redirect('error_404');
        }

        $kelas = $this->KelasModel->get_detail_data($id_kelas);
        $mapel = $this->MapelModel->get_detail_data($id_mapel);
        $komp_dasar = $this->MapelModel->get_mapel_with_kd_nilai($id_mapel, $id_kelas, $nilai);

        if (!isset($kelas) || !isset($mapel) || !isset($komp_dasar)) {
            redirect('error_404');
        }

        $data = $this->User_model->get_detail_admin($this->session->userdata['id_user'], $this->session->userdata['level']);
        $data = array(
            'id_user'   => $data['id_user'],
            'nama'      => $data['nama'],
            'foto'     => $data['foto'] != null ? $data['foto'] : 'user-placeholder.jpg',
            'level'     => $data['level'],
            'id_kelas'      => $id_kelas,
            'id_mapel'      => $id_mapel,
            'jenis_nilai'   => $nilai,
            'kelas'         => $kelas,
            'mapel'         => $mapel,
            'komp_dasar'    => $komp_dasar,
            'tahun'         => $this->Tahun_model->get_active_stats(),
            'menu'      => 'nilai',
            'breadcrumb' => [
                0 => (object)[
                    'name' => 'Dashboard',
                    'link' => 'admin'
                ],
                1 => (object)[
                    'name' => 'Nilai',
                    'link' => 'admin/nilai'
                ],
                2 => (object)[
                    'name' => 'Detail',
                    'link' => NULL
                ]
            ]
        );

        // var_dump($data['kelas']);
        // var_dump($data['mapel']);
        // var_dump($data['komp_dasar']);
        // var_dump($data['jenis_nilai']);
        // die();
        // $data = array(
        //     'id_kelas'      => $id_kelas,
        //     'id_mapel'      => $id_mapel,
        //     'jenis_nilai'   => $nilai,
        //     'kelas'         => $kelas,
        //     'mapel'         => $mapel,
        //     'komp_dasar'    => $komp_dasar,
        //     'tahun'         => $this->Tahun_model->get_active_stats(),

        // );
        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php', $data);
        $this->load->view('_partials/sidebar.php', $data);
        $this->load->view('dashboard/nilai/nilai_perkd.php', $data);
        $this->load->view('_partials/footer.php');
    }

    public function data_nilai_permapel()
    {
        $id_kelas       = $this->input->post('id_kelas', TRUE);
        $id_mapel       = $this->input->post('id_mapel', TRUE);
        $nilai          = $this->input->post('nilai', TRUE);
        $kelas          = $this->KelasModel->get_detail_data($id_kelas);
        $mapel          = $this->MapelModel->get_detail_data($id_mapel);
        $data_default   = $this->Nilai_model->get_nilai_permapel($id_mapel, $id_kelas, 'default', NULL, $nilai);
        $data_min       = $this->Nilai_model->get_nilai_permapel($id_mapel, $id_kelas, 'min', NULL, $nilai);
        $data_max       = $this->Nilai_model->get_nilai_permapel($id_mapel, $id_kelas, 'max', NULL, $nilai);
        $data_jumlah    = $this->Nilai_model->get_nilai_permapel($id_mapel, $id_kelas, 'jumlah', NULL, $nilai);
        $data_rerata    = $this->Nilai_model->get_nilai_permapel($id_mapel, $id_kelas, 'rerata', NULL, $nilai);
        $daftar_kd      = $this->Nilai_model->get_kd_permapel_result($id_mapel, $id_kelas, $nilai);
        $html           = '';

        if ($id_mapel == null || $id_kelas == null || $nilai == null) {
            //id not found
            $html = $html . '<div class="card">
                                <div class="card-body">
                                    <h6 class="text-center">Data Nilai Tidak Tersedia, Silahkan Masukkan Data Yang Diperlukan</h6>
                                </div>
                            </div>';
        } else if ($data_default != null) {
            //awal table
            $html = $html . '<div class="card">
                    <div class="card-header bg-behance">
                        <h6 class="text-white"> ' . $mapel['nama_mapel'] . ' / Kelas ' . $kelas['nama_kelas'] . '</h6>
                    </div>
                    <div class="card-body">
                        <a href="' . base_url('admin/nilai/kd?id_kelas=' . $id_kelas . '&id_mapel=' . $id_mapel . '&nilai=' . $nilai) . '" class="btn btn-primary mb-3"><i class="fas fa-info-circle"></i> Cek Selengkapnya</i></a>
                        <table class="table table-responsive-sm table-bordered table-striped table-sm w-100 d-block d-md-table">
                            <thead>
                                <tr>
                                    <th style="vertical-align : middle;text-align:center;">No</th>
                                    <th style="vertical-align : middle;text-align:center;">NIS</th>
                                    <th style="vertical-align : middle;text-align:center;">Nama</th>';

            //heading table
            foreach ($daftar_kd as $key => $value) {
                $html = $html . '<th style="vertical-align : middle;text-align:center;">' . $value->nama_kd . '</th>';
            }

            //jumlah dan rata-rata
            // <th style="vertical-align : middle;text-align:center;">Jumlah</th>
            $html = $html . '
                            <th style="vertical-align : middle;text-align:center;">Rata-rata</th>
                            </tr></thead><tbody>';

            //body table default
            foreach ($data_default as $dt => $value_dt) {
                $html = $html . '<tr>
                    <td width="20px">' . ++$dt . '</td>
                    <td width="20px">' . $value_dt['nis'] . '</td>
                    <td>' . $value_dt['nama_siswa'] . '</td>';
                foreach ($daftar_kd as $kd => $value_kd) {
                    $html = $html . '<td>' . $value_dt[$value_kd->nama_kd] . '</td>';
                }

                // <td>{$value_dt['jumlah']}</td>
                $html = $html . "
                    <td>{$value_dt['rerata']}</td></tr>";
            }

            //body table min
            foreach ($data_min as $dt => $value_dt) {
                $html = $html . '<tr><td colspan="100%"></td></tr>';

                $html = $html . '<tr>
                    <td colspan="3">MIN</td>';
                foreach ($daftar_kd as $kd => $value_kd) {
                    $html = $html . '<td>' . $value_dt[$value_kd->nama_kd] . '</td>';
                }

                // <td>{$value_dt['jumlah']}</td>
                $html = $html . "
                    <td>{$value_dt['rerata']}</td></tr>";
            }

            //body table max
            foreach ($data_max as $dt => $value_dt) {
                $html = $html . '<tr>
                    <td colspan="3">MAX</td>';
                foreach ($daftar_kd as $kd => $value_kd) {
                    $html = $html . '<td>' . $value_dt[$value_kd->nama_kd] . '</td>';
                }

                // <td>{$value_dt['jumlah']}</td>
                $html = $html . "
                    <td>{$value_dt['rerata']}</td></tr>";
            }

            //body table jumlah
            foreach ($data_jumlah as $dt => $value_dt) {
                $html = $html . '<tr>
                    <td colspan="3">JUMLAH</td>';
                foreach ($daftar_kd as $kd => $value_kd) {
                    $html = $html . '<td>' . $value_dt[$value_kd->nama_kd] . '</td>';
                }

                // <td>{$value_dt['jumlah']}</td>
                $html = $html . "
                    <td>{$value_dt['rerata']}</td></tr>";
            }

            //body table rerata
            foreach ($data_rerata as $dt => $value_dt) {
                $html = $html . '<tr>
                    <td colspan="3">RATA-RATA</td>';
                foreach ($daftar_kd as $kd => $value_kd) {
                    $html = $html . '<td>' . $value_dt[$value_kd->nama_kd] . '</td>';
                }

                // <td>{$value_dt['jumlah']}</td>
                $html = $html . "
                    <td>{$value_dt['rerata']}</td></tr>";
            }

            //akhir table
            $html = $html . '</tbody></table></div></div>';
        } else {
            $html = $html . '
                <div class="card">
                    <div class="card-header bg-behance">
                        <h6 class="text-white"> ' . $mapel['nama_mapel'] . ' / Kelas ' . $kelas['nama_kelas'] . ' (' . $nilai . ')</h6>
                    </div>
                    <div class="card-body">
                        <a href="' . base_url('admin/nilai/kd?id_kelas=' . $id_kelas . '&id_mapel=' . $id_mapel . '&nilai=' . $nilai) . '" class="btn btn-primary mb-3"><i class="fas fa-info-circle"></i> Cek Selengkapnya</i></a>
                        <h6 class="text-center">Data nilai belum lengkap, silahkan cek selengkapnya</h6>
                    </div>
                </div>
            
            ';
        }

        echo ($html);
    }



    public function data_nilai_perkd()
    {
        $id_kelas   = $this->input->post('id_kelas', TRUE);
        $id_mapel   = $this->input->post('id_mapel', TRUE);
        $id_kd      = $this->input->post('id_kd', TRUE);
        $tahun      = $this->input->post('tahun', TRUE);
        $nilai      = $this->input->post('nilai', TRUE);
        $data       = $this->Nilai_model->get_nilai_perkd($id_kelas, $id_mapel, $id_kd, $tahun);
        $jenis      = $this->Nilai_model->get_jenis_nilai_in_perkd($id_kelas, $id_mapel, $id_kd, $tahun);
        $kd         = $this->MapelModel->get_kd_detail($id_kd);
        $html       = '';

        if ($data != null || $jenis != null) {
            //awal table
            $html = $html . '<div class="card">
                    <div class="card-body">
                        ' . anchor('admin/nilai/input?id_kelas=' . $id_kelas . '&id_mapel=' . $id_mapel . '&id_kd=' . $id_kd . '&nilai=' . $nilai, '<button class="btn btn-sm btn-primary mb-3 mr-2"><i class="fas fa-plus fa-sm"></i> Tambah Nilai</button>') . '
                        ' . '
                        <h5>' . $kd['nama_kd'] . '</h5>
                        <table class="table table-responsive-sm table-bordered table-striped table-sm w-100 d-block d-md-table">
                            <thead>
                                <tr>
                                    <th rowspan="2" style="vertical-align : middle;text-align:center;" >No</th>
                                    <th rowspan="2" style="vertical-align : middle;text-align:center;" >Nama</th>';

            //heading button table
            foreach ($jenis as $jn => $value) {
                $html = $html . '<th class="text-center">' .
                    anchor('admin/nilai/edit?id_kelas=' . $id_kelas . '&id_mapel=' . $id_mapel . '&id_kd=' . $id_kd . '&jenis=' . $value->jenis . '&nilai=' . $nilai, '<div class="btn btn-sm btn-primary mr-1 ml-1 mb-1"><i class="fa fa-edit fa-sm"></i></div>') .
                    '<a href="' . base_url('admin/nilai/delete_data?id_kelas=' . $id_kelas . '&id_mapel=' . $id_mapel . '&id_kd=' . $id_kd . '&jenis=' . $value->jenis . '&nilai=' . $nilai) . '" class="btn btn-sm btn-dark mr-1 ml-1 mb-1" onclick="return deleteNilai(event)"><i class="fa fa-archive fa-sm"></i></a>' .
                    '</th>';
            }

            $html = $html . '<th rowspan="2" style="vertical-align : middle;text-align:center;">Jumlah</th>
                            <th rowspan="2" style="vertical-align : middle;text-align:center;">Rata-rata</th>
                            </tr><tr>';

            //heading table
            foreach ($jenis as $jn => $value) {
                $html = $html . '<th>' . $value->jenis . '</th>';
            }

            $html = $html . '</tr></thead><tbody>';

            //body table
            foreach ($data as $dt => $value_dt) {
                $html = $html . '<tr>
                    <td width="20px">' . ++$dt . '</td>
                    <td>' . $value_dt['nama_siswa'] . '</td>';
                foreach ($jenis as $jn => $value_jn) {
                    $html = $html . '<td>' . $value_dt[$value_jn->jenis] . '</td>';
                }

                $html = $html . "<td>{$value_dt['jumlah']}</td><td>{$value_dt['rerata']}</td></tr>";
            }

            //akhir table
            $html = $html . '</tbody></table></div></div>';
        } else if ($id_mapel == null || $id_kelas == null || $id_kd == null) {
            //id not found
            $html = $html . '<div class="card">
                                <div class="card-body">
                                    <h6 class="text-center">Data Nilai Tidak Dapat Ditampilkan, Silahkan Pilih Kompetensi Dasar</h6>
                                </div>
                            </div>';
        } else {
            //data not found
            $html = $html . '<div class="card">
                                <div class="card-body">
                                    ' . anchor('admin/nilai/input?id_kelas=' . $id_kelas . '&id_mapel=' . $id_mapel . '&id_kd=' . $id_kd . '&nilai=' . $nilai, '<button class="btn btn-sm btn-primary mb-3 mr-2"><i class="fas fa-plus fa-sm"></i> Tambah Nilai</button>') . '
                                    <h5>' . $kd['nama_kd'] . '</h5>
                                    <h5 class="text-center">Data nilai ' . $kd['nama_kd'] . ' belum tersedia, silahkan klik tambah nilai untuk menambahkan nilai siswa</h5>
                                </div>
                            </div>';
        }
        echo ($html);
    }

    // input nilai
    public function input()
    {
        $id_kelas   = $this->input->get('id_kelas', TRUE);
        $id_mapel   = $this->input->get('id_mapel', TRUE);
        $id_kd      = $this->input->get('id_kd', TRUE);
        $nilai      = $this->input->get('nilai', TRUE);
        $tahun      = $this->Tahun_model->get_active_stats();

        if (!isset($id_kelas) || !isset($id_mapel) || !isset($id_kd)) {
            redirect('error_404');
        }

        $kelas = $this->KelasModel->get_detail_data($id_kelas);
        $mapel = $this->MapelModel->get_detail_data($id_mapel);
        $komp_dasar = $this->MapelModel->get_kd_detail($id_kd);

        if (!isset($kelas) || !isset($mapel) || !isset($komp_dasar)) {
            redirect('error_404');
        }

        $result_jenis = array_column($this->Nilai_model->get_jenis_nilai_in_perkd_array($id_kelas, $id_mapel, $id_kd, $tahun['nama']), 'jenis');
        $object_jenis = ['Tugas Harian 1', 'Tugas Harian 2', 'Tugas Harian 3', 'Tugas Harian 4', 'Ulangan Harian 1', 'Ulangan Harian 2', 'Ulangan Harian 3', 'Ulangan Harian 4', 'UTS', 'UAS'];
        $data = $this->User_model->get_detail_admin($this->session->userdata['id_user'], $this->session->userdata['level']);

        $data = array(
            'id_user'           => $data['id_user'],
            'nama'              => $data['nama'],
            'foto'             => $data['foto'] != null ? $data['foto'] : 'user-placeholder.jpg',
            'level'             => $data['level'],
            'id_kelas'          => $id_kelas,
            'id_mapel'          => $id_mapel,
            'jenis_penilaian'   => $nilai,
            'tahun'             => $tahun,
            'kelas'             => $kelas,
            'mapel'             => $mapel,
            'komp_dasar'        => $komp_dasar,
            'pengajar'          => $this->Model_guru_kelas->get_detail_data_with_kelas_and_mapel($id_kelas, $id_mapel),
            'siswa'             => $this->SiswaModel->get_data_perkelas($id_kelas, $tahun),
            'jenis_nilai'       => array_diff($object_jenis, $result_jenis),
            'menu'              => 'nilai',
            'breadcrumb'        => [
                0 => (object)[
                    'name' => 'Dashboard',
                    'link' => 'admin'
                ],
                1 => (object)[
                    'name' => 'Nilai',
                    'link' => 'admin/nilai'
                ],
                2 => (object)[
                    'name' => 'Detail',
                    'link' => 'admin/nilai/kd?id_kelas=' . $id_kelas . '&id_mapel=' . $id_mapel . '&nilai=' . $nilai
                ],
                3 => (object)[
                    'name' => 'Input Nilai',
                    'link' => NULL
                ]
            ]


        );

        // var_dump($data['komp_dasar']);
        // var_dump($data['mapel']);
        // var_dump($data['kelas']);
        // var_dump($data['tahun']);
        // var_dump($data['siswa']);
        // die();

        $this->_rules_persiswa($data['siswa']);

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('_partials/header.php');
            $this->load->view('_partials/navbar.php', $data);
            $this->load->view('_partials/sidebar.php', $data);
            $this->load->view('dashboard/nilai/nilai_input.php', $data);
            $this->load->view('_partials/footer.php');
        } else {
            $this->Nilai_model->input_nilai($data['siswa'], $id_kd);
            $this->session->set_flashdata('message', 'Nilai Siswa Berhasil Ditambahkan!');
            redirect('admin/nilai/kd?id_kelas=' . $id_kelas . '&id_mapel=' . $id_mapel . '&nilai=' . $nilai);
        }
    }
    //edit nilai
    public function edit()
    {
        $id_kelas   = $this->input->get('id_kelas', TRUE);
        $id_mapel   = $this->input->get('id_mapel', TRUE);
        $id_kd      = $this->input->get('id_kd', TRUE);
        $jenis      = $this->input->get('jenis', TRUE);
        $nilai      = $this->input->get('nilai', TRUE);
        $tahun      = $this->Tahun_model->get_active_stats();

        if (!isset($id_kelas) || !isset($id_mapel) || !isset($id_kd) || !isset($jenis)) {
            redirect('error_404');
        }

        $kelas = $this->KelasModel->get_detail_data($id_kelas);
        $mapel = $this->MapelModel->get_detail_data($id_mapel);
        $komp_dasar = $this->MapelModel->get_kd_detail($id_kd);

        if (!isset($kelas) || !isset($mapel) || !isset($komp_dasar)) {
            redirect('error_404');
        }

        $data = array(
            'kelas'         => $kelas,
            'mapel'         => $mapel,
            'komp_dasar'    => $komp_dasar,
            'pengajar'      => $this->Model_guru_kelas->get_detail_data_with_kelas_and_mapel($id_kelas, $id_mapel),
            'siswa'         => $this->SiswaModel->get_data_perkelas($id_kelas, $tahun),
            'nilai'         => $this->Nilai_model->detail_nilai_perkd($id_kelas, $id_mapel, $id_kd, $jenis, $tahun['nama']),
            'jenis_nilai'   => $jenis,
            'jenis_penilaian' => $nilai,
            'tahun'         => $tahun,
        );

        $this->_rules_persiswa($data['nilai']);

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('_partials/header.php');
            $this->load->view('_partials/navbar.php', $data);
            $this->load->view('_partials/sidebar.php', $data);
            $this->load->view('dashboard/nilai/nilai_edit.php', $data);
            $this->load->view('_partials/footer.php');
        } else {
            $this->Nilai_model->update_nilai($data['siswa'], $id_kd, $jenis);
            $this->session->set_flashdata('message', 'Nilai Siswa Berhasil Diupdate!');
            redirect('admin/nilai/kd?id_kelas=' . $id_kelas . '&id_mapel=' . $id_mapel . '&nilai=' . $nilai);
        }
    }


    public function delete_data()
    {
        $id_kelas   = $this->input->get('id_kelas', TRUE);
        $id_mapel   = $this->input->get('id_mapel', TRUE);
        $id_kd      = $this->input->get('id_kd', TRUE);
        $jenis      = $this->input->get('jenis', TRUE);
        $nilai      = $this->input->get('nilai', TRUE);
        $tahun      = $this->Tahun_model->get_active_stats();


        $this->_delete($id_kelas, $id_kd, $jenis, $id_mapel, $nilai, $tahun);
    }




    private function _delete($id_kelas, $id_kd, $jenis, $id_mapel, $nilai, $tahun)
    {
        if (!isset($id_kelas) || !isset($id_kd) || !isset($jenis) || !isset($id_mapel)) {
            redirect('error_404');
        }

        $this->Nilai_model->delete_nilai($id_kelas, $id_kd, $jenis, $tahun['nama']);
        $this->session->set_flashdata('message', 'Data Nilai Berhasil DiHapus!');
        redirect('admin/nilai/kd?id_kelas=' . $id_kelas . '&id_mapel=' . $id_mapel . '&nilai=' . $nilai);
    }

    private function _rules_persiswa($data_siswa)
    {
        foreach ($data_siswa as $key => $value) {
            $this->form_validation->set_rules('nilai' . $key, 'Nilai', 'required|numeric');
        }
        $this->form_validation->set_rules('jenis', 'Jenis Nilai', 'required');
    }
}
