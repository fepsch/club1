<div class="row">
    <div class="small-12 columns">
        <div id="listar">
            <h3>Reclamos realizados</h3>
            <?php
            if (isset($reclamos)):
                if (empty($reclamos)):
                    echo 'No existen reclamos<br>';
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
                        <?php foreach ($reclamos as $reclamo): ?>
                            <tr>
                                <td><?= date('d/m/Y', strtotime($reclamo['fecha'])) ?></td>
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