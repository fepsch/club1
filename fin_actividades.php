<?php 
$ch = curl_init('http://www.clubdelacocina.cl/home/mailingFinActividad');
if(curl_exec($ch))
	$msg = 'Finalizacion de actividades correcta';
else
	$msg = 'Fallo al finalizar las actividades';
curl_close($ch);
$fecha = date('d-m-Y H:i', time());
$log = fopen("log_cron.log", "a+");
fwrite($log, $fecha. ' - ' . $msg.PHP_EOL );
fclose($log);