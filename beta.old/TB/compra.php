<?php
$conexion = mysql_connect("mysql.radar.cl", "clubcocina", "radar1314x");
mysql_select_db("bddd_clubcocina", $conexion);
//rescate de datos de POST.
$fecha_expiracion = isset($_POST['TBK_FECHA_EXPIRACION']) ? $_POST['TBK_FECHA_EXPIRACION'] : '';
$fecha_contable = isset($_POST['TBK_FECHA_CONTABLE']) ? $_POST['TBK_FECHA_CONTABLE'] : '';
$fecha_transaccion = isset($_POST['TBK_FECHA_TRANSACCION']) ? $_POST['TBK_FECHA_TRANSACCION'] : '';
$data = array(
    'idActividad' => isset($_POST['TBK_ORDEN_COMPRA']) ? $_POST['TBK_ORDEN_COMPRA'] : '',
    'monto' => isset($_POST['TBK_MONTO']) ? $_POST['TBK_MONTO'] / 100 : '',
    'respuesta' => isset($_POST['TBK_RESPUESTA']) ? $_POST['TBK_RESPUESTA'] : '',
    'codigoAutorizacion' => isset($_POST['TBK_CODIGO_AUTORIZACION']) ? $_POST['TBK_CODIGO_AUTORIZACION'] : '',
    'finalTarjeta' => isset($_POST['TBK_FINAL_NUMERO_TARJETA']) ? $_POST['TBK_FINAL_NUMERO_TARJETA'] : '',
    'fechaTransaccion' => ($fecha_transaccion == '') ? strftime('%Y-%m-%d') : strftime('%Y') . '-' . substr($fecha_transaccion, 0, 2) . '-' . substr($fecha_transaccion, 2, 2),
    'idSesion' => isset($_POST['TBK_ID_SESION']) ? $_POST['TBK_ID_SESION'] : '',
        /* 'transaccion' => isset($_POST['TBK_TIPO_TRANSACCION']) ? $_POST['TBK_TIPO_TRANSACCION'] : '',
          'nro_tarjeta' => isset($_POST['TBK_NUMERO_TARJETA']) ? $_POST['TBK_NUMERO_TARJETA'] : '',
          'hora_transaccion' => isset($_POST['TBK_HORA_TRANSACCION']) ? $_POST['TBK_HORA_TRANSACCION'] : '',
          'id_transaccion' => isset($_POST['TBK_ID_TRANSACCION']) ? $_POST['TBK_ID_TRANSACCION'] : '',
          'tipo_pago' => isset($_POST['TBK_TIPO_PAGO']) ? $_POST['TBK_TIPO_PAGO'] : '',
          'nro_cuotas' => isset($_POST['TBK_NUMERO_CUOTAS']) ? $_POST['TBK_NUMERO_CUOTAS'] : '',
          'mac' => isset($_POST['TBK_MAC']) ? $_POST['TBK_MAC'] : '',
          'monto_cuota' => isset($_POST['TBK_MONTO_CUOTA']) ? $_POST['TBK_MONTO_CUOTA'] : '',
          'tasa_interes_max' => isset($_POST['TBK_TASA_INTERES_MAX']) ? $_POST['TBK_TASA_INTERES_MAX'] : '',
          'fecha_expiracion' => ($fecha_expiracion == '') ? strftime('%Y-%m-%d') : strftime('%Y') . '-' . substr($fecha_expiracion, 0, 2) . '-' . substr($fecha_expiracion, 2, 2),
          'fecha_contable' => ($fecha_contable == '') ? strftime('%Y-%m-%d') : strftime('%Y') . '-' . substr($fecha_contable, 0, 2) . '-' . substr($fecha_contable, 2, 2), */
);

/* * **************** CONFIGURACION RUTAS PARA VALIDACION MAC ****************** */
//GENERA ARCHIVO PARA MAC
$filename_txt = getcwd() . "/cgi-bin/log/validacionmac/MAC01Normal$data[idSesion].txt";
// Ruta Checkmac
$cmdline = getcwd() . "/cgi-bin/tbk_check_mac.cgi $filename_txt";
/* * **************** FIN CONFIGURACION RUTAS PARA VALIDACION MAC **************** */

//Validación de respuesta de Transbank, solo si es 0 continua con la pagina de cierre
if ($data['respuesta'] == "0") {

    reset($_POST);
    //guarda los datos del post uno a uno en archivo para la ejecución del MAC
    $fp = fopen($filename_txt, "wt");
    while (list($key, $val) = each($_POST)) {
        fwrite($fp, "$key=$val&");
    }
    fclose($fp);

    //Validación MAC
    if ($data['respuesta'] == "0") {
        exec($cmdline, $result, $retint);
        if ($result [0] == "CORRECTO") {
            $acepta = TRUE;
        } else {
            $acepta = FALSE;
        }
    }

    if ($acepta) {

        // VERIFICA MONTO
        $sql = sprintf('SELECT idActividad FROM actividad WHERE idActividad=%s AND valor=%s', $data['idActividad'], $data['monto']);
        $query = mysql_query($sql, $conexion) or die(mysql_error());

        if (mysql_num_rows($query) == 1) {
            $acepta = TRUE;
        } else {
            $acepta = FALSE;
        }

        // VERIFICA DUPLICIDAD DE OC
        if ($acepta) {
            $sql = sprintf('SELECT idActividad FROM pagoActividad WHERE idActividad=%s', $data['idActividad']);
            $query = mysql_query($sql, $conexion) or die(mysql_error());
            if (mysql_num_rows($query) == 0) {
                $acepta = TRUE;
            } else {
                $acepta = FALSE;
            }
        }

        // VERIFICA DUPLICIDAD DE PAGO
        if ($acepta) {
            $sql = sprintf('SELECT idActividad FROM pagoActividad WHERE idActividad=%s AND respuesta=%s', $data['idActividad'], '0');
            $query = mysql_query($sql, $conexion) or die(mysql_error());
            if (mysql_num_rows($query) == 0) {
                $acepta = TRUE;
            } else {
                $acepta = FALSE;
            }
        }

        if ($acepta) {
            $sql = sprintf("INSERT INTO pagoActividad (idActividad, respuesta, codigoAutorizacion, finalTarjeta, fechaTransaccion, monto, idSesion) values(%s, %s, %s, %s, '%s', %s, %s)", $data["idActividad"], $data["respuesta"], $data["codigoAutorizacion"], $data["finalTarjeta"], $data["fechaTransaccion"], $data["monto"], $data["idSesion"]);
            mysql_query($sql, $conexion) or die(mysql_error());
        }
    }
} else {
    $sql = sprintf("INSERT INTO pagoActividad (idActividad, respuesta, codigoAutorizacion, finalTarjeta, fechaTransaccion, monto, idSesion) values(%s, %s, %s, %s, '%s', %s, %s)", $data["idActividad"], $data["respuesta"], $data["codigoAutorizacion"], $data["finalTarjeta"], $data["fechaTransaccion"], $data["monto"], $data["idSesion"]);
    mysql_query($sql, $conexion) or die('ACEPTADO');
    $acepta = TRUE;
}
?>
<html>
<?php if ($acepta): ?>
        ACEPTADO
    <?php else: ?>
        RECHAZADO
    <?php endif; ?>
</html>