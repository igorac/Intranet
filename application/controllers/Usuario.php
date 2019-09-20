<?php 
    defined('BASEPATH') OR exit('URL inválida.');

class Usuario extends CI_Controller
{
    public function __construct() 
    {
        parent::__construct();
        date_default_timezone_set('America/Sao_Paulo');
        $this->load->model('model_usuario');
        $this->load->model('model_mensagem');
    }

    public function index()
    {
        if ($this->session->has_userdata('logged_in')) {
            redirect('auth/login');
        } else {
            redirect('usuario/cadastrar');
        }
    }

    /**
     * Responsável por recuperar os dados do usuário logado 
     */
    private function recoverProfileUser()
    {
        $id = (int) $this->session->userdata('logged_in')['id_usuario'];
        return $this->model_usuario->profile($id);
    }


    /**
     * Responsável por cadastrar o usuário
     */
    public function cadastrar()
    {
        if ($this->session->has_userdata('logged_in')) {
            redirect('app/logout');
        } else {
            if ($this->input->post()) {
                
                $this->form_validation->set_error_delimiters('<span class="red">', '</span>');

                $dados['nome'] = $this->input->post('nome');
                $dados['login'] = $this->input->post('login');
                $dados['email'] = $this->input->post('email');
                $dados['senha'] = password_hash($this->input->post('senha'), PASSWORD_DEFAULT);
                $dados['status'] = 1;
                $dados['data_cadastro'] = date('Y-m-d H:i:s');


                if ($this->form_validation->run('usuario/cadastro')) {
                    if ($this->model_usuario->cadastrar($dados))
                        redirect('auth/login', 'refresh');
                } else {
                    $this->load->view('telas/usuarios/formcadastro');
                }

            } else {
                $this->load->view('telas/usuarios/formcadastro');
            }
            
        }
    }

     /**
     * Renderiza a view perfil do usuário
     */
    public function perfilView()
    {
        if ($this->session->has_userdata('logged_in')) {


            /* Consumir via api através do curl */
            $dados['nacionalidades'] = array ( ['nome' => 'Argentina', 'code' => 'AR'], ['nome' => 'Bolívia', 'code' => 'BO'], 
                ['nome' => 'Brasil', 'code' => 'BR'], ['nome' => 'Chile', 'code' => 'CL'], ['nome' => 'Colômbia', 'code' => 'CO'], 
                ['nome' => 'Ecuador', 'code' => 'EC'],['nome' => 'Ilhas Falklands','code' => 'FK'], ['nome' => 'Guyana','code' => 'GY'], 
                ['nome' => 'Paraguay','code' => 'PY'], ['nome' => 'Perú','code' => 'PE'], ['nome' => 'South Georgia','code' => 'GS'], 
                ['nome' => 'Suriname','code' => 'SR'], ['nome' => 'Uruguay','code' => 'UY'], ['nome' => 'Venezuela','code' => 'VE']
            );


            $dados['skills'] = $this->exibirHabilidades();


            /* Responsável por retornar os dados do usuário da sessão */
            $this->load->model('model_usuario');
            $id_usuario = filter_var($this->session->userdata('logged_in')['id_usuario'], FILTER_VALIDATE_INT);
            $dados['profile'] = $this->model_usuario->profile($id_usuario);

            $dados['tela'] = 'usuarios/view_profile';

            $this->load->view('view_home', $dados);
        } else {
            redirect('auth/login');
        }
    }

     /**
     * Utilizado para trazer os dados do banco de dados do perfil do usuário
     */
    public function dadosUsuario()
    {
        $id = (int) $this->session->userdata('logged_in')['id_usuario'];
        $dados['dados_profile'] = $this->model_usuario->profile($id);

        echo json_encode($dados['dados_profile']);
    }

