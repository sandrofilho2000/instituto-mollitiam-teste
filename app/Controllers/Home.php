<?php

namespace App\Controllers;

use App\Models\Aluno_model;

class Home extends BaseController
{
    public function index()
    {
        // Carregar o modelo
        $alunoModel = new Aluno_model();
        
        // Obter todos os alunos
        $data['alunos'] = $alunoModel->get_all();

        // Passar os dados para a view
        echo view('templates/header'); // Inclui o cabeçalho
        echo view('home', $data); // Inclui o conteúdo da página, passando os dados
        echo view('templates/scripts'); // Inclui os scripts
        echo view('templates/footer'); // Inclui o rodapé
    }
}
