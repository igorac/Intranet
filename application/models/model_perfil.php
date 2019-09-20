<?php 
    defined('BASEPATH') OR exit('URL inválida.');


class Model_perfil extends CI_Model
{

    /**
     * Realiza um cadastro de perfil
     * @param array $dados
     * @return bool
     */
    public function cadastrar(array $dados): bool 
    {
        if ($this->validarDados($dados) && !empty(is_array($dados))) {
            $this->db->insert('perfil', $dados);

            return ($this->db->affected_rows() > 0) ? true : false;
        }    
    }   


    /**
     * Realiza uma validação no dados, evitando dados nulos na base de dados.
     * @param array $dados
     * @return bool
     */
    public function validarDados(array $dados): bool
    {
        foreach ($dados as $dado) {
            if (isset($dado) && empty($dado)) {
                return false;
            }
        }
        return true;
    }


    /**
     * Realiza uma busca na base de dados dos perfis, utilizado na paginação
     * @param int $inicio
     * @param int $per_page
     * @param string $search
     * @param int $idperfil
     * @return array
     */
    public function buscarPerfil(int $inicio = null, int $limite = null, string $search = null, int $idperfil = null): array
    {
        $this->db->select('id_perfil, perfil, data_cadastro');
        $this->db->from('perfil');
        $this->db->order_by('data_cadastro', 'desc');
        if (isset($search) && !empty($search))
            $this->db->like('perfil', $search);
        if (isset($limite) && !empty($limite))
            $this->db->limit($limite, $inicio);

        if (isset($idperfil) && is_int($idperfil))
            $this->db->where('id_perfil', $idperfil);

        return  $this->db->get()->result();
    }
   
    /**
     * Retorna uma quantidade de perfis da base de dados, para utilizar na paginação
     * @param string $perfil
     * @return int
     */
    public function getQtdPerfil(string $perfil = null): int
    {
        $this->db->select('count(*) AS total');
        if (isset($perfil) && !empty($perfil))
            $this->db->like('perfil', $perfil);
        return $this->db->count_all_results('perfil');
    }
  

    /**
     * Realiza uma alteração no perfil
     * @param array $dados
     * @return bool
     */
    public function alterar(array $dados): bool
    {
        if ($this->validarDados($dados) && !empty($dados) && is_array($dados)) {
            $query = $this->db->where('id_perfil', $dados['id_perfil'])
                              ->update('perfil', $dados);
            return true;
       } else {
           return false;
       }
    }


    /**
     * Deleta o perfil da base de dados
     * @param int $idperfil
     * @return bool
     */
    public function deletar(int $idperfil): bool 
    {
        if (!empty($idperfil) && is_int($idperfil)) {
            $this->db->delete('perfil', array('id_perfil' => $idperfil));
            
            return ($this->db->affected_rows() > 0) ? true : false;
        }
    }

    


    


     /**
     * Realiza uma busca de perfis na base de dados, utilizado 
     * @param string $searchTerm
     * @return array $perfis
     
    public function consultarPerfil($searchTerm=""): array
    {
        $this->db->select('id_perfil, perfil');
        $this->db->where("perfil LIKE '%".$searchTerm."%' ");
        $fetched_records = $this->db->get('PERFIL');
        return $perfis = $fetched_records->result_array();
    }
    */

      /**
     * Realiza uma consulta na base de dados dos perfil de acordo com o ID_PERFIL
     * @param int $idperfil
     * @return array | @return bool
     
    public function consultarPerfilPorId(int $idperfil)
    {
        $perfil = $this->db->select('id_perfil, perfil')
                           ->from('perfil')
                           ->where('id_perfil', $idperfil)
                           ->get();

        if ($perfil->num_rows() > 0) {
            return $perfil->row(); // Retorna o primeiro elemento
        } else {
            return false;
        }
    }
    */
    
}
