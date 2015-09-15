<script>
    $(document).ready(function() {
        $("ul.pagination").quickPagination({pageSize: "3"});
    });
</script>
<div id="mensajes">
    <?php if (!empty($mensajes)) : ?>
        <ul class="pagination centerbox">
            <?php foreach ($mensajes as $mensaje): ?>
                <?php if ($mensaje['idUsuario'] == $this->session->userdata('idUsuario')): ?>
                    <li>
                        <div class="contenidomsje-izq overflowauto">
                            <div class="float-left imagenmsj imagen-izq">
                                <img src="<?= base_url('avatar/' . $mensaje['avatar']); ?>" alt="avatar chef" >
                            </div>
                            <div class="float-left textomsj textomsj-der">
                                <p><?= $mensaje['contenido'] ?></p>
                            </div>
                        </div>
                        <div class="puntamsje1"><img src="<?= base_url('images/punta-01.png'); ?>" /></div>
                    </li>
                <?php else: ?>
                    <li>
                        <div class="contenidomsje-der overflowauto">
                            <div class="float-left textomsj textomsj-izq">
                                <p><?= $mensaje['contenido'] ?></p>
                            </div>
                            <div class="float-left imagenmsj imagen-der">
                                <img src="<?= base_url('avatar/' . $mensaje['avatar']); ?>" alt="avatar chef" >
                            </div>
                        </div>
                        <div class="puntamsje2"><img src="<?= base_url('images/punta-02.png'); ?>" /></div>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>                            
    <?php endif; ?>
    <?php
    $idEvento = (int) $this->uri->segment(3);
    if ($idEvento !== 0):
        ?>
        <div id="error-msjes"><?php echo validation_errors(); ?></div>
        <div id="enviar-mensaje" class="overflowauto">
            <div id="mensaje-inbox" class="float-left overflowauto">

                <?php echo form_open('mipanel/mensajesActividad/' . $this->uri->segment(3), array('id' => 'form-mensaje')); ?>
                <textarea name="nvomensaje"></textarea>
                <input type="submit" value="ENVIAR">
                </form>
            </div>
            <div id="avatar-inbox" class="float-left">
                <img src="<?= base_url('avatar/' . $avatarUser); ?>" alt="Avatar">
            </div>
        </div>
    <?php endif; ?>
</div>
<script>
    $(document).ready(function() {
        $(function() {
            $('#form-mensaje').submit(function(event) {
                event.preventDefault();
                $.blockUI({ message: $('#mensaje-carga') });
                var form = $(this);
                var url = form.attr('action');
                var msje = form.find('textarea[name="nvomensaje"]').val();
                $.post(url, {nvomensaje: msje}).done(function(data) {
                    $('#result').html(data);
                    $.unblockUI();
                });
            });
        });
    });
</script>