<?
$buscador = array(
    'name' => 'buscador',
    'id' => 'buscador',
);
?>
<div class="row">
    <div class="buscador-box small-12 large-6 medium-6 medium-centered large-centered columns">
        <?= form_open('admin/usuarios/buscar'); ?>
        <div class="row collapse">
            <div class="small-10 columns">
                <?= form_input($buscador,'',"placeholder='Buscar por mail...'"); ?>
            </div>
            <div class="small-2 columns">
                
                <?= form_submit('enviarRegistro', 'Enviar',"class='button postfix'"); ?>
            </div>
        </div>
        <?= form_close(); ?>
    </div>
</div>