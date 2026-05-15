<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class KendaliController extends BaseController
{
    public function __construct() {
        $this->db = \Config\Database::connect();
        $this->builder = $this->db->table('kendalirelay');
    }

    public function index()
    {
        $data = [
            'title' => "Kendali Relay + NodeMCU v3.0"
        ];
        return view('kontrol/kendali',$data);
    }

    public function ubah()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $db = \Config\Database::connect();
            $query = $db->query("SELECT * FROM kendalirelay WHERE id = $id");
            $relay = $query->getRow()->relay;
            
            if ($relay == 0) {
                $data = [
                    'relay'  => '1',
                ];
                $this->builder->where('id', $id);
                $this->builder->update($data);
                $result = [
                    'success' => 'Relay OFF'
                ];
            } else {
                $data = [
                    'relay'  => '0',
                ];
                $this->builder->where('id', $id);
                $this->builder->update($data);
                $result = [
                    'success' => 'Relay ON'
                ];
            }
            echo json_encode($result);
        } else {
            exit('404 Not Found!');
        }
    }

    public function update_relay($relay)
    {
        $request = \Config\Services::request();
        $path = $request->getPath();


        $segments = explode('/',$path);

        $segments1 = $segments[1];
        
        $updateData = array(
            'relay' => $segments1,
        );

        $this->builder->where('id',1);
        $this->builder->update($updateData);
        return redirect()->to(base_url('kendali'));
    }
}
