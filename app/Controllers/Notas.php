<?php
namespace App\Controllers;
use App\Models\Nota_model;
require_once APPPATH . 'Libraries/fpdf/fpdf.php';

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

    public function gerarPdf($aluno_id)
    {
        $notaModel = new Nota_model();
        $notas = $notaModel->where('aluno_id', $aluno_id)->findAll();
        $teste = $notaModel->get_all_with_notas($aluno_id);
    
        if (headers_sent()) {
            die("Erro: Cabeçalhos já enviados, impossibilitando a geração do PDF.");
        }
    
        ob_end_clean();
    
        $pdf = new \FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
    
        if (isset($teste['aluno'])) {
            $pdf->SetTitle(utf8_decode("Boletim de " . $teste['aluno']['aluno'] . " (". $teste['aluno']['matricula'] .")"));
            $pdf->Cell(190, 10, utf8_decode("Boletim de " . $teste['aluno']['aluno'] . " (". $teste['aluno']['matricula'] .")"), 0, 1, );
            $pdf->Ln(3);
            $pdf->SetFont('Arial', '', 10);
            
            if($teste['media'] != 0){
                
                foreach ($teste['disciplinas'] as $disciplina) {
                    $pdf->Cell(40, 5, utf8_decode($disciplina['nome'].": "));
                    $pdf->Cell(40, 5, utf8_decode($disciplina['nota']));
                    $pdf->Ln(5);
                }
            }else{
                $pdf->Cell(40, 5, txt: utf8_decode("O aluno não possui notas disponíveis"));
            }


        } else {
            $pdf->SetTitle(utf8_decode("Boletim do Aluno ID: $aluno_id"));
            $pdf->Cell(190, 10, utf8_decode("Aluno não encontrado..."));
        }
    
        $pdf->Output('I', "boletim_aluno_$aluno_id.pdf");
        exit;
    }
    

}
