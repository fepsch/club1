<div class="row">
    <div class="small-12 columns">
        <div id="listar">
            <h3>Pagos realizados</h3>
            <?php
            if (isset($actividades)):
                if (empty($actividades)):
                    echo 'No existen registros<br>';
                else:
                    ?>
                    <table border="1">
                        <tr>
                            <th>Fecha</th>
                            <th>Actividad</th>
                            <th>Respuesta</th>
                            <th>Id Autorizaci&oacute;n</th>
                            <th>Final Tarjeta</th>
                        </tr>
                        <?php foreach ($pagos as $pago): ?>
                            <tr>
                                <td><?= $pago['fecha'] ?></td>
                                <td><a href="<?= base_url() . 'admin/actividades/view/' . $pago['idActividad'] ?>">Ver</a></td>
                                <td><?= $pago['respuesta'] ?></td>
                                <td><?= $pago['codigoAutorizacion'] ?></td>
                                <td><?= $pago['finalTarjeta'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>

                </table>
            <?php endif; ?>
        </div>
    </div>
</div>