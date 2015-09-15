<div class="container">
    <h1>
        <? //$titulo?>
    </h1>
    <div id="registro">
        <?
        echo validation_errors();
        echo form_open();
        ?>
        <div>Email <input type="text" name="mail" value="<?= set_value('mail') ?>" /></div>
        <div>Nombre <input type="text" name="nombre" value="<?= set_value('nombre') ?>" /></div>
        <div>Apellido Paterno <input type="text" name="apellidoPaterno" value="<?= set_value('apellidoPaterno') ?>" /></div>
        <div>Apellido Materno <input type="text" name="apellidoMaterno" value="<?= set_value('apellidoMaterno') ?>" /></div>
        <div>Password <input type="password" name="password" value="<?= set_value('password') ?>" /></div>
        <div>Confirme Password <input type="password" name="passwordVerificacion" value="<?= set_value('passwordVerificacion') ?>" /></div>

        <?php include('fields.php'); ?>
        <div id="datospersonales-chef">
            <legend>Datos Personales</legend>
            <?php generaText($datosPersonales); ?>
        </div>
        <div id="comunas-chef">
            <legend>Comunas que trabaja</legend>
            <?php generaCheck($comunas); ?>
        </div>
        <div id="tags-chef">
            <legend>Tags</legend>
            <?php generaCheck($tags); ?>
        </div>
        <div>
            <input type="submit" value="Enviar" />
        </div>
        <?= form_close();    ?>

</div></div>

