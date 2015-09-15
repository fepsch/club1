<script src="<?= base_url('js/raty/lib/jquery.raty.min.js') ?>"></script>
<div id="superior" class="centerbox">
    <div id="datos-avatar" class="float-left">
        <div class="avatar-calif">
            <img class="float-right" src="<?= base_url('avatar/' . $chef['avatar']); ?>" alt="Avatar del Chef"/>
        </div>
    </div>
    <div id="datos-evento" class="float-left mayus">
        <div class="nombre-calif SueEllen mayus info-calif"><p><?= $chef['nombre'] . ' ' . $chef['apellidoPaterno'] . ' ' . $chef['apellidoMaterno'] ?></p></div>
        <div class="experiencia-calif mayus info-calif"><?= $experiencia['nombre'] ?></div>
        <p><?= $actividad['direccion']; ?></p>
        <p><?= date('d/m/Y', strtotime($actividad['fecha'])); ?></p>
        <p>N° Personas: <?= $actividad['pasajeros']; ?></p>
    </div>
</div>
<div id="calificar" class="overflowauto">
    <div id="estrellas" class="float-left">
        <?php if (!empty($metasEval)): ?>
            <form id="form-calificaciones">
                <div class="titulo">¿Con cuántos tenedores calificas tu experiencia con el Club de la Cocina en cuánto a..</div>
                <ul>
                    <?php foreach ($metasEval as $eval): ?>
                        <li>
                            <div class="titulo-calificacion"><?= ucwords(str_replace('_', ' ', $eval['nombreMeta'])) ?></div>
                            <div id="<?= normaliza($eval['nombreMeta']); ?>" meta-id="<?= $eval['idMetaKey'] ?>"></div>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <?php if ($actividad['evaluacion'] != 1): ?>
                <div class="submit-raty">
                    <input type="submit" class="enviar-buscador" value="Guardar">
                </div>
                <?php endif; ?>
            </form>
        <?php endif; ?>
    </div>
    <div id="tabla-valoracion" class="float-right">
        <table class="mayus">
            <tr><th colspan="2" class="SueEllen">Tabla de Calificaciones</th></tr>
            <tr>
                <td class="col-izq">Excelente</td>
                <td class="col-der">
                    <img src="<?= base_url('js/raty/img/star-on.png') ?>"/>
                    <img src="<?= base_url('js/raty/img/star-on.png') ?>"/>
                    <img src="<?= base_url('js/raty/img/star-on.png') ?>"/>
                    <img src="<?= base_url('js/raty/img/star-on.png') ?>"/>
                    <img src="<?= base_url('js/raty/img/star-on.png') ?>"/>
                </td>
            </tr>
            <tr>
                <td class="col-izq">Muy bueno</td>
                <td class="col-der">
                    <img src="<?= base_url('js/raty/img/star-on.png') ?>"/>
                    <img src="<?= base_url('js/raty/img/star-on.png') ?>"/>
                    <img src="<?= base_url('js/raty/img/star-on.png') ?>"/>
                    <img src="<?= base_url('js/raty/img/star-on.png') ?>"/>
                    <img src="<?= base_url('js/raty/img/star-off.png') ?>"/>
                </td>
            </tr>
            <tr>
                <td class="col-izq">Bueno</td>
                <td class="col-der">
                    <img src="<?= base_url('js/raty/img/star-on.png') ?>"/>
                    <img src="<?= base_url('js/raty/img/star-on.png') ?>"/>
                    <img src="<?= base_url('js/raty/img/star-on.png') ?>"/>
                    <img src="<?= base_url('js/raty/img/star-off.png') ?>"/>
                    <img src="<?= base_url('js/raty/img/star-off.png') ?>"/>
                </td>
            </tr>
            <tr>
                <td class="col-izq">Regular</td>
                <td class="col-der">
                    <img src="<?= base_url('js/raty/img/star-on.png') ?>"/>
                    <img src="<?= base_url('js/raty/img/star-on.png') ?>"/>
                    <img src="<?= base_url('js/raty/img/star-off.png') ?>"/>
                    <img src="<?= base_url('js/raty/img/star-off.png') ?>"/>
                    <img src="<?= base_url('js/raty/img/star-off.png') ?>"/>
                </td>
            </tr>
            <tr>
                <td class="col-izq">Malo</td>
                <td class="col-der">
                    <img src="<?= base_url('js/raty/img/star-on.png') ?>"/>
                    <img src="<?= base_url('js/raty/img/star-off.png') ?>"/>
                    <img src="<?= base_url('js/raty/img/star-off.png') ?>"/>
                    <img src="<?= base_url('js/raty/img/star-off.png') ?>"/>
                    <img src="<?= base_url('js/raty/img/star-off.png') ?>"/>
                </td>
            </tr>
            <!--<tr>
                <td class="col-izq">Pésimo</td>
                <td class="col-der"><img src="<?= base_url() ?>images/pesimo.png" /></td>
            </tr>-->
        </table>
    </div>
