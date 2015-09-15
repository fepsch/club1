<div id="regitro-usuario">
<?
	$mail = array(
              'name'        => 'mail',
              'id'          => 'mail',
              'value'       => set_value('mail'),
            );
	$nombre = array(
              'name'        => 'nombre',
              'id'          => 'nombre',
              'value'       => set_value('nombre'),
            );
	$apellidoPaterno = array(
              'name'        => 'apellidoPaterno',
              'id'          => 'apellidoPaterno',
              'value'       => set_value('apellidoPaterno'),
            );
	$apellidoMaterno = array(
              'name'        => 'apellidoMaterno',
              'id'          => 'apellidoMaterno',
              'value'       => '',//set_value('apellidoMaterno'),        //R
            );
	$password = array(
              'name'        => 'password',
              'id'          => 'password',
              'value'       => set_value('password'),
            );
	$passwordVerificacion = array(
              'name'        => 'passwordVerificacion',
              'id'          => 'passwordVerificacion',
              'value'       => set_value('passwordVerificacion'),
            );
	$avatar = array(
              'name'        => 'avatar',
              'id'          => 'avatar',
              'value'       => $avatar,        
            );
	$fbid = array(
              'fbid'       => $fbid,
            );
	
	echo validation_errors();
	echo form_open();
	?>
    <img src="https://graph.facebook.com/<?= $fbid['fbid'] ?>/picture?type=large">
    <?
	echo form_upload($avatar); echo "<br>";
	echo "E-mail: ".form_input($mail); echo "<br>";
	echo "Nombre: ".form_input($nombre); echo "<br>";
	echo "Primer apellido: ".form_input($apellidoPaterno); echo "<br>";
	echo "Segundo apellido: ".form_input($apellidoMaterno); echo "<br>";
	echo "Contraseña: ".form_password($password); echo "<br>";
	echo "Repita su contraseña: ".form_password($passwordVerificacion); echo "<br>";
	echo form_hidden($fbid); echo "<br>";
	echo form_submit('enviarRegistro','Enviar'); echo "<br>";
	echo form_close(); echo "<br>";

  //ver guardar datos en base de datos
?>

</div>
