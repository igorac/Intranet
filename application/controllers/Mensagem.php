<?php 
    defined('BASEPATH') OR exit('URL inválida.');

class Mensagem extends CI_Controller
{
    public function __construct() 
    {
        parent::__construct();
        date_default_timezone_set('America/Sao_Paulo');
        $this->load->model('model_mensagem');
        $this->load->model('model_usuario');
    }

    
    // Responsável por trazer os dados do perfil do usuário logado
    private function recoverProfileUser()
    {
        $id = (int) $this->session->userdata('logged_in')['id_usuario'];
        return $this->model_usuario->profile($id);
    }

    // Responsável por enviar mensagem 
    public function enviarMensagem()
    {
        if ($this->session->has_userdata('logged_in')) {
            if ($this->input->post()) {

               
                $email_destino = is_array($this->input->post('usuario_destino')) ? explode(",",  $this->input->post("usuario_destino")[0]) : null;

                $dados_multiple = array();

                if (isset($email_destino) && is_array($email_destino)) {

                    foreach($email_destino as $email) {
                       
                        $dados = [
                            'USUARIO_ORIGEM'  => filter_var($this->session->userdata('logged_in')['email'], FILTER_VALIDATE_EMAIL),
                            'USUARIO_DESTINO' => filter_var($email, FILTER_VALIDATE_EMAIL),
                            'TITULO'          => $this->input->post('titulo'),
                            'DESCRICAO'       => $this->input->post('editor1'),
                            'DATA_ENVIO'      => date('Y-m-d H:i:s')
                        ];
    
                        array_push($dados_multiple, $dados);
    
                    }

                } 

                $this->form_validation->set_error_delimiters('<p class="red">', '</p>'); // Alterando o delimitador

                if ($this->form_validation->run('mensagem/enviar')) {

                    
                    if ($this->model_mensagem->enviarMensagem($dados_multiple)) {
                        $data = [ 
                            'tela'    => 'mensagem/view_enviarmensagem',
                            'sucesso' => true,
                            'mensagem' => 'Enviado com sucesso!'
                        ];

                        $this->form_validation->clear_field_data(); // Responsável por limpar os campos mesmo utilizando o set_value
                    } else {
                        $data = [ 
                            'tela'    => 'mensagem/view_enviarmensagem',
                            'sucesso' => false,
                            'mensagem' => 'Erro ao enviar a mensagem!'
                        ];
                    }

                } else {
                    $data = [ 
                        'tela'    => 'mensagem/view_enviarmensagem',
                        'sucesso' => false,
                        'mensagemFormValidation' => true
                    ];
                }
                
            } else {
                
                $data['tela']    = 'mensagem/view_enviarmensagem';
                $data['ativa']   = 'mailbox';
                
            }

            $data['profile'] = $this->recoverProfileUser(); // Recupera os dados do perfil do usuário da sessão

            $this->load->view('view_home', $data);
        } else {
            redirect('auth/login');
        }
    }

    // Responsável por validar o email do usuário, para ver se existe na base dados
    public function validarEmail()
    {
        if ($this->session->has_userdata('logged_in')) {

                       
            $emails = !empty($this->input->post('usuario_destino')) ? explode(',', $this->input->post('usuario_destino')[0]) : $this->input->post('usuario_destino');
            
            $array_emails = array();

            if (isset($emails) && is_array($emails)) {
                
                foreach ($emails as $email_destino) {
                    
                    $email = filter_var($email_destino, FILTER_VALIDATE_EMAIL);
                    array_push($array_emails, $email);
                }

            } else {
                array_push($array_emails, filter_var($emails, FILTER_VALIDATE_EMAIL));
            }

            return !empty($this->model_usuario->validarEmail($array_emails)) ? true: false; 

        } else {
            redirect('auth/login');
        }
       
    }

    // Responsável pela renderização da view_enviarmensagem_especifico
    public function view_enviarMensagemUsuarioEspecifico()
    {
        if ($this->session->has_userdata('logged_in')) {

            $data['profile'] = $this->recoverProfileUser(); // Recupera os dados do perfil do usuário da sessão
            
            $id_usuario = filter_var($this->input->post('id_usuario'), FILTER_VALIDATE_INT);
            $data['usuario'] = $this->model_usuario->buscarUsuario(null, null, "", null, $id_usuario);

            $data['tela'] = 'mensagem/view_enviarmensagem_especifico';
            $data['ativa'] = 'mailbox';
            $this->load->view('view_home', $data);
           
        } else {
            redirect('auth/login');
        }
    }

