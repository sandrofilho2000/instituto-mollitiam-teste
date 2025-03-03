<?php

namespace App\Controllers;

use App\Models\Disciplina_model;

class Disciplinas extends BaseController
{
    public function index()
    {

        $disciplinaModel = new Disciplina_model();
        $data['disciplinas'] = $disciplinaModel->get_all();
        
        echo view('templates/header'); 
        echo view('disciplinas', $data); 
        echo view('templates/scripts');
        echo view('templates/footer'); 
    }
    
    public function getDisciplinas()
    {
        $disciplinaModel = new Disciplina_model();
        $disciplinas = $disciplinaModel->findAll();
    
        // Retorna JSON corretamente
        return $this->response
                    ->setStatusCode(200)
                    ->setContentType('application/json')
                    ->setJSON($disciplinas);
    }
    public function addDisciplina()
    {

        $nome = $this->request->getVar('nome');   
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nome' => [
                'label' => 'Nome',
                'rules' => 'required|min_length[3]|max_length[100]|regex_match[/^[\p{L} ]+$/u]', 
                'errors' => [
                    'required' => 'O campo Disciplina é obrigatório.',
                    'min_length' => 'A Disciplina deve ter pelo menos 3 caracteres.',
                    'max_length' => 'A Disciplina deve ter no máximo 100 caracteres.',
                    'alpha_space' => 'A Disciplina deve conter apenas letras e espaços.',
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
        


        $disciplinaModel = new Disciplina_model();

        $new_disciplina = ['nome' => $nome];
        $disciplinaModel->insert_data($new_disciplina);

        return $this->response
                    ->setStatusCode(200)
                    ->setContentType('application/json')
                    ->setJSON(['nome' => $nome]);
    }
    public function deleteDisciplina($id = null)
    {
        if (!$id) {
            return $this->response
                        ->setStatusCode(400)
                        ->setContentType('application/json')
                        ->setJSON(['error' => 'ID da disciplina é obrigatório']);
        }
    
        $disciplinaModel = new Disciplina_model();
        if ($disciplinaModel->delete($id)) {
            return $this->response
                        ->setStatusCode(200)
                        ->setContentType('application/json')
                        ->setJSON(['message' => 'Disciplina deletado com sucesso!']);
        }
    
        return $this->response
                    ->setStatusCode(500)
                    ->setContentType('application/json')
                    ->setJSON(['error' => 'Erro ao deletar disciplinas']);
    }
}
