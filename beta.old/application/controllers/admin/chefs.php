<?php

include('usuarios.php');

class Chefs extends Usuarios {

    public function __construct() {
        parent::__construct();
        $this->load->model('experiencia_model');
        $this->load->model('meta_model');
        $this->load->model('agenda_chef_model');
    }

    function experienciasChef($id) {
        $data['experiencias'] = $this->experiencia_model->getExperienciasChef($id);
        $this->load->view('admin/header');
        $this->load->view('admin/buscador');
        $this->load->view('admin/chef_view', $data);
        $this->load->view('admin/footer');
    }

    public function view($id) {
        $this->load->model('mensaje_model');
        $this->load->model('pago_model');
        $this->load->model('actividad_model');
        $this->load->model('experiencia_model');
        $this->load->model('meta_usuario_model');
        $metasChef = $this->meta_usuario_model->getMetaUsuario($id, 2);
        $parametrosChef = $this->meta_usuario_model->getMetaUsuario($id, 6);

        $personalData = $this->usuario_model->getUserData($id);
        $data['datos_usuario'] = $personalData[0];
        $data['metasChef'] = $metasChef;
        $data['parametros_chef'] = $parametrosChef;
        $data['periodos'] = $this->agenda_chef_model->agendaChef($id);
        $data['reclamos'] = $this->mensaje_model->mensajesUsuario($id, 1);
        $data['reclamos_recibidos'] = $this->mensaje_model->mensajesParaChef($id, 1);
        $data['pagos'] = $this->pago_model->pagosUsuario($id);
        $data['actividades'] = $this->actividad_model->actividadesUsuario($id);
        $data['actividades_chef'] = $this->actividad_model->actividadesChef($id);
        $data['experiencias'] = $this->experiencia_model->getExperienciasChef($id);

        $this->load->view('admin/header');
        $this->load->view('admin/usuarios_view', $data);
        $this->load->view('admin/metas_chef_view', $data);
        $this->load->view('admin/listar_calendario', $data);
        $this->load->view('admin/listar_experiencias', $data);
        $this->load->view('admin/listar_actividades', $data);
        $this->load->view('admin/listar_actividades_chef', $data);
        $this->load->view('admin/listar_pagos', $data);
        //$this->load->view('admin/listar_reclamos_chef', $data);
        //$this->load->view('admin/listar_reclamos', $data);
        $this->load->view('admin/footer');
    }

    public function add() {
        //$data['metas'] = $this->meta_model->getMetaChef();
        $data['datosPersonales'] = $this->meta_model->getMetaChef(2);
        $data['parametrosText'] = $this->meta_model->getMetaChef(6);
        $data['parametrosCheck'] = $this->meta_model->getMetaChef(7);
        $data['comunas'] = $this->meta_model->getMetaChef(3);
        $data['tags'] = $this->meta_model->getMetaChef(4);
        $query = $this->db->get('tipoUsuario');
        $data['tipo_usuario'] = $query->result_array();

        //viene post
        if ($_POST) {
            $this->form_validation->set_rules('mail', 'Mail', 'required|valid_email');
            $this->form_validation->set_rules('nombre', 'Nombre', 'required');
            $this->form_validation->set_rules('apellidoPaterno', 'Apellido', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required|matches[passwordVerificacion]');
            $this->form_validation->set_rules('passwordVerificacion', 'Password', 'required');

            $this->setDumbValidations($data['datosPersonales'], 'text');
            $this->setDumbValidations($data['parametrosText'], 'text');
            $this->setDumbValidations($data['parametrosCheck']);
            $this->setDumbValidations($data['comunas']);
            $this->setDumbValidations($data['tags']);

            if ($this->form_validation->run() == FALSE) {

                $this->load->view('admin/header');
                $this->load->view('admin/chef_add', $data);
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
                    'tipoUsuario' => 2,
                );

                $this->usuario_model->add($data);
                $userCreado = $this->usuario_model->getInsertedId();

                $arrayDescripcion = $this->input->post('descripcion_personal');
                foreach ($arrayDescripcion as $idMeta => $value) {
                    $metaChef[] = array(
                        'idUsuario' => $userCreado,
                        'idMeta' => $idMeta,
                        'dato' => $value
                    );
                }

                $arrayComunas = $this->input->post('Comuna');
                foreach ($arrayComunas as $idMeta => $value) {
                    $metaChef[] = array(
                        'idUsuario' => $userCreado,
                        'idMeta' => $value,
                        'dato' => $value
                    );
                }

                $arrayTags = $this->input->post('Tag');
                foreach ($arrayTags as $idMeta => $value) {
                    $metaChef[] = array(
                        'idUsuario' => $userCreado,
                        'idMeta' => $value,
                        'dato' => $value
                    );
                }

                $this->load->model('meta_model');
                $this->meta_model->addMetaChef($metaChef);

                $arrayPeriodos = $this->input->post('horarios');
                foreach ($arrayPeriodos as $periodo) {
                    $newData = array(
                        'idChef' => $id,
                        'idPeriodo' => $periodo
                    );
                    $this->agenda_chef_model->add($newData);
                }
                redirect('admin/usuarios');
            }
        } else {

            $this->load->view('admin/header');
            $this->load->view('admin/chef_add', $data);
            $this->load->view('admin/footer');
        }
    }

