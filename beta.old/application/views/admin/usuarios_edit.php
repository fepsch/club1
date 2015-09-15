<div class="row">
    <div class="small-6">
        <div id="container">
            <h1>
                <? //$titulo?>
            </h1>

            <div id="formulario">
                <?
                foreach ($usuarios as $usuario):

                    $mail = array(
                        'name' => 'mail',
                        'id' => 'mail',
                        'value' => $usuario['mail'],
                    );
                    $nombre = array(
                        'name' => 'nombre',
                        'id' => 'nombre',
                        'value' => $usuario['nombre'],
                    );
                    $apellidoPaterno = array(
                        'name' => 'apellidoPaterno',
                        'id' => 'apellidoPaterno',
                        'value' => $usuario['apellidoPaterno'],
                    );
                    $apellidoMaterno = array(
                        'name' => 'apellidoMaterno',
                        'id' => 'apellidoMaterno',
                        'value' => $usuario['apellidoMaterno'],
                    );

                    $hidden = array(
                        'fbid' => $usuario['fbid'],
                        'avatar' => $usuario['avatar'],
                        'idUsuario' => $usuario['idUsuario'],
                    );



                    echo validation_errors();
                    ?>
                    <?= form_open(); ?>

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

                    <?= form_hidden($hidden); ?>
                    <?= form_submit('enviarRegistro', 'Enviar', "class='button'"); ?>
                    <?= form_close(); ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>