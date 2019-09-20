<?php 
    defined('BASEPATH') OR exit('URL inválida.');

class Perfil extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('America/Sao_Paulo');
        $this->load->model('model_perfil');
    }

    
    /* Cadastra perfil
    */
    public function cadastrar()
    {
        if ($this->session->has_userdata('logged_in')) {

            $dados = [
                'perfil' => $this->input->post('perfil'),
                'data_cadastro' => date('Y-m-d H:i:s'),
                'status' => 1
            ];

            $this->form_validation->set_error_delimiters('', '');


            if ($this->form_validation->run('perfil/cadastro')) {

                $data['sucesso'] = false;

                if ($this->model_perfil->cadastrar($dados)) {
                    $data['sucesso'] = true;
                    $data['tipo'] = 'adicionar';
                }

            } else {
                $data['errors'] = $this->form_validation->error_array();
            }
           
            echo json_encode($data);

        } else {
            redirect('auth/login', 'refresh');
        }

        //$this->load->view('view_home', isset($dados)? $dados : '');
    }


    /* Altera perfil
    */
    public function alterar()
    {
        if ($this->session->has_userdata('logged_in')) {

            $this->form_validation->set_error_delimiters('<p class="red">', '</p>'); // Seta delimitadores

            if ($this->form_validation->run('perfil/altera')) {

                $id_perfil = (int) $this->input->post('id_perfil');
                $dados = [
                    'perfil' => $this->input->post('perfil'),
                    'id_perfil' => $id_perfil,
                    'data_modificacao' => date('Y-m-d H:i:s')
                ];
                
                $data['sucesso'] = FALSE;

                if ($this->model_perfil->alterar($dados)) {
                    $data['tipo'] = 'update';
                    $data['sucesso'] = TRUE;
                } 

            } else {
                $data['errors'] = $this->form_validation->error_array();
            }

            echo json_encode($data);

        } else {
            redirect('auth/login', 'refresh');
        }

        // $this->load->view('view_home', isset($dados)? $dados : '');
    }


    /* Valida o ID_PERFIL
    */
    public function validar_idperfil()
    {
        $id_perfil = (int) $this->input->post('id_perfil');
        $resultado = $this->model_perfil->buscarPerfil(null, null, null, $id_perfil);

        if (!empty($resultado)) {
            return true;
        } else {   
            return false;
        }
    }    


    /**
     * Deleta perfil
     */
    public function deletar()
    {
        if ($this->session->has_userdata('logged_in')) {
           
            $data['sucesso'] = false;

            if (!empty($this->input->post('id_perfil')))  {
                $id_perfil = (int) $this->input->post('id_perfil');

                
                $this->form_validation->set_error_delimiters('', '');
              
                if ($this->form_validation->run('perfil/deletar')) {
                    
                    if ( $this->model_perfil->deletar($id_perfil) ) {
                        $data['sucesso'] = true;
                    }

                } else {
                    $data['errors'] = $this->form_validation->error_array();
                }                
            }

            echo json_encode($data);

        } else {
            redirect('auth/login');
        }
    }


    /**
     * @param int $inicio
     * 
     * Responsável por listar os dados, paginar, realizar consulta dinâmica via ajax.
     * Responsável por renderizar a view de listar 
     */
    public function listar($inicio = 0)
    {
        /* Verifica se possui uma sessão ativa.
        *  CASO TRUE -> Verifica se não é uma requisição post.
            # CASO TRUE -> Renderiza a view listar
            # CASO FALSE -> Recebe o valor do search e o valor do per_page(limit) e 
              realiza as devidas configurações de paginação e cria os links
        *  CASO FALSE -> Redireciona para a tela de login
        */
        if ($this->session->has_userdata('logged_in')) {

            if (!$this->input->post()) {

                /* Responsável por retornar os dados do usuário da sessão */
                $this->load->model('model_usuario');
                $id_usuario = filter_var($this->session->userdata('logged_in')['id_usuario'], FILTER_VALIDATE_INT);
                $dados['profile'] = $this->model_usuario->profile($id_usuario);

                $dados['tela'] = 'perfil/view_listar';
                $dados['ativa'] = 'perfil';
                $this->load->view('view_home', $dados);
                
            } else {
                $search = $this->input->post('search');
                $per_page = (int) $this->input->post('per_page');
    
                if ($per_page === 0) {
                    $per_page = 2;
                }
                
                
                $config = [
                    'base_url' => base_url().'index.php/perfil/listar',
                    'per_page' => $per_page,
                    'total_rows' => $this->model_perfil->getQtdPerfil($search)
                ];
                
                if ($inicio != 0) {
                    $inicio = ($inicio - 1) * $config['per_page'];
                } else {
                    $inicio = 0;
                }
    
                $perfils = $this->model_perfil->buscarPerfil($inicio, $config['per_page'], $search);
                
                $this->pagination->initialize($config);
    
                if (is_array($perfils) && empty($perfils)) {
                    $dados['mensagem'] = 'Não existe(m) perfil na base de dados com esse(s) filtro(s).';
                }
    
                $dados['perfils'] = $perfils;
                $dados['pagination'] = $this->pagination->create_links();
            
                echo json_encode($dados);
               
            }

        } else {
            redirect('auth/login');
        }
    }


    /* Consulta todos os perfis, utilizado no select de perfis da view profile do usuário
    */
    public function consultarTodos()
    {
        $searchTerm = $this->input->post('searchTerm');

        if ($this->session->has_userdata('logged_in')) {
            $perfis = $this->model_perfil->buscarPerfil(null, null, $searchTerm);
            echo json_encode($perfis);
        } else {
            redirect('auth/login');
        }
        
    }


    /* Consulta o perfil de acordo com o ID_PERFIL
    */
    public function buscarPorId()
    {
        if ($this->session->has_userdata('logged_in')) {
            $id_perfil = (int) $this->input->post('id');
            $result = $this->model_perfil->buscarPerfil(null, null, null, $id_perfil);
            echo json_encode($result);
        } else {
            redirect('auth/login');
        }
    }

    



}
