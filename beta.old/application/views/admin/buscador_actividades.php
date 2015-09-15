<div class="row">
        <div class='small-12 medium-6  columns '>
<?php echo form_open('admin/actividades/listaActividades'); ?>
<div id="buscar_fecha">
    Fecha Inicio
    <input type="text" id="inicio" name="inicio" value=""/>
    Fecha Fin
    <input type="text" id="fin" name="fin" />
</div>
<div id="buscar_estado-chef">
    Estado Actividad
    <select name="estado">
        <option value="">Seleccione</option>
        <?php foreach ($estados as $estado): ?>
            <option value="<?= $estado['idEstadoActividad'] ?>"><?= $estado['nombre']; ?></option>
        <?php endforeach; ?>
    </select>
    Seleccione Chef
    <select name="chef">
        <option value="">Seleccione</option>
        <?php foreach ($chefs as $chef): ?>
            <option value="<?= $chef['idUsuario'] ?>"><?= $chef['nombre'] ?></option>
        <?php endforeach; ?>
    </select>
</div>

<input type="submit" value="Enviar" class='button tiny' />
<?php echo form_close(); ?>

<script>
    jQuery("#inicio").datetimepicker({
        lang: 'es',
        format: 'd-m-Y',
        formatDate: 'd-m-Y',
        onShow: function(ct) {
            this.setOptions({
                maxDate: jQuery('#fin').val() ? jQuery('#fin').val() : false
            })
        },
        closeOnDateSelect: true,
        dayOfWeekStart: 1,
        timepicker: false,
    });

    jQuery("#fin").datetimepicker({
        lang: 'es',
        format: 'd-m-Y',
        formatDate: 'd-m-Y',
        onShow: function(ct) {
            this.setOptions({
                minDate: jQuery('#inicio').val() ? jQuery('#inicio').val() : false
            })
        },
        closeOnDateSelect: true,
        dayOfWeekStart: 1,
        timepicker: false,
    });
</script>
</div>
</div>