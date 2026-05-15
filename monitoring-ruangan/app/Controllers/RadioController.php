<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class RadioController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Penilaian UKK',
            'dataNilai' => $this->RadioModel->findAll()
        ];
        return view('nilai/index',$data);
    }
}
