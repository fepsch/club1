<div id="contacto" class="overflowauto bg-color-general">
    <div class="titulo-contacto mayus">CONTÁCTANOS</div>
    <?= form_open('home/contacto') ?>
    <div class="float-left">
        <div class="contacto-fields">
            <div class="label">Nombre*</div>
            <div>
                <input type="text" name="nombre"/>
                <div class="error-validacion"><?= form_error('nombre') ?></div>
            </div>
        </div>
        <div class="contacto-fields">
            <div class="label">Correo*</div>
            <div>
                <input type="text" name="mail"/>
                <div class="error-validacion"><?= form_error('mail') ?></div>
            </div>
        </div>
        <div class="contacto-fields">
            <div class="label">Asunto</div>
            <div>
                <input type="text" name="asunto"/>
                <div class="error-validacion"><?= form_error('asunto') ?></div>
            </div>
        </div>
    </div>
    <div class="float-left">
        <div>Mensaje*</div>
        <textarea name="mensaje"></textarea>
        <div class="error-validacion"><?= form_error('mensaje') ?></div>
    </div>
    <?= isset($mensaje) ? $mensaje : ''; ?>
    <div class="float-right">
        <input class="enviar-contacto" type="submit" value="Enviar Mensaje" />
    </div>
    <?= form_close(); ?>
</div>
