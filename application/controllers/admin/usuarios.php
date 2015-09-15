<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Usuarios extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->model('usuario_model');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->library('table');
    }

    public function index() {

        $data['usuarios'] = $this->usuario_model->showPerfil();
        $this->load->view('admin/header');
        $this->load->view('admin/buscador');
        $this->load->view('admin/usuarios', $data);
        $this->load->view('admin/footer');
    }

    public function listarUsuarios($perfil = null) {
        $data['usuarios'] = $this->usuario_model->showPerfil($perfil);
        $this->load->view('admin/header');
        $this->load->view('admin/buscador');
        $this->load->view('admin/usuarios', $data);
        $this->load->view('admin/footer');
    }

    public function buscar() {
        $data['usuarios'] = $this->usuario_model->searchUserLike($this->input->post('buscador'));
        $this->load->view('admin/header');
        $this->load->view('admin/buscador');
        $this->load->view('admin/usuarios', $data);
        $this->load->view('admin/footer');
    }

    public function add() {
        $query = $this->db->get('tipoUsuario');
        $data['tipo_usuario'] = $query->result_array();

        //viene post
        if ($_POST) {

            $this->form_validation->set_rules('mail', 'Mail', 'required|valid_email');
            $this->form_validation->set_rules('nombre', 'Nombre', 'required');
            $this->form_validation->set_rules('apellidoPaterno', 'Apellido', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required|matches[passwordVerificacion]');
            $this->form_validation->set_rules('passwordVerificacion', 'Password', 'required');

            if ($this->form_validation->run() == FALSE) {
                $data['mail'] = $this->input->post('mail');
                $data['nombre'] = $this->input->post('nombre');
                $data['apellidoPaterno'] = $this->input->post('apellidoPaterno');
                $data['apellidoMaterno'] = $this->input->post('apellidoMaterno');
                $this->load->view('admin/header');
                $this->load->view('admin/usuarios_add', $data);
                $this->load->view('admin/footer');
            } else {
                $data = array(
                    'mail' => $this->input->post('mail'),
                    'nombre' => $this->input->post('nombre'),
                    'apellidoPaterno' => $this->input->post('apellidoPaterno'),
                    'apellidoMaterno' => $this->input->post('apellidoMaterno'),
                    'password' => md5($this->input->post('password')),
                    'fbid' => '',
                    'avatar' => '',
                    'tipoUsuario' => $this->input->post('tipo_usuario'),
                );
                $this->usuario_model->add($data);
                redirect('admin/usuarios');
            }
        } else {

            $this->load->view('admin/header');
            $this->load->view('admin/usuarios_add', $data);
            $this->load->view('admin/footer');
        }
    }

    public function edit($id) {
        //viene post
        if ($_POST) {

            $this->form_validation->set_rules('mail', 'Mail', 'required|valid_email');
            $this->form_validation->set_rules('nombre', 'Nombre', 'required');
            $this->form_validation->set_rules('apellidoPaterno', 'Apellido', 'required');

            if ($this->form_validation->run() == FALSE) {
                $data['mail'] = $this->input->post('mail');
                $data['nombre'] = $this->input->post('nombre');
                $data['apellidoPaterno'] = $this->input->post('apellidoPaterno');
                $data['apellidoMaterno'] = $this->input->post('apellidoMaterno');
                $data['usuarios'] = $this->usuario_model->getUserData($id);
                $this->load->view('admin/header');
                $this->load->view('admin/usuarios_edit', $data);
                $this->load->view('admin/footer');
            } else {
                $data = array(
                    'idUsuario' => $this->input->post('idUsuario'),
                    'mail' => $this->input->post('mail'),
                    'nombre' => $this->input->post('nombre'),
                    'apellidoPaterno' => $this->input->post('apellidoPaterno'),
                    'apellidoMaterno' => $this->input->post('apellidoMaterno'),
                    'fbid' => $this->input->post('fbid'),
                    'avatar' => $this->input->post('avatar'),
                );
                $this->usuario_model->edit($data);
                redirect('admin/usuarios');
            }
        } else {

            $data['usuarios'] = $this->usuario_model->getUserData($id);
            if ($data['usuarios'][0]['tipoUsuario'] == 2)
                redirect('admin/chefs/edit/' . $id);
            $this->load->view('admin/header');
            $this->load->view('admin/usuarios_edit', $data);
            $this->load->view('admin/footer');
        }
    }

    public function del($id) {

        if ($this->db->delete('usuario', array('idUsuario' => $id))) {
            $this->index();
        }
    }

    public function chgStatus($id, $status) {
        $this->usuario_model->edit(array('idUsuario' => $id, 'estado' => $status));
        $this->index();
    }

    public function view($id) {
        $personalData = $this->usuario_model->getUserData($id);
        if ($personalData[0]['tipoUsuario'] == 2)
            redirect('admin/chefs/view/' . $id);
        $this->load->model('mensaje_model');
        $this->load->model('pago_model');
        $this->load->model('actividad_model');
        $data['datos_usuario'] = $personalData[0];
        $data['reclamos'] = $this->mensaje_model->mensajesUsuario($id, 1);
        $data['pagos'] = $this->pago_model->pagosUsuario($id);
        $data['actividades'] = $this->actividad_model->actividadesUsuario('idUsuarioCliente', $id);

        $this->load->view('admin/header');
        $this->load->view('admin/usuarios_view', $data);
        $this->load->view('admin/listar_actividades', $data);
        $this->load->view('admin/listar_pagos', $data);
        $this->load->view('admin/listar_reclamos', $data);

        $this->load->view('admin/footer');
    }

}
