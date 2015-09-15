<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Periodos extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->model('periodos_model');
        $this->load->library('session');
        $this->load->library('form_validation');
    }

    function index() {
        $periodos = $this->periodos_model->get();
        $data['periodos'] = $periodos;
        $this->load->view('admin/header');
        
        $this->load->view('admin/periodos', $data);
        $this->load->view('admin/footer');
    }

    function add() {
        if ($_POST) {
            $this->form_validation->set_rules('inicio', 'Hora Inicio', 'required');
            $this->form_validation->set_rules('fin', 'Hora Tope', 'required');
            if ($this->form_validation->run() != FALSE) {
                $newData = array(
                    'inicio' => date('H:i:s', strtotime($this->input->post('inicio'))),
                    'fin' => date('H:i:s', strtotime($this->input->post('fin')))
                );
                $this->periodos_model->add($newData);
                redirect('admin/periodos');
            }
        }
        $this->load->view('admin/header');
        $this->load->view('admin/periodos_form');
        $this->load->view('admin/footer');
    }
    
    function edit($id) {
        if ($_POST) {
            $this->form_validation->set_rules('inicio', 'Hora Inicio', 'required');
            $this->form_validation->set_rules('fin', 'Hora Tope', 'required');
            if ($this->form_validation->run() != FALSE) {
                $newData = array(
                    'idPeriodo' => $id,
                    'inicio' => date('H:i:s', strtotime($this->input->post('inicio'))),
                    'fin' => date('H:i:s', strtotime($this->input->post('fin')))
                );
                $this->periodos_model->update($newData);
                redirect('admin/periodos');
            }
        }
        $periodo = $this->periodos_model->get($id);
        $data['periodo'] = $periodo[0];
        $this->load->view('admin/header');
        $this->load->view('admin/periodos_form', $data);
        $this->load->view('admin/footer');
    }

    function del($id){
        if($this->periodos_model->periodoActivo($id)){
            $data['error'] = "NO SE HA PODIDO ELIMINAR EL PERIODO";
        }
        else{
            $this->periodos_model->del($id);
            $data['error'] = "PERIODO ELIMINADO CON EXITO";
        }

        $periodos = $this->periodos_model->get();
        $data['periodos'] = $periodos;
        $this->load->view('admin/header');
        
        $this->load->view('admin/periodos', $data);
        $this->load->view('admin/footer');
    }



}

?>
