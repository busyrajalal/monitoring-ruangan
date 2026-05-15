<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\SensorModel;

class UdaraController extends BaseController
{
    protected $SensorModel;

    public function __construct() {
        $this->SensorModel = new SensorModel();
    }

    public function index()
    {
        $data = [
			'title' => 'Sensor Kualitas Udara',
            'dataSensor' => $this->SensorModel->find(1)
		];
		
		return view('udara/index', $data);
    }
    
    public function cekgas()
	{
		$data = [
            'dataGas' => $this->SensorModel->where('id',1)->findAll()
        ];
		return view('sensor/cekgas',$data);		
	}

    public function cekco2()
    {
        $data = [
            'dataCo2' => $this->SensorModel->where('id', 1)->findAll()
        ];
        return view('udara/cekco2', $data);		
    }

    public function cekamonia()
    {
        $data = [
            'dataAmonia' => $this->SensorModel->where('id', 1)->findAll()
        ];
        return view('udara/cekamonia', $data);		
    }

    public function cekbenzena()
    {
        $data = [
            'dataBenzena' => $this->SensorModel->where('id', 1)->findAll()
        ];
        return view('udara/cekbenzena', $data);		
    }

    public function cekalkohol()
    {
        $data = [
            'dataAlkohol' => $this->SensorModel->where('id', 1)->findAll()
        ];
        return view('udara/cekalkohol', $data);		
    }

    public function cekasap()
    {
        $data = [
            'dataAsap' => $this->SensorModel->where('id', 1)->findAll()
        ];
        return view('udara/cekasap', $data);		
    }

    public function getGas()
	{
		$db = \Config\Database::connect();
		$data = [];
		$query = $db->query("SELECT * FROM sensor WHERE id = 1");

		$row = $query->getRowArray();
		$data[] = $row; //tampilkan seluruh data array, jika menampilkan perkolom $data[] = $row['suhu'];
		
		echo json_encode($data);
	}

    public function getAllData()
    {
        $data = $this->SensorModel->find(1);
        return $this->response->setJSON($data);
    }


}
