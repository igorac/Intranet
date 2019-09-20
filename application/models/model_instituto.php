<?php 
    defined('BASEPATH') OR exit('URL inválida.');


class Model_instituto extends CI_Model
{

    /**
     * Responsável por cadastrar o instituto
     * @param array $dados
     * @return bool
     */
    public function cadastrar(array $dados): bool 
    {
       
        if ($this->validarDados($dados)) {
            $this->db->insert('instituto', $dados);

            return ( $this->db->affected_rows() > 0 ) ? true :  false;
        }
    }

    /**
     * Responsável por validar os dados, evitar dados nulos
     * @param array $dados
     * @return bool
     */
    public function validarDados(array $dados): bool 
    {
        foreach($dados as $dado) {
            if (isset($dado) && empty($dado)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Responsável por exibir os institutos
     * @param int $id
     * @param string $search
     * @return array
     */
    public function exibirInstituto(int $id = null, string $search = null): array
    {
        $this->db->select('i.id_instituto, i.nome_instituto, e.id_endereco, i.telefone, e.rua, e.cidade, e.estado, i.tipo_ensino, i.cnpj');
        $this->db->from('instituto AS i');
        $this->db->join('endereco AS e', 'e.id_endereco = i.id_endereco');
        if (isset($id))
            $this->db->where('i.id_instituto', $id);

        if (isset($search))
            $this->db->like('i.nome_instituto', $search);

        $query = $this->db->get();

        return $query->result_array();
    }
    
    
    /**
     * Responsável por deletar o instituto
     * @param int $id
     * @return bool
     */
    public function deletar(int $id): bool
    {   
        if (isset($id) && is_int($id)) {
            $this->db->delete('instituto', array('id_instituto' => $id));

            return $this->db->affected_rows() > 0 ? true : false;
        }
    }

    /**
     * Responsável por alterar os dados do instituto
     * @param array $dados
     * @param int $id
     * @return bool
     */
    public function alterar(array $dados, int $id): bool
    {   
        
        if ($this->validarDados($dados) && isset($dados)) {
            $this->db->where('ID_INSTITUTO', $id);
            $this->db->update('instituto', $dados);

            //return ($this->db->affected_rows() > 0) ? true : false;
            return true;
            
        }
    }

}
