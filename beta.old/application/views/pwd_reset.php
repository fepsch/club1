<div id="mail-recuperacion">
    <div class="linea-normal">Ingrese su mail</div>
    <div><?= validation_errors(); ?></div>
<?= form_open(); ?>
<input type="text" name="mail" />
<input type="submit" value="Enviar" />
<?= form_close(); ?>
</div>
