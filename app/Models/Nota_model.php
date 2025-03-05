<?php
namespace App\Models;

use CodeIgniter\Model;

class Nota_model extends Model
{
    protected $table = 'notas';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'aluno_id', 'disciplina_id', 'nota'];

    public function __construct()
    {
        parent::__construct();
    }
    // Função para obter todas as notas
    public function get_all() {
        return $this->db->get($this->table)->result();
    }

    public function get_id($aluno_id, $disciplina_id)
    {
        $nota = $this->where('aluno_id', $aluno_id)
                    ->where('disciplina_id', $disciplina_id)
                    ->select('id')
                    ->first();

        return $nota? $nota['id'] : null;
    }

    private function slugify($string)
    {
        $map = [
            'á' => 'a', 'à' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a',
            'é' => 'e', 'è' => 'e', 'ê' => 'e', 'ë' => 'e',
            'í' => 'i', 'ì' => 'i', 'î' => 'i', 'ï' => 'i',
            'ó' => 'o', 'ò' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o',
            'ú' => 'u', 'ù' => 'u', 'û' => 'u', 'ü' => 'u',
            'ç' => 'c',
            'ñ' => 'n',
            'Á' => 'A', 'À' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A',
            'É' => 'E', 'È' => 'E', 'Ê' => 'E', 'Ë' => 'E',
            'Í' => 'I', 'Ì' => 'I', 'Î' => 'I', 'Ï' => 'I',
            'Ó' => 'O', 'Ò' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O',
            'Ú' => 'U', 'Ù' => 'U', 'Û' => 'U', 'Ü' => 'U',
            'Ç' => 'C',
            'Ñ' => 'N'
        ];
    
        $string = strtr($string, $map);
        $string = mb_strtolower($string, 'UTF-8');
        $string = preg_replace('/[^a-z0-9]+/', '-', $string);
        $string = trim($string, '-');
    
        return $string;
    }

    public function get_all_with_notas($aluno_id=null)
    {
        $disciplinas = $this->db->query("SELECT id, nome FROM disciplinas")->getResultArray();

        $selectColumns = [
            'a.id AS id',
            'a.nome AS aluno',
            'a.matricula AS matricula'
        ];

        if (!empty($disciplinas)) {
            foreach ($disciplinas as $disciplina) {
                $nomeDisciplina = $disciplina['nome'];
                $alias = $this->slugify($nomeDisciplina);
                $selectColumns[] = "COALESCE(MAX(CASE WHEN d.nome = '$nomeDisciplina' THEN n.nota END), NULL) AS \"$alias\" ";
            }

            $sql = "SELECT " . implode(", ", $selectColumns) . "
                    FROM alunos a
                    LEFT JOIN disciplinas d ON 1=1
                    LEFT JOIN notas n ON n.aluno_id = a.id AND n.disciplina_id = d.id
                    WHERE a.id = $aluno_id GROUP BY a.id, a.nome";
        } else {
            $sql = "SELECT " . implode(", ", $selectColumns) . "
                    FROM alunos a  WHERE a.id = $aluno_id";
        }

        $query = $this->db->query($sql);
        $result = $query->getResultArray();
        
        
        if(empty($result)){
            return ['status'=>404];
        }
        

        $media = 0;
        
        foreach ($disciplinas as &$disciplina) {
            $nomeDisciplina = $this->slugify($disciplina['nome']); 
            $media += $result[0][$nomeDisciplina];
            $disciplina['nota'] = $result[0][$nomeDisciplina] ?? null;
        }

        if($media != 0){
            $media /= count($disciplinas);
        }
        
        return [
            'aluno' => $result[0],
            'disciplinas' => $disciplinas,
            'media' => $media
        ];
    }

    public function get_by_id($id)
    {
        return $this->find($id); 
    }

    public function insert_data($data)
    {
        return $this->insert($data); 
    }

    public function update_data($id, $data)
    {
        return $this->update($id, $data);
    }

    public function delete_data($id)
    {
        return $this->delete($id); 
    }
}
?>
