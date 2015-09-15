<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {

        parent:: __construct();

        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->library('session');

        $this->load->model('page_model');
        $this->load->model('usuario_model');
        $this->load->model('meta_usuario_model');
        $this->load->model('periodos_model');
        $this->load->model('agenda_chef_model');
    }

    public function index() {
        $this->load->model('meta_model');
        $this->load->model('experiencia_model');
        $data['comunas'] = $this->meta_usuario_model->getMetasExistentesEnChef(3);
        $data['tags'] = $this->meta_usuario_model->getMetasExistentesEnChef(4);
        $data['nro_chefs'] = $this->usuario_model->countPerfil(2);
        $data['nro_experiencias'] = $this->experiencia_model->countExperiencias();
        $data['chefsCarrusel'] = $this->usuario_model->chefsCarrusel();
        $fotos = scandir(getcwd() . '/slides/');
        unset($fotos[0], $fotos[1]);
        $data['slides'] = $fotos;
        $this->load->view('header');
        $this->load->view('home', $data);
        $this->load->view('footer');
    }

    public function diasNoDisponibles() {
        $fechas = $this->agenda_chef_model->diasNoDisponiblesBusqueda($this->input->post('fecha'));
        //print($this->db->last_query());
        $this->output->set_output(json_encode($fechas));
    }

    public function fechasCalendarioBusqueda() {
        $diasSemana = $this->agenda_chef_model->diasSemanaDisponibles();
        $this->output->set_output(json_encode($diasSemana));
    }

    public function horariosCalendarioBusqueda() {
        $intervalo = new DateInterval('PT1H');
        $this->load->model('agenda_chef_model');
        $fecha = $this->functions->dateTimeSecsMySql($this->input->post('fecha'));
        $periodos = $this->agenda_chef_model->periodosDisponiblesDiaForm($fecha);
        //print($this->db->last_query());
        $horas = array();
        foreach ($periodos as $id) {
            $qperiodo = $this->periodos_model->get($id['idPeriodo']);
            $periodo = $qperiodo[0];
            $inicio = date_create($periodo['inicio']);
            $fin = date_create($periodo['fin']);
            $fin->modify("+ 1 hours");
            $rango = new DatePeriod($inicio, $intervalo, $fin);
            foreach ($rango as $hora) {
                if (!in_array($hora->format('H:i'), $horas))
                    $horas[] = $hora->format('H:i');
            }
        }
        $this->output->set_output(json_encode($horas));
    }

    public function page($id) {
        $pagina = $this->page_model->getPage($id);
        $data['pagina'] = $pagina[0];
        $this->load->view('header');
        $this->load->view('page_template', $data);
        $this->load->view('footer');
    }

    public function contacto() {
        if ($_POST) {
            $this->form_validation->set_rules('nombre', 'Nombre', 'required');
            $this->form_validation->set_rules('mail', 'Correo', 'required|valid_email');
            $this->form_validation->set_rules('mensaje', 'Mensaje', 'required');
            if ($this->form_validation->run() != FALSE) {
                $this->load->library('session');
                $this->load->library('email');
                $this->email->from('contacto@clubdelacocina.cl', $this->input->post('nombre'));
                $this->email->to('hola@clubdelacocina.cl');
                $this->email->reply_to($this->input->post('mail'), $this->input->post('nombre'));
                $this->email->subject($this->input->post('asunto'));
                $this->email->message($this->input->post('mensaje'));
                if ($this->email->send()) {
                    $data['mensaje'] = '<div class="exito">Tu mensaje fue enviado exitosamente, nos contactaremos contigo en breve!</div>';
                } else {
                    $data['mensaje'] = '<div class="fallo">Ocurrió un problema al enviar el mensaje, por favor inténtelo nuevamente</div>';
                }
                $this->load->view('header');
                $this->load->view('contacto', $data);
                $this->load->view('footer');
            } else {
                $this->load->view('header');
                $this->load->view('contacto');
                $this->load->view('footer');
            }
        } else {
            $this->load->view('header');
            $this->load->view('contacto');
            $this->load->view('footer');
        }
    }

    public function resetPwd() {
        $token = sha1(rand(0, time()));
        if ($_POST) {
            $this->form_validation->set_rules('mail', 'Correo', 'required|valid_email|callback_check_existe_mail');
            if ($this->form_validation->run() != FALSE) {
                $usuario = $this->usuario_model->getUser($this->input->post('mail'));
                if (!empty($usuario)) {
                    $dataToken = array(
                        'idUsuario' => $usuario[0]['idUsuario'],
                        'token' => $token
                    );

                    $this->usuario_model->edit($dataToken);
                    $this->load->library('session');
                    $this->load->library('email');
                    $this->email->from('hola@clubdelacocina.cl', 'Club de la Cocina');
                    $this->email->to($this->input->post('mail'));
                    $this->email->subject('Restablecer contraseña');
                    $this->email->message('Para restablecer su contraseña, por favor siga el siguiente link ' .
                            (base_url('home/newPassword/?m=' . base64_encode($this->input->post('mail')) . "&t=" . base64_encode($token))));
                    if ($this->email->send()) {
                        $data['mensaje'] = '<div class="exito">Mensaje enviado de forma exitosa. Gracias</div>';
                        $this->load->view('header');
                        $this->load->view('mensajes', $data);
                        $this->load->view('footer');
                    } else {
                        $data['mensaje'] = '<div class="fallo">Ocurrió un problema al enviar el mensaje, por favor inténtelo nuevamente</div>';
                        $this->load->view('header');
                        $this->load->view('mensajes', $data);
                        $this->load->view('footer');
                    }
                } else {
                    echo 'no existe la cuenta';
                }
            } else {
                $this->load->view('header');
                $this->load->view('pwd_reset');
                $this->load->view('footer');
            }
        } else {
            $this->load->view('header');
            $this->load->view('pwd_reset');
            $this->load->view('footer');
        }
    }

    function check_existe_mail($str) {
        $valido = $this->usuario_model->isUser($str);
        if ($valido) {
            return TRUE;
        } else {
            $this->form_validation->set_message('check_existe_mail', 'El mail que indica, no se encuentra registrado en nuestras bases');
            return FALSE;
        }
    }

    public function newPassword() {
        if ($_GET) {
            $mail = base64_decode($_GET['m']);
            $token = base64_decode($_GET['t']);
            $this->session->set_userdata(array('mail' => $mail, 'token' => $token));
            $usuario = $this->usuario_model->getUserToken($mail, $token);
            if (!empty($usuario)) {
                $this->load->view('header');
                $this->load->view('reset_password');
                $this->load->view('footer');
            } else {
                $data['mensaje'] = "El token ha expirado";
                $this->load->view('header');
                $this->load->view('mensajes', $data);
                $this->load->view('footer');
            }
        }
        if ($_POST) {
            $this->form_validation->set_rules('password', 'Password', 'required|matches[repetirpassword]');
            $this->form_validation->set_rules('repetirpassword', 'Repetir Password', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->load->view('header');
                $this->load->view('reset_password');
                $this->load->view('footer');
            } else {
                $usuario = $this->usuario_model->getUserToken($this->session->userdata('mail'), $this->session->userdata('token'));
                $usuario[0]['password'] = md5($this->input->post('password'));
                $usuario[0]['token'] = NULL;
                $this->usuario_model->edit($usuario[0]);
                $this->session->unset_userdata(array('mail' => '', 'token' => ''));
                redirect('home');
            }
        }
    }

    public function mailingFinActividad() {
        $this->load->model('actividad_model');
        $actividades = $this->actividad_model->actividadesFinalizadas();
        $this->load->library('email');
        $this->load->model('usuario_model');
        foreach ($actividades as $actividad) {
            $actividad['idEstado'] = 5;
            $data_actividad = array('idActividad' => $actividad['idActividad'], 'idEstado' => $actividad['idEstado']);
            $usuario = $this->usuario_model->getUserData($actividad['idUsuario']);
            $this->actividad_model->update($data_actividad);
            $this->email->clear();
            $this->email->initialize(array('mailtype' => 'html'));
            $this->email->from('hola@clubcocina.cl', 'Club de la cocina');
            $this->email->to($actividad['mail']);
            $this->email->subject('Evaluación de su Actividad');
            $actividad_id = base64_encode($actividad['idActividad']);
            $metodo = base64_encode(base_url('mipanel/calificaciones/'));
            $mail = base64_encode($actividad['mail']);
            $data['nombreCliente'] = $usuario[0]['nombre'];
            $data['url'] = base_url("home/acs/?m=$mail&to=$metodo&a=$actividad_id");
            $this->email->message($this->load->view('mailing/calificar_experiencia', $data, true));
            $this->email->send();
            //Mail cliente
            
        }
    }

    public function acs() {
        if ($_GET) {
            $metodo = base64_decode($_GET['to']);
            $idActividad = base64_decode($_GET['a']);
            $mail = base64_decode($_GET['m']);
            /* $usuario = $this->usuario_model->getUserTokenAcs($mail);
              if (!empty($usuario)) {
              $sessionData = array(
              'idUsuario' => $usuario[0]['idUsuario'],
              'username' => $usuario[0]['mail'],
              'tipoUsuario' => $usuario[0]['tipoUsuario']
              );
              $this->session->set_userdata($sessionData);
              //redirect('mipanel/calificarByMail/'.$idActividad);
              } */
            $this->load->model('login_model');
            $logged = $this->login_model->isLogged($mail);
            if ($logged) {
                $data['mensaje'] = "<script>
                    window.location.href = '$metodo';
                        </script>";
            } else {
                $unsetData = array('username' => '', 'idUsuario' => '', 'tipoUsuario' => '');
                $this->session->unset_userdata($unsetData);
                $data['mensaje'] = "<script>
                $(document).ready(function() {\$('.simple-ajax-popup').magnificPopup('open')
                });
                </script>";
                $this->session->set_userdata(array('url' => $metodo));
            }
            $this->load->view('header');
            $this->load->view('mensajes', $data);
            $this->load->view('footer');
        }
    }

}

/* End of file welcome.php */
    /* Location: ./application/controllers/welcome.php */