    /**
     * Utilizado para alterar os dados do perfil do usuário
     */
    public function perfil()
    {
        if ($this->session->has_userdata('logged_in')) {

            if ($this->input->post()) {
                
                
                $habilidades = !empty($this->input->post('habilidades')) ? implode(',', $this->input->post('habilidades')) : NULL;

                $this->form_validation->set_error_delimiters('', '');

                $validator = [
                    'sucesso' => false,
                    'mensagem' => ''
                ];

               
                if ($this->form_validation->run('usuario/profile')){


                    $id_usuario = filter_var($this->session->userdata('logged_in')['id_usuario'], FILTER_VALIDATE_INT);
                    $id_endereco = empty($this->input->post('id_endereco')) ? NULL : $this->input->post('id_endereco');
                    $id_instituto = empty($this->input->post('id_instituto')) ? NULL : $this->input->post('id_instituto');
                    $id_perfil = empty($this->input->post('id_perfil')) ? NULL : $this->input->post('id_perfil');

                   
                    $dados = [
                        'NOME' => $this->input->post('nome'),
                        'ID_ENDERECO' => $id_endereco,
                        'ID_INSTITUTO' => $id_instituto,
                        'ID_PERFIL' => $id_perfil,
                        'HABILIDADE' => $habilidades,
                        'NACIONALIDADE' => $this->input->post('nacionalidade'),
                        'DATA_MODIFICACAO' => date('Y-m-d H:i:s')
                    ];

                    if ($this->model_usuario->alterarProfile($dados, $id_usuario)) {
                        $validator = [
                            'sucesso' => true,
                            'mensagem' => 'Alterado com sucesso!'
                        ];
                    } else {
                        $validator = [
                            'sucesso' => false,
                            'mensagem' => 'Erro ao alterar!'
                        ];
                    }
    
                } else {
                   $validator = [
                        'sucesso' => false,
                        'mensagemFormValidation' => $this->form_validation->error_array()
                    ];
                   
                }

                echo json_encode($validator);
           
            } else {
                $this->dadosUsuario();
            }
          
        } else {
            redirect('auth/login');
        }
    }
   
