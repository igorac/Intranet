<?php 
    defined('BASEPATH') OR exit('URL inválida.');

class Instituto extends CI_Controller
{
    public function __construct() 
    {
        parent::__construct();
        date_default_timezone_set('America/Sao_Paulo');
        $this->load->model('model_instituto', 'inst');
    }

    // Responsável por cadastrar o instituto
    public function cadastrar()
    {
        if ($this->session->has_userdata('logged_in')) {

            if ($this->input->post()) {
                
                $data = [
                    'sucesso' => false,
                    'mensagem' => array()
                ];

               
                $this->form_validation->set_error_delimiters('<p class="red">', '</p>'); // Alterando o delimitador

                $fields = [
                    'nome_instituto' => $this->input->post('instituto'),
                    'cnpj'  => $this->input->post('cnpj'),
                    'id_endereco' => (int) $this->input->post('endereco'),
                    'telefone' => $this->input->post('telefone'),
                    'tipo_ensino' => $this->input->post('tipo_ensino'),
                    'status' => 1,
                    'data_cadastro' => Date('Y-m-d H:i:s')
                ];
                
                if ($this->form_validation->run('instituto/cadastrar')) {

                    if ($this->inst->cadastrar($fields)) {
                        $data['sucesso'] = true;
                        $this->form_validation->clear_field_data(); // Responsável por limpar os campos mesmo utilizando o set_value
                    } else {
                        $data['sucesso'] = false;
                    }

                } 

                $data['tela'] = 'instituto/view_formcadastro';
                $data['ativa'] = 'instituto';

            } else {
                
                $data['tela'] = 'instituto/view_formcadastro';
                $data['ativa'] = 'instituto';
               
            }

            /* Responsável por retornar os dados do usuário da sessão */
            $this->load->model('model_usuario');
            $id_usuario = filter_var($this->session->userdata('logged_in')['id_usuario'], FILTER_VALIDATE_INT);
            $data['profile'] = $this->model_usuario->profile($id_usuario);

            $this->load->view('view_home', $data);

        } else {
            redirect('auth/login', 'refresh');
        }
    }

    // Responsável por renderizar a view listar de institutos
    public function listar()
    {
        if ($this->session->has_userdata('logged_in')) {

            if ($this->input->post()) {
                echo 'post'; // DEBUG
            } else {
                
                /* Responsável por retornar os dados do usuário da sessão */
                $this->load->model('model_usuario');
                $id_usuario = filter_var($this->session->userdata('logged_in')['id_usuario'], FILTER_VALIDATE_INT);
                $data['profile'] = $this->model_usuario->profile($id_usuario);


                $data['tela'] = 'instituto/view_listar';
                $data['ativa'] = 'instituto';
                $this->load->view('view_home', $data);
            }

        } else {
            redirect('auth/login', 'refresh');
        }
    }
    
    // Responsável por validar o idEndereco
    public function valida_IdEndereco() 
    {
        if ($this->session->has_userdata('logged_in')) {
            
            $this->load->model('model_endereco');
            $id_endereco = (int) $this->input->post('endereco');

            $endereco = $this->model_endereco->exibirEndereco(null, null, null, $id_endereco);


            if ( isset($endereco) && !empty($endereco) ) {
                return true;
            } else {
                return false;
            }

        } else {
            redirect('auth/login');
        }
    }

    // Responsável por exibir todos os institutos
    public function exibirTodos()
    {
        if ($this->session->has_userdata('logged_in')) {
            $result = array('data' => array());

            $instituicoes = $this->inst->exibirInstituto(null, null);
            
            $button = '&nbsp;';

            foreach($instituicoes as $key => $instituto) {
                $result['data'][$key] = [
                    $instituto['id_instituto'],
                    $instituto['nome_instituto'],
                    $instituto['rua'],
                    $instituto['cidade'],
                    $instituto['estado'],
                    $instituto['tipo_ensino'],
                    $instituto['cnpj'],
                    $button
                ];
            }

            echo json_encode($result);

        } else {
            redirect('auth/login', 'refresh');
        }

    }

