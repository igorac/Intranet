<?php 
    defined('BASEPATH') OR exit('URL inválida.');

class Auth extends CI_Controller
{
    public function __construct() 
    {
        parent::__construct();
        date_default_timezone_set('America/Sao_Paulo');
        $this->load->model('model_usuario');
    }

    public function login()
    {
        
        if ($this->session->has_userdata('logged_in')) {
            redirect('app/dashboard');
            
        } else {
            if ($this->input->post()) {

                $this->form_validation->set_error_delimiters('<p class="red">', '</p>');
                    
                if ($this->form_validation->run('usuario/login')) {
                    redirect('app/dashboard');
                } else {
                    $this->load->view('view_login');
                }
    
            } else {
                $this->load->view('view_login');
            }
        }

    }

    public function validar_senha() 
    {
        $login = $this->input->post('login');
        $senha = $this->input->post('senha');

        $resultado = $this->model_usuario->validarLogin($login);
        
        if ( isset($resultado) && !empty($resultado) && password_verify($senha, $resultado[0]->senha) ) {
            $dados = [
                'id_usuario' => $resultado[0]->id_usuario,
                'nome'       => $resultado[0]->nome,
                'login'      => $resultado[0]->login,
                'email'      => $resultado[0]->email,
                'senha'      => $resultado[0]->senha
            ];

            $this->session->set_userdata('logged_in', $dados);

           // var_dump($this->session->userdata('logged_in'));

            return true;
        } else {
            return false;
        } 
        
    }

    public function validar_login()
    {
        $login = $this->input->post('login');

        $resultado = $this->model_usuario->validarLogin($login);

        if (isset($resultado) && empty($resultado))
            return false;
        else   
            return true;    
    }

   
    
}