<?php 
    defined('BASEPATH') OR exit('URL inválida.');


class Model_mensagem extends CI_Model
{
    /**
     * Responsável por exibir as mensagens
     * @param int $id
     * @param string $emailOrigem
     * @param string $emailDestino
     * @param int $status
     * @param array $filter
     * @param int $is_favorite
     * @return array
     */
    public function exibir(int $id = null, string $emailOrigem = null, string $emailDestino = null, int $status = null, array $filter = null, int $is_favorite = null): array
    {
        $this->db->select('m.ID_MENSAGEM, m.USUARIO_ORIGEM, m.USUARIO_DESTINO, m.TITULO, m.DESCRICAO, m.DATA_ENVIO, m.STATUS, u.ID_USUARIO ,u.NOME, m.IS_FAVORITE, m.IS_READ');
        $this->db->from('MENSAGEM AS m');
        $this->db->join('USUARIO AS u', 'm.USUARIO_DESTINO = u.EMAIL', 'left');

        if (isset($filter)) {
            if (isset($filter['titulo'])) {
                $this->db->like('m.TITULO', $filter['titulo']);
            }

            if (isset($filter['limite'])) {
                $this->db->limit($filter['limite'], $filter['inicio']);
            }
        }

        if (isset($id) && is_int($id)) {
            $this->db->where('m.ID_MENSAGEM', $id);
        }

        if (isset($emailOrigem) && !isset($emailDestino)) {
            $this->db->where('m.USUARIO_ORIGEM', $emailOrigem);
        }
        
        if (isset($emailDestino) && !isset($emailOrigem)) {
            $this->db->where('m.USUARIO_DESTINO', $emailDestino);
        }

        if (isset($status)) {
            $this->db->where('m.STATUS', $status);
        }

        if (isset($emailDestino) && isset($emailOrigem)) {
            $this->db->group_start();    
                $this->db->where('m.USUARIO_DESTINO', $emailDestino);
                $this->db->or_where('m.USUARIO_ORIGEM', $emailOrigem);
            $this->db->group_end();
        }
        
        if (isset($is_favorite) && $is_favorite !== 0) {
            $this->db->where('m.IS_FAVORITE', $is_favorite);
        }
        
        $this->db->order_by('DATA_ENVIO', 'DESC');
        
        return $query = $this->db->get()->result_array();
    }


    /**
     * Responsável por pegar a quantidade de mensagens, para fazer a paginação
     * @param string $search
     * @param string $emailOrigem
     * @param string $emailDestino
     * @param int $status
     * @param int $is_favorite
     * @return int
     */
    public function getQtdMensagem(string $search = null, string $emailOrigem = null, string $emailDestino = null, int $status = null, int $is_favorite = null): int
    {
        $this->db->select('count(*) AS total');
        if (isset($search) && !empty($search))
            $this->db->like('TITULO', $search);

        if (isset($emailOrigem) && !isset($emailDestino)) {
            $this->db->where('USUARIO_ORIGEM', $emailOrigem);
        }

        if (isset($emailDestino) && !isset($emailOrigem)) {
            $this->db->where('USUARIO_DESTINO', $emailDestino);
        }

        if (isset($emailDestino) && isset($emailOrigem)) {
            $this->db->group_start();
                $this->db->where('USUARIO_DESTINO', $emailDestino);
                $this->db->or_where('USUARIO_ORIGEM', $emailOrigem);
            $this->db->group_end();
        }

        if (isset($status))
            $this->db->where('STATUS', $status);

        if (isset($is_favorite) && $is_favorite !== 0)
            $this->db->where('IS_FAVORITE', $is_favorite);

        return $this->db->count_all_results('MENSAGEM');
    }
    

    /**
     * Responsável por enviar mensagem para o usuário
     * @param array $dados
     * @return bool
     */
    public function enviarMensagem(array $dados): bool
    {   
        
        foreach($dados as $dado) {
            $this->db->insert('mensagem', $dado);
        }

        return $this->db->affected_rows() > 0 ? true : false;
    }


    /**
     * Responsável por alterar o status da mensagem
     * @param array $ids
     * @param int $status
     * @return bool
     */
    public function alterarStatusMensagem(array $ids, int $status): bool
    {     
        foreach($ids as $id) {
            $this->db->where('ID_MENSAGEM', $id);
            $this->db->update('MENSAGEM', array('STATUS' => $status));
        }
        
        return ($this->db->affected_rows() > 0) ? true : false;
    }
    

    /**
     * Responsável por deletar as mensagens
     * @param array $ids
     * @return bool
     */
    public function deletarMensagem(array $ids): bool
    { 
        foreach($ids as $id) {
            $this->db->where('ID_MENSAGEM', $id);
            $this->db->delete('MENSAGEM');
        }

        return $this->db->affected_rows() > 0 ? true : false;
    }


    /**
     * Responsável por validar o id das mensagens, em casos de várias mensagens é utilizado o array, no caso de uma única mensagem utiliza-se o $id
     * @param array $ids
     * @param int $id
     */
    public function validarIdMensagem(array $ids = null, int $id = null) 
    {   
        
        if (isset($ids) && is_array($ids)) {

            foreach ($ids as $id) {
                $this->db->select('ID_MENSAGEM, TITULO');
                $this->db->from('MENSAGEM');
                $this->db->where('ID_MENSAGEM', $id);
                $query = $this->db->get();
                
                $valid = ( $query->num_rows() !==0 ) ? true : false;
               
                if ($valid === false) {
                    break;
                } else {
                    continue;
                }
               
            }

            return $valid;
            
        } else {

            $this->db->select('ID_MENSAGEM, TITULO');
            $this->db->from('MENSAGEM');
            $this->db->where('ID_MENSAGEM', $id);
            $query = $this->db->get();
            
            return ( $query->num_rows() !==0 ) ? true : false;
        }
    }

    /**
     * Responsável por favoritar ou desfavoritar as mensagens
     * @param array $dados
     * @return bool
     */
    public function favoritar_desfavoritar(array $dados): bool
    {
       
        if (isset($dados) && !empty($dados) && is_int($dados['ID_MENSAGEM'])) {
           
            $this->db->where('ID_MENSAGEM', $dados['ID_MENSAGEM']);
            $this->db->update('MENSAGEM', array('IS_FAVORITE' => $dados['IS_FAVORITE']));

            return ($this->db->affected_rows() > 0 ) ? true : false;
        }
    }


    /**
     * Responsável por marcar como lido ou não lido as mensagens
     * @param array $dados
     * @return bool
     */
    public function marcar_lido_naoLido(array $dados): bool
    {   
        if (isset($dados) && is_array($dados)) {
            foreach ($dados['id_mensagem'] as $id_mensagem) {
                $this->db->where('ID_MENSAGEM', $id_mensagem);
                $this->db->update( 'MENSAGEM', array('IS_READ' => $dados['is_read']) );
            }
            
            return ($this->db->affected_rows() > 0) ? true : false;
        }
    }

    
}
