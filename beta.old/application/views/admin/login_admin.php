<div class="row login-admin">
    <div><?= validation_errors(); ?></div>
    <?= form_open(base_url('admin/login', array('method' => 'POST'))); ?>
    <div class="small-3 small-centered columns">
        <input type="text" name="username" placeholder="Nombre de Usuario" >
        <input type="password" name="password" placeholder="Password">
        <input type="submit" value="Ingresar" class="button tiny">
    </div>
    <div><?= isset($error) ? $error : ''; ?></div>
    <?= form_close(); ?>
</div>
