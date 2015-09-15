<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Actividad extends CI_Controller { 
    
    public function __construct() {
        parent::__construct();
        $this->load->model('evaluacion_model');
        $this->load->model('actividad_model');
    }
    
    public function cierraCalificacion($id) {
        $evaluaciones = array();
        foreach($this->input->post() as $k => $v){
            if($v == "") {
                $v = 1;
            }
            $evaluaciones[] = array(
                'idActividad' => $id,
                'idMeta' => $k,
                'nota' => $v
            );
        }
        
        $this->evaluacion_model->insertBatch($evaluaciones);
        $this->actividad_model->update(array('idActividad' => $id, 'evaluacion' => 1));
    }
}