    // Responsável por consultar instituto por ID_INSTITUTO,  para verificar a existência
    public function consultarPorId() 
    {
        if ($this->session->has_userdata('logged_in')) {

            $id_inst = (int) $this->input->post('id_inst');
      
            $validate = [
                'sucesso' => false,
            ];


            if ($this->form_validation->run('instituto/consultar')) {
                //$instituto = $this->inst->consultarPorId($id_inst);
                $instituto = $this->inst->exibirInstituto($id_inst, null);
                

                if (!empty($instituto)) {

                    $validate = [
                        'sucesso' => true,
                        'instituto' => $instituto
                    ];

                } else {

                    $validate = [
                        'sucesso' => false
                    ];

                }

            } 

            echo json_encode($validate);

        } else {
            redirect('auth/login', 'refresh');
        }
    }

    // Responsável por alterar os dados do instituto
    public function alterar()
    {

        if ($this->session->has_userdata('logged_in')) {

            $validator = [
                'sucesso' => false,
                'mensagem' => ''
            ];

            $id_inst = (int) $this->input->post('id_inst');

            // Verifica se existe algum envio de CNPJ
            if($this->input->post('cnpj')) {
                $dados = [
                    'CNPJ'           => $this->input->post('cnpj'),
                ];

                $groupRules = 'instituto/cnpj'; // Define um group rules do form validation a ser utilizado

            } else {
                $dados = [
                    'NOME_INSTITUTO' => $this->input->post('instituto'),
                    'ID_ENDERECO'    => $this->input->post('endereco'),
                    'TIPO_ENSINO'    => $this->input->post('tipo_ensino'),
                    'TELEFONE'       => $this->input->post('telefone')
                ];

                $groupRules = 'instituto/alterar'; // Define um group rules do form validation a ser utilizado
            }


            $this->form_validation->set_error_delimiters('', ''); // Alterando o delimitador


            if ($this->form_validation->run($groupRules)) {

                if ($this->inst->alterar($dados, $id_inst)) {
                    $validator = [
                        'sucesso' => true,
                        'mensagem' => 'Alterado com sucesso!'
                    ];

                } else {
                    $validator = [
                        'sucesso' => false,
                        'mensagem' => 'Erro ao alterar'
                    ];
                }
            } else {
                $validator = [
                    'sucesso' => false,
                    'messagesFormValidationInsti' => $this->form_validation->error_array()
                ];
            }

            echo json_encode($validator);
        } else {
            redirect('auth/login');
        }
        
    }

    // Responsável por validar o ID_INSTITUTO, para verificar a existência
    public function validarIdInstituto()
    {
        if ($this->session->has_userdata('logged_in')) {

            $id_inst = (int) $this->input->post('id_inst');

            if ($this->inst->exibirInstituto($id_inst, null)) {
                return true;
            } else {
                return false;
            }

        } else {
            redirect('auth/login', 'refresh');
        }
    }

    // Responsável por deletar o instituto
    public function deletar()
    {
        if ($this->session->has_userdata('logged_in')) {

            $id_inst = (int) $this->input->post('id_inst');

            $validator = [
                'sucesso' => false,
                'mensagem'=> ''
            ];

            if ($this->form_validation->run('instituto/consultar')) {

                if ($this->inst->deletar($id_inst)) {
                    $validator = [
                        'sucesso' => true,
                        'mensagem'=> 
                            'Deletado com sucesso!'    
                        
                    ];
                } else {
                    $validator = [
                        'sucesso' => false,
                        'mensagem'=> 
                            'Erro ao Deletar!'
                        
                    ];
                }
                
    
            } else {

                $validator = [
                    'sucesso' => false,
                    'messagesFormValidation'=> $this->form_validation->error_array()
                ];

            }

            echo json_encode($validator);
             
        } else {
            redirect('auth/login');
        }
    }

    // Responsável por consultar todos os institutos, para ser utilizado no select2 do view_profile do usuário
    public function consultarTodos()
    {
        $searchTerm = $this->input->post('searchTerm');
        
        if ($this->session->has_userdata('logged_in')) {

            $institutos = $this->inst->exibirInstituto(null, $searchTerm);          
            echo json_encode($institutos);
        } else {
            redirect('auth/login');
        }
        
    }

}
