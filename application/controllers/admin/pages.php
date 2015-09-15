<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pages extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->model('page_model');
        $this->load->library('session');
        $this->load->library('form_validation');
    }

    public function index() {
        $data['pages'] = $this->page_model->getPage();
        $this->load->view('admin/header');
        $this->load->view('admin/pages', $data);
        $this->load->view('admin/footer');
    }

    public function add() {
        //print_r($this->session->userdata);
        //viene post
        if ($_POST) {

            $this->form_validation->set_rules('titulo', 'Titulo', 'required');
            $this->form_validation->set_rules('bajada', 'Bajada', '');
            $this->form_validation->set_rules('contenido', 'Contenido', '');

            if ($this->form_validation->run() == FALSE) {
                $data['titulo'] = $this->input->post('titulo');
                $data['bajada'] = $this->input->post('bajada');
                $data['contenido'] = $this->input->post('contenido');
                $this->load->view('admin/pages_add', $data);
            } else {
                $data = array(
                    'titulo' => $this->input->post('titulo'),
                    'bajada' => $this->input->post('bajada'),
                    'contenido' => $this->input->post('contenido'),
                    'idUsuario' => $this->session->userdata['idUsuario'],
                );
                $this->page_model->add($data);
                redirect('/admin/pages');
            }
        } else {

            $this->load->view('admin/header');
            $this->load->view('admin/pages_add');
            $this->load->view('admin/footer');
        }
    }

    public function edit($id) {
        //viene post
        if ($_POST) {

            $this->form_validation->set_rules('titulo', 'Titulo', 'required');
            $this->form_validation->set_rules('bajada', 'Bajada', '');
            $this->form_validation->set_rules('contenido', 'Contenido', '');

            if ($this->form_validation->run() == FALSE) {
                $data['titulo'] = $this->input->post('titulo');
                $data['bajada'] = $this->input->post('bajada');
                $data['contenido'] = $this->input->post('contenido');
                $data['idPage'] = $id;

                $this->load->view('admin/header');
                $this->load->view('admin/pages_edit', $data);
                $this->load->view('admin/footer');
            } else {
                $data = array(
                    'titulo' => $this->input->post('titulo'),
                    'bajada' => $this->input->post('bajada'),
                    'contenido' => $this->input->post('contenido'),
                    'idPage' => $id,
                );
                $this->page_model->edit($data);
                redirect('admin/pages');
            }
        } else {

            $data['pages'] = $this->page_model->getPage($id);
            $this->load->view('admin/header');
            $this->load->view('admin/pages_edit', $data);
            $this->load->view('admin/footer');
        }
    }

    public function del($id) {
        $this->page_model->delete($id);
        $this->index();
    }

}