    // Responsável por enviar mensagem para um único usuário em específico
    public function enviarMensagemUsuarioEspecifico()
    {
        if ($this->session->has_userdata('logged_in')) {

            if ($this->input->post()) {

                $email_destino = $this->input->post('usuario_destino');

                $dados_multiple = array();

                $dados = [
                    'USUARIO_ORIGEM'  => filter_var($this->session->userdata('logged_in')['email'], FILTER_VALIDATE_EMAIL),
                    'USUARIO_DESTINO' => filter_var($email_destino, FILTER_VALIDATE_EMAIL),
                    'TITULO'          => $this->input->post('titulo'),
                    'DESCRICAO'       => $this->input->post('editor1'),
                    'DATA_ENVIO'      => date('Y-m-d H:i:s')
                ];

                array_push($dados_multiple, $dados);
            
                $this->form_validation->set_error_delimiters('<p class="red">', '</p>'); // Alterando o delimitador

                if ($this->form_validation->run('mensagem/enviar_especifico')) {

                    
                    if ($this->model_mensagem->enviarMensagem($dados_multiple)) {
                        $data = [ 
                            'tela'    => 'mensagem/view_enviarmensagem_especifico',
                            'sucesso' => true,
                            'mensagem' => 'Enviado com sucesso!'
                        ];

                        $this->form_validation->clear_field_data(); // Responsável por limpar os campos mesmo utilizando o set_value
                    } else {
                        $data = [ 
                            'tela'    => 'mensagem/view_enviarmensagem_especifico',
                            'sucesso' => false,
                            'mensagem' => 'Erro ao enviar a mensagem!'
                        ];
                    }

                } else {
                    $data = [ 
                        'tela'    => 'mensagem/view_enviarmensagem_especifico',
                        'sucesso' => false,
                        'mensagemFormValidation' => true
                    ];
                }
                
            } 

            $data['profile'] = $this->recoverProfileUser(); // Recupera os dados do perfil do usuário da sessão

            $this->load->view('view_home', $data);
        } else {
            redirect('auth/login');
        }
    }
    
    // Responsável por exivir a mensagem por ID, utilizada na hora de leitura da mensagem
    public function visualizarMensagemPorId()
    {
        if ($this->session->has_userdata('logged_in')) {

            if ($this->input->get()) {
                $id_mensagem = filter_var($this->input->get('id'), FILTER_SANITIZE_NUMBER_INT);
                $data['mensagem'] = $this->model_mensagem->exibir($id_mensagem);
            }
            
            $data['profile'] = $this->recoverProfileUser(); // Recupera os dados do perfil do usuário da sessão

            $data['tela'] = 'mensagem/view_lerMensagem';
            $data['ativa'] = 'mailbox';
            $this->load->view('view_home', $data);

        } else {
            redirect('auth/login');
        }
    }

    // Responsável pela renderização da view
    public function view_enviado()
    {
        if ($this->session->has_userdata('logged_in')) {

            if ($this->input->post()) {
                echo 'POST'; // debug
            } else {
                
                $data['profile'] = $this->recoverProfileUser(); // Recupera os dados do perfil do usuário da sessão
                $data['tela'] = 'mensagem/view_listarMensagens';
                $data['ativa'] = 'mailbox';
                $data['title'] = 'Mensagens Enviadas';
                $this->load->view('view_home', $data);  
            }

        } else {
            redirect('auth/login');
        }
    }

