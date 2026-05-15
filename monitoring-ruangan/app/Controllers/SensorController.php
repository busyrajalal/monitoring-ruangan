<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\SensorModel;

class SensorController extends BaseController
{
	public function __construct() {
		$this->db = \Config\Database::connect();
		$this->builder = $this->db->table('sensor');

		$this->SensorModel = new SensorModel();
    }

    public function index()
    {
		$data = [
			'title' => 'Sensor Suhu & Kelembaban',
			'dataSensor' => $this->SensorModel->where('id',1)->findAll()
		];
		
		return view('sensor/index', $data);
    }

    public function ceksuhu()
	{
		$data = [
            'dataSuhu' => $this->SensorModel->where('id',1)->findAll()
        ];
		return view('sensor/ceksuhu',$data);		
	}

	public function getSuhu()
	{
		$db = \Config\Database::connect();
		$data = [];
		$query = $db->query("SELECT * FROM sensor WHERE id = 1");

		$row = $query->getRowArray();
		$data[] = $row; //tampilkan seluruh data array, jika menampilkan perkolom $data[] = $row['suhu'];
		
		echo json_encode($data);
	}

	public function cekkelembaban()
	{
		$data = [
            'dataKelembaban' => $this->SensorModel->where('id',1)->findAll()
        ];
		return view('sensor/cekkelembaban',$data);		
	}

	public function update($suhu, $kelembaban, $gas, $co2, $amonia, $benzena, $alkohol, $asap)
	{
		$updateData = [
			'suhu'       => $suhu,
			'kelembaban' => $kelembaban,
			'gas'        => $gas,
			'co2'        => $co2,
			'amonia'     => $amonia,
			'benzena'    => $benzena,
			'alkohol'    => $alkohol,
			'asap'       => $asap,
		];

		$this->builder->where('id', 1);
		$this->builder->update($updateData);
	}
}
