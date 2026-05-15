<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Sensor extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'auto_increment' => true,
                'unsigned'       => false,
            ],
            'suhu' => [
                'type'       => 'VARCHAR',
                'constraint' => '6',
            ],
            'kelembaban' => [
                'type'       => 'VARCHAR',
                'constraint' => '3',
            ],
            'gas' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
            ],
            'co2' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
            ],
            'amonia' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
            ],
            'benzena' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
            ],
            'alkohol' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
            ],
            'asap' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('sensor');
        }
        
        public function down()
        {
        $this->forge->dropTable('kendalirelay');
        }
}

