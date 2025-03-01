<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Disciplina_model extends CI_Model {

    // Nome da tabela
    protected $table = 'disciplinas';

    public function __construct() {
        parent::__construct();
    }

    // Função para obter todas as disciplinas
    public function get_all() {
        return $this->db->get($this->table)->result();
    }

    // Função para obter uma disciplina pelo ID
    public function get_by_id($id) {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    // Função para inserir uma nova disciplina
    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    // Função para atualizar dados de uma disciplina
    public function update($id, $data) {
        return $this->db->update($this->table, $data, ['id' => $id]);
    }

    // Função para excluir uma disciplina
    public function delete($id) {
        return $this->db->delete($this->table, ['id' => $id]);
    }
}
?>
