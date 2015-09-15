<?
if ((!isset($this->session->userdata['tipoUsuario']) || ( $this->session->userdata['tipoUsuario'] != 1)) && $this->router->class != 'login') {
    redirect(base_url('admin'), 'refresh');
}
?>
<!DOCTYPE html>
<!--[if IE 9]><html class="lt-ie10" lang="en" > <![endif]-->
<html class="no-js" lang="en" >

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CDLC | Admin</title>

        <!-- If you are using CSS version, only link these 2 files, you may add app.css to use for your overrides if you like. -->
        <link rel="stylesheet" href="<?= base_url() ?>css/normalize.css">
        <link href="<?= base_url('css/jquery-ui-1.9.2.custom.min.css'); ?>" rel="stylesheet" media="screen" />
        <link rel="stylesheet" href="<?= base_url() ?>css/foundation.css">
        <link rel="stylesheet" href="<?= base_url() ?>css/foundation-icons.css">
        <link rel="stylesheet" href="<?= base_url() ?>css/admin/style.css">
        <link rel="stylesheet" href="<?= base_url('css/jquery.datetimepicker.css') ?>">
        <script src="<?= base_url('js/jquery.min.js'); ?>"></script>
        <script src="<?= base_url('js/jquery-ui-1.9.2.custom.min.js'); ?>"></script>
        <script src="<?= base_url('js/i18n/datepicker-es.js'); ?>"></script>
        <script src="<?= base_url('js/tinymce/tinymce.min.js'); ?>"></script>
        <script src="<?= base_url() ?>js/modernizr.js"></script>
        <script src="<?= base_url('js/jquery.datetimepicker.js'); ?>"></script>

        <script>
            $(document).ready(function() {
                $('.del').click(function() {
                    var resp = confirm('¿Está seguro que desea borrar el registro?');
                    return resp;
                });
            });
            $(document).ready(function() {
                $('.off').click(function() {
                    var resp = confirm('¿Está seguro que desea deshabilitar este usuario?');
                    return resp;
                });
            });
            
            $(document).ready(function() {
                $('.on').click(function() {
                    var resp = confirm('¿Está seguro que desea habilitar este usuario?');
                    return resp;
                });
            });
        </script>
    </head>

    <body>
        <div id="wrapper-header">
            <div id="header"> 
                <div class="logo"></div> 
                <nav class="top-bar" data-topbar>
                    <ul class="title-area">
                        <li class="name"></li>
                        <li class="toggle-topbar menu-icon"><a href="#">Menu</a></li>
                    </ul>
                    <section class="top-bar-section">
                        <!-- Right Nav Section -->
                        <ul class="right">
                            <? if($this->router->class != 'home'):
                                $this->load->view('admin/menu'); ?>
                            <li class="divider"></li>
                            <li><a href='<?= base_url('admin/login/logout'); ?>'>Logout</a></li>
                            <?php endif; ?>
                        </ul>
                    </section>
                </nav>  
            </div>
        </div>
        <div id="wrapper-content">
            <div id="content">
                <div class='row'>
                <?
$controlador = $this->uri->segment(2);
$func = $this->uri->segment(3);
?>
<h1>
    
    <?= $controlador; ?>
    
</h1>
<h3>
    <?= $func; ?>
    
</h3>
</div>