    private function setDumbValidations($metas, $tipo = NULL) {
        foreach ($metas as $meta) {
            $nombreMeta = $meta['nombreTipo'] . '[]';
            if ($tipo === 'text') {
                $nombreMeta = str_replace(' ', '_', strtolower($meta['nombreTipo'] . '[' . $meta['idMetaKey'] . ']'));
            }
            if (isset($meta['requerido'])) {
                $required = 'required';
            } else {
                $required = '';
            }
            if ($meta['idMetaKey'] == 5) {
                if ($required != '')
                    $required .= '|callback_formato_rango';
                else
                    $required = 'callback_formato_rango';
            }
            $this->form_validation->set_rules($nombreMeta, $meta['nombreMeta'], $required);
        }
    }

    function formato_rango($str) {
        $min_max = explode('-', $str);
        if (count($min_max) > 1 && count($min_max) < 3) {
            $icero = (int) $min_max[0];
            $iuno = (int) $min_max[1];
            if (min($icero, $iuno) < 2 OR max($icero, $iuno) > 14) {
                $this->form_validation->set_message('formato_rango', 'El rango para el campo %s debe ser desde 2 hasta 14');
                return FALSE;
            } else if ($icero != 0 && $iuno != 0) {
                return TRUE;
            } else {
                $this->form_validation->set_message('formato_rango', 'Los límites del campo %s no pueden ser el número cero');
                return FALSE;
            }
        } else {
            $this->form_validation->set_message('formato_rango', 'El campo %s tiene un formato erroneo');
            return FALSE;
        }
    }

