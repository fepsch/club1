<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Registro extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->model('usuario_model');
        $this->load->library('session');
        $this->load->library('form_validation');
    }

    public function index() {

        if (isset($this->session->userdata['mailRegistro'])) { //si vienen datos desde la session los seteo para la vista
            $data['mail'] = $this->session->userdata['mailRegistro'];
            $data['nombre'] = $this->session->userdata['nombreRegistro'];
            $data['apellidoPaterno'] = $this->session->userdata['apellidoPaternoRegistro'];
            //$data['apellidoMaterno'] = $this->session->userdata['apellidoMaternoRegistro'];          // Robert
            $data['avatar'] = $this->session->userdata['avatarRegistro'];
            $data['fbid'] = $this->session->userdata['fbidRegistro'];
        } else {
            $data['mail'] = '';
            $data['nombre'] = '';
            $data['apellidoPaterno'] = '';
            $data['apellidoMaterno'] = '';      //Robert
            $data['avatar'] = '';
            $data['fbid'] = '';
        }
        $this->load->model('comuna_model');
        $data['comunas'] = $this->comuna_model->getComunas();

        //viene post
        if ($_POST) {
            if (isset($this->session->userdata['url'])) {
                $urlRedirect = $this->session->userdata('url');
            } else {
                $this->load->library('user_agent');
                $urlRedirect = $this->agent->referrer();
            }

            $this->form_validation->set_rules('mail', 'Mail', 'required|valid_email|is_unique[usuario.mail]');
            $this->form_validation->set_rules('nombre', 'Nombre', 'required');
            $this->form_validation->set_rules('apellidoPaterno', 'Primer apellido', 'required');
            //$this->form_validation->set_rules('apellidoMaterno', 'Segundo apellido', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required|matches[passwordVerificacion]');
            $this->form_validation->set_rules('passwordVerificacion', 'Repetir Password', 'required');
            $this->form_validation->set_rules('comuna', 'Comuna', 'required');

            $this->form_validation->set_message('is_unique', 'El %s ya se encuentra registrado');

            if ($this->form_validation->run() == FALSE) {   //si es que contiene errores
                $this->output->set_output($this->load->view('form_registro', $data, TRUE));
            } else {             //si no contiene errores

                /* if($this->input->post('avatar') != ''){ //viene imagen
                  $file = 'no viene nada';
                  } */
                if (isset($this->session->userdata['fbidRegistro'])) {
                    $img = file_get_contents('https://graph.facebook.com/' . $this->session->userdata('fbidRegistro') . '/picture?type=large');
                    $seed = rand(0, 999999);
                    $file = $seed . '-' . $this->session->userdata('fbidRegistro') . '.jpg';
                    $path = 'avatar/' . $file;
                    //echo getcwd();
                    //exit;
                    file_put_contents($path, $img);
                }
                $data = array(
                    'mail' => $this->input->post('mail'),
                    'nombre' => $this->input->post('nombre'),
                    'apellidoPaterno' => $this->input->post('apellidoPaterno'),
                    'apellidoMaterno' => $this->input->post('apellidoMaterno'),
                    'password' => md5($this->input->post('password')),
                    'fbid' => isset($this->session->userdata['fbidRegistro']) ? $this->session->userdata('fbidRegistro') : NULL,
                    'idComuna' => $this->input->post('comuna')
                );
                if (isset($file)) {
                    $data['avatar'] = $file;
                }

                $this->usuario_model->add($data);
                $dumpData = array(
                    'mailRegistro' => '',
                    'nombreRegistro' => '',
                    'apellidoPaternoRegistro' => '',
                    'apellidoMaternoRegistro' => '',
                    'fbidRegistro' => '',
                    'avatarRegistro' => '',
                );
                $this->session->unset_userdata($dumpData);
                $sessionData = array(
                    'username' => $data['mail'],
                    'idUsuario' => $this->usuario_model->getInsertedId(),
                    'tipoUsuario' => 3
                );
                unset($this->session->userdata['url']);
                $this->session->set_userdata($sessionData);
                $this->output->set_output(json_encode(array('success' => TRUE, 'url' => $urlRedirect)));
                //redirect('/');
            }
        } else {

            /* 	$this->load->view('header');						 */
            /* 	$this->load->view('registro',$data);				 */
            $this->output->set_output($this->load->view('form_registro', $data, TRUE));
            /* 	$this->load->view('footer');			 */
        }
    }

}
