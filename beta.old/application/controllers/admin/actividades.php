<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Actividades extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->model('actividad_model');
        $this->load->model('estado_model'); // se carga el modelo de estados para el combo del filtro
        $this->load->model('experiencia_model');
        $this->load->model('usuario_model');
        $this->load->library('session');
        $this->load->library('form_validation');
    }

    function index() {
        $this->load->view('admin/header');
        $this->load->view('admin/buscador_actividades');
        $this->load->view('admin/actividades');
        $this->load->view('admin/footer');
    }

    function listaActividades() {
        $condiciones = array();
        $inicio = Date('Y-m-d', strtotime("-7 days"));
        $fin = Date('Y-m-d', strtotime("+7 days"));
        $join = NULL;
        if ($_POST) {
            if(!empty($_POST['inicio']))
                $condiciones['fecha >= '] = date('Y-m-d', strtotime($this->input->post('inicio')));
            if(!empty($_POST['fin']))
                $condiciones['fecha <= '] = date('Y-m-d', strtotime($this->input->post('fin')));
            if(!empty($_POST['estado']))
                $condiciones['idEstado'] = $this->input->post('estado');
            if(!empty($_POST['chef'])) {
                $condiciones['experiencia.idUsuario'] = $this->input->post('chef');
                //$join = array('experiencia' ,'experiencia.idExperiencia=actividad.idExperiencia');
            }
        } else {
            //Se envían las fechas por defecto para mostrar la lista de actividades
            $condiciones['fecha >= '] = $inicio;
            $condiciones['fecha <= '] = $fin;
        }
        //Traemos las actividades según las condiciones (en este caso sólo la fecha)
        $filename = rand(0,100000000);
        $data['actividades'] = $this->actividad_model->showActividad($condiciones, $join, TRUE,$filename);
        $data['filename'] = $filename .'.csv';
        //descarga
         /*$csv = $this->dbutil->csv_from_result($query);
            if ( ! write_file('file.php', $csv,'w+'))
            {
                 echo 'Unable to write the file';
            }
            else
            {
                 echo 'File written!';
            }

*/
        //Traemos los estados desde la bd para cargarlos en el filtro por estado.
        $queryEstados = $this->estado_model->getEstado();
        $data['estados'] = $queryEstados;
        $this->load->model('usuario_model');
        $queryChefs = $this->usuario_model->showPerfil(2);
        $data['chefs'] = $queryChefs;
        //$this->actividad_model->getActividadFull();
        $this->load->view('admin/header');
        $this->load->view('admin/buscador_actividades', $data);
        $this->load->view('admin/actividades', $data);
        $this->load->view('admin/footer');
    }

    function view($id) {
        $actividad = $this->actividad_model->getActividad($id);
        $estado = $this->estado_model->getEstado($actividad[0]['idEstado']);
        $actividad[0]['estado'] = $estado[0]['nombre'];
        $usuario = $this->usuario_model->getUserData($actividad[0]['idUsuarioCliente']);
        $actividad[0]['usuario'] = $usuario[0];
        $experiencia = $this->experiencia_model->getExperiencia($actividad[0]['idExperiencia']);
        $actividad[0]['experiencia'] = $experiencia[0];
        $chef = $this->usuario_model->getUserData($experiencia[0]['idUsuario']);
        $actividad[0]['chef'] = $chef[0];
        $data['actividad'] = $actividad[0];
        $this->load->view('admin/header');
        $this->load->view('admin/actividades_view', $data);
        $this->load->view('admin/footer');
    }

    function edit($id) {

        $actividad = $this->actividad_model->getActividad($id);
        $estados = $this->estado_model->getEstado();
        $actividad[0]['estados'] = $estados;
        $usuario = $this->usuario_model->getUserData($actividad[0]['idUsuarioCliente']);
        $actividad[0]['usuario'] = $usuario[0];
        $experiencia = $this->experiencia_model->getExperiencia($actividad[0]['idExperiencia']);
        $actividad[0]['experiencia'] = $experiencia[0];
        $chef = $this->usuario_model->getUserData($experiencia[0]['idUsuario']);
        $actividad[0]['chef'] = $chef[0];
        //Se asigna al array $data para ser enviado a la vista
        $data['actividad'] = $actividad[0];

        //Se valida si la petición se genera desde un POST, de ser así, se modifican
        //los datos que se trajeron desde la base de datos con los del formulario para
        //ser validados y posteriormente almacenados de vuelta a la bd con las modificiones. 
        //En caso contrario, se envían los datos al formulario para ser modificados.
        if ($_POST) {
            $this->form_validation->set_rules('usuario', 'Cliente', 'required');
            $this->form_validation->set_rules('chef', 'Chef', 'required');
            $this->form_validation->set_rules('experiencia', 'Experiencia', 'required');
            $this->form_validation->set_rules('fecha', 'Fecha', 'required');
            $this->form_validation->set_rules('valor', 'Valor', 'required');
            $this->form_validation->set_rules('pasajeros', 'Pasajeros', 'required');
            $this->form_validation->set_rules('estado', 'Estado', 'required');


            if ($this->form_validation->run() == FALSE) {
                $this->load->view('admin/header');
                $this->load->view('admin/actividades_edit');
                $this->load->view('admin/footer');
            } else {
                $newData = array(
                    'idActividad' => $id,
                    'fecha' => $this->functions->dateMySql($this->input->post('fecha')),
                    'valor' => $this->input->post('valor'),
                    'pasajeros' => $this->input->post('pasajeros'),
                    'idEstado' => $this->input->post('estado'),
                    'comentarioActividad' => $this->input->post('comentarioActividad')
                );
                $this->actividad_model->update($newData);
                redirect('admin/actividades/view/'.$id);
            }
        } else {
            $this->load->view('admin/header');
            $this->load->view('admin/actividades_edit', $data);
            $this->load->view('admin/footer');
        }
    }
    
    function del($id) {
        if($this->actividad_model->delete($id))
            $this->index();
    }
}

?>