    /**
     * Responsável por exibir todas mensagens enviadas
     * @param int $inicio
     */
    public function exibirTodasMensagensEnviada(int $inicio = 0)
    {
        if ($this->session->has_userdata('logged_in')) {

            $search = $this->input->post('search');
            $is_favorite = (int) $this->input->post('is_favorite');

            $email = filter_var($this->session->userdata('logged_in')['email'], FILTER_VALIDATE_EMAIL);

            // Config Pagination
            $config = [
                'base_url'        =>  base_url().'index.php/mensagem/exibirTodasMensagensEnviada',
                'total_rows'      =>  $this->model_mensagem->getQtdMensagem($search, $email, null, 1, $is_favorite),
                'per_page'        =>  5,
                'first_link'      =>  false, // Definindo que não haverá o link que trás os primeiros elementos da lista
                'last_link'       =>  false, // Definindo que não haverá o link que trás os últimos elementos da lista
                'first_tag_open'  =>  false, // tag open do link que trás os primeiro elementos da lista
                'first_tag_close' =>  false, // tag close do link que trás os primeiro elementos da lista
                'last_tag_open'   =>  false, // tag open do link que trás os últimos elementos da lista
                'last_tag_close'  =>  false, // tag close do link que trás os últimos elementos da lista
                'prev_link'       =>  '&lt;', // Conteudo a ser exibido para o link de paginação que vai levar para página anterior
                'prev_tag_open'   =>  "<li class='prev'>", // tag open link anterior
                'prev_tag_close'  =>  "</li>", // tag close link anterior
                'next_link'       =>  '&gt;', // Conteudo a ser exibido para o link de paginação que vai levar para próxima página
                'next_tag_open'   =>  "<li class='next'>", // tag open próxima página
                'next_tag_close'  =>  "</li>", // tag close próxima página
                'display_pages'   =>  false  // Esconde os number digit pages
            ];


            if ($inicio != 0) {
                $inicio = ($inicio - 1) * $config['per_page'];
            } else {
                $inicio = 0;
            }


            $features = array();
            $features = [ 
                'titulo' => $search,
                'limite' => $config['per_page'],
                'inicio' => $inicio
            ];

            
            $emails = $this->model_mensagem->exibir(null, $email, null, 1, $features, $is_favorite);

            $this->pagination->initialize($config);

            if (is_array($emails) && empty($emails)) {
                $dados['mensagem'] = 'Não existe(m) mensagem na base de dados com esse(s) filtro(s).';
            }

            $dados['emails'] = $emails;
            $dados['pagination'] = $this->pagination->create_links();

            echo json_encode($dados);
        } else {
            redirect('auth/login');
        }
    }

    // Responsável pela renderização da view
    public function view_caixaEntrada()
    {
        if ($this->session->has_userdata('logged_in')) {

            if ($this->input->post()) {
                echo 'POST'; // debug
            } else {
                
                $data['profile'] = $this->recoverProfileUser(); // Recupera os dados do perfil do usuário da sessão
                $data['tela'] = 'mensagem/view_listarMensagens';
                $data['ativa'] = 'mailbox';
                $data['title'] = 'Caixa de Entrada';
                $this->load->view('view_home', $data);  
            }

        } else {
            redirect('auth/login');
        }
    }

    /**
     * Responsável por exibir todas mensagens da caixa de entrada
     * @param int $inicio
     */
    public function exibirTodasMensagensCaixaEntrada(int $inicio = 0)
    {
        if ($this->session->has_userdata('logged_in')) {

            $search = $this->input->post('search');
            $is_favorite = (int) $this->input->post('is_favorite');

            $email = filter_var($this->session->userdata('logged_in')['email'], FILTER_VALIDATE_EMAIL);

            // Config Pagination
            $config = [
                'base_url' => base_url().'index.php/mensagem/exibirTodasMensagensCaixaEntrada',
                'per_page' => 10,
                'total_rows' => $this->model_mensagem->getQtdMensagem($search, null, $email, 1, $is_favorite),
                'first_link'      =>  false, // Definindo que não haverá o link que trás os primeiros elementos da lista
                'last_link'       =>  false, // Definindo que não haverá o link que trás os últimos elementos da lista
                'first_tag_open'  =>  false, // tag open do link que trás os primeiro elementos da lista
                'first_tag_close' =>  false, // tag close do link que trás os primeiro elementos da lista
                'last_tag_open'   =>  false, // tag open do link que trás os últimos elementos da lista
                'last_tag_close'  =>  false, // tag close do link que trás os últimos elementos da lista
                'prev_link'       => '&lt;', // Conteudo a ser exibido para o link de paginação que vai levar para página anterior
                'prev_tag_open'   => "<li class='prev'>", // tag open link anterior
                'prev_tag_close'  => "</li>", // tag close link anterior
                'next_link'       => '&gt;', // Conteudo a ser exibido para o link de paginação que vai levar para próxima página
                'next_tag_open'   => "<li class='prev'>", // tag open próxima página
                'next_tag_close'  => "</li>", // tag close próxima página
                'display_pages'   =>  false  // Esconde os number digit pages
            ];


            if ($inicio != 0) {
                $inicio = ($inicio - 1) * $config['per_page'];
            } else {
                $inicio = 0;
            }


            $features = array();
            $features = [ 
                'titulo' => $search,
                'limite' => $config['per_page'],
                'inicio' => $inicio
            ];

            
            $emails = $this->model_mensagem->exibir(null, null, $email, 1, $features, $is_favorite);

            $this->pagination->initialize($config);

            if (is_array($emails) && empty($emails)) {
                $dados['mensagem'] = 'Não existe(m) mensagem na base de dados com esse(s) filtro(s).';
            }

            $dados['emails'] = $emails;
            $dados['pagination'] = $this->pagination->create_links();


            echo json_encode($dados);
        } else {
            redirect('auth/login');
        }
    }
    
