<?php

namespace App\Controllers;

use App\Models\Aluno_model;

class Alunos extends BaseController
{
    public function index()
    {

        $alunoModel = new Aluno_model();
        $data['alunos'] = $alunoModel->get_all();
        
        echo view('templates/header'); 
        echo view('alunos', $data); 
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
    public function addAluno()
    {

        $nome = $this->request->getVar('nome');   
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nome' => [
                'label' => 'Nome',
                'rules' => 'required|min_length[3]|max_length[100]|alpha_space', // Regras de validação
                'errors' => [
                    'required' => 'O campo Nome é obrigatório.',
                    'min_length' => 'O Nome deve ter pelo menos 3 caracteres.',
                    'max_length' => 'O Nome deve ter no máximo 100 caracteres.',
                    'alpha_space' => 'O Nome deve conter apenas letras e espaços.',
                ]
            ]
        ]);

        if (!$validation->run(['nome' => $nome])) {
            return $this->response
                        ->setStatusCode(400)
                        ->setContentType('application/json')
                        ->setJSON([
                            'errors' => $validation->getErrors()
                        ]);
        }
        
        $alunoModel = new Aluno_model();
        $aluno = $alunoModel->get_latest_aluno();
        $max_id = $aluno ? $aluno['id'] : null;
        $max_id += 1;

        $matricula = "MATR" . str_pad($max_id, 3, '0', STR_PAD_LEFT);

        $new_aluno = ['matricula' => $matricula, 'nome' => $nome];
        $alunoModel->insert_data($new_aluno);

        return $this->response
                    ->setStatusCode(200)
                    ->setContentType('application/json')
                    ->setJSON(['maxId' => $max_id, 'matricula' => $matricula, 'nome' => $nome]);
    }
}