    /**
     * Responsável por alterar imagem de perfil do usuário
     */
    public function imagem()
    {
        
        if ($this->session->has_userdata('logged_in')) {
            
          
            $config['upload_path']   = './assets/upload/160px/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size']      = 3000000;
            $config['max_width']     = 1024;
            $config['max_height']    = 1024;
            $config['max_filename']  = 60;   // O máximo de caracter do nome do arquivo
            $config['encrypt_name']  = TRUE; // Encrypt o nome do arquivo
            $config['remove_spaces'] = TRUE; // Converte os espaços em underline por DEFAULT JÁ É TRUE
            $config['overwrite']     = TRUE;
    
    
            $validator = [
                'sucesso' => false,
                'mensagem' => ''
            ];
    
    
            $this->load->library('upload', $config); // Inicializo a library de upload com as preferência de configs
            
            
            if (isset($_FILES['imagem']['name'])) {
                if ( $this->upload->do_upload('imagem')) {

                    $imagem =  $this->upload->data()['file_name'];
                   
                    $config['image_library']  = 'gd2'; // Load the library
                    $config['source_image']   = './assets/upload/160px/'.$imagem;
                    $config['create_thumb']   = FALSE;
                    $config['maintain_ratio'] = FALSE; // Faz as medidas definidas abaixo serem utilizadas independente do tamanho
                    $config['quality']        = '60%';
                    $config['width']          = 160;
                    $config['height']         = 160;
        
                    $this->load->library('image_lib', $config); // The load library with configs preferences

                    $id_usuario = (int) $this->session->userdata('logged_in')['id_usuario'];
                    
                    $dados = [
                        'IMAGEM' => $imagem,
                        'DATA_MODIFICACAO' => date('Y-m-d H:i:s')
                    ];
                    
                   
                    if ($this->image_lib->resize()) {
                      
                        if ($this->model_usuario->alterarImagem($dados, $id_usuario)) {
                            $validator = [
                                'sucesso' => true,
                                'mensagem' => 'Alterado com sucesso!'
                            ];
                        } else {
                          
                            $validator = [
                                'sucesso' => false,
                                'mensagem' => 'Erro ao Alterar'
                            ];
                        }
                    } else {
                        
                        $validator = [
                            'sucesso' => false,
                            'mensagemResizeErrors' => $this->image_lib->display_errors()
                        ];
                    }
        
                } else {
                    
                    $validator = [
                        'sucesso' => false,
                        'mensagemUploadErrors' => $this->upload->display_errors('', '')
                    ];
                }

                echo json_encode($validator);
            }

        } else {
            redirect('auth/login');
        }
        
    }

     /**
     * Utilizado na function de pesquisa de pessoas por nome da view usuarios/view_search 
     */
    public function consultar()
    {
        if ($this->session->has_userdata('logged_in')) {
            $search = $this->input->post('nome_search');

            $email = filter_var($this->session->userdata('logged_in')['email'], FILTER_VALIDATE_EMAIL); // Evitar a busca pelo o usuário que já logado
            $usuario = $this->model_usuario->buscarUsuario(null, null, $search, $email);

            echo json_encode($usuario);
        } else {
            redirect('auth/login');
        }
    }

    /**
     * Responsável por consultar o usuário de acordo com o email
     */
    public function consultarPorEmail()
    {
        if ($this->session->has_userdata('logged_in')) {

            $email = filter_var($this->input->post('search'), FILTER_SANITIZE_EMAIL);
            $emails = $this->model_usuario->consultarPorEmail($email);

            echo json_encode($emails);
            
        } else {
            redirect('auth/login');
        }
    }


    /**
     * Responsável por alterar a senha do usuário
     */
    public function alterarSenha()
    {
        if ($this->session->has_userdata('logged_in')) {

            

            $senhaAntiga = $this->input->post('senhaAntiga');
            $novaSenha   = $this->input->post('novaSenha');
            $id_usuario  = (int) $this->session->userdata('logged_in')['id_usuario'];


            $this->form_validation->set_error_delimiters('', '');
            if ($this->form_validation->run('usuario/alterarSenha')) {

                if( $this->model_usuario->alterarSenha(password_hash($novaSenha, PASSWORD_DEFAULT), $id_usuario) ) {

                    $this->session->unset_userdata('logged_in');
                    session_destroy();

                    $validator = [
                        'sucesso' => true,
                        'is_redirect' => true,
                        'redirect' => site_url('auth/login')
                    ];
                } else {
                    $validator = [
                        'sucesso' => false,
                        'is_redirect' => false,
                        'mensagem' => 'Erro ao tentar alterar a senha.'
                    ];
                }
            } else {
                $validator = [
                    'sucesso' => false,
                    'is_redirect' => false,
                    'mensagemFormValidation' => $this->form_validation->error_array()
                ];
              
            }

            echo json_encode($validator);
           
            

        } else {
            redirect('auth/login');
        }
    }


    /**
     * Responsável por alterar o email do usuário
     */
    public function alterarEmail()
    {
        if ($this->session->has_userdata('logged_in')) {

          

           $this->form_validation->set_error_delimiters('', '');
            if ($this->form_validation->run('usuario/alterarEmail')) {

                $novo_email = filter_var($this->input->post('novoEmail'), FILTER_SANITIZE_EMAIL);
                $id_usuario = (int) $this->session->userdata('logged_in')['id_usuario'];

                if ($this->model_usuario->alterarEmail($novo_email, $id_usuario)) {

                    $this->session->unset_userdata('logged_in');
                    session_destroy();

                    $validator = [
                        'sucesso' => true,
                        'is_redirect' => true,
                        'redirect' => site_url('auth/login')
                    ];

                } else {

                    $validator = [
                        'sucesso' => false,
                        'is_redirect' => false,
                        'mensagem' => 'Erro ao tentar alterar o E-mail.'
                    ];

                }
            } else {

                $validator = [
                    'sucesso' => false,
                    'is_redirect' => false,
                    'mensagemFormValidation' => $this->form_validation->error_array()
                ];

            }

            echo json_encode($validator);

        } else {
            redirect('auth/login');
        }
    }


    /**
     * Responsável por validar a senha do usuário de acordo com o email
     */
    public function validarSenha()
    {
        if ($this->session->has_userdata('logged_in')) {

            $senhaAntiga = $this->input->post('senhaAntiga');
            $email       = $this->session->userdata('logged_in')['email'];

            $dados = $this->model_usuario->validarSenha($email); // Retorna a senha do DB

           
            if (isset($dados) && !empty($dados)) {
                $senhaDB = $dados[0]->senha;
                if (password_verify($senhaAntiga, $senhaDB)) {
                    return true;
                } else {
                    return false;
                }
            }

        } else {
            redirect('auth/login');
        }
    }

    /**
     * @param int $inicio
     * Responsável pela a lista de registros paginados em { search usuarios }
     */
    public function listar(int $inicio = 0)
    {
        if ($this->session->has_userdata('logged_in')) {

            if ($this->input->post()) {

                $search = $this->input->post('nome_search');
                $limite = filter_var($this->input->post('limite'), FILTER_VALIDATE_INT);
                $email = filter_var($this->session->userdata('logged_in')['email'], FILTER_VALIDATE_EMAIL);
                

                $limite = $limite === 0 ? 1: $limite;


                // Config Pagination
                $config = [
                    'base_url' => base_url().'index.php/usuario/listar',
                    'per_page' => $limite,
                    'total_rows' => $this->model_usuario->qtdUsuario($search, $email)
                ]; 

                if ($inicio !== 0) {
                    $inicio = ($inicio - 1) * $config['per_page'];
                } else {
                    $inicio = 0;
                }

               
                $usuarios = $this->model_usuario->buscarUsuario($inicio, $config['per_page'], $search, $email);
              
                $this->pagination->initialize($config);

                if (isset($usuarios) && empty($usuarios)) {
                    $dados['mensagem'] = 'Não existe(m) usuário(s) com esse filtro na base de dados.';
                }

                $dados['usuarios'] = $usuarios;
                $dados['pagination'] = $this->pagination->create_links();


                echo json_encode($dados);

            } else {
                /* Responsável por retornar os dados do usuário da sessão */
                $id_usuario = filter_var($this->session->userdata('logged_in')['id_usuario'], FILTER_VALIDATE_INT);
                $data['profile'] = $this->model_usuario->profile($id_usuario);

                $data['tela'] = 'usuarios/view_search';
                $data['ativa'] = 'usuario';
                $this->load->view('view_home', $data);
            }
            
        } else {
            redirect('auth/login');
        }
    }

    /**
     * Responsável por exibir as habilidades
     */
    private function exibirHabilidades()
    {

        if ($this->session->has_userdata('logged_in')) {
            $skills = $this->model_usuario->exibirHabilidades();
            
            $habilidades = array();

            foreach($skills as $skill) {
                array_push($habilidades, ['id' => $skill['HABILIDADE'], 'value' => $skill['HABILIDADE']]);
            }

            $data['habilidades'] = $habilidades;

            return $data['habilidades'];

        } else {
            redirect('auth/login');
        }
    }
    
    /**
     * Responsável por adicionar novas habilidades
     */
    public function addHabilidade()
    {
        if ($this->session->has_userdata('logged_in')) {

            $habilidade = filter_var($this->input->post('habilidade'), FILTER_SANITIZE_SPECIAL_CHARS);
        
            if ($this->form_validation->run('habilidade/cadastrar')) {

                $sucesso = $this->model_usuario->cadastrarHabilidade([
                    'HABILIDADE' => $habilidade,
                    'DATA_CADASTRO' => date('Y-m-d H:i:s')
                ]);

                if ($sucesso) {
                    $validator = [
                        'sucesso' => true,
                        'mensagem' => 'Habilidade cadastrada com sucesso!',
                        'habilidade' => $habilidade
                    ];
                } else {
                    $validator = [
                        'sucesso' => false,
                        'mensagem' => 'Erro ao cadastrada a habilidade'
                    ];
                }
            } else {
                $validator = [
                    'sucesso' => false,
                    'mensagemFormValidation' => $this->form_validation->error_array()
                ];
            }

            echo json_encode($validator);

        } else {
            redirect('auth/login');
        }
    }
}