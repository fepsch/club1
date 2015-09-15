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

    /*
      LOS DATOS DE SESSION SON:
      $sesion_data = array(
      'username' => $this->input->post('username'), //email
      'usuarioTipo' => $isValidLogin[0]['tipo'],
      );
     */

    public function index() {
        $logged = $this->login_model->isLogged();
        if (isset($this->session->userdata['url'])) {
            $urlRedirect = $this->session->userdata('url');
        } else {
            $this->load->library('user_agent');
            $urlRedirect = $this->agent->referrer();
            $this->session->set_userdata('url', $urlRedirect);
        }
        if ($logged) { //USUARIO LOGUEADO
            redirect('/');
        } else { //USUARIO NO LOGUEADO
            if ($_POST) {
                $this->form_validation->set_rules('username', 'Usuario', 'required');
                $this->form_validation->set_rules('password2', 'Password', 'required');

                if ($this->form_validation->run() == FALSE) { //DATOS INCOMPLETOS
                    $this->output->set_output($this->load->view('form_registro', '', TRUE));
                } else {
                    $userData = $this->login_model->getLogin($this->input->post('username'), $this->input->post('password2')); //AUTENTICACION
                    if ($userData) {
                        //DATOS DE USUARIO A SESSION
                        $sessionData = array(
                            'idUsuario' => $userData[0]['idUsuario'],
                            'username' => $userData[0]['mail'],
                            'tipoUsuario' => $userData[0]['tipoUsuario']
                        );
                        $this->session->set_userdata($sessionData);
                        unset($this->session->userdata['url']);
                        $this->output->set_output(json_encode(array('success' => TRUE, 'url' => $urlRedirect)));
                        //redirect($urlRedirect);
                    } else {
                        $data['error'] = "Nombre de usuario o clave equivocada";
                        $this->output->set_output($this->load->view('form_registro', $data, TRUE));
                    }
                }
            } else {
                $this->load->model('comuna_model');
                $data['comunas'] = $this->comuna_model->getComunas();
                $this->load->view('registro3', $data);
            }
        }
    }

    /*
      public function fblogout() {
      $signed_request_cookie = 'fbsr_' . $this->config->item('appID');
      setcookie($signed_request_cookie, '', time() - 3600, "/");
      $this->session->sess_destroy();  //session destroy
      redirect('index', 'refresh');  //redirect to the home page
      }
     */

    public function fblogin() {

        /* $facebook = new Facebook(array(
          'appId' => '160123597528115',
          'secret' => '56532133a5e1c7b660737f1e2bd4fe26',
          )); */

        $config = array(
            'appId' => '160123597528115',
            'secret' => '56532133a5e1c7b660737f1e2bd4fe26'
        );

        $this->load->library('facebook/src/facebook', $config);

        //$CI->load->library('facebook', $config);

        $user = $this->facebook->getUser();

        $facebook = $this->facebook;

        // We may or may not have this data based on whether the user is logged in.
        // If we have a $user id here, it means we know the user is logged into
        // Facebook, but we don't know if the access token is valid. An access
        // token is invalid if the user logged out of Facebook.
        //$user = $facebook->getUser(); // Get the facebook user id
        $profile = NULL;
        $logout = NULL;
        //print_r($user);
        if ($user) {
            try {
                $profile = $facebook->api('/me');  //Get the facebook user profile data
                //print_r($profile);
                //exit;
                $access_token = $facebook->getAccessToken();
                $params = array('next' => base_url('login/logout/'), 'access_token' => $access_token);
                $logout = $facebook->getLogoutUrl($params);
                //print_r($this->usuario_model->isUser($profile['email']));
                //exit;
                if (isset($profile['email'])) {
                    $isUser = $this->usuario_model->isUser($profile['email']);
                    $mail = $profile['email'];
                } else {
                    $isUser = $this->usuario_model->isUserFBNoMail($profile['id']);
                    $mail = '';
                }
                if (!$isUser) { //el usuario no existe
                    $data = array(
                        'mailRegistro' => $mail,
                        'nombreRegistro' => $profile['first_name'],
                        'apellidoPaternoRegistro' => $profile['last_name'],
                        //'apellidoMaternoRegistro' => $profile[],
                        'fbidRegistro' => $profile['id'],
                        'avatarRegistro' => $profile['id'],
                    );
                    $this->session->set_userdata($data);
                    redirect('/registro');
                    //$this->load->view('registro',$data);
                } else {
                    if (isset($profile['email'])) {
                        $userData = $this->login_model->getFBLoginMail($profile['email']); //AUTENTICACION
                    } else {
                        $userData = $this->login_model->getFBLoginFBId($profile['id']);
                    }
                    if ($userData) {
                        //DATOS DE USUARIO A SESSION
                        $sessionData = array(
                            'idUsuario' => $userData[0]['idUsuario'],
                            'username' => $userData[0]['mail'],
                            'tipoUsuario' => $userData[0]['tipoUsuario']
                        );
                        $this->session->set_userdata($sessionData);
                        $urlRedirect = $this->session->userdata('url');
                        unset($this->session->userdata['url']);
                        $this->output->set_output(json_encode(array('success' => TRUE, 'url' => $urlRedirect)));
                    } /* else {
                      $data['error'] = 'El mail ya se encuentra registrado, por favor inicie sesión';
                      $this->load->view('registro3', $data);
                      } */
                }
            } catch (FacebookApiException $e) {
                error_log($e);
                $user = NULL;
                $login_url = $facebook->getLoginUrl(array('scope' => 'basic_info,email'));
                $data['url'] = $login_url;
                header('Location: ' . $login_url);
            }
        } else {
            //$login_url = $facebook->getLoginUrl(array('scope' => 'basic_info,email'));
            //header('Location: '. $login_url);
            //echo "si";
        }
    }

    public function logout() {
        //destruimos la sesión
        $this->login_model->close();
        //$this->session->sess_destroy();  
        redirect('/');
    }

}

?>