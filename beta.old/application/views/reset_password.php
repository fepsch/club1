<div id="mail-recuperacion">
    <?= validation_errors(); ?>
    <?= form_open(); ?>
    Password
    <input type="password" name="password"/>
    Repetir Password
    <input type="password" name="repetirpassword" />
    <input type="submit" value="Enviar" />
    <?= form_close(); ?>
</div>