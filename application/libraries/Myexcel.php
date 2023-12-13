<?php

defined('BASEPATH') or exit('No direct script access allowed');

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class Myexcel
{
    protected $ci;

    public function __construct()
    {
        $this->ci = &get_instance();
    }

    public function generate($user, $jenis, $tahun, $kelas, $mapel, $result, $result_min = NULL, $result_max = NULL, $result_sum = NULL, $result_avg = NULL)
    {
        $kelas              = $kelas['nama_kelas'];
        $semester           = $tahun['semester'];
        $tahun              = $tahun['nama'];
        $list_head_cell     = ['E6', 'F6', 'G6', 'H6', 'I6', 'J6', 'K6', 'L6', 'M6', 'N6', 'O6', 'P6', 'Q6', 'R6', 'S6', 'T6', 'U6'];
        $list_body_cell     = ['E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U'];

        $object             = new Spreadsheet();

        $object->getProperties()->setCreator($user);
        $object->getProperties()->setLastModifiedBy($user);
        $object->getProperties()->setTitle("Nilai $jenis Siswa Kelas $kelas Tahun $tahun Semester $semester");

        $object->setActiveSheetIndex(0);
        $object->getActiveSheet()->setCellValue('A1', 'LAPORAN DAFTAR NILAI SISWA ' . $jenis);
        $object->getActiveSheet()->setCellValue('A2', "SMP AL - GHUROBA");
        $object->getActiveSheet()->setCellValue('A3', 'Tahun Ajaran ' . $tahun . ' Semester ' . $semester);
        $object->getActiveSheet()->setCellValue('A4', 'Kelas ' . $kelas);
        $object->getActiveSheet()->setCellValue('A6', 'NO');
        $object->getActiveSheet()->setCellValue('B6', 'NIS');
        $object->getActiveSheet()->setCellValue('C6', 'NIK');
        $object->getActiveSheet()->setCellValue('D6', 'NAMA');

        $style = array(
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            )
        );

        $no_head = 0;
        foreach ($mapel as $key => $value) {
            $object->getActiveSheet()->setCellValue($list_head_cell[$key], $value->nama_mapel);
            $no_head++;
        }

        $object->getActiveSheet()->setCellValue($list_head_cell[$no_head], 'Jumlah');
        $object->getActiveSheet()->setCellValue($list_head_cell[$no_head + 1], 'Rata-Rata');

        $baris = 7;
        foreach ($result as $key => $value) {
            $object->getActiveSheet()->setCellValue('A' . $baris, ++$key);
            $object->getActiveSheet()->setCellValue('B' . $baris, $value['nis']);
            $object->getActiveSheet()->setCellValue('C' . $baris, $value['nik']);
            $object->getActiveSheet()->setCellValue('D' . $baris, $value['nama_siswa']);

            $no_body = 0;
            foreach ($mapel as $mp => $value_mp) {
                $object->getActiveSheet()->setCellValue($list_body_cell[$mp] . $baris, $value[$value_mp->nama_mapel]);
                $no_body++;
            }

            $object->getActiveSheet()->setCellValue($list_body_cell[$no_body] . $baris, $value['jumlah']);
            $object->getActiveSheet()->setCellValue($list_body_cell[$no_body + 1] . $baris, $value['rerata']);
            $object->getActiveSheet()->mergeCells('A1:' . $list_body_cell[$no_body + 1] . '1');
            $object->getActiveSheet()->mergeCells('A2:' . $list_body_cell[$no_body + 1] . '2');
            $object->getActiveSheet()->mergeCells('A3:' . $list_body_cell[$no_body + 1] . '3');
            $object->getActiveSheet()->mergeCells('A4:' . $list_body_cell[$no_body + 1] . '4');
            $object->getActiveSheet()->getStyle('A1:' . $list_body_cell[$no_body + 1] . '1')->applyFromArray($style);
            $object->getActiveSheet()->getStyle('A2:' . $list_body_cell[$no_body + 1] . '2')->applyFromArray($style);
            $object->getActiveSheet()->getStyle('A3:' . $list_body_cell[$no_body + 1] . '3')->applyFromArray($style);
            $object->getActiveSheet()->getStyle('A4:' . $list_body_cell[$no_body + 1] . '4')->applyFromArray($style);


            $object->getActiveSheet()->getStyleByColumnAndRow(3, $baris)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);

            $baris++;
        }

        foreach ($result_min as $key => $value) {
            $object->getActiveSheet()->mergeCells('B' . $baris . ':D' . $baris);
            $object->getActiveSheet()->setCellValue('B' . $baris, 'MIN');

            $no_body = 0;
            foreach ($mapel as $mp => $value_mp) {
                $object->getActiveSheet()->setCellValue($list_body_cell[$mp] . $baris, $value[$value_mp->nama_mapel]);
                $no_body++;
            }

            $object->getActiveSheet()->setCellValue($list_body_cell[$no_body] . $baris, $value['jumlah']);
            $object->getActiveSheet()->setCellValue($list_body_cell[$no_body + 1] . $baris, $value['rerata']);
            $baris++;
        }

        foreach ($result_max as $key => $value) {
            $object->getActiveSheet()->mergeCells('B' . $baris . ':D' . $baris);
            $object->getActiveSheet()->setCellValue('B' . $baris, 'MAX');

            $no_body = 0;
            foreach ($mapel as $mp => $value_mp) {
                $object->getActiveSheet()->setCellValue($list_body_cell[$mp] . $baris, $value[$value_mp->nama_mapel]);
                $no_body++;
            }

            $object->getActiveSheet()->setCellValue($list_body_cell[$no_body] . $baris, $value['jumlah']);
            $object->getActiveSheet()->setCellValue($list_body_cell[$no_body + 1] . $baris, $value['rerata']);
            $baris++;
        }

        foreach ($result_sum as $key => $value) {
            $object->getActiveSheet()->mergeCells('B' . $baris . ':D' . $baris);
            $object->getActiveSheet()->setCellValue('B' . $baris, 'JUMLAH');

            $no_body = 0;
            foreach ($mapel as $mp => $value_mp) {
                $object->getActiveSheet()->setCellValue($list_body_cell[$mp] . $baris, $value[$value_mp->nama_mapel]);
                $no_body++;
            }

            $object->getActiveSheet()->setCellValue($list_body_cell[$no_body] . $baris, $value['jumlah']);
            $object->getActiveSheet()->setCellValue($list_body_cell[$no_body + 1] . $baris, $value['rerata']);
            $baris++;
        }

        foreach ($result_avg as $key => $value) {
            $object->getActiveSheet()->mergeCells('B' . $baris . ':D' . $baris);
            $object->getActiveSheet()->setCellValue('B' . $baris, 'RATA-RATA');

            $no_body = 0;
            foreach ($mapel as $mp => $value_mp) {
                $object->getActiveSheet()->setCellValue($list_body_cell[$mp] . $baris, $value[$value_mp->nama_mapel]);
                $no_body++;
            }

            $object->getActiveSheet()->setCellValue($list_body_cell[$no_body] . $baris, $value['jumlah']);
            $object->getActiveSheet()->setCellValue($list_body_cell[$no_body + 1] . $baris, $value['rerata']);
            $baris++;
        }

        $object->getActiveSheet()->getStyle('A1:' . $list_head_cell[$no_head + 1])->getFont()->setBold(true);
        $object->getActiveSheet()->getColumnDimension('A')->setWidth(4);
        $object->getActiveSheet()->getColumnDimension('B')->setWidth(12);
        $object->getActiveSheet()->getColumnDimension('C')->setWidth(12);
        $object->getActiveSheet()->getColumnDimension('D')->setWidth(35);

        $file_name = "Data_Nilai_{$jenis}_Kelas{$kelas}_Tahun{$tahun}_Semester{$semester}" . '.xlsx';

        $object->getActiveSheet()->setTitle("Kelas $kelas");

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $file_name . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($object);
        $writer->save('php://output');
        exit;
    }
}