    // Responsável por renderização da view
    public function view_lixeira()
    {
        if ($this->session->has_userdata('logged_in')) {

            if ($this->input->post()) {
                echo 'POST'; // debug
            } else {
                $data['profile'] = $this->recoverProfileUser(); // Recupera os dados do perfil do usuário da sessão
                $data['is_recover'] = true; // Utilizado para exibição do componente de recuperação da mensagem da lixeira para a caixa de entrada
                $data['tela'] = 'mensagem/view_listarMensagens';
                $data['ativa'] = 'mailbox';
                $data['title'] = 'Mensagens excluídas';
                $this->load->view('view_home', $data);  
            }

        } else {
            redirect('auth/login');
        }
    }

    /**
     * Responsável por exibir as mensagens excluídas
     * @param int $inicio
     */
    public function exibirTodasMensagensExcluidas($inicio = 0)
    {
        if ($this->session->has_userdata('logged_in')) {

            $search = $this->input->post('search');
            $is_favorite = (int) $this->input->post('is_favorite');
            $email = filter_var($this->session->userdata('logged_in')['email'], FILTER_VALIDATE_EMAIL);

            // Config Pagination
            $config = [
                'base_url'        =>  base_url().'index.php/mensagem/exibirTodasMensagensExcluidas',
                'per_page'        =>  5,
                'total_rows'      =>  $this->model_mensagem->getQtdMensagem($search, $email, $email, 2, $is_favorite),
                'first_link'      =>  false, // Definindo que não haverá o link que trás os primeiros elementos da lista
                'last_link'       =>  false, // Definindo que não haverá o link que trás os últimos elementos da lista
                'first_tag_open'  =>  false, // tag open do link que trás os primeiro elementos da lista
                'first_tag_close' =>  false, // tag close do link que trás os primeiro elementos da lista
                'last_tag_open'   =>  false, // tag open do link que trás os últimos elementos da lista
                'last_tag_close'  =>  false, // tag close do link que trás os últimos elementos da lista
                'prev_link'       => '&lt;', // Conteudo a ser exibido para o link de paginação que vai levar para página anterior
                'prev_tag_open'   => "<li class='prev'>", // tag open link anterior
                'prev_tag_close'  => "</li>", // tag close link anterior
                'next_link'       => '&gt;', // Conteudo a ser exibido para o link de paginação que vai levar para próxima página
                'next_tag_open'   => "<li class='prev'>", // tag open próxima página
                'next_tag_close'  => "</li>", // tag close próxima página
                'display_pages'   =>  false  // Esconde os number digit pages
            ];

            


            if ($inicio != 0) {
                $inicio = ($inicio - 1) * $config['per_page'];
            } else {
                $inicio = 0;
            }


            $features = array();
            $features = [ 
                'titulo' => $search,
                'limite' => $config['per_page'],
                'inicio' => $inicio
            ];

            $emails = $this->model_mensagem->exibir(null, $email, $email, 2, $features, $is_favorite);// REFATORAR
            

            $this->pagination->initialize($config);

            if (is_array($emails) && empty($emails)) {
                $dados['mensagem'] = 'Não existe(m) mensagem na base de dados com esse(s) filtro(s).';
            }

            $dados['emails'] = $emails;
            $dados['pagination'] = $this->pagination->create_links();
            // $dados['total_rows'] = $config['total_rows'];

            echo json_encode($dados);
        } else {
            redirect('auth/login');
        }
    }

