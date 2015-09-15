<div class="row">
    <div class="small-12 medium-6">

    
<div id="container">
    
    <div id="formulario">
        <?php
        echo validation_errors();
        echo form_open();
        ?>
        <fieldset>
            <legend>Datos periodo</legend>
        Hora de Inicio
        <input type="text" id="inicio" name="inicio" value="<?= set_value('inicio', isset($periodo['inicio']) ? date('H:i', strtotime($periodo['inicio'])) : ''); ?>" />
        Hora Tope
        <input type="text" id="fin" name="fin" value="<?= set_value('fin', isset($periodo['fin']) ? date('H:i', strtotime($periodo['fin'])) : ''); ?>"/>
        <label>
            <input type="submit" class='button tiny' value="Enviar" />
        </label>
        </fieldset>
        <?php
        
        echo form_close();
        ?>
    </div>
</div>
<script>
    jQuery('#inicio').datetimepicker({
        datepicker: false,
        format: 'H:i',
        formatTime: 'H:i',
        onShow: function(ct) {
            this.setOptions({
                maxTime: jQuery('#fin').val() ? jQuery('#fin').val() : false
            });
        },
    });

    jQuery('#fin').datetimepicker({
        datepicker: false,
        format: 'H:i',
        formatTime: 'H:i',
        onShow: function(ct) {
            this.setOptions({
                minTime: jQuery('#inicio').val() ? jQuery('#inicio').val() : false
            });
        },
    });
</script>

</div>
</div>