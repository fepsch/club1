<div>
    <?php $this->load->view('mipanel/menu') ?>
    <div id="form-panel" class="centerbox overflowauto">
        <?php echo validation_errors(); ?>
        <?php echo form_open_multipart('mipanel/perfil'); ?>
        <div id="container-form" class="bg-color-general overflowauto">
            <div id="datos-configuracion" class="float-left">
                <div class="campo-conf">
                    <label for="nombre" >Nombre</label><br>
                    <input type="text" name="nombre" id="nombre" value="<?= set_value('nombre', $usuario['nombre']); ?>">
                </div>
                <div class="float-left campo-conf">
                    <label for="aPaterno">Apellido Paterno</label><br>
                    <input type="text" name="aPaterno" id="aPaterno" class="apellido"  value="<?= set_value('aPaterno', $usuario['apellidoPaterno']); ?>">
                </div>
                <div class="float-right campo-conf">
                    <label for="aMaterno">Apellido Materno</label><br>
                    <input type="text" name="aMaterno" id="aMaterno" class="apellido"  value="<?= set_value('aMaterno', $usuario['apellidoMaterno']); ?>">
                </div>
                <div class="campo-conf">
                    <label for="mail">Email</label><br>
                    <input type="text" name="mail" id="mail" value="<?= set_value('mail', $usuario['mail']); ?>">
                </div>
                <div class="campo-conf">
                    <label for="direccion">Dirección</label><br>
                    <input type="text" name="direccion" id="direccion">
                </div>
                <div class="campo-conf">
                    <label for="password">Contraseña</label><br>
                    <input type="password" name="password" id="password" value="<?= set_value('password', ''); ?>">
                </div>
                <div class="campo-conf">
                    <label for="passwordVerificacion">Repetir Contraseña</label><br>
                    <input type="password" name="passwordVerificacion" id="passwordVerificacion" value="<?= set_value('passwordVerificacion', ''); ?>">
                </div>
                <div class="overflowauto campo-conf">
                    <div class="float-left medio-div">
                        <label for="comuna">Comuna</label>
                        <input type="text" name="comuna" id="comuna">
                    </div>
                    <div class="float-right medio-div gap-region-comuna">
                        <label for="dia">Fecha de nacimiento</label>
                        <input type="text" id="fechanac">
                        <input type="hidden" name="fechanac" id="altfecha">
                    </div>
                </div>
            </div>
            <div id="avatar-configuracion" class="float-left">
                <div class="container-imagen overflowauto">
                    <div id="titulo-avatar" class="bg-color-general">AVATAR</div>
                    <img src="<?= base_url('avatar/' . $usuario['avatar']); ?>" />
                </div>
                <div class="avatar-uploader">
                    <input type="file" name="avatar" value="Editar foto">
                </div>
                <div class="guardar">
                    <input type="submit" value="Guardar Cambios" class="btn-guardar">
                </div>
            </div>

            <div class="error-form-panel">
                <?= isset($error) ? $error : '' ?>
            </div>
        </div>
        <?= form_close(); ?>
    </div>
    <script>
        $(function() {
            $("#fechanac").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'dd-mm-yy',
                altField: "#altfecha",
                altFormat: 'yy-mm-dd',
                firstDay: 1,
                minDate: -365 * 80,
                maxDate: -365 * 15,
                yearRange: "-80:-15"
            });
            $("#fechanac").datepicker("option", $.datepicker.regional["es"]);
        });
    </script>
</div>