    // Responsável por ativar e desativar as mensagens, alterando o status
    public function ativar_desativarMensagem()
    {
        if ($this->session->has_userdata('logged_in')) {

            $ids_mensagem = $this->input->post('checados');
            $status       = (int) $this->input->post('status');

            

            $this->form_validation->set_error_delimiters('', '');
            if ($this->form_validation->run('mensagem/checkbox')) {
                if ($this->model_mensagem->alterarStatusMensagem($ids_mensagem, $status)) {
                    $validator = [
                        'sucesso' => TRUE,
                        'mensagem' => 'Deletado com sucesso!'
                    ];
                } else {
                    $validator = [
                        'sucesso' => FALSE,
                        'mensagem' => 'Erro ao deletar a mensagem!'
                    ];
                }
            } else {
                $validator = [
                    'sucesso' => FALSE,
                    'mensagemFormValidation' => array('checados' => form_error('checados[]'))
                ];
            }
            

            echo json_encode($validator);

        } else {
            redirect('auth/login');
        }
    }
    
    // Responsável por deletar as mensagens
    public function deletarMensagem()
    {
        if ($this->session->has_userdata('logged_in')) {

            $ids_mensagem = $this->input->post('checados');
            $this->form_validation->set_error_delimiters('', '');
            if ($this->form_validation->run('mensagem/checkbox')) {
                if ($this->model_mensagem->deletarMensagem($ids_mensagem)) {
                    $validator = [
                        'sucesso' => TRUE,
                        'mensagem'=> 'Deletada com sucesso!'
                    ];
                } else {
                    $validator = [
                        'sucesso' => FALSE,
                        'mensagem'=> 'Error ao deletar a Mensagem!'
                    ];
                }
            } else {
                $validator = [
                    'sucesso' => FALSE,
                    'mensagemFormValidation' => array('checados' => form_error('checados[]'))
                ];
            }

            echo json_encode($validator);

        } else {
            redirect('auth/login');
        }

    }

    // Responsável por favoritas as mensagens
    public function favoritar_naoFavoritar()
    {
        if ($this->session->has_userdata('logged_in')) {

            $dados = [
                'ID_MENSAGEM' => (int) $this->input->post('checados'),
                'IS_FAVORITE' => $this->input->post('favorite')
            ];

            $this->form_validation->set_error_delimiters('', '');
            if ($this->form_validation->run('mensagem/favoritar_naoFavoritar')) {

                if ($this->model_mensagem->favoritar_desfavoritar($dados)) {
                    $validator = [
                        'sucesso' => TRUE,
                    ];
                } else {
                    $validator = [
                        'sucesso' => FALSE,
                    ];
                }

            } else {
                $validator = [
                    'sucesso' => FALSE,
                    'mensagemFormValidation' =>  array('identificador' => form_error('checados')),
                    
                ];
            }

            echo json_encode($validator);

        } else {
            redirect('auth/login');
        }
    }

