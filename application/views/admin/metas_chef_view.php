<div class="row">
    <div class="small-12 columns">
        <h3>Descripci&oacute;n Personal</h3>
        <div id="listar">
            <table>
                <?php foreach ($metasChef as $meta): ?>
                    <?php $dato = isset($meta['dato']) ? $meta['dato'] : ''; ?>
                    <tr>
                        <td><?= ucwords(str_replace('_', ' ', $meta['nombreMeta'])); ?></td>
                        <td><?= $dato; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>

<div class="row">
    <div class="small-12 columns">
        <h3>Parametros para eventos</h3>
        <div id="listar">
            <table>
                <?php foreach ($parametros_chef as $meta): ?>
                    <?php $dato = isset($meta['dato']) ? $meta['dato'] : ''; ?>
                    <tr>
                        <td><?= ucwords(str_replace('_', ' ', $meta['nombreMeta'])); ?></td>
                        <td><?= $dato; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>