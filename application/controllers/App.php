<?php 
    defined('BASEPATH') OR exit('URL inválida.');

class App extends CI_Controller
{
    public function __construct() 
    {
        parent::__construct();
        date_default_timezone_set('America/Sao_Paulo');
    }

    public function logout()
    {
        if ($this->session->has_userdata('logged_in')) {
            $this->session->unset_userdata('logged_in');
            session_destroy();
            redirect('app','refresh');
        } else {
            redirect('auth/login','refresh');
        }
    }    

    public function index()
    {
        if ($this->session->has_userdata('logged_in')) {
            redirect('app/dashboard');
        } else {
            redirect('auth/login');
        }
    }

    public function dashboard()
    {
        if ($this->session->has_userdata('logged_in')) {

            $this->load->model('model_usuario');
            $id_usuario = filter_var($this->session->userdata('logged_in')['id_usuario'], FILTER_VALIDATE_INT);
            $dados['profile'] = $this->model_usuario->profile($id_usuario);
            
            $dados['tela'] = 'view_dashboard';
            $this->load->view('view_home', $dados);
        } else {
            redirect('auth/login');
        }
    }
}