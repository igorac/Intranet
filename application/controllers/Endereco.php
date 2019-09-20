<?php 
    defined('BASEPATH') OR exit('URL inválida.');

class Endereco extends CI_Controller
{
    public function __construct() 
    {
        parent::__construct();
        date_default_timezone_set('America/Sao_Paulo');
        $this->load->model('model_endereco');
    }

    // Responsável por renderizar a view listar_endereco
    public function listar()
    {
        if ($this->session->has_userdata('logged_in')) {
            if ($this->input->post()) {
                echo 'POST'; // Apenas DEBUG
            } else {

                /* Responsável por retornar os dados do usuário da sessão */
                $this->load->model('model_usuario');
                $id_usuario = filter_var($this->session->userdata('logged_in')['id_usuario'], FILTER_VALIDATE_INT);
                $dados['profile'] = $this->model_usuario->profile($id_usuario);


                $dados['tela'] = 'endereco/view_listar';
                $dados['ativa'] = 'endereco';
                $this->load->view('view_home', $dados);
            }
        } else {
            redirect('auth/login');
        }
    }

    // Responsável por cadastrar os endereços
    public function cadastrar()
    {
        if ($this->session->has_userdata('logged_in')) {


            $validator = [
                'sucesso' => false,
                'messages' => array()
            ];

            $cep = $this->input->post('cep');
            $cep = preg_replace("/\D+/", "", $cep); // Retirando a máscara do CEP

            $field = [
                'rua' => $this->input->post('rua'),
                'bairro' => $this->input->post('bairro'),
                'cidade' => $this->input->post('cidade'),
                'estado' => $this->input->post('estado'),
                'cep'    => $cep, 
                'data_cadastro' => date('Y-m-d H:i:s')
            ];

            $this->form_validation->set_error_delimiters('', ''); // Seta delimitadores
            if ($this->form_validation->run('endereco/cadastro')) {
                    
    
                if ($this->model_endereco->cadastrar($field)) {
                    
                    $validator = [
                        'sucesso' => true,
                        'messages' => array('Cadastro com sucesso!')
                    ];
                } else {
                    $validator = [
                        'sucesso' => false,
                        'messages' => array('Erro ao cadastrar!')
                    ];
                }
            
            } else {

                $validator = [
                    'sucesso' => false,
                    'messagesFormValidation' => $this->form_validation->error_array()
                ];
               
            }

            echo json_encode($validator);
        }
    }

