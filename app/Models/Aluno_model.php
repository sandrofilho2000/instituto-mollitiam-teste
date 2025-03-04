<?php
namespace App\Models;

use CodeIgniter\Model;

class Aluno_model extends Model
{
    protected $table = 'alunos';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'matricula', 'nome'];

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all()
    {
        return $this->findAll(); 
    }
    private function slugify($string)
    {
        // Tabela de substituição de caracteres acentuados
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
    
        // Substitui os caracteres acentuados
        $string = strtr($string, $map);
    
        // Converte para minúsculas
        $string = mb_strtolower($string, 'UTF-8');
    
        // Substitui espaços e caracteres não alfanuméricos por hífens
        $string = preg_replace('/[^a-z0-9]+/', '-', $string);
    
        // Remove hífens no início e no final
        $string = trim($string, '-');
    
        return $string;
    }

    public function get_all_custom()
    {
        // Consulta para obter as disciplinas
        $disciplinas = $this->db->query("SELECT id, nome FROM disciplinas")->getResultArray();

        // Iniciar a construção da query SQL
        $selectColumns = [
            'a.id AS id',
            'a.nome AS aluno',
            'a.matricula AS matricula'
        ];

        // Verifica se há disciplinas
        if (!empty($disciplinas)) {
            // Adicionar colunas dinâmicas para cada disciplina
            foreach ($disciplinas as $disciplina) {
                $nomeDisciplina = $disciplina['nome'];
                $alias = $this->slugify($nomeDisciplina);
                $selectColumns[] = "COALESCE(MAX(CASE WHEN d.nome = '$nomeDisciplina' THEN n.nota END), NULL) AS \"$alias\"";
            }

            // Montar a query SQL com LEFT JOIN
            $sql = "SELECT " . implode(", ", $selectColumns) . "
                    FROM alunos a
                    LEFT JOIN disciplinas d ON 1=1
                    LEFT JOIN notas n ON n.aluno_id = a.id AND n.disciplina_id = d.id
                    GROUP BY a.id, a.nome;";
        } else {
            $sql = "SELECT " . implode(", ", $selectColumns) . "
                    FROM alunos a;";
        }

        // Executar a query
        $query = $this->db->query($sql);
        $result = $query->getResultArray();

        if (!empty($disciplinas)) {
            foreach ($result as &$row) {
                foreach ($disciplinas as &$disciplina) {
                    $alias = $this->slugify($disciplina['nome']);
                    $disciplina['alias'] = $alias;
                    $row[$alias] = $row[$alias] === NULL ? '-' : $row[$alias];
                }
            }
        }

        return [
            'alunos' => $result,
            'disciplinas' => $disciplinas
        ];
    }
    
    
    

    public function get_latest_aluno()
    {
        return $this->orderBy('id', 'DESC')->first();
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
