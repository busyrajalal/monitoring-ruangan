<?php

namespace App\Models;

use CodeIgniter\Model;

class SensorModel extends Model
{
    protected $table            = 'sensor';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['suhu', 'kelembaban', 'gas', 'co2', 'amonia', 'benzena', 'alkohol', 'asap'];
    public function getSensor()
    {
        return $this->findAll();
    }

}
