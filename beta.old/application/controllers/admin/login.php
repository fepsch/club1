<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {

        parent:: __construct();

        $this->load->model('login_model');
        $this->load->model('usuario_model');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    public function index() {
        //USUARIO NO LOGUEADO
        if ($_POST) {
            $this->form_validation->set_rules('username', 'Usuario', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if ($this->form_validation->run() == FALSE) { //DATOS INCOMPLETOS
                $this->load->view('admin/header');
                $this->load->view('admin/login_admin');
                $this->load->view('admin/footer');
            } else {
                $userData = $this->login_model->getLogin($this->input->post('username'), $this->input->post('password')); //AUTENTICACION
                if ($userData && $userData[0]['tipoUsuario'] == 1) {
                    //DATOS DE USUARIO A SESSION
                    $sessionData = array(
                        'idUsuario' => $userData[0]['idUsuario'],
                        'username' => $userData[0]['mail'],
                        'tipoUsuario' => $userData[0]['tipoUsuario']
                    );
                    $this->session->set_userdata($sessionData);
                    redirect('admin/usuarios');
                } else {
                    $data['error'] = "Nombre de usuario o clave equivocada";
                    $this->load->view('admin/header');
                    $this->load->view('admin/login_admin', $data);
                    $this->load->view('admin/footer');
                }
            }
        } else {
            $this->load->view('admin/header');
            $this->load->view('admin/login_admin');
            $this->load->view('admin/footer');
        }
    }

    public function logout() {
        //destruimos la sesión
        $this->login_model->close();
        //$this->session->sess_destroy();  
        redirect(base_url('admin/login'));
    }

}

?>