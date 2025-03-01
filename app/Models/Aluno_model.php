<?php
namespace App\Models;

use CodeIgniter\Model;

class Aluno_model extends Model
{
    protected $table = 'alunos';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nome']; 

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all()
    {
        return $this->findAll(); 
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
