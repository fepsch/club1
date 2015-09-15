<?php

class Chefs extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('form_validation');

        $this->load->model('usuario_model');
        $this->load->model('agenda_chef_model');
        $this->load->model('experiencia_model');
        $this->load->model('evaluacion_model');
        $this->load->model('meta_usuario_model');
        $this->load->model('periodos_model');
        $this->load->helper('url');
    }

    public function busquedaForm($tag = FALSE) {
        if ($tag !== FALSE) {
            $filtros = array(
                'fecha' => FALSE,
                'comuna' => FALSE,
                'tag' => array($tag),
                'nombreChef' => FALSE,
                'boolHora' => FALSE
            );
        } else if ($_POST) {
            $filtros = array(
                'fecha' => !empty($_POST['agenda']) ? $this->functions->dateTimeMySql($_POST['agenda']) : FALSE,
                'comuna' => !empty($_POST['comuna']) ? $_POST['comuna'] : FALSE,
                'tag' => !empty($_POST['tag']) ? array($_POST['tag']) : FALSE,
                'tagSeleccionado' => !empty($_POST['tag']) ? $_POST['tag'] : FALSE,
                'nombreChef' => !empty($_POST['nombre_chef']) ? $_POST['nombre_chef'] : FALSE,
                'boolHora' => $_POST['bool_hora'] == '1' ? TRUE : FALSE
            );
        }
        $this->session->set_userdata($filtros);
        unset($this->session->userdata['tagsOriginales']); //una busqueda nueva reemplaza los filtros guardados. Esta variable se setea en el listar.
        unset($this->session->userdata['orden']);
        $chefs = $this->usuario_model->getChefsDisponibles($this->setDataBusqueda());
        if (empty($chefs)) {
            $data['mensaje'] = '<div id="no-data">No existe ningún Chef disponible según su criterio de búsqueda</div>';
            $this->load->view('header');
            $this->load->view('mensajes', $data);
            $this->load->view('footer');
        } else {
            $this->listarChefs($chefs);
        }
    }

    public function get_id_periodos($var) {
        return $var['idPeriodo'];
    }

    public function setDataBusqueda() {
        $idPeriodos = FALSE;
        $dia = FALSE;
        $fecha = $this->session->userdata('fecha');
        /** Se valida el booleano de hora, ya que si existe, debiera existir fecha (se elige primero la fecha) * */
        if ($this->session->userdata('boolHora')) {
            $periodos = $this->periodos_model->getPeriodoHora(date('H:i', strtotime($fecha)));
            foreach ($periodos as $periodo) {
                $idPeriodos[] = $periodo['idPeriodo'];
            }
            $idPeriodos = implode(',', $idPeriodos);
        }
        if ($this->session->userdata('fecha')) {
            $this->load->model('dia_agenda_model');
            $qDiaMysql = $this->dia_agenda_model->getIdDiaFecha($fecha);
            $dia = $qDiaMysql[0]['idDiaAgenda'];
        }
        $data = array(
            'fecha' => $this->session->userdata('fecha'),
            'periodos' => $idPeriodos,
            'comuna' => $this->session->userdata('comuna'),
            'tag' => $this->session->userdata('tag'),
            'nombreChef' => $this->session->userdata('nombreChef'),
            'dia' => $dia,
            'orden' => $this->session->userdata('orden')
        );
        return $data;
    }

    public function filtroTag($accion) {
        if ($_POST) {
            $tags = $this->session->userdata('tag') ? $this->session->userdata('tag') : array();

            if ($accion === 'agregar') {
                $tags[] = $_POST['tags'];
            } else {
                $tag = array_search($_POST['tags'], $tags);
                unset($tags[$tag]);
                if (empty($tags)) {
                    $tags = FALSE;
                }
            }
            $this->session->set_userdata('tag', $tags);
            $chefs = $this->usuario_model->getChefsDisponibles($this->setDataBusqueda());

            $this->listarChefs($chefs, 'ajax');
        }
    }

    public function ordenar() {
        if ($_POST) {
            $orden = $this->input->post('ordenar') ? $this->input->post('ordenar') : FALSE;
            $this->session->set_userdata('orden', $orden);
            $chefs = $this->usuario_model->getChefsDisponibles($this->setDataBusqueda());
            $this->listarChefs($chefs, 'ajax');
        }
    }

    public function autocompleteNombre() {
        $term = $this->input->get('term');
        $result = $this->usuario_model->getAutocomplete($term);
        $dataSet = array();
        foreach ($result as $item)
            $dataSet[] = $item['nombreFull'];
        $this->output->set_output(json_encode($dataSet));
    }

    public function listarChefs($idsChefs, $ajax = FALSE) {
        $this->load->model('actividad_model');
        $chefs = array();
        $idsChefsImplode = array();
        foreach ($idsChefs as $index => $idChef) {
            $chef = $this->usuario_model->getUserData($idChef['idUsuario']);
            $parametros = $this->meta_usuario_model->getMetaUsuario($idChef['idUsuario'], 6);
            $parametros = $this->_getMetasPorID($parametros);
            $chef[0]['precio'] = $parametros['4'];
            $fotos = $this->meta_usuario_model->getMetaUsuario($idChef['idUsuario'], 5);
            $fotos = $this->_getMetasPorID($fotos);
            $chef[0]['fotos'] = $fotos;
            $reviews = $this->evaluacion_model->getEvaluacionesChef($idChef['idUsuario']);
            //$chef[0]['conteo'] = count($reviews);
            $eval = array();
            foreach ($reviews as $evaluacion) {
                $porcentaje = round($evaluacion['nota'] / $evaluacion['conteo']) * 100 / 5; //se divide en 5 porque es el mayor puntaje (100%)
                $eval[$evaluacion['nombreMeta']] = $porcentaje;
            }

            $chef[0]['porcentGral'] = empty($eval) ? '0' : round(array_sum($eval) / count($eval), 1);
            $chefs[] = $chef[0];
            $idsChefsImplode[] = $idChef['idUsuario'];
        }
        $data['chefs'] = $chefs;
        if ($this->session->userdata('tagsOriginales')) {
            $tags = $this->session->userdata('tagsOriginales');
        } else {
            $tags = $this->meta_usuario_model->getMetasComunes($idsChefsImplode);
            $this->session->set_userdata('tagsOriginales', $tags);
        }

        $data['tags'] = $tags;
        if ($this->session->userdata('comuna')) {
            $comunaNombre = $this->meta_model->getMeta($this->session->userdata('comuna'));
            $data['comunaNombre'] = $comunaNombre[0]['nombreMeta'];
        }

        if ($this->session->userdata('fecha')) {
            $data['fecha'] = date('d/m/Y', strtotime($this->session->userdata('fecha')));
        }

        if ($ajax === FALSE) {
            $this->load->view("header");
            $this->load->view('resultados_busqueda', $data);
            $this->load->view('footer');
        } else
            $this->output->set_output($this->load->view('resultados_busqueda', $data, true));
    }

    public function verDatosChef($id, $ajax = NULL) {
        if ($_POST) {
            $parametrosChef = $this->_getMetasChef($id, 6);
            $idExperiencia = $_POST['id'];
            $min_invitados = 1;
            $max_invitados = 1;
            $rangos = array();
            if (isset($parametrosChef['5']))
                $rangos = explode('-', $parametrosChef['5']);
            if (!empty($rangos)) {
                $icero = (int) $rangos[0];
                $iuno = (int) $rangos[1];
                $min_invitados = min($icero, $iuno);
                $max_invitados = max($icero, $iuno);
            }
            $this->form_validation->set_rules('invitados' . $idExperiencia, 'Cantidad de invitados', 'required|callback_valida_min[' . $min_invitados . ']|callback_valida_max[' . $max_invitados . ']');
            //$this->form_validation->set_rules('horario' . $idExperiencia, 'Horario', 'required');
            $this->form_validation->set_rules('horario' . $idExperiencia, 'Fecha y Hora', 'required|callback_check_disponible[' . $id . ']');
            $this->form_validation->set_rules('total' . $idExperiencia, 'Total', '');
            $this->form_validation->set_rules('precioporpersona' . $idExperiencia, 'Precio por persona', '');
            $this->form_validation->set_rules('bool_hora' . $idExperiencia, 'Hora', 'required|callback_check_hora');
            if ($this->form_validation->run() != FALSE) {
                $data = array(
                    'invitados' => $this->input->post('invitados' . $idExperiencia),
                    'horario' => date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $this->input->post('horario' . $idExperiencia)))),
                    'idExperiencia' => $idExperiencia,
                    'precio' => $parametrosChef['4'],
                );
                $this->session->set_userdata($data);
                $this->load->model('login_model');
                if ($this->login_model->isLogged()) {
                    $this->output->set_output(json_encode(array('login' => FALSE, 'url' => base_url('comprar/confirmaServicio'))));
                } else {
                    $this->session->set_userdata('url', base_url('comprar/confirmaServicio'));
                    $this->output->set_output(json_encode(array('login' => TRUE)));
                }
            } else {
                $this->_loadData($id);
                $this->load->view('detallechef/ver_chef');
            }
        } else {
            $this->_loadData($id);
            if ($ajax !== NULL) {
                $this->load->view('detallechef/ver_chef');
            } else {
                $this->load->view('header');
                $this->load->view('detallechef/ver_chef');
                $this->load->view('footer');
            }
        }
    }

    public function check_disponible($str, $id) {
        $fecha = $this->functions->dateTimeSecsMySql($str);
        if ($fecha == date('Y-m-d H:i:s', NULL)) {
            $this->form_validation->set_message('check_disponible', 'Debe seleccionar una fecha y hora para el evento');
            return FALSE;
        } else {
            $this->load->model('agenda_chef_model');
            $result = $this->agenda_chef_model->checkHoraDisponible($id, $fecha);
            if (count($result) > 0) {
                $this->form_validation->set_message('check_disponible', 'La hora seleccionada no se encuentra disponible');
                return FALSE;
            } else {
                return TRUE;
            }
        }
    }

    function check_hora($str) {
        if ($str == '1') {
            return TRUE;
        } else {
            $this->form_validation->set_message('check_hora', 'Debe seleccionar la hora del evento');
            return FALSE;
        }
    }

    public function valida_min($str, $min) {
        if ($str < $min) {
            $this->form_validation->set_message('valida_min', "El mínimo de participantes debe ser de $min personas");
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function valida_max($str, $max) {
        if ($str > $max) {
            $this->form_validation->set_message('valida_max', "El máximo de participantes debe ser de $max personas");
            return FALSE;
        } else {
            return TRUE;
        }
    }

    private function _loadData($id) {
        $this->load->model('plato_model');
        $this->load->model('agenda_chef_model', 'agenda');
        $this->load->model('mensaje_model');
        $this->load->model('actividad_model');
        //asignación de las variables a $data
        $mintime = $this->experiencia_model->getMinTimeChef($id);
        $data['minTimeExp'] = $mintime[0];
        $data['fotos'] = $this->_getMetasChef($id, 5);
        $data['datosChef'] = $this->_getDatosUser($id);
        $data['descripcionesChef'] = $this->_getMetasChef($id, 2, 0);
        $data['parametrosChef'] = $this->_getMetasChef($id, 6);
        $data['tagsChef'] = $this->meta_usuario_model->tagsChef($id);
        $data['evaluaciones'] = $this->_getEvaluacionesActividades($id);
        $data['comunas'] = $this->_getComunasChef($id);
        $data['porcentGral'] = array_pop($data['evaluaciones']);
        $data['experiencias'] = $this->_getExperienciasChef($id);
        $data['diasSemana'] = $this->_getDiasAgenda($id);
        $data['comentarios'] = $this->_getComentarios($id);

        $this->load->vars($data); //función que disponibiliza $data para todas las vistas
    }

    private function _getDatosUser($id) {
        //datos básicos
        $queryChef = $this->usuario_model->getUserData($id);
        //conteo de reviews
        $reviews = $this->evaluacion_model->getEvaluacionesChef($id);
        $queryChef[0]['conteo'] = count($reviews);
        return $queryChef[0];
    }

    private function _getMetasChef($id, $tipo, $byID = 1) {
        //Queryies para solicitar los datos de la vista detalle chef
        //metas con datos anexos, como ej: precio, cant personas, etc.
        $queryMetas = $this->meta_usuario_model->getMetaUsuario($id, $tipo);
        //Por defecto se devuelven los metas por id, si se especifica 0 se devuelven "en bruto"
        if ($byID == 1) {
            $metasChef = $this->_getMetasPorID($queryMetas);
            return $metasChef;
        } else {
            return $queryMetas;
        }
    }

    private function _getEvaluacionesActividades($id) {

        //las evaluaciones que se le hicieron luego de una actividad
        $queryEvaluaciones = $this->evaluacion_model->getEvaluacionesChef($id);

        //para poder sacar los porcentajes de las evaluaciones, se traen todas
        //las evaluaciones, se agrupan por el nombreMeta y luego se hacen los cálculos en %
        $eval = array();
        foreach ($queryEvaluaciones as $evaluacion) {
            $porcentaje = round($evaluacion['nota'] / $evaluacion['conteo']) * 100 / 5; //se divide en 5 porque es el mayor puntaje (100%)
            $eval[$evaluacion['nombreMeta']] = $porcentaje;
        }

        $eval['porcentGral'] = empty($eval) ? '0' : round(array_sum($eval) / count($eval), 1);

        return $eval;
    }

    private function _getComunasChef($id) {
        //las comunas en donde entrega su servicio
        $queryComunas = $this->meta_usuario_model->getMetaComuna($id, 3);

        //para enviar solo las comunas, procesamos el array devuelto
        $comunas = array();
        foreach ($queryComunas as $comuna) {
            $comunas[] = $comuna['nombreMeta'];
        }

        return $comunas;
    }

    private function _getExperienciasChef($id) {
        //las experiencias del chef
        $queryExperiencias = $this->experiencia_model->getExperienciasChef($id);
        //asociamos los plato a la experiencia que corresponde
        foreach ($queryExperiencias as &$experiencia) {
            $platos = $this->plato_model->getPlatosExperiencia($experiencia['idExperiencia']);
            $experiencia['platos'] = $platos;
        }
        return $queryExperiencias;
    }

    private function _getFechasNoDisponibles($id, $fecha = FALSE) {
        //Fechas ocupadas
        if ($fecha === FALSE) {
            if ($this->session->userdata('fecha')) {
                $queryFechas = $this->agenda_chef_model->diasNoDisponibles($id, $this->session->userdata('fecha'));
            } else {
                $queryFechas = $this->agenda_chef_model->diasNoDisponibles($id, date('Y-m-d', time()));
            }
        } else {
            $queryFechas = $this->agenda_chef_model->diasNoDisponibles($id, $fecha);
        }
        return $queryFechas;
    }

    private function _getDiasAgenda($id) {
        return $this->agenda->diasSemanaDisponibles($id);
    }

    private function _getComentarios($id) {
        //comentarios
        $queryComentarios = $this->mensaje_model->comentariosParaChef($id);
        foreach ($queryComentarios as &$comentario) {
            $usuario = $this->usuario_model->getUserData($comentario['idUsuario']);
            $comentario['usuario'] = $usuario[0];
        }

        return $queryComentarios;
    }

    private function _getMetasPorID($metas) {
        $metasChef = array();
        if (!empty($metas)) {
            foreach ($metas as $indice) {
                $metasChef[$indice['idMetaKey']] = isset($indice['dato']) ? $indice['dato'] : 'No Asignado';
            }
        }
        return $metasChef;
    }

    public function horasDisponibles() {
        //periodo de tiempo del chef para experiencia (si viene un filtro fecha con hora
        //se muestran sólo los horarios que competen al periodo de tiempo elegido).
        $intervalo = new DateInterval('PT1H');
        $horas = array();

        $this->load->model('agenda_chef_model');
        $fecha = $this->functions->dateTimeSecsMySql($this->input->post('fecha'));
        $idChef = $this->input->post('idChef');
        $idPeriodos = $this->agenda_chef_model->periodosDisponiblesDia($idChef, $fecha);
        foreach ($idPeriodos as $id) {
            $qperiodo = $this->periodos_model->get($id['idPeriodo']);
            $periodo = $qperiodo[0];
            $inicio = date_create($periodo['inicio']);
            $fin = date_create($periodo['fin']);
            $fin->modify("+ 1 hours");
            $rango = new DatePeriod($inicio, $intervalo, $fin);
            foreach ($rango as $fecha) {
                if (!in_array($fecha->format('H:i'), $horas))
                    $horas[] = $fecha->format('H:i');
            }
        }
        $this->output->set_output(json_encode($horas));
    }

    public function diasNoDisponiblesMes() {
        $fecha = $this->functions->dateTimeSecsMySql($this->input->post('fecha'));
        $idChef = $this->input->post('idChef');
        $fechas = $this->_getFechasNoDisponibles($idChef, $fecha);
        $this->output->set_output(json_encode($fechas));
    }

    public function busquedaPorNombre() {
        $id = $this->usuario_model->getIdChefByLink($this->uri->segment(2));
        if (count($id) == 1) {
            $this->verDatosChef($id[0]['idUsuario']);
        } else {
            $this->load->view('404');
        }
    }

}

?>