    /**
     * Responsável por exibir as mensagens favoritas e não favoritas
     * @param $inicio
     */
    public function exibirTodasMensagensFavoritas_naoFavoritas($inicio = 0)
    {
        if ($this->session->has_userdata('logged_in')) {
            
            $is_favorite = (int) $this->input->post('is_favorite');
            $view        = $this->input->post('view');
            $search      = $this->input->post('search');

            $email = filter_var($this->session->userdata('logged_in')['email'], FILTER_VALIDATE_EMAIL);

            $per_page = 5;

            if ($inicio != 0) {
                $inicio = ($inicio - 1) * $per_page;
            } else {
                $inicio = 0;
            }


            $features = [
                'titulo' => $search,
                'limite' => $per_page,
                'inicio' => $inicio
            ];

            switch($view) {
                case 'view_enviado':
                    $emails = $this->model_mensagem->exibir(null, $email, null, 1, $features, $is_favorite);
                    $total_rows = $this->model_mensagem->getQtdMensagem($search, $email, null, 1, $is_favorite);
                    break;
                case 'view_caixaEntrada':
                    $emails = $this->model_mensagem->exibir(null, null, $email, 1, $features, $is_favorite);
                    $total_rows = $this->model_mensagem->getQtdMensagem($search, null, $email, 1, $is_favorite);
                    break;
                case 'view_lixeira':
                    $emails = $this->model_mensagem->exibir(null, $email, $email, 2, $features, $is_favorite);
                    $total_rows = $this->model_mensagem->getQtdMensagem($search, $email, $email, 2, $is_favorite);
                    break;
            }


            // Config Pagination
            $config = [
                'base_url'        =>  base_url().'index.php/mensagem/exibirTodasMensagensFavoritas_naoFavoritas',
                'total_rows'      =>  $total_rows,
                'per_page'        =>  $per_page,
                'first_link'      =>  false, // Definindo que não haverá o link que trás os primeiros elementos da lista
                'last_link'       =>  false, // Definindo que não haverá o link que trás os últimos elementos da lista
                'first_tag_open'  =>  false, // tag open do link que trás os primeiro elementos da lista
                'first_tag_close' =>  false, // tag close do link que trás os primeiro elementos da lista
                'last_tag_open'   =>  false, // tag open do link que trás os últimos elementos da lista
                'last_tag_close'  =>  false, // tag close do link que trás os últimos elementos da lista
                'prev_link'       =>  '&lt;', // Conteudo a ser exibido para o link de paginação que vai levar para página anterior
                'prev_tag_open'   =>  "<li class='prev'>", // tag open link anterior
                'prev_tag_close'  =>  "</li>", // tag close link anterior
                'next_link'       =>  '&gt;', // Conteudo a ser exibido para o link de paginação que vai levar para próxima página
                'next_tag_open'   =>  "<li class='next'>", // tag open próxima página
                'next_tag_close'  =>  "</li>", // tag close próxima página
                'display_pages'   =>  false  // Esconde os number digit pages
            ];


            $this->pagination->initialize($config);

            if (is_array($emails) && empty($emails)) {
                $dados['mensagem'] = 'Não existe(m) mensagem na base de dados com esse(s) filtro(s).';
            }

            $dados['emails'] = $emails;
            $dados['pagination'] = $this->pagination->create_links();
            $dados['total_rows'] = $config['total_rows'];

            echo json_encode($dados);
            
        } else {
            redirect('auth/login');
        }
    }

    // Responsável por marcar a mensagem como lido e não lido
    public function lido_naoLido()
    {
        if ($this->session->has_userdata('logged_in')) {


       
            $ids_mensagem = $this->input->post('checados');

            $this->form_validation->set_error_delimiters('', '');
            if ($this->form_validation->run('mensagem/checkbox')) {
                
                $dados = [
                    'id_mensagem' => $ids_mensagem,
                    'is_read'     => (int) $this->input->post('lido_naoLido')
                ];

                if ($this->model_mensagem->marcar_lido_naoLido($dados)) {
                    $validator = [
                        'sucesso' => TRUE,
                    ];
                } else {
                    $validator = [
                        'sucesso' => FALSE,
                    ];
                }

            } else {
                $validator = [
                    'sucesso' => FALSE,
                    'mensagemFormValidation' => array('checados' => form_error('checados[]'))
                ];
            }
            
            echo json_encode($validator);

        } else {
            redirect('auth/login');
        }
    }

    // Responsável por validar o ID_MENSAGEM
    public function validarIdMensagem()
    {
        if ($this->session->has_userdata('logged_in')) {
           
            
            $id_mensagem =  $this->input->post('checados');
           
            if (gettype($id_mensagem) === "array" && is_array($id_mensagem)) {
                return $this->model_mensagem->validarIdMensagem($id_mensagem,null);

            } else {
                return $this->model_mensagem->validarIdMensagem(null, $id_mensagem);
            }
            
        } else {
            redirect('auth/login');
        }
    }




    /**
     * Responsável por ativar as mensagens, alterando o status
     
    public function ativarMensagem()
    {
        if ($this->session->has_userdata('logged_in')) {



            $ids_mensagem = $this->input->post('checados');
            $this->form_validation->set_error_delimiters('', '');
            if ($this->form_validation->run('mensagem/checkbox')) {
                if ($this->model_mensagem->alterarStatusMensagem($ids_mensagem, 1)) {
                    $validator = [
                        'sucesso' => TRUE,
                        'mensagem' => 'Recuperado com sucesso!'
                    ];
                } else {
                    $validator = [
                        'sucesso' => FALSE,
                        'mensagem' => 'Erro ao recuperar a mensagem!'
                    ];
                }
            } else {
                $validator = [
                    'sucesso' => FALSE,
                    'mensagemFormValidation' => array('checados' => form_error('checados[]'))
                ];
            }
            
            echo json_encode($validator);

        } else {
            redirect('auth/login');
        }
    }
    */

}


