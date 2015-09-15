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
    }

    public function index() {
        if (!isset($this->session->userdata['tipoUsuario']) OR ($this->session->userdata['tipoUsuario'] != 1)) {
            redirect('admin/login');
        } else {
            redirect('admin/usuarios');
        }
    }

}
