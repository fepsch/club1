<div class="row">
    <div class="small-6">
        <div class="container">
            <h1>
                <? //$titulo?>
            </h1>
            <div id="formulario">
                <?
                $mail = array(
                    'name' => 'mail',
                    'id' => 'mail',
                    'label' => 'Email',
                );
                $nombre = array(
                    'name' => 'nombre',
                    'id' => 'nombre',
                );
                $apellidoPaterno = array(
                    'name' => 'apellidoPaterno',
                    'id' => 'apellidoPaterno',
                );
                $apellidoMaterno = array(
                    'name' => 'apellidoMaterno',
                    'id' => 'apellidoMaterno',
                );
                $password = array(
                    'name' => 'password',
                    'id' => 'password',
                    'value' => '',
                );
                $passwordVerificacion = array(
                    'name' => 'passwordVerificacion',
                    'id' => 'passwordVerificacion',
                    'value' => '',
                );
                $link = array(
                    'name' => 'link',
                    'id' => 'link',
                    'value' => '',
                );

                $tipoUsuario = array();
                foreach ($tipo_usuario as $key => $value) {
                    $tipoUsuario[$value['idtipoUsuario']] = $value['nombre'];
                }

                $hidden = array(
                    'fbid' => '',
                    'avatar' => '',
                );

                echo validation_errors();
                echo form_open();
                ?>
                <label> Email
                    <?= form_input($mail); ?>
                </label>
                <label>Nombre
                    <?= form_input($nombre); ?>
                </label>
                <label>Apellido Paterno
                    <?= form_input($apellidoPaterno); ?>
                </label>
                <label>Apellido Materno
                    <?= form_input($apellidoMaterno); ?>
                </label>
                <label>Password
                    <?= form_password($password) ?>
                </label>
                <label>Confirme Password
                    <?= form_password($passwordVerificacion); ?>
                </label>
                <label>Tipo de Usuario
                    <?= form_dropdown('tipo_usuario', $tipoUsuario); ?>
                </label>
                <label>Link directo
                    <?= form_input($link); ?>
                </label>
                    <?= form_hidden($hidden); ?>
                    <?= form_submit('enviarRegistro', 'Enviar', "class='button'"); ?>
                    <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>