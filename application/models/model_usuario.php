<?php 
    defined('BASEPATH') OR exit('URL inválida.');


class Model_usuario extends CI_Model
{

    /**
     * Realiza um cadastro do usuário na base de dados.
     * @param array $dados
     * @return bool
     */
    public function cadastrar(array $dados): bool
    {
        
        if ($this->validarDados($dados) && !empty(is_array($dados))) {
            $this->db->insert('usuario', $dados);
            return ($this->db->affected_rows() > 0) ? true : false;
        }    
    }   

    /**
     * Valida os dados, evitando dados nulos na base de dados. 
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
        
        if (strlen($dados['senha']) < 3) {
            return false;
        }

        return true;
    }


    /**
     * Valida o login, para verificar a existência dele na base de dados.
     * @param string $login
     * @return array
     */
    public function validarLogin(string $login)
    {
        $query = $this->db->select('id_usuario, nome, login, email, senha')
                          ->from('usuario')
                          ->where('login', $login)
                          ->get();
    
        return $query->result();                          
    }

    
    /**
     * Retorna uma consulta da dados com os dados do usuário de acordo com o ID_USUARIO
     * @param int $idusuario
     * @return array | @return bool
     */
    public function profile(int $idusuario)
    {
        if (isset($idusuario) && is_int($idusuario)) {
            $this->db->select('u.ID_USUARIO, u.ID_ENDERECO, u.ID_PERFIL, u.ID_INSTITUTO, i.NOME_INSTITUTO, e.RUA, e.CIDADE, e.ESTADO, p.PERFIL, u.NOME, u.IMAGEM, u.NACIONALIDADE, u.HABILIDADE, u.DATA_CADASTRO');
            $this->db->from('USUARIO AS u');
            $this->db->join('ENDERECO as e', 'e.ID_ENDERECO = u.ID_ENDERECO', 'LEFT');
            $this->db->join('PERFIL as p', 'p.ID_PERFIL = u.ID_PERFIL', 'LEFT');
            $this->db->join('INSTITUTO as i', 'i.ID_INSTITUTO = u.ID_INSTITUTO', 'LEFT');
            $this->db->where('u.ID_USUARIO', $idusuario);
            $profile = $this->db->get();

            if ($profile->num_rows() > 0) {
                return $profile->row(); 
            } else {
               return false;
            }
        }
    } 
    

    /**
     * Realiza uma alteração no perfil do usuário
     * @param array $dados
     * @param int $id
     * @return bool
     */
    public function alterarProfile(array $dados = null, int $id): bool
    {
        if (isset($dados) && is_int($id)) {
            $this->db->where('id_usuario', $id);
            $this->db->update('usuario', $dados);
        
            return true;
        } else {
            return false;
        }
    }

    /**
     * Realiza uma alteração na imagem de perfil do usuário
     * @param array $dados
     * @param int $idusuario
     * @return bool
     */
    public function alterarImagem(array $dados, int $idusuario): bool
    {
        
        if (isset($dados) && is_int($idusuario)) {
            $this->db->where('id_usuario', $idusuario);
            $this->db->update('usuario', $dados);

            return true;
        } else {
            return false;
        }
        
    }

    /**
     * Realiza uma consulta na base de dados, retornando os usuários
     * @param int $inicio
     * @param int $limite
     * @param string $nome
     * @param string $email
     * @param int $idusuario
     * @return array
     */
    public function buscarUsuario(int $inicio = null,  int $limite = null,  string $nome = "",  string $email = null, int $idusuario = null): array
    {
      
        $this->db->select('NOME, IMAGEM, ID_USUARIO, EMAIL');
        $this->db->from('USUARIO');
        $this->db->like('NOME', $nome);

        if (isset($idusuario)) {
            $this->db->where('ID_USUARIO', $idusuario);
        }
        
        if (isset($email)) {
            $this->db->where('EMAIL !=', $email);
        }

        if (isset($limite) && !empty($limite))
            $this->db->limit($limite, $inicio);

        $query = $this->db->get();

        return $query->result_array();
    }

    /**
     * Retorna a quantidade de usuários, para utilizar na paginação
     * @param string $nome
     * @param string email
     * @return int
     */
    public function qtdUsuario(string $nome = "", string $email = null): int
    {
        $this->db->like('nome', $nome);
        $this->db->from('USUARIO');

        if (isset($email)) {
            $this->db->where('EMAIL !=', $email);
        }

        return $this->db->count_all_results();
    }


    /**
     * Valida o email do usuário, para verifica a existência dele no banco de dados
     * @param array $emails
     * @return array | @return bool
     */
    public function validarEmail(array $emails)
    {

        $this->db->select('email');
        $this->db->from('usuario');
       
        $this->db->where_in('EMAIL', $emails);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }

    }


    /**
     * Retorna uma consulta da tabela HABILIDADE
     * @return array
     */
    public function exibirHabilidades(): array
    {
        return $this->db->get('HABILIDADE')->result_array();
    }


    /**
     * Realiza um cadastro de habilidades, caso não tenha na base de dados uma habilidade que o usuário queira
     * @param array $dados
     * @return bool
     */
    public function cadastrarHabilidade(array $dados): bool
    {
        
        $this->db->insert('HABILIDADE', $dados);
        return $this->db->affected_rows() > 0 ? true : false;
    }

    /**
     * Realiza uma consulta na base de dados de acordo com o email do usuário
     * @param string $email
     * @return array
     */
    public function consultarPorEmail(string $email): array
    {
        $this->db->select('ID_USUARIO, EMAIL, IMAGEM');
        $this->db->from('USUARIO');
        $this->db->like('EMAIL', $email);
        return $query = $this->db->get()->result_array();
    }


    /**
     * Realiza uma alteração na senha do usuário
     * @param string $senha
     * @param int $id
     * @return bool
     */
    public function alterarSenha(string $senha, int $id): bool
    {
        if (isset($senha) && isset($id) && is_int($id)) {
            $this->db->where('ID_USUARIO', $id);
            $this->db->update('USUARIO', array('SENHA' => $senha));

            return $this->db->affected_rows() > 0 ? true : false;
        }
        
    }


    /**
     * Realiza uma validação na senha, para verificar se a senha digitada está de acordo com o email e se ambos existem na base de dados.
     * @param string $email
     * @return array
     */
    public function validarSenha(string $email): array
    {
        $query = $this->db->select('id_usuario, nome, login, email, senha')
                          ->from('usuario')
                          ->where('email', $email)
                          ->get();

        return $query->result();    
    }


    /**
     * Realiza uma alteração no email do usuário
     * @param string $email
     * @param int $id
     * @return bool
     */
    public function alterarEmail(string $email, int $id): bool
    {
        if (isset($email) && is_int($id)) {
            $this->db->where('ID_USUARIO', $id);
            
            $this->db->update('USUARIO', array('EMAIL' => $email));

            return $this->db->affected_rows() > 0 ? true : false;
        }
    }
}
