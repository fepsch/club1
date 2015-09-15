<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Experiencias extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->model('experiencia_model');
        $this->load->library('session');
        $this->load->library('form_validation');
    }

    function index() {
        
    }

    function add($id) {
        $data['idChef'] = $id;
        if ($_POST) {
            $this->form_validation->set_rules('nombre', 'Nombre', 'required');
            $this->form_validation->set_rules('descripcion', 'Descripción', 'required');
            $this->form_validation->set_rules('tiempo2', 'Tiempo 2 Personas', 'required|greater_than[0]');
            $this->form_validation->set_rules('tiempo3', 'Tiempo 3 Personas', 'required|greater_than[0]');
            $this->form_validation->set_rules('tiempo4', 'Tiempo 4 Personas', 'required|greater_than[0]');
            $this->form_validation->set_rules('tiempo5', 'Tiempo 5 Personas', 'required|greater_than[0]');
            $this->form_validation->set_rules('tiempo6', 'Tiempo 6 Personas', 'required|greater_than[0]');
            $this->form_validation->set_rules('tiempo7', 'Tiempo 7 Personas', 'required|greater_than[0]');
            $this->form_validation->set_rules('tiempo8', 'Tiempo 8 Personas', 'required|greater_than[0]');
            $this->form_validation->set_rules('tiempo9', 'Tiempo 9 Personas', 'required|greater_than[0]');
            $this->form_validation->set_rules('tiempo10', 'Tiempo 10 Personas', 'required|greater_than[0]');
            $this->form_validation->set_rules('tiempo11', 'Tiempo 11 Personas', 'required|greater_than[0]');
            $this->form_validation->set_rules('tiempo12', 'Tiempo 12 Personas', 'required|greater_than[0]');
            $this->form_validation->set_rules('tiempo13', 'Tiempo 13 Personas', 'required|greater_than[0]');
            $this->form_validation->set_rules('tiempo14', 'Tiempo 14 Personas', 'required|greater_than[0]');

            $config['upload_path'] = getcwd() . '/images/experiencias/';
            $config['allowed_types'] = 'gif|png|jpg|jpeg';
            $this->load->library('upload', $config);
            if ($this->form_validation->run() == FALSE) {
                $data['error'] = $this->upload->display_errors();
                $this->load->view('admin/header');
                $this->load->view('admin/experiencia_add', $data);
            } else {
                $this->upload->do_upload('imagen');
                $fotoUp = $this->upload->data();
                $dataAdd = array(
                    'idUsuario' => $this->input->post('chef'),
                    'nombre' => $this->input->post('nombre'),
                    'descripcion' => $this->input->post('descripcion'),
                    'tiempo2' => $this->input->post('tiempo2'),
                    'tiempo3' => $this->input->post('tiempo3'),
                    'tiempo4' => $this->input->post('tiempo4'),
                    'tiempo5' => $this->input->post('tiempo5'),
                    'tiempo6' => $this->input->post('tiempo6'),
                    'tiempo7' => $this->input->post('tiempo7'),
                    'tiempo8' => $this->input->post('tiempo8'),
                    'tiempo9' => $this->input->post('tiempo9'),
                    'tiempo10' => $this->input->post('tiempo10'),
                    'tiempo11' => $this->input->post('tiempo11'),
                    'tiempo12' => $this->input->post('tiempo12'),
                    'tiempo13' => $this->input->post('tiempo13'),
                    'tiempo14' => $this->input->post('tiempo14'),
                    'imagen' => $fotoUp['file_name']
                );
                $this->experiencia_model->add($dataAdd);
                redirect('admin/chefs/view/' . $id);
            }
        } else {
            $this->load->view('admin/header');
            $this->load->view('admin/experiencia_add', $data);
        }
    }

    function view($id) {
        $this->load->model('plato_model');
        $experiencia = $this->experiencia_model->getExperiencia($id);
        $data['experiencia'] = $experiencia[0];
        $data['platos'] = $this->plato_model->getPlatosExperiencia($id);

        $this->load->view('admin/header');
        $this->load->view('admin/experiencia_view', $data);
        $this->load->view('admin/footer');
    }

    function edit($id) {
        $experiencia = $this->experiencia_model->getExperiencia($id);
        if ($_POST) {
            $this->form_validation->set_rules('nombre', 'Nombre', 'required');
            $this->form_validation->set_rules('descripcion', 'Descripción', 'required');
            $this->form_validation->set_rules('tiempo2', 'Tiempo 2 Personas', 'required|greater_than[0]');
            $this->form_validation->set_rules('tiempo3', 'Tiempo 3 Personas', 'required|greater_than[0]');
            $this->form_validation->set_rules('tiempo4', 'Tiempo 4 Personas', 'required|greater_than[0]');
            $this->form_validation->set_rules('tiempo5', 'Tiempo 5 Personas', 'required|greater_than[0]');
            $this->form_validation->set_rules('tiempo6', 'Tiempo 6 Personas', 'required|greater_than[0]');
            $this->form_validation->set_rules('tiempo7', 'Tiempo 7 Personas', 'required|greater_than[0]');
            $this->form_validation->set_rules('tiempo8', 'Tiempo 8 Personas', 'required|greater_than[0]');
            $this->form_validation->set_rules('tiempo9', 'Tiempo 9 Personas', 'required|greater_than[0]');
            $this->form_validation->set_rules('tiempo10', 'Tiempo 10 Personas', 'required|greater_than[0]');
            $this->form_validation->set_rules('tiempo11', 'Tiempo 11 Personas', 'required|greater_than[0]');
            $this->form_validation->set_rules('tiempo12', 'Tiempo 12 Personas', 'required|greater_than[0]');
            $this->form_validation->set_rules('tiempo13', 'Tiempo 13 Personas', 'required|greater_than[0]');
            $this->form_validation->set_rules('tiempo14', 'Tiempo 14 Personas', 'required|greater_than[0]');
            
            $this->form_validation->set_error_delimiters('<label class="error collapse">', '</label>');

            $config['upload_path'] = getcwd() . '/images/experiencias/';
            $config['allowed_types'] = 'gif|png|jpg|jpeg';
            if ($experiencia[0]['imagen'] != '') {
                $config['file_name'] = $experiencia[0]['imagen'];
                $config['overwrite'] = TRUE;
            }
            $this->load->library('upload', $config);
            if ($this->form_validation->run() == FALSE) {
                $data['error'] = $this->upload->display_errors();
                $this->load->view('admin/header');
                $this->load->view('admin/experiencia_add', $data);
                $this->load->view('admin/footer');
            } else {
                $this->upload->do_upload('imagen');
                $fotoUp = $this->upload->data();
                if($fotoUp['file_name'] == '')
                    $imagen = $experiencia[0]['imagen'];
                else
                    $imagen = $fotoUp['file_name'];
                $newData = array(
                    'idExperiencia' => $id,
                    'idUsuario' => $experiencia[0]['idUsuario'],
                    'nombre' => $this->input->post('nombre'),
                    'descripcion' => $this->input->post('descripcion'),
                    'tiempo2' => $this->input->post('tiempo2'),
                    'tiempo3' => $this->input->post('tiempo3'),
                    'tiempo4' => $this->input->post('tiempo4'),
                    'tiempo5' => $this->input->post('tiempo5'),
                    'tiempo6' => $this->input->post('tiempo6'),
                    'tiempo7' => $this->input->post('tiempo7'),
                    'tiempo8' => $this->input->post('tiempo8'),
                    'tiempo9' => $this->input->post('tiempo9'),
                    'tiempo10' => $this->input->post('tiempo10'),
                    'tiempo11' => $this->input->post('tiempo11'),
                    'tiempo12' => $this->input->post('tiempo12'),
                    'tiempo13' => $this->input->post('tiempo13'),
                    'tiempo14' => $this->input->post('tiempo14'),
                    'imagen' => $imagen
                );
                $this->experiencia_model->edit($newData);
                redirect('admin/experiencias/view/' . $id);
            }
        } else {
            $data['experiencia'] = $experiencia[0];
            $this->load->view('admin/header');
            $this->load->view('admin/experiencia_add', $data);
            $this->load->view('admin/footer');
        }
    }

}

?>
