<div class="row">
    <div class="small-12 columns">
<div id ="listar-metas-chef" class="container">
    <li><a class="button tiny fi-plus" href="<?= base_url() . 'admin/metas/add/2' ?>">Tipo de comida</a></li>
    <li><a class="button tiny fi-plus" href="<?= base_url() . 'admin/metas/add/3' ?>">Texto general</a></li>
    <li><a class="button tiny fi-plus" href="<?= base_url() . 'admin/metas/add/4' ?>">Seleccion</a></li>
    <li><a class="button tiny fi-plus" href="<?= base_url() . 'admin/metas/add/5' ?>">Comuna</a></li>

    <?php
    $nombre = array(
        'name' => 'nombre',
        'id' => 'nombre',
    );

    echo validation_errors();?>

    <?=form_open('admin/metas/add/' . $tipo);?>
    <label>Nombre
    <?=form_input($nombre);?>
    </label>
    <?=form_submit('enviarDatos', 'Enviar',"class='button'");?>
    <?=form_close();?>
    ?>
    <div id="lista">
        <ul class='lista-ver'>
            <? foreach ($metas as $meta):
                ?>
                <li>
                    <div class="lista-titulo">
                        <a href="<?= base_url() . "admin/metas/view/" . $meta['idMetaKey']; ?>"><?= ucwords(str_replace('_', ' ', $meta['nombreMeta'])) . ' - ' . $meta['nombreTipo'] ?></a>
                    </div>
                    <div class="lista-acciones">
                        
                        <a href="<?= base_url() . "admin/metas/edit/" . $meta['idMetaKey']; ?>" class="left fi-pencil button tiny">Modificar</a>
                        <a href="<?= base_url() . "admin/metas/del/" . $meta['idMetaKey']; ?>" class="del left fi-minus button tiny">Eliminar</a>
                    </div>
                </li>
                <?
            endforeach;
            ?>
        </ul>
    </div>
</div>
    </div>
</div>
