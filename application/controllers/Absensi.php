<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Absensi extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_absensi');
        $this->load->model('Model_siswa_kelas');
    }
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
        $data["jadwal"] = $this->Model_absensi->all(array("hari" => $hari));
        $data["page"] = "jadwal/absensi";
        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php');
        $this->load->view('_partials/sidebar.php');
        $this->load->view('dashboard/absensi/index.php', array("contents" => $data));
        $this->load->view('_partials/footer.php');
    }

    public function isi_absensi($jadwal_id = null, $kelas_id = null, $mapel_id = null)
    {
        $getDay = date("l");
        $hari = getDay($getDay);
        $data["active"] = "absensi";
        $data["title"] = "Isi Absensi";
        $data["absensi"] = $this->Model_absensi->absensi(array("id_jadwal" => $jadwal_id, "tbl_jadwal_pelajaran.kelas_id" => $kelas_id));
        $data["detail_absensi"] = $this->Model_absensi->getAbsensi(array("jadwal_id" => $jadwal_id));

        if (empty($data["detail_absensi"])) {
            $data["edit"] = TRUE;
            $data["detail_absensi"] = $this->Model_siswa_kelas->getKelasSiswa($kelas_id);
        }
        $this->load->view('_partials/header.php');
        $this->load->view('_partials/navbar.php');
        $this->load->view('_partials/sidebar.php');
        $this->load->view('dashboard/absensi/isi_absensi.php', array("contents" => $data));
        $this->load->view('_partials/footer.php');
    }

    public function save_absensi()
    {
        $siswa_id = $this->input->post("siswa_id");
        $absensi = $this->input->post("absensi");
        $kelas_id = $this->input->post("kelas_id");
        $mapel_id = $this->input->post("mapel_id");
        $jadwal_id = $this->input->post("jadwal_id");
        $keterangan = $this->input->post("keterangan");
        foreach ($siswa_id as $key => $value) {
            $params = array(
                "jadwal_id" => $jadwal_id,
                "kelas_id" => $kelas_id,
                "mapel_id" => $mapel_id,
                "siswa_id" => $siswa_id[$key],
                "absensi" => $absensi[$key],
                "keterangan" => $keterangan[$key],
                "created_at" => date("Y-m-d H:i:s")
            );

            $this->Model_absensi->save_absensi($params);
        }
        $this->session->set_flashdata("success", "Anda telah berhasil melakukan absensi");
        redirect("Absensi/absensi");
    }

    public function update_absensi()
    {
        $siswa_id = $this->input->post("siswa_id");
        $absensi = $this->input->post("absensi");
        $kelas_id = $this->input->post("kelas_id");
        $mapel_id = $this->input->post("mapel_id");
        $jadwal_id = $this->input->post("jadwal_id");
        $keterangan = $this->input->post("keterangan");
        foreach ($siswa_id as $key => $value) {
            $params = array(
                "jadwal_id" => $jadwal_id,
                "kelas_id" => $kelas_id,
                "mapel_id" => $mapel_id,
                "siswa_id" => $siswa_id[$key],
                "absensi" => $absensi[$key],
                "keterangan" => $keterangan[$key],
            );
            $where = array("absensi_id" => $this->input->post("absensi_id")[$key]);
            // var_dump($params, $where);
            // die();



            $this->Model_absensi->update_absensi($params, $where);
        }
        $this->session->set_flashdata("success", "Anda telah berhasil melakukan Edit absensi");
        redirect("Absensi/absensi");
    }
}
