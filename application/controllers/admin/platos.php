<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Platos extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->model('plato_model');
        $this->load->library('session');
        $this->load->library('form_validation');
    }

    function index() {
        
    }

    function add($id) {
        $data['idExperiencia'] = $id;
        if ($_POST) {
            $this->form_validation->set_rules('nombre', 'Nombre', 'required');
            $this->form_validation->set_rules('descripcion', 'Descripción', 'required');

            $config['upload_path'] = getcwd() . '/images/platos/';
            $config['allowed_types'] = 'gif|png|jpg|jpeg';
            $this->load->library('upload', $config);
            if ($this->form_validation->run() == FALSE OR !$this->upload->do_upload('imagen')) {
                $data['error'] = $this->upload->display_errors();
                $this->load->view('admin/header');
                $this->load->view('admin/plato_add', $data);
            } else {
                $fotoUp = $this->upload->data();
                $dataAdd = array(
                    'idExperiencia' => $this->input->post('experiencia'),
                    'nombre' => $this->input->post('nombre'),
                    'descripcion' => $this->input->post('descripcion'),
                    'imagen' => $fotoUp['file_name']
                );
                $this->plato_model->add($dataAdd);
                redirect('admin/experiencias/view/'.$id);
            }
        } else {
            $this->load->view('admin/header');
            $this->load->view('admin/plato_add', $data);
        }
    }
    
    public function edit($id) {
        $plato = $this->plato_model->getPlato($id);
        $data['plato'] = $plato[0];
        $data['idExperiencia'] = $plato[0]['idExperiencia'];
        if ($_POST) {
            $this->form_validation->set_rules('nombre', 'Nombre', 'required');
            $this->form_validation->set_rules('descripcion', 'Descripción', 'required');

            $config['upload_path'] = getcwd() . '/images/platos/';
            $config['allowed_types'] = 'gif|png|jpg|jpeg';
            if ($plato[0]['imagen'] != '') {
                $config['file_name'] = $plato[0]['imagen'];
                $config['overwrite'] = TRUE;
            }
            $this->load->library('upload', $config);
            if ($this->form_validation->run() == FALSE) {
                $data['error'] = $this->upload->display_errors();
                $this->load->view('admin/header');
                $this->load->view('admin/plato_add', $data);
            } else {
                $this->upload->do_upload('imagen');
                $fotoUp = $this->upload->data();
                if($fotoUp['file_name'] == '')
                    $imagen = $plato[0]['imagen'];
                else
                    $imagen = $fotoUp['file_name'];
                $dataAdd = array(
                    'idPlato' => $id,
                    'idExperiencia' => $this->input->post('experiencia'),
                    'nombre' => $this->input->post('nombre'),
                    'descripcion' => $this->input->post('descripcion'),
                    'imagen' => $imagen
                );
                $this->plato_model->edit($dataAdd);
                redirect('admin/experiencias/view/'.$data['idExperiencia']);
            }
        } else {
            $this->load->view('admin/header');
            $this->load->view('admin/plato_add', $data);
        }
    }

}

?>
