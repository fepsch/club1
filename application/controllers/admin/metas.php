<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Metas extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->model('meta_model');
        $this->load->library('session');
        $this->load->library('form_validation');
    }

    public function listarMetasChef() {
        $data['metas'] = $this->meta_model->getMetaChef();
        $this->load->view('admin/header');
        $this->load->view('admin/listar_metas_chef', $data);
        $this->load->view('admin/footer');
    }

    public function listarMetasCalificacion() {
        $data['metas'] = $this->meta_model->getMetasCalificacion();
        $this->load->view('admin/header');
        $this->load->view('admin/listar_metas_calificacion', $data);
        $this->load->view('admin/footer');
    }

    public function listarMetasPorTipo($idTipo) {
        $data['metas'] = $this->meta_model->getMetasByTipo($idTipo);
        $data['tipo'] = $idTipo;
        $this->load->view('admin/header');
        $this->load->view('admin/listar_metas_por_tipo', $data);
        $this->load->view('admin/footer');
    }

    public function add($id = null) {

        if ($_POST) {
            $this->form_validation->set_rules('nombre', 'Nombre', 'required|callback_meta_unique');
            $this->form_validation->set_rules('requerido', 'Requerido', '');
            //if(isset($_POST['requerido']))
            $data['nombre'] = $this->input->post('nombre');
            $data['tipoMeta'] = $id;
            if ($this->input->post('requerido'))
                $data['requerido'] = 1;

            if ($this->form_validation->run() == FALSE) {
                $this->load->view('admin/header');
                $this->load->view('admin/meta_add', $data);
                $this->load->view('admin/footer');
            } else {
                $data['nombre'] = $this->functions->meta_a_bd($data['nombre']);
                $this->meta_model->add($data);
                $this->listarMetasChef();
            }
        } else {
            $this->load->view('admin/header');
            $this->load->view('admin/meta_add');
            $this->load->view('admin/footer');
        }
    }

    public function edit($id) {

        $query = $this->meta_model->getMeta($id);
        $data['meta'] = $query[0];
        $this->load->model('tipo_meta_model');
        $tiposMeta = $this->tipo_meta_model->getTiposMeta();

        $selectTiposMeta = array();
        foreach ($tiposMeta as $tipo) {
            $selectTiposMeta[$tipo['idTipoMeta']] = $tipo['nombreTipo'];
        }

        $data['tiposMeta'] = $selectTiposMeta;

        if ($_POST) {
            $this->form_validation->set_rules('nombre', 'Nombre', 'required|callback_meta_unique['.$id.']');
            $this->form_validation->set_rules('tipo', 'Tipo', 'required');
            //$this->form_validation->set_rules('publico', 'Indicar si es público', 'required');

            $data['meta']['nombreMeta'] = $this->input->post('nombre');
            $data['meta']['tipoMeta'] = $this->input->post('tipo');
            //$data['meta']['publico'] = $this->input->post('publico');
            if ($this->input->post('requerido')) {
                $data['meta']['requerido'] = 1;
            }

            if ($this->form_validation->run() == FALSE) {
                $this->load->view('admin/header');
                $this->load->view('admin/meta_edit', $data);
                $this->load->view('admin/footer');
            } else {
                $data['meta']['nombreMeta'] = $this->functions->meta_a_bd($data['meta']['nombreMeta']);
                $this->meta_model->update($data['meta']);
                $this->listarMetasChef();
            }
        } else {
            $this->load->view('admin/header');
            $this->load->view('admin/meta_edit', $data);
            $this->load->view('admin/footer');
        }
    }

    public function del($id) {
        $this->meta_model->delete($id);

        $this->listarMetasChef();
    }
    
    function meta_unique($str, $update = FALSE) {
        $dato = $this->functions->meta_a_bd($this->input->post('nombre'));
        if($this->meta_model->is_unique($dato, $update)) {
            return TRUE;
        } else {
            $this->form_validation->set_message('meta_unique', 'El %s ya se encuentra registrado');
            return FALSE;
        }
    }

}
?>
