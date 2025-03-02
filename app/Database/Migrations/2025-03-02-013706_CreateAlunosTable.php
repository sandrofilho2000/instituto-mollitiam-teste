<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAlunosTable extends Migration
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
            'matricula' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => false,
                'unique' => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('alunos');
    }

    public function down()
    {
        $this->forge->dropTable('alunos');
    }
}