<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Presensi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_presensi');
        $this->load->model('Model_siswa_kelas');
        $this->load->library('form_validation');
    }

    // public function isiPresensi($kelas_id)
    // {
    //     $data['students_by_class'] = $this->Model_siswa_kelas->getKelasSiswa($kelas_id);
    //     $data['daftar_presensi'] = $this->Model_presensi->getDaftarPresensi();

    //     $this->load->view('_partials/header.php');
    //     $this->load->view('_partials/navbar.php');
    //     $this->load->view('_partials/sidebar.php');
    //     $this->load->view('dashboard/kelas/presensi/isi_presensi.php', $data);
    //     $this->load->view('_partials/footer.php');
    // }

    public function absensi()
    {

        if ($this->input->get("hari") != "") {
            $hari = $this->input->get("hari");
        } else {
            $getDay = date("l");
            $hari = getDay($getDay);
        }

        $data["active"] = "absensi";
        $data["title"] = "absensi";
        $data["jadwal"] = $this->Model_presensi->all(array("hari" => $hari));
        $data["page"] = "jadwal/absensi";
        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php');
        $this->load->view('_partials/sidebar.php');
        $this->load->view('dashboard/kelas/presensi/presensi.php', array("contents" => $data));
        $this->load->view('_partials/footer.php');
    }

    public function isi_presensi($jadwalID = null, $kelas_id = null, $mapel_id = null)
    {
        $getDay = date("l");
        $hari = getDay($getDay);
        $data["title"] = "Isi Absensi";
        $data["absensi"] = $this->Model_presensi->absensi(array("hari" => $hari, "id_jadwal_pelajaran" => $jadwalID, "tbl_jadwal_pelajaran.kelas" => $kelas_id));
        $data["detail_absensi"] = $this->Model_presensi->getAbsensi(array("jadwal_id" => $jadwalID));

        if (empty($data["detail_absensi"])) {
            $data["edit"] = TRUE;
            $data["detail_absensi"] = $this->Model_siswa_kelas->getKelasSiswa($kelas_id);
        }


        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php');
        $this->load->view('_partials/sidebar.php');
        $this->load->view('dashboard/kelas/presensi/isi_presensi.php',  array("contents" => $data));
        $this->load->view('_partials/footer.php');
    }


    public function save_absensi()
    {
        $siswa_id = $this->input->post("siswa_id");
        $keterangan = $this->input->post("keterangan");
        $absensi = $this->input->post("absensi");
        $kelas_id = $this->input->post("kelas_id");
        $mapel_id = $this->input->post("mapel_id");
        $jadwal_id = $this->input->post("jadwal_id");
        foreach ($siswa_id as $key => $value) {
            $params = array(
                "jadwal_id" => $jadwal_id,
                "kelas_id" => $kelas_id,
                "mapel_id" => $mapel_id,
                "siswa_id" => $siswa_id[$key],
                "absensi" => $absensi[$key],
                "keterangan" => $keterangan,
                "created_at" => date("Y-m-d H:i:s"),
            );

            // var_dump($params);
            // die();
            $this->Model_presensi->save_absensi($params);
        }
        $this->session->set_flashdata("success", "Anda telah berhasil melakukan absensi");
        redirect("Presensi/absensi");
    }

    public function update_absensi()
    {
        $siswa_id = $this->input->post("siswa_id");
        $keterangan = $this->input->post("keterangan");
        $absensi = $this->input->post("absensi");
        $kelas_id = $this->input->post("kelas_id");
        $mapel_id = $this->input->post("mapel_id");
        $jadwal_id = $this->input->post("jadwal_id");
        $where = $this->input->post("absensi_id");
        foreach ($siswa_id as $key => $value) {
            $params = array(
                'absensi_id' => $where,
                "jadwal_id" => $jadwal_id,
                "kelas_id" => $kelas_id,
                "mapel_id" => $mapel_id,
                "keterangan" => $keterangan,
                "siswa_id" => $siswa_id[$key],
                "absensi" => $absensi[$key]
            );
            // $where = array("absensi_id" => $this->input->post("absensi_id"));
            // var_dump($where, $params);
            // die();

            $this->Model_presensi->update_absensi($where, $params);

            // var_dump($query);
            // die();
        }
        $this->session->set_flashdata("success", "Anda telah berhasil melakukan Edit absensi");
        redirect("Presensi/absensi");
    }
}
