<?php 
    defined('BASEPATH') OR exit('URL inválida.');


class Model_endereco extends CI_Model
{

    /**
     * Responsável por cadastrar os endereços
     * @param array $fields
     * @return bool
     */
    public function cadastrar(array $fields): bool 
    {

        if ($this->validarDados($fields) && !empty($fields)) {
            $this->db->insert('endereco', $fields);
            return ($this->db->affected_rows() > 0) ? true : false;
        }
        
    }

    /**
     * Responsável por validar a existência o cep na base de dados
     * @param string $cep
     * @return int
     */
    public function validaCep(string $cep): int
    {
        $this->db->select('cep');
        $this->db->from('endereco');
        $this->db->where('cep', $cep);
        return $resultado = $this->db->count_all_results();
    }

    /**
     * Responsável por exibir os endereços
     * @param array $filtros
     * @param int $limit
     * @param int $offset ($inicio)
     * @return array
     */
    public function exibirEndereco(array $filtro = null, $limit = null, $offset = null, int $idendereco = null): array
    {
        $this->db->select('id_endereco, rua, bairro, cidade, estado, cep');
        $this->db->from('endereco');
        $this->db->order_by('id_endereco', 'DESC');

        if (isset($filtro) && !empty($filtro)) {
            if ( isset($filtro['cep']) && !empty($filtro) ) {
                $this->db->where('cep', $filtro['cep']);
            }

            if ( isset($filtro['cidade']) && !empty($filtro) ) {
                $this->db->like('cidade', $filtro['cidade']);
            }

            // Utilizado na consulta do select2 de endereço do view_profile do usuário
            if ( isset($filtro['rua']) && !empty($filtro) ) {
                $this->db->like('rua', $filtro['rua']);
            }
        }

        if (isset($limit) && !empty($limit)) {
            $this->db->limit($limit, $offset);
        }

        if (isset($idendereco)) {
            $this->db->where('id_endereco', $idendereco);
        }

        $query = $this->db->get();
        
        return $query->result_array();
        
    }


    /**
     * Responsável por retornar a quantidade de registros na base de dados para fazer a paginação
     * @param array $filtro
     * @return int
     */
    public function totalRows(array $filtro = null): int 
    {
        $this->db->get('endereco');
        
        if (isset($filtro) && !empty($filtro)) {
            if (isset($filtro['cep']) && !empty($filtro['cep'])){
                $this->db->where('cep', $filtro['cep']);
            }

            if (isset($filtro['cidade']) && !empty($filtro['cidade'])){
                $this->db->like('cidade', $filtro['cidade']);
            }
        }
        return $this->db->count_all_results('endereco');
    }


    /**
     * Responsável por alterar o endereço
     * @param array $fields
     * @param int $id
     * @return bool
     */
    public function alterar(array $fields, int $id): bool 
    {
        if ($this->validarDados($fields) && !empty($fields)) {
            $this->db->where('id_endereco', $id);
            $this->db->update('endereco', $fields);

            return true;
        }
    }


    /**
     * Responsável por validar os dados, evitando dados nulos na base de dados
     * @param array $fields
     * @return bool
     */
    public function validarDados(array $fields): bool 
    {
        foreach($fields as $field) {
            if (isset($field) && empty($field)) {
                return false;
            } 
        }

        return true;
    }


    /**
     * Responsável por deletar o endereço da base de dados
     * @param int $idendereco
     * @return bool
     */
    public function deletar(int $idendereco): bool 
    {
        if (isset($idendereco) && is_int($idendereco)) {
            $this->db->delete('endereco', array('id_endereco' => $idendereco));
            
            return ($this->db->affected_rows() > 0) ? true : false;
        }
    }





    /**
     * @param int $id
     * @return Object | @return bool
     
    public function buscarEndereco(int $id)
    {
        $endereco = $this->db->select('id_endereco, rua, bairro, cidade, estado, cep')
                             ->from('endereco')
                             ->where('id_endereco', $id)
                             ->get();

        if ($endereco->num_rows() > 0) {
            return $endereco->row();
        } else {
            return false;
        }
    }
    */

    /**
     * @param string $searchTerm
     * @return array $endereco
     
    public function consultarEndereco($searchTerm=""): array
    {
        $this->db->select('id_endereco, rua, bairro, cidade, estado, cep');
        $this->db->where("rua LIKE '%".$searchTerm."%' ");
        $fetched_records = $this->db->get('endereco');
        return $endereco = $fetched_records->result_array();
    }
    */
}