    public function edit($id) {
        $this->load->model('meta_usuario_model');
        //$data['metas'] = $this->meta_model->getMetaChef();
        $chef = $this->usuario_model->getUserData($id);
        $data['chef'] = $chef[0];
        $datosPersonales = $this->meta_usuario_model->getMetaUsuario($id, 2);
        $data['datosPersonales'] = $this->setNombreTipo($datosPersonales, 2);
        $parametrosText = $this->meta_usuario_model->getMetaUsuario($id, 6);
        $data['parametrosText'] = $this->setNombreTipo($parametrosText, 6);
        $parametrosCheck = $this->meta_usuario_model->getMetaUsuario($id, 7);
        $data['parametrosCheck'] = $this->setNombreTipo($parametrosCheck, 7);
        $comunas = $this->meta_usuario_model->getMetaUsuario($id, 3);
        $data['comunas'] = $this->setNombreTipo($comunas, 3);
        $tags = $this->meta_usuario_model->getMetaUsuario($id, 4);
        $data['tags'] = $this->setNombreTipo($tags, 4);
        $fotos = $this->meta_usuario_model->getMetaUsuario($id, 5);
        $data['fotos'] = $fotos;
        $this->load->model('agenda_chef_model');
        $periodos = $this->agenda_chef_model->agendaChef($id);
        $data['periodos'] = $periodos;
        if ($_POST) {
            $this->form_validation->set_rules('mail', 'Mail', 'required|valid_email');
            $this->form_validation->set_rules('nombre', 'Nombre', 'required');
            $this->form_validation->set_rules('apellidoPaterno', 'Apellido Paterno', 'required');
            $this->form_validation->set_rules('horarios[]', 'Horario de Atencion', 'required');
            $this->form_validation->set_rules('link', 'Link directo', 'callback_link_unique[' . $id . ']');
            $this->setDumbValidations($data['datosPersonales'], 'text');
            $this->setDumbValidations($data['parametrosText'], 'text');
            $this->setDumbValidations($data['parametrosCheck']);
            $this->setDumbValidations($data['comunas']);
            $this->setDumbValidations($data['tags']);
            $config['upload_path'] = getcwd() . '/avatar/';
            $config['allowed_types'] = 'gif|png|jpg|jpeg';
            $fname = array();
            if (isset($data['chef']['avatar'])) {
                $fname = explode('.', $data['chef']['avatar']);
                $config['file_name'] = $fname[0];
                $config['overwrite'] = TRUE;
            } else {
                $config['file_name'] = rand(0, 999999) . '_' . md5($id);
            }

            $this->load->library('upload', $config);

            if ($this->form_validation->run() == FALSE) {
                $this->load->view('admin/header');
                $this->load->view('admin/chef_edit', $data);
                $this->load->view('admin/footer');
            } else {
                if ($this->upload->do_upload('avatar')) {
                    $fotoUp = $this->upload->data();
//                    print_r($fotoUp); die();
                    $imagen = $fotoUp['file_name'];
                    if (!empty($fname) && $fname[1] != str_replace('.', '', $fotoUp['file_ext'])) {
                        unlink($fotoUp['file_path'] . $data['chef']['avatar']);
                    }
                } else if (!isset($data['chef']['avatar'])) {
                    $imagen = NULL;
                } else {
                    $imagen = $data['chef']['avatar'];
                }

                $data = array(
                    'idUsuario' => $id,
                    'mail' => $this->input->post('mail'),
                    'nombre' => $this->input->post('nombre'),
                    'apellidoPaterno' => $this->input->post('apellidoPaterno'),
                    'apellidoMaterno' => $this->input->post('apellidoMaterno'),
                    'avatar' => $imagen,
                    'link' => $this->input->post('link')
                );
                $this->usuario_model->edit($data);
                foreach ($fotos as $foto) {
                    $fname = array();
                    $config['upload_path'] = getcwd() . '/images/';
                    $config['allowed_types'] = 'gif|png|jpg|jpeg';
                    if (isset($foto['dato'])) {
                        $fname = explode('.', $foto['dato']);
                        $config['file_name'] = $fname[0];
                        $config['overwrite'] = TRUE;
                    } else {
                        $config['file_name'] = $foto['nombreMeta'] . '_' . md5($id);
                    }

                    $this->upload->initialize($config);

                    if ($this->upload->do_upload($foto['nombreMeta'])) {
                        $fotoUp = $this->upload->data();
                        $imagen = $fotoUp['file_name'];
                        if (!empty($fname) && $fname[1] != str_replace('.', '', $fotoUp['file_ext']))
                            unlink($fotoUp['file_path'] . $foto['dato']);
                    } else if (!isset($foto['dato']))
                        $imagen = NULL;
                    else {
                        $imagen = $foto['dato'];
                    }

                    $metaChef[] = array(
                        'idUsuario' => $id,
                        'idMeta' => $foto['idMetaKey'],
                        'dato' => $imagen
                    );
                }

                /*
                 * Funciones de eliminacion de metas y asignación de las que vienen por post
                 * como en el add
                 */

                $arrayDescripcion = $this->input->post('descripcion_personal');
                if ($arrayDescripcion) {
                    foreach ($arrayDescripcion as $idMeta => $value) {
                        $metaChef[] = array(
                            'idUsuario' => $id,
                            'idMeta' => $idMeta,
                            'dato' => $value
                        );
                    }
                }

                $arrayParametrosText = $this->input->post('parametro_chef_texto');
                if ($arrayParametrosText) {
                    foreach ($arrayParametrosText as $idMeta => $value) {
                        $metaChef[] = array(
                            'idUsuario' => $id,
                            'idMeta' => $idMeta,
                            'dato' => $value
                        );
                    }
                }

                $arrayParametrosCheck = $this->input->post('parametro_chef_check');
                if ($arrayParametrosCheck) {
                    foreach ($arrayParametrosCheck as $idMeta => $value) {
                        $metaChef[] = array(
                            'idUsuario' => $id,
                            'idMeta' => $value,
                            'dato' => $value
                        );
                    }
                }

                $arrayComunas = $this->input->post('comuna');
                if ($arrayComunas) {
                    foreach ($arrayComunas as $idMeta => $value) {
                        $metaChef[] = array(
                            'idUsuario' => $id,
                            'idMeta' => $value,
                            'dato' => $value
                        );
                    }
                }

                $arrayTags = $this->input->post('especialidad');
                if ($arrayTags) {
                    foreach ($arrayTags as $idMeta => $value) {
                        $metaChef[] = array(
                            'idUsuario' => $id,
                            'idMeta' => $value,
                            'dato' => $value
                        );
                    }
                }

                $this->meta_usuario_model->deleteMetasUsuario($id);
                $this->meta_model->addMetaChef($metaChef);

                $diasPeriodos = $this->input->post('horarios');
                $newData = array();
                if (!empty($diasPeriodos)) {
                    foreach ($diasPeriodos as $periodo) {
                        $split = explode('-', $periodo);
                        $idDia = $split[0];
                        $idPeriodo = $split[1];
                        $newData[] = array(
                            'idChef' => $id,
                            'idPeriodo' => $idPeriodo,
                            'idDiaAgenda' => $idDia
                        );
                    }
                    $this->agenda_chef_model->addBatch($newData);
                } else {
                    $this->agenda_chef_model->del($id);
                }
                redirect('admin/usuarios');
            }
        } else {

            $this->load->view('admin/header');
            $this->load->view('admin/chef_edit', $data);
            $this->load->view('admin/footer');
        }
    }

