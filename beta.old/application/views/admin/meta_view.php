<div id="meta-view">
    <h3>Atributo Chef # <?= $meta['idMeta']; ?> </h3>
    Nombre: <?= $meta['nombre']; ?>
    <br>
    Tipo: <?= $meta['tipoMeta']; ?>
    <br>
    P&uacute;blico: <?= $meta['publico']; ?>
    <br>
    <a href="<?= base_url().'admin/metas/edit/'.$meta['idMetaKey']; ?>">Editar</a>
    <a href="<?= base_url().'admin/metas/del/'.$meta['idMetaKey']; ?>" class="del" >Eliminar</a>
</div>