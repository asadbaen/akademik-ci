<?php

use chriskacerguis\RestServer\RestController;

class Dashboard extends RestController
{

    public function index_get()
    {
        $id_user = $this->get('id_user');
        $level = $this->input->get('level');

        if ($level == 'admin' && isset($id_user)) {
            $tahun = $this->Tahun_model->get_active_stats();
            $siswa = $this->SiswaModel->get_count_allsiswa($tahun);
            $kelas = $this->KelasModel->get_count();
            $guru = $this->GuruModel->get_count($tahun);

            $data = [
                'school_year'   => $tahun['nama'],
                'semester'      => $tahun['semester'],
                'students'      => $siswa,
                'class'         => $kelas,
                'teachers'      => $guru
            ];


            $this->response(['status' => 200, 'messages' => 'success', 'dashboard' => $data], RestController::HTTP_OK);
        }
    }
}
