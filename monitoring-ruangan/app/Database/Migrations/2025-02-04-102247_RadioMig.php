<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RadioMig extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nilai1' => [
                'type'       => 'VARCHAR',
                'constraint' => '1',
            ],
            'nilai2' => [
                'type' => 'VARCHAR',
                'constraint' => '1',
            ],
            'nilai3' => [
                'type' => 'VARCHAR',
                'constraint' => '1',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('nilai');
    }

    public function down()
    {
        $this->forge->dropTable('nilai');
    }
}
