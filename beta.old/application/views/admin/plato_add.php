<div class="row">
    <div class="small-12 medium-6">
<div class="container">
    <? //print_r($plato)?>
    <h1>
        <? //$titulo?>
    </h1>
    <div id="formulario">
    <?php echo validation_errors(); ?>
    <?php echo form_open_multipart(); ?>
    <input type='hidden' name='experiencia' value='<?= $idExperiencia ?>' />
    <div>
        Nombre
    <input type="text" name="nombre" value="<?= set_value('nombre', (isset($plato['nombre']) ? $plato['nombre'] : '')) ?>"/>
    </div>
    <div>
        Descripción
    <textarea name="descripcion" ><?= set_value('descripcion', (isset($plato['descripcion']) ? $plato['descripcion'] : '')) ?></textarea>
    </div>
    <div>
        Imagen
    <input type="file" name="imagen"/>
    <? if (isset($plato['imagen'])){ ?>
        <img src="<?= base_url('/images/platos/'.$plato['imagen'])?>" class='small-12 columns' />
    <? } ?>
    </div>
    <input type='submit' value='Guardar' class='button tiny' />
    <div>
        <?= isset($error) ? $error : '' ?>
    </div>
    <?php echo form_close(); ?>
</div>
</div>
</div>