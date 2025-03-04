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