    // Responsável por validar o tipo de entrada do cep
    public function validaCep()
    {
        $cep = $this->input->post('cep');
        $cep = preg_replace("/\D+/", "", $cep);
        if ($this->model_endereco->validaCep($cep) == 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Responsável por exibir os endereços com paginação
     * @param int $inicio
     */
    public function exibir(int $inicio = 0)
    {
        if ($this->session->has_userdata('logged_in')) {

            $per_page = (int) $this->input->post('per_page');


            if ($per_page === 0) {
                $per_page = 3;
            }


            // config pagination
            $config['base_url'] = base_url().'index.php/endereco/exibir';
            $config['per_page'] = $per_page;
            $config['total_rows'] = $this->model_endereco->totalRows([
                'cep'    => $this->input->post('cep'),
                'cidade' => $this->input->post('cidade'),
            ]);


            if ($inicio != 0) {
                $inicio = ($inicio - 1) * $config['per_page'];
            } else {
                $inicio = 0;
            }

            $data['enderecos'] = $this->model_endereco->exibirEndereco([
                'cep'    => $this->input->post('cep'),
                'cidade' => $this->input->post('cidade'),
            ], $config['per_page'], $inicio );

            $this->pagination->initialize($config); // Inicializando a paginação
            $data['pagination'] = $this->pagination->create_links(); // Cria os links

            if (isset($data['enderecos']) && is_array($data['enderecos']) && empty($data['enderecos'])) {
                $data['mensagem'] = 'Não existem endereço(s) na base de dados com esse(s) filtro(s).';
            }

            echo json_encode($data);


        } else {
            redirect('auth/login');
        }
    }


    // Utilizado para exibir os endereços e é utilizado no select2
    public function consultarEndereco()
    {
        $searchTerm = $this->input->post('searchTerm');

        if ($this->session->has_userdata('logged_in')) {

            $enderecos = $this->model_endereco->exibirEndereco([
                'rua'    => $searchTerm,
            ], null, null);

            echo json_encode($enderecos);
        } else {
            redirect('auth/login');
        }
        
    }
    

    // Utilizado por exibir o endereço de acordo com o ID_ENDEREÇO
    public function buscarPorId()
    {
        if ($this->session->has_userdata('logged_in')) {
            
            $id_endereco = (int) $this->input->post('id_endereco');
            // $data['endereco'] = $this->model_endereco->buscarEndereco($id_endereco);
            $data['endereco'] = $this->model_endereco->exibirEndereco(null, null, null, $id_endereco);

            echo json_encode($data);

        } else {
            redirect('auth/login');
        }
    }

    // Utilizado para alterar os dados do endereço
    public function alterar()
    {
        if ($this->session->has_userdata('logged_in')) {

            $validator = [
                'sucesso' => false,
                'messages' => array()
            ];
            
            $this->form_validation->set_error_delimiters('', ''); // Seta delimitadores
            
            $id_endereco = (int) $this->input->post('id_endereco');

            if ($this->form_validation->run('endereco/alterar')) {

                
                $fields = [
                    'cep'              => $this->input->post('cep'),
                    'rua'              => $this->input->post('rua'),
                    'bairro'           => $this->input->post('bairro'),
                    'cidade'           => $this->input->post('cidade'),
                    'estado'           => $this->input->post('estado'),
                    'data_modificacao' => date('Y-m-d H:i:s')
                ];

                

                if ($this->model_endereco->alterar($fields, $id_endereco)) {
                    $validator = [
                        'sucesso' => true,
                        'messages' => array('Alterado com sucesso!')
                    ];
                } else {
                    $validator = [
                        'sucesso' => false,
                        'messages' => array('Erro ao Alterar!')
                    ];
                }
            
            } else {
                $validator = [
                    'sucesso' => false,
                    'messagesFormValidation' => $this->form_validation->error_array()
                ];
            }

            echo json_encode($validator);

        } else {
            redirect('auth/login');
        }
    }

    // Responsável por validar o ID_ENDEREÇO, para verificar a existência na base de dados.
    public function valida_IdEndereco() 
    {
        if ($this->session->has_userdata('logged_in')) {

            $id_endereco = (int) $this->input->post('id_endereco');
            
            $endereco = $this->model_endereco->exibirEndereco(null, null, null, $id_endereco);

            if ( isset($endereco) ) {
                return true;
            } else {
                return false;
            }

        } else {
            redirect('auth/login');
        }
    }

    // Responsável por deletar da base de dados o endereço
    public function deletar()
    {
        if ($this->session->has_userdata('logged_in')) {

            $id_endereco = (int) $this->input->post('id_endereco');

            $data['sucesso'] = false;
            if ($this->form_validation->run('endereco/deletar')) {
                
                if ($this->model_endereco->deletar($id_endereco)) {

                    $data['sucesso'] = true;
                } 
              
            } else {
                $data['errors'] = $this->form_validation->error_array();
            }

            echo json_encode($data);            

        } else {
            redirect('auth/login');
        }
    }





    // Responsável por exibir os endereços
    /*
    public function exibirTodos()
    {
        $searchTerm = $this->input->post('searchTerm');

        if ($this->session->has_userdata('logged_in')) {
            $enderecos = $this->model_endereco->exibirEndereco();
            echo json_encode($enderecos);
        } else {
            redirect('auth/login');
        }
    }
    */

}