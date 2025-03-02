<?php

namespace App\Controllers;

use App\Models\Aluno_model;

class Home extends BaseController
{
    public function index()
    {

        $alunoModel = new Aluno_model();
        $data['alunos'] = $alunoModel->get_all();
        
        echo view('templates/header'); 
        echo view('home', $data); 
        echo view('templates/scripts');
        echo view('templates/footer'); 
    }
    
    public function getAlunos()
    {
        $alunoModel = new Aluno_model();
        $alunos = $alunoModel->findAll();
    
        // Retorna JSON corretamente
        return $this->response
                    ->setStatusCode(200)
                    ->setContentType('application/json')
                    ->setJSON($alunos);
    }
}