    private function setNombreTipo($metas, $tipo) {
        $this->load->model('tipo_meta_model');
        $nombreTipo = $this->tipo_meta_model->getTipoMeta($tipo);
        foreach ($metas as &$meta) {
            $meta['nombreTipo'] = $nombreTipo[0]['nombreTipo'];
        }

        return $metas;
    }

    function normalizaFechas($fecha) {
        return $this->functions->dateMySql($fecha);
    }

    public function modificarCalendario($id) {
        if ($_POST) {
            if ($this->input->post('fecha')) {
                $fechas = $this->input->post('fecha');
                $fechas_filtradas = array_map(array($this, "normalizaFechas"), array_unique($fechas));
                $newData = array();
                foreach ($fechas_filtradas as $fecha) {
                    $tmp = array(
                        'idChef' => $id, 'fecha' => $fecha
                    );
                    $this->agenda_chef_model->deleteDiaNoDisponible($tmp);
                    $query = $this->agenda_chef_model->getAgendaPorFecha($tmp);
                    if (!empty($query)) {
                        $newData = array_merge($newData, $query);
                    }
                }
                $this->agenda_chef_model->setDiasNoDisponibles($newData);
                $this->output->set_output('true');
            } else if ($this->input->post('horarios')) {
                $diasPeriodos = $this->input->post('horarios');
                $newData = array();
                if (!empty($diasPeriodos)) {
                    foreach ($diasPeriodos as $periodo) {
                        $split = explode('-', $periodo);
                        $idDia = $split[0];
                        $idPeriodo = $split[1];
                        $newData[] = array(
                            'idChef' => $id,
                            'idPeriodo' => $idPeriodo,
                            'idDiaAgenda' => $idDia
                        );
                    }
                    $this->agenda_chef_model->addBatch($newData);
                } else {
                    $this->agenda_chef_model->del($id);
                }
                $this->output->set_output('true');
            }
        } else {
            $data['agenda'] = $this->agenda_chef_model->agendaChef($id);
            $data['agendaNoDisponible'] = $this->generaTabla($this->agenda_chef_model->agendaNoDisponible($id));
            $data['idChef'] = $id;
            $this->load->view('admin/header');
            $this->load->view('admin/calendario_chef', $data);
            $this->load->view('admin/footer');
        }
    }

    public function habilitarFecha($id) {
        $data = array('idChef' => $id, 'fecha' => $this->input->post('fecha'));
        $this->agenda_chef_model->deleteDiaNoDisponible($data);
        $this->output->set_output(json_encode($this->generaTabla($this->agenda_chef_model->agendaNoDisponible($id))));
    }

    function generaTabla($data) {
        $tabla = array();
        foreach ($data as $fila) {
            $tabla[] = array(
                date('d/m/Y', strtotime($fila['fecha'])),
                '<a href="" class="activa-fecha"><span class="fi-x"></span></a>'
                . '<input type="hidden" name="fecha" value="' . $fila['fecha'] . '"/>'
            );
        }
        $this->table->set_heading('Fecha Bloqueada', 'Eliminar Bloqueo');
        return $this->table->generate($tabla);
    }

    function link_unique($str, $update = FALSE) {
        if ($str != '') {
            if ($this->usuario_model->link_is_unique($str, $update)) {
                return TRUE;
            } else {
                $this->form_validation->set_message('link_unique', 'El %s ya está asignado');
                return FALSE;
            }
        } else {
            return TRUE;
        }
    }

}
