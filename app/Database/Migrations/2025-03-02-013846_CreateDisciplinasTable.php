<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDisciplinasTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nome' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('disciplinas');
    }

    public function down()
    {
        $this->forge->dropTable('disciplinas');
    }
}