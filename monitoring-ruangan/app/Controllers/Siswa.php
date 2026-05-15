<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Siswa extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Data Siswa',
            'data_siswa' => $this->SiswaModel->orderBy('nama', 'ASC')->findAll()
        ];

        return view('siswa/index',$data);
    }

    public function cetakMaster()
    {
        
        return view('admin/cetak');
    }

    public function simpanExcel()
		{
			$file_excel = $this->request->getFile('fileexcel');
			$ext = $file_excel->getClientExtension();
			if($ext == 'xls') {
				$render = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
			} else {
				$render = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
			}
			$spreadsheet = $render->load($file_excel);
	
			$data = $spreadsheet->getActiveSheet()->toArray();
			foreach($data as $x => $row) {
				if ($x == 0) {
					continue;
				}
				
				$nis = $row[0];
				$nama = $row[1];
				$alamat = $row[2];
	
				$db = \Config\Database::connect();

				$ceknis = $db->table('siswa')->getWhere(['nis'=>$nis])->getResult();

				if(count($ceknis) > 0) {
					session()->setFlashdata('message','<b style="color:red">Data Gagal di Import nis ada yang sama</b>');
				} else {
	
				$simpandata = [
					'nis' => $nis, 'nama' => $nama, 'alamat'=> $alamat
				];
	
				//$db->table('siswa')->insert($simpandata);
                $this->SiswaModel->insert($simpandata);
				session()->setFlashdata('message','Berhasil import excel'); 
			}
		}
			
			return redirect()->to(base_url('data-siswa'));
		}

	public function export()
    {
        $data = [
            'data_siswa' => $this->SiswaModel->orderBy('nama', 'ASC')->findAll()
        ];

		$spreadsheet = new Spreadsheet();

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'NISN')
            ->setCellValue('B1', 'NAMA')
            ->setCellValue('C1', 'Alamat');

        $column = 2;

        foreach ($data['data_siswa'] as $user) {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $column, $user->nis)
                ->setCellValue('B' . $column, $user->nama)
                ->setCellValue('C' . $column, $user->alamat);

            $column++;
        }

        date_default_timezone_set('Asia/Jakarta');
        $writer = new Xlsx($spreadsheet);
        $filename = date('d-m-Y-His'). '-Master-Data';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $filename . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}
