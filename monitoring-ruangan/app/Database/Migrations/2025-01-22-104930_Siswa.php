<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Siswa extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'nis' => [
                'type'           => 'VARCHAR',
                'constraint'     => 20,
                'unsigned'       => false,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'alamat' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
        ]);
        $this->forge->addKey('nis', true);
        $this->forge->createTable('siswa');
        }
        
        public function down()
        {
        $this->forge->dropTable('siswa');
        }
}
