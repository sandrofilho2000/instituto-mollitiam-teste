<?php
namespace App\Controllers;
use App\Models\Nota_model;

class Notas extends BaseController{
    public function handleNota()
    {
        $notaModel = new Nota_model();

        $nota = $this->request->getVar('nota');   
        $aluno_id = $this->request->getVar('aluno_id');   
        $disciplina_id = $this->request->getVar('disciplina_id');   
        $new_nota = ['aluno_id'=>$aluno_id,'disciplina_id'=> $disciplina_id, 'nota'=>$nota];
        $nota_id = $notaModel->get_id($aluno_id, $disciplina_id);

        
        if($nota_id){
            $notaModel->update_data($nota_id, $new_nota);
        }else{
            $notaModel->insert_data($new_nota);
        }
        
        return $this->response
                    ->setStatusCode(200)
                    ->setContentType('application/json')
                    ->setJSON(['nota' => $nota]);
    }

}
