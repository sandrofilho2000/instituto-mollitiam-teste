<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nota_model extends CI_Model {

    // Nome da tabela
    protected $table = 'notas';

    public function __construct() {
        parent::__construct();
    }

    // Função para obter todas as notas
    public function get_all() {
        return $this->db->get($this->table)->result();
    }

    // Função para obter notas de um aluno específico
    public function get_by_aluno($aluno_id) {
        return $this->db->get_where($this->table, ['aluno_id' => $aluno_id])->result();
    }

    // Função para inserir uma nova nota
    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    // Função para atualizar dados de uma nota
    public function update($id, $data) {
        return $this->db->update($this->table, $data, ['id' => $id]);
    }

    // Função para excluir uma nota
    public function delete($id) {
        return $this->db->delete($this->table, ['id' => $id]);
    }
}
?>
