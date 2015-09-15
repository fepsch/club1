<div id="inicio-sesion" class="wrapper overflowauto centerbox">
    <div id="fb-root"></div>
    <div id="registro" class="float-left">
        <h2>CREAR UNA CUENTA</h2>
        <form action="<?= base_url('registro'); ?>"class="centerbox form-registro" method='POST'>						
            <input type="text" name="nombre" placeholder="Nombre*" value="<?= set_value('nombre', isset($nombre) ? $nombre : '') ?>"/>
            <input type="text" name="apellidoPaterno" placeholder="Apellido Paterno*" value="<?= set_value('apellidoPaterno', isset($apellidoPaterno) ? $apellidoPaterno : '') ?>"/>
            <input type="text" name="apellidoMaterno" placeholder="Apellido Materno" value="<?= set_value('apellidoMaterno', isset($apellidoMaterno) ? $apellidoMaterno : '') ?>"/>		
            <input type="text" name="mail" placeholder="Correo Electrónico*" value="<?= set_value('mail', isset($mail) ? $mail : '') ?>"/>
            <input type="password" name="password" placeholder="Contraseña*" value="<?= set_value('password') ?>"/>
            <input type="password" name="passwordVerificacion" placeholder="Repetir Contraseña" <?= set_value('passwordVerificacion') ?>/>           
            <select name="comuna">
                <option value="">Comuna</option>
                <?php foreach($comunas as $comuna): ?>
                <option value="<?= $comuna['idComuna']; ?>"><?= $comuna['nombreComuna']; ?></option>
                <?php endforeach; ?>
            </select>

            <div>
                <div class="float-left disclaimer">
                    *Campos obligatorios
                </div>
                <input id ="registrarme" class="bot-light" type="submit" value="Registrarse" />
            </div>
            <div class="registro_error"><?php echo validation_errors(); ?></div>
        </form>
    </div>
    <div id="login-light" class="float-left">
        <h2>Entra con tu cuenta</h2>
        <form class="form-registro" action="<?= base_url('login'); ?>" method="POST">
            <div>
                <?php
                echo form_error('username');
                echo form_error('password2');
                ?>			
            </div>						
            <div id="campos-login">
                <div class="username">
                    <input type="text" name="username" size="13" placeholder="Ingresa tu mail" />
                </div>
                <div class="password">
                    <input type="password" name="password2" size="13" placeholder="Contraseña"/>
                </div>
                <a href="<?= base_url('home/resetPwd'); ?>">Olvidé mi contraseña</a>
            </div>
            <div><?= isset($error) ? $error : ''; ?></div>
            <div>
                <input type="submit" value="Ingresar" class="bot-light">
            </div>
        </form>
        <div>
            <div>
                <span>O inicia sesión con</span>
            </div>
            <div class="fb-login-button" data-max-rows="1" data-size="medium" data-scope="basic_info, email" onlogin="fbLogin" data-show-faces="false" data-auto-logout-link="false"></div>
        </div>
    </div>
    <script type="text/javascript">
        /*window.fbAsyncInit = function() {
            FB.init({
                appId: '160123597528115',
                status: true,
                xfbml: true,
                cookie: true
            });
        };

        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {
                return;
            }
            js = d.createElement(s);
            js.id = id;
            js.src = "//connect.facebook.net/es_LA/all.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));*/
        FB.init({
                appId: '160123597528115',
                status: true,
                xfbml: true,
                cookie: true
            });
        $(document).ready(function() {
            $('.form-registro').submit(function(event) {
                event.preventDefault();
                var form = $(this);
                var url = form.attr('action');
                $.post(url, form.serialize(), function(data) {
                    try {
                        var resp = JSON.parse(data);
                        if (resp.success) {
                            $.magnificPopup.close();
                            window.location.href = resp.url;
                        }
                    } catch (e) {
                        $('#inicio-sesion').replaceWith(data);
                    }
                });
            });
        });

        function fbLogin() {
            $.post("<?= base_url('login/fblogin'); ?>").done(function(data) {
                try {
                        var resp = JSON.parse(data);
                        if (resp.success) {
                            $.magnificPopup.close();
                            window.location.href = resp.url;
                        }
                    } catch (e) {
                        $('#inicio-sesion').replaceWith(data);
                    }
            });
        }
    </script>
</div>