<div class="row">
    <div class="small-12 medium-6">
<div class="container">
    <h1>
        <? //$titulo?>
    </h1>
    <div id="formulario">
<?php
$tipos = $tiposMeta;
$valorTipo = $meta['tipoMeta'];

/* $publico = array(
  'name' => 'publico',
  'id' => 'publico',
  'value' => $meta['publico'],
  ); */
?>
<?= validation_errors(); ?>
<?= form_open('', array('id' => 'edit-meta')); ?>
<fieldset>
    <legend>Datos</legend>
<label for="nombre" >Nombre</label>
<input type="text" id="nombre" name="nombre" value="<?= set_value('nombre', (isset($meta['nombreMeta']) ? $this->functions->meta_a_ui($meta['nombreMeta']) : '')); ?>" />
<label for="tipo">Tipo</label>
<?= form_dropdown('tipo', $tipos, $valorTipo); ?>
<ul><li>
<input type="checkbox" name="requerido" id="requerido" value="1" <?= set_checkbox('requerido', '1'); ?>/>
Requerido
</li>
</ul>
<input type="submit" value="Enviar" class='button tiny'/>
<input type="button" value="Cancelar" class="cancelar button tiny"/>
</fieldset>
<?= form_close(); ?>
<script type="text/javascript">
    $('#edit-meta').submit(function() {
        if (!$('#requerido').is(':checked') && $('#nombre').val() !== '') {
            var confirma = confirm('¿Está seguro de que este meta no sea requerido?');
            if (confirma) {
                return true;
            } else {
                return false;
            }
        }
    });

    $('.cancelar').click(function() {
        window.location.href = '<?= base_url('admin/metas/listarMetasChef'); ?>';
    });
</script>
</div>
</div>
</div>