</div>
<div id="comentario-calif" class="overflowauto">
    <div class="mayus titulo-tags">Comentarios</div>
    <form id="form-comentario" action="<?= base_url('mipanel/guardaComentario') ?>" method="POST">
        <textarea class="float-left" name="comentario"><?= !empty($comentario) ? $comentario[0]['contenido'] : ''; ?></textarea>
        <div class="float-left guardar-calif"><input type="submit" value="Guardar"></div>
        <div class="informacion"></div>
    </form>
</div>
<script>
    $('#form-comentario').submit(function(event) {
        event.preventDefault();
        $('.informacion').html('');
        var form = $(this);
        var url = form.attr('action');
        var msje = form.find('textarea[name="comentario"]').val();
        $.post(url, {comentario: msje, idActividad: <?= $actividad['idActividad'] ?>}).done(function() {
            $('.informacion').html('COMENTARIO GUARDADO EXITOSAMENTE');
        });
    });
<?php
foreach ($metasEval as $eval):
    $evalNota = isset($eval['nota']) ? $eval['nota'] : 0
    ?>
        $('#<?= normaliza($eval['nombreMeta']) ?>').raty({
            space: false,
            path: "<?= base_url('js/raty/img') ?>",
            width: false,
            <?php if($actividad['evaluacion'] == 1): ?>
                readOnly: true,
            <?php endif; ?>
            scoreName: '<?= normaliza($eval['idMetaKey']) ?>',
            score: <?= $evalNota ?>,
            /*click: function(score) {
             $.post('<?= base_url('mipanel/guardaCalificacion'); ?>',
             {
             idActividad: <?= $actividad['idActividad'] ?>,
             idMeta: $(this).attr('meta-id'),
             nota: score
             }
             );
             }*/
        });

<?php endforeach; ?>
    $("#form-calificaciones").submit(function(e) {
        e.preventDefault();
        var counter = 0;
        $(this).find("input[type=hidden]").each(function() {
            if ($(this).val() == "") {
                counter++;
            }
        });
        if (counter > 0) {
            var r = confirm("Aun existen atributos sin calificar. ¿Está seguro de continuar? De ser así, serán calificados con 1 tenedor");
            if (!r) {
                return false;
            }
        }

        $.blockUI({message: $('#mensaje-carga')});
        $.post('<?= base_url('actividad/cierraCalificacion/' . $actividad['idActividad']); ?>',
                $(this).serialize()
                ).done(function() {
            $.unblockUI();
            alert("Muchas gracias por su opinión!");
            $.post('<?= base_url('mipanel/calificacionesActividad/' . $actividad['idActividad']); ?>').done(function(data) {
                $('#result').html(data);
            });
        });
    });
</script>
<?php

function normaliza($cadena) {
    $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
    $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
    $cadena = utf8_decode($cadena);
    $cadena = strtr($cadena, utf8_decode($originales), $modificadas);
    $cadena = strtolower($cadena);
    $cadena = str_replace(' ', '_', $cadena);
    return utf8_encode($cadena);
}
?>