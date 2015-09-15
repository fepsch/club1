<div class="row">
    <div class="small-12 columns">
        <div id ="listar-metas-chef" class="container">
            <a class="button tiny fi-plus" href="<?= base_url() . 'admin/metas/add/2' ?>"> Descripcion Personal</a>
            <a class="button tiny fi-plus" href="<?= base_url() . 'admin/metas/add/3' ?>"> Comuna</a>
            <a class="button tiny fi-plus" href="<?= base_url() . 'admin/metas/add/4' ?>"> Especialidad</a>
            <div id="lista">
                <ul class='lista-ver'>
                    <?php foreach ($metas as $meta): ?>
                        <li>
                            <div class="row ">
                                <div class="medium-5 columns">
                                    <a href="<?= base_url() . "admin/metas/view/" . $meta['idMetaKey']; ?>"><?= ucwords(str_replace('_', ' ', $meta['nombreMeta'])) . ' - ' . $meta['nombreTipo'] ?></a>
                                </div>
                                <div class="medium-2 end columns">

                                    <a href="<?= base_url() . "admin/metas/edit/" . $meta['idMetaKey']; ?>" class="left fi-pencil button tiny"></a>
                                    <a href="<?= base_url() . "admin/metas/del/" . $meta['idMetaKey']; ?>" class="del left fi-minus button tiny"></a>
                                </div>
                            </div>
                        </li>
                        <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
