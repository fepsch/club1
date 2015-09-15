<fieldset>
    <legend>Platos Experiencia</legend>
    <div class="row">
        <a class="button tiny fi-plus round right"href="<?= base_url('admin/platos/add/' . $idExperiencia); ?>">
            Agregar nuevo plato
        </a>
    </div>
    <?php
    if (isset($platos)):
        if (empty($platos)):
            echo 'No existen platos para esta experiencia.<br>';
        else:
            ?>
            <table border="1">
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Imagen</th>
                    <th></th>
                </tr>
                <?php foreach ($platos as $plato): ?>
                    <tr>
                        <td><?= $plato['nombre'] ?></td>
                        <td><?= $plato['descripcion'] ?></td>
                        <td><div class="img-prev-plato"><img src="<?= base_url('images/platos/' . $plato['imagen']); ?>"/></div></td>
                        <td><a href="<?= base_url('admin/platos/edit/' . $plato['idPlato']); ?>" class="left fi-pencil button tiny "></a></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    <?php endif; ?>
</fieldset>