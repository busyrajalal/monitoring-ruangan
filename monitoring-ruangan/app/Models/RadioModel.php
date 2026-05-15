<?php

namespace App\Models;

use CodeIgniter\Model;

class RadioModel extends Model
{
    protected $table            = 'nilai';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nilai1','nilai2','nilai3'];
}
