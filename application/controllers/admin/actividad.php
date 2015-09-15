<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Actividad extends CI_Controller{
        
        function __construct() {
            parent::__construct();
            $this->load->helper('form');
            $this->load->helper('url');
            $this->load->model('actividad_model');
            $this->load->library('session'); 
            $this->load->library('form_validation'); 
        }
        
        function index(){
            $this->load->view('admin/header');
            
            $this->load->view('admin/actividades');
            $this->load->view('admin/footer');
        }
        
        function listaActividades(){
            
            $data['actividades'] = $this->actividad_model->showActividad(array());
            $this->load->view('admin/actividades', $data);
            
        }
    }
?>
