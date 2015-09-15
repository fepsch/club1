<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mipanel extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->model('actividad_model');
        $this->load->model('usuario_model');
        $this->load->model('meta_usuario_model');
        $this->load->model('periodos_model');
        $this->load->model('mensaje_model');
        if (!isset($this->session->userdata['username']))
            redirect('home');
    }
    
    public function index() {
        redirect('mipanel/reservas');
    }

    public function reservas() {
        $actividades = $this->actividad_model->actividadesUsuario($this->session->userdata['idUsuario']);
        $this->load->model('experiencia_model');
        $this->load->model('estado_model');
        $this->load->model('evaluacion_model');
        foreach ($actividades as &$actividad) {
            $experiencia = $this->experiencia_model->getExperiencia($actividad['idExperiencia']);
            $chef = $this->usuario_model->getUserData($experiencia[0]['idUsuario']);
            $estado = $this->estado_model->getEstado($actividad['idEstado']);
            $actividad['experiencia'] = array('nombre' => $experiencia[0]['nombre'], 'id' => $experiencia[0]['idExperiencia']);
            $actividad['chef']['nombre'] = trim($chef[0]['nombre'] . ' ' . $chef[0]['apellidoPaterno'] . ' ' . $chef[0]['apellidoMaterno']);
            $actividad['chef']['avatar'] = $chef[0]['avatar'];
            $actividad['estado'] = $estado[0]['nombre'];
            $actividad['evaluada'] = $this->evaluacion_model->actividadEvaluada($actividad['idActividad']);
        }
        $data['actividades'] = $actividades;

        $this->load->view('header');
        $this->load->view('mipanel/reservas', $data);
        $this->load->view('footer');
    }

    public function perfil() {
        $result = $this->usuario_model->getUser($this->session->userdata['username']);
        $data['usuario'] = $result[0];
        $this->session->set_userdata('idUsuario', $data['usuario']['idUsuario']);
        if ($_POST) {
            $this->form_validation->set_rules('mail', 'Mail', 'required|valid_email');
            $this->form_validation->set_rules('nombre', 'Nombre', 'required');
            $this->form_validation->set_rules('aPaterno', 'Apellido Paterno', 'required');
            $this->form_validation->set_rules('aMaterno', 'Apellido Materno', 'required');
            $this->form_validation->set_rules('password', 'Password', 'matches[passwordVerificacion]');
            $this->form_validation->set_rules('passwordVerificacion', 'Repetir Password', '');

            $config['upload_path'] = getcwd() . '/avatar/';
            $config['allowed_types'] = 'gif|png|jpg|jpeg';
            if ($data['usuario']['avatar'] != '') {
                $config['file_name'] = $data['usuario']['avatar'];
                $config['overwrite'] = TRUE;
            }

            $this->load->library('upload', $config);
            if ($this->form_validation->run() == FALSE) {
                $data['error'] = $this->upload->display_errors();
                $this->load->view('header');
                $this->load->view('mipanel/perfil', $data);
                $this->load->view('footer');
            } else {
                $password = '';
                if ($this->input->post('password') != '')
                    $password = md5($this->input->post('password'));
                else
                    $password = $data['usuario']['password'];
                $this->upload->do_upload('avatar');
                $fotoUp = $this->upload->data();
                if ($fotoUp['file_name'] == '')
                    $imagen = $data['usuario']['avatar'];
                else
                    $imagen = $fotoUp['file_name'];
                $newData = array(
                    'idUsuario' => $this->session->userdata('idUsuario'),
                    'nombre' => $this->input->post('nombre'),
                    'apellidoPaterno' => $this->input->post('aPaterno'),
                    'apellidoMaterno' => $this->input->post('aMaterno'),
                    'mail' => $this->input->post('mail'),
                    'password' => $password,
                    'avatar' => $imagen,
                    'fechaNacimiento' => $this->input->post('fechanac')
                );
                $this->usuario_model->edit($newData);
                $result = $this->usuario_model->getUserData($this->session->userdata['idUsuario']);
                $data['usuario'] = $result[0];
                $this->load->view('header');
                $this->load->view('mipanel/perfil', $data);
                $this->load->view('footer');
            }
        } else {
            $this->load->view('header');
            $this->load->view('mipanel/perfil', $data);
            $this->load->view('footer');
        }
    }

    public function inbox() {
        $this->cargaDatosCarrusel('inbox');
        $this->load->view('header');
        $this->load->view('mipanel/inbox');
        $this->load->view('footer');
    }

    private function cargaDatosCarrusel($seccion = null) {
        if ($seccion == 'inbox-chef' OR $seccion == 'comentarios') {
            $actividades = $this->actividad_model->actividadesChef($this->session->userdata('idUsuario'));
            foreach ($actividades as &$actividad) {
                $cliente = $this->usuario_model->getUserData($actividad['idUsuarioCliente']);
                $actividad['usuario'] = $cliente[0];
            }
        } else if($seccion == 'calificacion'){
            $actividades = $this->actividad_model->actividadesUsuario($this->session->userdata('idUsuario'), 5);
            $this->load->model('experiencia_model', 'experiencia');
            $this->load->model('evaluacion_model');
            foreach ($actividades as &$actividad) {
                $exp = $this->experiencia->getExperiencia($actividad['idExperiencia']);
                $eval = $this->evaluacion_model->actividadEvaluada($actividad['idActividad']);
                $actividad['evaluada'] = $eval;
                $chef = $this->usuario_model->getUserData($exp[0]['idUsuario']);
                $actividad['usuario'] = $chef[0];
            }
        } else {
            $actividades = $this->actividad_model->actividadesUsuario($this->session->userdata('idUsuario'));
            $this->load->model('experiencia_model', 'experiencia');
            foreach ($actividades as &$actividad) {
                $exp = $this->experiencia->getExperiencia($actividad['idExperiencia']);
                $chef = $this->usuario_model->getUserData($exp[0]['idUsuario']);
                $actividad['usuario'] = $chef[0];
            }
        } 
        $this->load->vars(array(
            'actividades' => $actividades,
            'seccion' => $seccion,
        ));
    }

    public function mensajesActividad($id) {
        $usuario = $this->usuario_model->getUser($this->session->userdata('username'));
        $data['avatarUser'] = $usuario[0]['avatar'];
        if ($_POST) {
            $this->form_validation->set_rules('nvomensaje', 'Mensaje', 'required');
            if ($this->form_validation->run() == FALSE) {
                $data['mensajes'] = $this->mensaje_model->mensajesActividad($id);
                $this->output->set_output($this->load->view('mipanel/mensajes', $data, true));
                return false;
            } else {
                $mensaje = array(
                    'contenido' => $this->input->post('nvomensaje'),
                    'idUsuario' => $this->session->userdata('idUsuario'),
                    'fecha' => date('Y-m-d H:i:s', time()),
                    'idActividad' => $id
                );
                $this->mensaje_model->add($mensaje);
                $data['mensajes'] = $this->mensaje_model->mensajesActividad($id);
                $this->output->set_output($this->load->view('mipanel/mensajes', $data, true));
            }
        } else {
            $data['mensajes'] = $this->mensaje_model->mensajesActividad($id);
            $this->output->set_output($this->load->view('mipanel/mensajes', $data, true));
        }
    }

    public function calificaciones($id = FALSE) {
        $this->load->view('header');
        $this->cargaDatosCarrusel('calificacion');
        $this->load->view('mipanel/calificaciones');
        $this->load->view('footer');
    }

    public function calificacionesActividad($id, $noajax = NULL) {
        $this->load->model('evaluacion_model');
        $this->load->model('experiencia_model');
        $comentario = $this->mensaje_model->comentariosActividad($id);
        $actividad = $this->actividad_model->getActividad($id);
        $experiencia = $this->experiencia_model->getExperiencia($actividad[0]['idExperiencia']);
        $queryChef = $this->usuario_model->getUserData($experiencia[0]['idUsuario']);
        $data['actividad'] = $actividad[0];
        $data['comentario'] = $comentario;
        $data['experiencia'] = $experiencia[0];
        $data['chef'] = $queryChef[0];
        $data['metasEval'] = $this->evaluacion_model->getEvalActividad($id);
        if ($noajax == NULL)
            $this->output->set_output($this->load->view('mipanel/calificar', $data, true));
        else
            $this->load->view('mipanel/calificar', $data);
    }

    //TODO calificarByMail
    public function calificarByMail($idActividad = NULL, $noajax = NULL) {
        if ($idActividad !== NULL) {
            /* $this->load->view('header');
              $this->cargaDatosCarrusel('calificacion');
              $this->calificacionesActividad($idActividad, 'noajax');
              $this->load->view('footer'); */
        }
    }

    public function guardaCalificacion() {
        if ($_POST) {
            $this->load->model('evaluacion_model');
            $data = array(
                'idActividad' => $_POST['idActividad'],
                'idMeta' => $_POST['idMeta'],
                'nota' => $_POST['nota'],
                'fecha' => date('Y-m-d H:i:s', time())
            );
            $this->evaluacion_model->addOrUpdate($data);
        }
    }

    public function guardaComentario() {
        if ($_POST) {
            $data = array(
                'idActividad' => $_POST['idActividad'],
                'contenido' => $_POST['comentario'],
                'idUsuario' => $this->session->userdata('idUsuario'),
                'fecha' => date('Y-m-d H:i:s', time()),
                'comentario' => 1,
                'reclamo' => 0
            );
            $this->mensaje_model->addOrUpdate($data);
        }
    }

    public function msjesParaChef() {
        if ($this->session->userdata('tipoUsuario') == 2) {
            $this->load->view('header');
            $this->cargaDatosCarrusel('inbox-chef');
            $this->load->view('mipanel/inbox');
        } else {
            $this->load->view('index.html');
        }
    }

    public function comentarios() {
        if ($this->session->userdata('tipoUsuario') == 2) {
            $queryComentarios = $this->mensaje_model->comentariosParaChef($this->session->userdata('idUsuario'));
            foreach ($queryComentarios as &$comentario) {
                $usuario = $this->usuario_model->getUserData($comentario['idUsuario']);
                $comentario['usuario'] = $usuario[0];
            }
            $data['comentarios'] = $queryComentarios;
            $this->load->view('header');
            $this->load->view('mipanel/comentarios', $data);
            $this->load->view('footer');
        } else {
            $this->load->view('index.html');
        }
    }

    public function verExperiencia($id) {
        $this->load->model('experiencia_model');
        $experiencia = $this->experiencia_model->getExperiencia($id);
        $this->load->model('plato_model');
        $experiencia[0]['platos'] = $this->plato_model->getPlatosExperiencia($id);
        $data['experiencia'] = $experiencia[0];
        $this->load->view('mipanel/ver_experiencia', $data);
    }

}