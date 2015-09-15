<!DOCTYPE>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="shortcut icon" href="<?= base_url('images/favicon.ico'); ?>" />
        <title>Página no encontrada</title>
        <link href="<?= base_url('css/style2.css'); ?>" rel="stylesheet" media="screen" />
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
    </head>
    <body>
        <div id="mensaje-404">
            <div id="wrapper-fallo">
                <div>
                    <div><img src="<?= base_url('images/barra-error-top.png'); ?>" /></div>
                    <div class="overflowauto">
                        <div id="img-fallo" class="float-left">
                            <img src="<?= base_url('images/img-error.png'); ?>" alt="error" />
                        </div>
                        <div id="op-fallida-texto" class="float-left">
                            <div class="destacado-fracaso">Error 404</div>
                            <div class="destacado-fracaso">La página solicitada no fue encontrada</div>
                        </div>
                    </div>
                </div>
                <div><img src="<?= base_url('images/barra-error-bottom.png'); ?>" /></div>
                <div id="back-404">
                    <a id="link-home-404" href="<?= base_url(); ?>">Volver al Home</a>
                </div>
            </div>
        </div>
    </body>
</html>