<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateNotasTable extends Migration
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
            'aluno_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'disciplina_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'nota' => [
                'type' => 'DECIMAL',
                'constraint' => '4,2',
                'null' => false,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('aluno_id', 'alunos', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('disciplina_id', 'disciplinas', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('notas');
    }

    public function down()
    {
        $this->forge->dropTable('notas');
    }
}