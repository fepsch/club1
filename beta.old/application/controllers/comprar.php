<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Comprar extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('periodos_model');
        if ((!isset($this->session->userdata['username'])))
            redirect('home');
    }

    public function index() {
        redirect(base_url());
    }

    public function confirmaServicio() {
        $id = $this->session->userdata('idExperiencia');
        if ($_POST) {
            redirect('comprar/ingresoDatos');
        } else {
            $this->load->model('experiencia_model');
            $this->load->model('plato_model');
            $this->load->model('usuario_model');
            $exp = $this->experiencia_model->getExperiencia($id);
            foreach ($exp as &$e) {
                $e['platos'] = $this->plato_model->getPlatosExperiencia($e['idExperiencia']);
            }
            $experiencia = $exp[0];
            $chef = $this->usuario_model->getUserData($experiencia['idUsuario']);
            $dataSesion = $this->session->userdata;
            $total = $experiencia['tiempo' . $dataSesion['invitados']] * $dataSesion['precio'];
            $horarioVista = date('d/m/Y H:i', strtotime($dataSesion['horario']));
            $sessionData = array('total' => $total);
            $this->session->set_userdata($sessionData);
            $data['experiencias'] = $exp;
            $data['invitados'] = $dataSesion['invitados'];
            $data['duracion'] = $experiencia['tiempo' . $dataSesion['invitados']];
            $data['horario'] = $horarioVista;
            $data['total'] = $total;
            $data['precio'] = $dataSesion['precio'];
            $data['nombreChef'] = $chef[0]['nombre'] . ' ' . $chef[0]['apellidoPaterno'];
            $this->load->vars($data);
            $this->load->view('header');
            $this->load->view('comprar/paso1');
            $this->load->view('footer');
        }
    }

    public function ingresoDatos() {
        $this->load->model('experiencia_model', 'experiencia');
        $experiencia = $this->experiencia->getExperiencia($this->session->userdata('idExperiencia'));
        $this->load->model('meta_usuario_model', 'metas');
        $comunas = $this->metas->getMetaUsuario($experiencia[0]['idUsuario'], 3);
        $data['comunas'] = $comunas;
        if ($_POST) {
            $this->form_validation->set_rules('comuna', 'Comuna', 'required');
            $this->form_validation->set_rules('calle', 'Calle', 'required');
            $this->form_validation->set_rules('nrocasa', 'Número', 'required');
            $this->form_validation->set_rules('nrocontacto', 'Teléfono de contacto', 'required|callback_largo_numero');
            $this->form_validation->set_rules('codigopostal', 'Código Postal', 'numeric');
            $this->form_validation->set_rules('nrodepto', 'Número de departamento', '');
            if ($this->form_validation->run() == FALSE) {
                $this->load->view('header');
                $this->load->view('comprar/paso2', $data);
                $this->load->view('footer');
            } else {
                $nroDepto = $this->input->post('nrodepto');
                $this->load->model('usuario_model');
                $result = $this->usuario_model->getUser($this->session->userdata['username']);
                $usuario = $result[0];
                $dataCompra = array(
                    'idUsuarioCliente' => $usuario['idUsuario'],
                    'idExperiencia' => $this->session->userdata('idExperiencia'),
                    'fecha' => $this->session->userdata('horario'),
                    'valor' => $this->session->userdata('total'),
                    'pasajeros' => $this->session->userdata('invitados'),
                    'idEstado' => 1,
                    'direccion' => trim($this->input->post('calle') . ' ' . $this->input->post('nrocasa') . ' ' . (isset($nroDepto) ? '' : 'Depto' . $nroDepto)),
                    'comuna' => $this->input->post('comuna'),
                    'nroContacto' => $this->input->post('nrocontacto')
                );
                $this->load->model('actividad_model');
                if (isset($this->session->userdata['idActividad'])) {
                    $dataCompra['idActividad'] = $this->session->userdata['idActividad'];
                    $this->actividad_model->update($dataCompra);
                } else {
                    $this->actividad_model->add($dataCompra);
                    $idActividad = array('idActividad' => $this->actividad_model->getInsertedId());

                    $this->session->set_userdata($idActividad);
                }
                redirect('comprar/metodoPago');
            }
        } else {
            $this->load->view('header');
            $this->load->view('comprar/paso2', $data);
            $this->load->view('footer');
        }
    }

    function largo_numero($str) {
        if (strlen($str) != 8) {
            $this->form_validation->set_message('largo_numero', 'El número de teléfono debe tener un largo de 8 dígitos');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function metodoPago() {
        if ($_POST) {
            redirect('comprar/finalizarCompra');
        }

        $TBK_MONTO = $this->session->userdata('total');
        /* CONFIGURACION DATOS A SER ENVIADOS AL CGI */
        $data['TBK_ORDEN_COMPRA'] = $this->session->userdata('idActividad');
        $data['TBK_ID_SESION'] = $TBK_ID_SESION = date("Ymdhis");
        $data['TBK_TIPO_TRANSACCION'] = "TR_NORMAL";
        $data['TBK_URL_EXITO'] = base_url('comprar/finalizarCompra');
        $data['TBK_URL_FRACASO'] = base_url('comprar/avisoFalla');
        $data['TBK_MONTO'] = $TBK_MONTO * 100;
        /*         * *************** FIN CONFIGURACION **************** */

        $this->load->model('usuario_model');
        $this->load->model('actividad_model');
        $this->load->model('meta_model');
        $this->load->model('experiencia_model');
        $experiencia = $this->experiencia_model->getExperiencia($this->session->userdata('idExperiencia'));
        $actividad = $this->actividad_model->getActividad($this->session->userdata('idActividad'));
        $comuna = $this->meta_model->getMeta($actividad[0]['comuna']);
        $chef = $this->usuario_model->getUserData($experiencia[0]['idUsuario']);
        $data['experiencia'] = $experiencia[0];
        $data['actividad'] = $actividad[0];
        $data['comuna'] = $comuna[0];
        $data['nombreChef'] = $chef[0]['nombre'] . ' ' . $chef[0]['apellidoPaterno'];
        $this->load->view('header');
        $this->load->view('comprar/paso3', $data);
        $this->load->view('footer');
    }

    public function finalizarCompra() {

        $this->load->model('actividad_model');
        if ($this->input->post('siguiente')) {
            $dumpData = array(
                'fecha' => '',
                'comuna' => '',
                'tag' => '',
                'invitados' => '',
                'horario' => '',
                'idExperiencia' => '',
                'precio' => '',
                'total' => '',
                'idActividad' => ''
            );
            $this->session->unset_userdata($dumpData);
            redirect('/');
        } else {
            //Se deben mostrar los datos de la transacción para la certificación TransBank
            $TBK_ID_SESION = isset($_POST["TBK_ID_SESION"]) ? $_POST["TBK_ID_SESION"] : '';
            $TBK_ORDEN_COMPRA = isset($_POST["TBK_ORDEN_COMPRA"]) ? $_POST["TBK_ORDEN_COMPRA"] : '';

            $this->load->model('pago_model');
            $pagada = $this->pago_model->validaActividadPagada($TBK_ORDEN_COMPRA);

            if ($pagada) {

                $filename_txt = getcwd() . "/TB/cgi-bin/log/validacionmac/MAC01Normal$TBK_ID_SESION.txt";
                $mac_valido = file_exists($filename_txt);

                if ($mac_valido) {
                    //Rescate de los valores informados por transbank
                    $fic = fopen($filename_txt, "r");
                    $linea = fgets($fic);
                    fclose($fic);
                    $detalle = explode("&", $linea);
                    $data['TBK_ORDEN_COMPRA'] = explode("=", $detalle[0]);
                    $data['TBK_TIPO_TRANSACCION'] = explode("=", $detalle[1]);
                    $data['TBK_RESPUESTA'] = explode("=", $detalle[2]);
                    $data['TBK_MONTO'] = explode("=", $detalle[3]);
                    $data['TBK_CODIGO_AUTORIZACION'] = explode("=", $detalle[4]);
                    $data['TBK_FINAL_NUMERO_TARJETA'] = explode("=", $detalle[5]);
                    $data['TBK_FECHA_CONTABLE'] = explode("=", $detalle[6]);
                    $data['TBK_FECHA_TRANSACCION'] = explode("=", $detalle[7]);
                    $data['TBK_HORA_TRANSACCION'] = explode("=", $detalle[8]);
                    $data['TBK_ID_TRANSACCION'] = explode("=", $detalle[10]);
                    $data['TBK_TIPO_PAGO'] = explode("=", $detalle[11]);
                    $data['TBK_NUMERO_CUOTAS'] = explode("=", $detalle[12]);
                    $data['TBK_MAC'] = explode("=", $detalle[13]);
                    //$data['TBK_FECHA_CONTABLE'][1] = substr($TBK_FECHA_CONTABLE[1], 2, 2) . "-" . substr($TBK_FECHA_CONTABLE[1], 0, 2);
                    //$data['TBK_FECHA_TRANSACCION'][1] = substr($TBK_FECHA_TRANSACCION[1], 2, 2) . "-" . substr($TBK_FECHA_TRANSACCION[1], 0, 2);
                    //$data['TBK_HORA_TRANSACCION'][1] = substr($TBK_HORA_TRANSACCION[1], 0, 2) . ":" . substr($TBK_HORA_TRANSACCION[1], 2, 2) . ":" . substr($TBK_HORA_TRANSACCION[1], 4, 2);
                    //Tipos de Venta y cuota
                    switch ($data['TBK_TIPO_PAGO'][1]) {
                        case 'VN': $data['TBK_TIPO_PAGO'][1] = 'Crédito';
                            $data['tipoCuota'] = 'Sin Cuotas';
                            break;
                        case 'VC': $data['TBK_TIPO_PAGO'][1] = 'Crédito';
                            $data['tipoCuota'] = 'Cuotas Normales';
                            break;
                        case 'SI': $data['TBK_TIPO_PAGO'][1] = 'Crédito';
                            $data['tipoCuota'] = 'Sin Interés';
                            break;
                        case 'S2': $data['TBK_TIPO_PAGO'][1] = 'Crédito';
                            $data['tipoCuota'] = 'Sin Interés';
                            break;
                        case 'CI': $data['TBK_TIPO_PAGO'][1] = 'Crédito';
                            $data['tipoCuota'] = 'Cuotas Comercio';
                            break;
                        case 'VD': $data['TBK_TIPO_PAGO'][1] = 'Redcompra';
                            $data['tipoCuota'] = 'Débito';
                            break;
                    }

                    //Si es cero cuotas, debe mostrarse 00
                    if ($data['TBK_NUMERO_CUOTAS'][1] == '0') {
                        $data['TBK_NUMERO_CUOTAS'][1] = '00';
                    }

                    //También se debe desplegar el cliente en el resumen de la transacción
                    $this->load->model('usuario_model');
                    $usuario = $this->usuario_model->getUser($this->session->userdata('username'));
                    $data['comprador'] = $usuario[0]['nombre'] . ' ' . $usuario[0]['apellidoPaterno'] . ' ' . (isset($usuario[0]['apellidoMaterno']) ? $usuario[0]['apellidoMaterno'] : '');


                    $actividad = $this->actividad_model->getActividad($this->session->userdata('idActividad'));
                    $comuna = $this->meta_model->getMeta($actividad[0]['comuna']);
                    $data['comuna'] = $comuna[0];
                    $actividadUp = array(
                        'idActividad' => $this->session->userdata('idActividad'),
                        'idEstado' => 4
                    );
                    $this->load->model('experiencia_model');
                    $experiencia = $this->experiencia_model->getExperiencia($this->session->userdata('idExperiencia'));
                    $this->load->model('usuario_model');
                    $chef = $this->usuario_model->getUserData($experiencia[0]['idUsuario']);
                    $data['nombreChef'] = $chef[0]['nombre'] . ' ' . $chef[0]['apellidoPaterno'];
                    $data['experiencia'] = $experiencia[0];
                    $data['actividad'] = $actividad[0];
                    $data['invitados'] = $this->session->userdata('invitados');
                    $data['horario'] = $this->session->userdata('horario');
                    $data['total'] = $this->session->userdata('total');
                    $this->actividad_model->update($actividadUp);

                    //Mail cliente
                    $this->load->library('email');
                    $this->email->initialize(array('mailtype' => 'html'));
                    $this->email->from('hola@clubdelacocina.cl', 'Club de la cocina');
                    $this->email->to($this->session->userdata('username'));
                    $this->email->bcc('hola@clubdelacocina.cl');
                    $this->email->subject('Confirmación de la compra');
                    $this->email->message($this->load->view('comprar/datos_mail', $data, true));
                    $this->email->send();

                    //Mail custom para chef
                    $mailChef = $chef[0]['mail'];
                    $data['nombreChef'] = $chef[0]['nombre'];
                    $this->email->clear();
                    $this->email->from('hola@clubdelacocina.cl', 'Club de la cocina');
                    $this->email->to($mailChef);
                    $this->email->bcc('hola@clubdelacocina.cl');
                    $this->email->subject('Nuevo evento');
                    $this->email->message($this->load->view('mailing/chef_nuevo_evento', $data, true));
                    $this->email->send();

                    $dumpData = array(
                        'fecha' => '',
                        'comuna' => '',
                        'tag' => '',
                        'invitados' => '',
                        'horario' => '',
                        'idExperiencia' => '',
                        'precio' => '',
                        'total' => '',
                        'idActividad' => ''
                    );
                    $this->session->unset_userdata($dumpData);
                    $this->load->view('header');
                    $this->load->view('comprar/paso4', $data);
                    $this->load->view('footer');
                } else {
                    $this->avisoFalla($TBK_ORDEN_COMPRA);
                }
            } else {
                $this->avisoFalla($TBK_ORDEN_COMPRA);
            }
        }
    }

    public function avisoFalla($oc = NULL) {

        $dumpData = array(
            'fecha' => '',
            'comuna' => '',
            'tag' => '',
            'invitados' => '',
            'horario' => '',
            'idExperiencia' => '',
            'precio' => '',
            'total' => '',
            'idActividad' => ''
        );

        if ($oc != NULL) {
            $data['oc'] = $oc;
        } else if ($_POST['TBK_ORDEN_COMPRA']) {
            $data['oc'] = $_POST['TBK_ORDEN_COMPRA'];
        } else {
            $this->session->unset_userdata($dumpData);
            redirect('/');
            exit();
        }
        $actividadUp = array(
            'idActividad' => $this->session->userdata('idActividad'),
            'idEstado' => 2
        );
        $this->session->unset_userdata($dumpData);
        $this->load->model('actividad_model');
        $this->actividad_model->update($actividadUp);
        $this->load->view('header');
        $this->load->view('comprar/avisofalla', $data);
        $this->load->view('footer');
    }

}

?>