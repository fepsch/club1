<div class="row">
    <div class="small-12 columns">
        <div id="listar">
            <h3>Reclamos recibidos</h3>
            <?php
            if (isset($reclamos_recibidos)):
                if (empty($reclamos_recibidos)):
                    echo 'No existen reclamos recibidos<br>';
                else:
                    ?>
                    <table border="1">
                        <tr>
                            <th>Fecha</th>
                            <th>Actividad</th>
                            <th>Titulo</th>
                            <th>Contenido</th>
                            <th>Leido</th>
                        </tr>
                        <?php foreach ($reclamos_recibidos as $reclamo): ?>
                            <tr>
                                <td><?= $reclamo['fecha'] ?></td>
                                <td><a href="<?= base_url() . 'admin/actividades/view/' . $reclamo['idActividad'] ?>">Ver</a></td>
                                <td><?= $reclamo['titulo'] ?></td>
                                <td><?= $reclamo['contenido'] ?></td>
                                <td><?= $reclamo['leido'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>