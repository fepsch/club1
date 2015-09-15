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
                <td style="font-family: Arial; font-size: 15px; font-weight: bold; padding-right: 100px;">
                    <p>Hola <span style="color: #F9A33F"><?= $nombreCliente; ?></span></p>
                    <p style="text-align: justify">Te invitamos a calificar tu experiencia
                        con el Chef de Club de la Cocina.
                    </p>
                    <a href="<?= $url; ?>" style="background-color: #F9A33F; color: #fff; padding: 8px 17px; text-decoration: none; float: right">Ingresa Aquí</a>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <img src="<?= base_url('images/email_07.jpg');?>" width="423" height="99" alt=""></td>
            </tr>
        </table>
    </body>
</html>