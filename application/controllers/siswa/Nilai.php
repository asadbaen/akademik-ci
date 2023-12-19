<?php
class Nilai extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->model('MapelModel');
        $this->load->model('KelasModel');
        $this->load->model('SiswaModel');
        $this->load->model('Nilai_model');
        $this->load->model('Tahun_model');
        $this->load->model('User_model');
        $this->load->model('Model_guru_kelas');

        if (!isset($this->session->userdata['username']) && $this->session->userdata['level'] != 'siswa') {
            $this->session->set_flashdata('message', 'Anda Belum Login!');
            redirect('login');
        }

        if ($this->session->userdata['level'] != 'siswa') {
            $this->session->set_flashdata('message', 'Anda Belum Login!');
            redirect('login');
        }
    }

    public function index()
    {
        $data       = $this->User_model->get_detail_siswa($this->session->userdata['id_user'], $this->session->userdata['level']);
        $tahun      = $this->Tahun_model->get_active_stats();
        $kelas      = $this->KelasModel->get_detail_siswa($data['id_siswa'], $tahun);
        $id_kelas   = $kelas['id_kelas'];
        $id_tahun   = $tahun['id_tahun'];
        $id_siswa   = $data['id_siswa'];
        $nilai      = $this->Nilai_model->nilai_persiswa($id_siswa, $id_kelas, $id_tahun);
        $total_nilai = $this->Nilai_model->total_nilai_persiswa($id_siswa, $id_kelas, $id_tahun);
        $allkelas   = $this->Model_guru_kelas->get_allkelas_peserta($id_siswa);
        $data = array(
            'id_user'   => $data['id_user'],
            'nama'      => $data['nama_siswa'],
            'foto'     => $data['foto'] != null ? $data['foto'] : 'user-placeholder.jpg',
            'level'     => $data['level'],
            'kelas'     => $kelas,
            'allkelas'  => $allkelas,
            'menu'      => 'dashboard',
            'tahun'     => $this->Tahun_model->get_data(),
            'tahun_aktif' => $this->Tahun_model->get_active_stats(),
            'nilai'     => $nilai,
            'total'     => $total_nilai,
            'breadcrumb' => [
                0 => (object)[
                    'name' => 'Dashboard',
                    'link' => NULL
                ]
            ]
        );


        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php', $data);
        $this->load->view('_partials/sidebar.php', $data);
        $this->load->view('siswa/nilai.php', $data);
        $this->load->view('_partials/footer.php');
    }

    public function get_other_nilai()
    {
        $id_tahun   = $this->input->post('id_tahun', TRUE);
        $tahun      = $this->Tahun_model->get_detail_data($id_tahun);
        $data       = $this->User_model->get_detail_siswa($this->session->userdata['id_user'], $this->session->userdata['level']);
        $peserta    = $this->Model_guru_kelas->get_kelas($data['id_siswa'], $tahun['nama']);
        $kelas      = $this->KelasModel->get_detail_data($peserta['id_kelas']);
        $nilai      = $this->Nilai_model->nilai_persiswa($data['id_siswa'], $peserta['id_kelas'], $id_tahun);
        $total_nilai = $this->Nilai_model->total_nilai_persiswa($data['id_siswa'], $peserta['id_kelas'], $id_tahun);
        $html = '';

        $html = $html . '
            <h5 class="text-right">Kelas ' . $kelas['kelas'] . '</h5>
            <table class="table table-responsive-sm table-bordered table-striped table-sm w-100 d-block d-md-table" id="table-guru">
                <thead>
                    <tr>
                        <th class="text-center" width="30px">No</th>
                        <th>Mata Pelajaran</th>
                        <th>PTS</th>
                        <th>PAS</th>
                        <th>Jumlah</th>
                        <th>Rata-rata</th>
                    </tr>
                </thead>
                <tbody>';
        foreach ($nilai as $key => $value) {
            $html = $html . '
                <tr>
                    <td class="text-center">' . ++$key . '</td>
                    <td>' . $value->nama_mapel . '</td>
                    <td>' . $value->pts . '</td>
                    <td>' . $value->pas . '</td>
                    <td>' . $value->jumlah . '</td>
                    <td>' . $value->rerata . '</td>
                </tr>
            ';
        }
        $html = $html . '
                    <tr>
                        <td colspan="5">Jumlah Seluruh Nilai</td>
                        <td>' . $total_nilai['jumlah'] . '</td>
                    </tr>
                    <tr>
                        <td colspan="5">Rata-rata Seluruh Nilai</td>
                        <td>' . $total_nilai['rerata'] . '</td>
                    </tr>
                </tbody>
            </table>
        ';

        echo $html;
    }
}
