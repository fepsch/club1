<html>
    <head>
        <title>Club de la Cocina</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    </head>
    <body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
        <table width="600" height="561" border="0" align="center" cellpadding="0" cellspacing="0" id="Tabla_01" style="border:#666 1px solid">
            <tr>
                <td rowspan="4" width="69" height="561"></td>
                <td colspan="2">&nbsp;</td>
                <td rowspan="4" width="69" height="561">
                </td>
            </tr>
            <tr>
                <td width="167">
                    <img src="<?= base_url('images/email_04.jpg'); ?>" width="167" height="136" alt="">
                </td>
                <td width="293">
                    <span style="font-family:Arial; font-size:13px; font-weight:bold">Hola</span>
                    <span style="font-family:Arial; font-size:13px; font-weight:bold; color:#f8a23e;"> <?= ucwords($comprador); ?>,</span><br>

                    <span style="font-family:Arial; font-size:13px; font-weight:bold">
                        Tu Compra se ha efectuado exitosamente.<br>
                        A continuaci&oacute;n puedes ver el detalle</span>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <table width="100%" border="0" cellpadding="2" cellspacing="2">
                        <tr><th colspan="2">DETALLE DE LA COMPRA</th></tr>
                        <tr>
                            <td width="49%" height="25" bgcolor="#EEEEEE"><span style="font-family:Arial; font-size:13px; font-weight:bold">Chef</span></td>
                            <td width="51%" bgcolor="#EEEEEE"><span style="font-family:Arial; font-size:13px;"><?= $nombreChef; ?></span></td>
                        </tr>
                        <tr>
                            <td width="49%" height="25" bgcolor="#EEEEEE"><span style="font-family:Arial; font-size:13px; font-weight:bold">Experiencia</span></td>
                            <td width="51%" bgcolor="#EEEEEE"><span style="font-family:Arial; font-size:13px;"><?= $experiencia['nombre']; ?></span></td>
                        </tr>
                        <tr>
                            <td width="49%" height="25" bgcolor="#EEEEEE"><span style="font-family:Arial; font-size:13px; font-weight:bold">¿Cu&aacute;ntos comen?</span></td>
                            <td width="51%" bgcolor="#EEEEEE"><span style="font-family:Arial; font-size:13px;"><?= $this->session->userdata('invitados'); ?></span></td>
                        </tr>
                        <tr>
                            <td width="49%" height="25" bgcolor="#EEEEEE"><span style="font-family:Arial; font-size:13px; font-weight:bold">Fecha</span></td>
                            <td width="51%" bgcolor="#EEEEEE"><span style="font-family:Arial; font-size:13px;"><?= date('d/m/Y', strtotime($actividad['fecha'])); ?></span></td>
                        </tr>
                        <tr>
                            <td width="49%" height="25" bgcolor="#EEEEEE"><span style="font-family:Arial; font-size:13px; font-weight:bold">Horario</span></td>
                            <td width="51%" bgcolor="#EEEEEE"><span style="font-family:Arial; font-size:13px;"><?= date('H:i', strtotime($this->session->userdata('horario'))); ?> Hrs.</span></td>
                        </tr>
                        <tr>
                            <td width="49%" height="25" bgcolor="#EEEEEE"><span style="font-family:Arial; font-size:13px; font-weight:bold">Duraci&oacute;n</span></td>
                            <td width="51%" bgcolor="#EEEEEE"><span style="font-family:Arial; font-size:13px;"><?= gmdate('H:i', $experiencia['tiempo' . $this->session->userdata('invitados')] * 60 * 60 ); ?> HRS.</span></td>
                        </tr>
                        <tr>
                            <td width="49%" height="25" bgcolor="#EEEEEE"><span style="font-family:Arial; font-size:13px; font-weight:bold">Direcci&oacute;n</span></td>
                            <td width="51%" bgcolor="#EEEEEE"><span style="font-family:Arial; font-size:13px;"><?= $actividad['direccion']; ?></span></td>
                        </tr>
                        <tr>
                            <td width="49%" height="25" bgcolor="#EEEEEE"><span style="font-family:Arial; font-size:13px; font-weight:bold">Comuna</span></td>
                            <td width="51%" bgcolor="#EEEEEE"><span style="font-family:Arial; font-size:13px;"><?= $comuna['nombreMeta']; ?></span></td>
                        </tr>
                        <tr>
                            <td width="49%" height="25" bgcolor="#EEEEEE"><span style="font-family:Arial; font-size:13px; font-weight:bold">Tel&eacute;fono</span></td>
                            <td width="51%" bgcolor="#EEEEEE"><span style="font-family:Arial; font-size:13px;"><?= $actividad['nroContacto']; ?></span></td>
                        </tr>
                        <tr>
                            <td width="49%" height="25" bgcolor="#EEEEEE"><span style="font-family:Arial; font-size:13px; font-weight:bold">Precio por persona</span></td>
                            <td width="51%" bgcolor="#EEEEEE"><span style="font-family:Arial; font-size:13px;">$<?= number_format($this->session->userdata('total') / $this->session->userdata('invitados'), 0, ',', '.'); ?></span></td>
                        </tr>
                        <!-- fin datos evento -->
                        <tr><td colspan="2"></td></tr>
                        <tr><th colspan="2">Datos compra transbank</th></tr>
                        <tr>
                            <td width="49%" height="25" bgcolor="#EEEEEE"><span style="font-family:Arial; font-size:13px; font-weight:bold">Nro. Tarjeta</span></td>
                            <td width="51%" bgcolor="#EEEEEE"><span style="font-family:Arial; font-size:13px;">********<?= $TBK_FINAL_NUMERO_TARJETA[1]; ?></span></td>
                        </tr>
                        <tr>
                            <td height="25" bgcolor="#F8F8F8"><span style="font-family:Arial; font-size:13px; font-weight:bold">Tipo de Pago</span></td>
                            <td bgcolor="#F8F8F8"><span style="font-family:Arial; font-size:13px;"><?= $TBK_TIPO_PAGO[1]; ?></span></td>
                        </tr>
                        <tr>
                            <td height="25" bgcolor="#EEEEEE"><span style="font-family:Arial; font-size:13px; font-weight:bold">Nro. Orden</span></td>
                            <td bgcolor="#EEEEEE"><span style="font-family:Arial; font-size:13px;"><?= $TBK_ORDEN_COMPRA[1]; ?></span></td>
                        </tr>
                        <tr>
                            <td height="25" bgcolor="#F8F8F8"><span style="font-family:Arial; font-size:13px; font-weight:bold">Descripci&oacute;n</span></td>
                            <td bgcolor="#F8F8F8"><span style="font-family:Arial; font-size:13px;">Servicios Chef</span></td>
                        </tr>
                        <tr>
                            <td height="25" bgcolor="#EEEEEE"><span style="font-family:Arial; font-size:13px; font-weight:bold">Nombre Comercio</span></td>
                            <td bgcolor="#EEEEEE"><span style="font-family:Arial; font-size:13px;">Club de la Cocina</span></td>
                        </tr>
                        <tr>
                            <td bgcolor="#F8F8F8"><span style="font-family:Arial; font-size:13px; font-weight:bold">URL Comercio</span></td>
                            <td bgcolor="#F8F8F8"><span style="font-family:Arial; font-size:13px;">http://www.clubdelacocina.cl</span></td>
                        </tr>
                        <tr>
                            <td height="25" bgcolor="#EEEEEE"><span style="font-family:Arial; font-size:13px; font-weight:bold">Monto Transacci&oacute;n</span></td>
                            <td bgcolor="#EEEEEE"><span style="font-family:Arial; font-size:13px;">$<?= number_format($TBK_MONTO[1] / 100, 0, ',', '.'); ?></span></td>
                        </tr>
                        <tr>
                            <td bgcolor="#F8F8F8"><span style="font-family:Arial; font-size:13px; font-weight:bold">Fecha</span></td>
                            <td bgcolor="#F8F8F8"><span style="font-family:Arial; font-size:13px;"><?= date('d/m/Y', time()); ?></span></td>
                        </tr>
                        <tr>
                            <td height="25" bgcolor="#F8F8F8"><span style="font-family:Arial; font-size:13px; font-weight:bold">C&oacute;digo Autorizaci&oacute;n</span></td>
                            <td bgcolor="#F8F8F8"><span style="font-family:Arial; font-size:13px;"><?= $TBK_CODIGO_AUTORIZACION[1]; ?></span></td>
                        </tr>
                        <tr>
                            <td height="25" bgcolor="#EEEEEE"><span style="font-family:Arial; font-size:13px; font-weight:bold">Tipo Transacci&oacute;n</span></td>
                            <td bgcolor="#EEEEEE"><span style="font-family:Arial; font-size:13px;"><?= 'Venta'; ?></span></td>
                        </tr>
                        <tr>
                            <td height="25" bgcolor="#F8F8F8"><span style="font-family:Arial; font-size:13px; font-weight:bold">Nro. Cuotas</span></td>
                            <td bgcolor="#F8F8F8"><span style="font-family:Arial; font-size:13px;"><?= $TBK_NUMERO_CUOTAS[1]; ?></span></td>
                        </tr>
                        <tr>
                            <td height="25" bgcolor="#F8F8F8"><span style="font-family:Arial; font-size:13px; font-weight:bold">Tipo Cuota</span></td>
                            <td bgcolor="#F8F8F8"><span style="font-family:Arial; font-size:13px;"><?= $tipoCuota; ?></span></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <img src="<?= base_url('images/email_07.jpg'); ?>" width="423" height="99" alt=""></td>
            </tr>
        </table>
    </body>
</html>