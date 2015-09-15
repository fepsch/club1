<html>
    <head>
        <title>Club de la Cocina</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    </head>
    <body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
        <table width="600" border="0" align="center" cellpadding="0" cellspacing="0" id="Tabla_01" style="border:#EFEFEF 1px solid; margin-top: 20px;">
            <tr>
                <td width="220" style="text-align: center; padding: 50px 0;">
                    <img src="<?= base_url('images/email_04.jpg'); ?>" width="167" height="136" alt="">
                </td>
                <td style="font-family: Arial; font-size: 15px; font-weight: bold">
                    <p>Hola <span style="color: #F9A33F"><?= $nombreChef?></span></p>
                    <p>
                        <span style="color:#F9A33F">¡Felicitaciones!</span><br>
                        Te han contratado para una nueva experiencia. 
                        A continuación, te enviamos el detalle del evento. 
                        Por favor, confirma la recepción de este email.
                    </p>
                    <p>¡Abrazos!</p>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <table width="100%" border="0" cellpadding="2" cellspacing="2">
                        <tr><th colspan="2">DETALLE DE LA COMPRA</th></tr>
                        <tr>
                            <td width="49%" height="25" bgcolor="#EEEEEE"><span style="font-family:Arial; font-size:13px; font-weight:bold">Cliente</span></td>
                            <td width="51%" bgcolor="#EEEEEE"><span style="font-family:Arial; font-size:13px;"><?= ucwords($comprador); ?></span></td>
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
                            <td width="49%" height="25" bgcolor="#EEEEEE"><span style="font-family:Arial; font-size:13px; font-weight:bold">Tel&eacute;fono</span></td>
                            <td width="51%" bgcolor="#EEEEEE"><span style="font-family:Arial; font-size:13px;"><?= $actividad['nroContacto']; ?></span></td>
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
                            <td width="49%" height="25" bgcolor="#EEEEEE"><span style="font-family:Arial; font-size:13px; font-weight:bold">Duraci&oacute;n</span></td>
                            <td width="51%" bgcolor="#EEEEEE"><span style="font-family:Arial; font-size:13px;"><?= $experiencia['tiempo' . $this->session->userdata('invitados')]; ?> HRS.</span></td>
                        </tr>
                        <tr>
                            <td width="49%" height="25" bgcolor="#EEEEEE"><span style="font-family:Arial; font-size:13px; font-weight:bold">Direcci&oacute;n</span></td>
                            <td width="51%" bgcolor="#EEEEEE"><span style="font-family:Arial; font-size:13px;"><?= $actividad['direccion']; ?></span></td>
                        </tr>
                        <tr>
                            <td width="49%" height="25" bgcolor="#EEEEEE"><span style="font-family:Arial; font-size:13px; font-weight:bold">Comuna</span></td>
                            <td width="51%" bgcolor="#EEEEEE"><span style="font-family:Arial; font-size:13px;"><?= $comuna['nombreMeta']; ?></span></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <img src="<?= base_url('images/email_07.jpg');?>" width="423" height="99" alt=""></td>
            </tr>
        </table>
    </body>
</html>