<div class="row">
    <div class="small-12 medium-6 columns">
        <div id="listar">
            <h3>Listado de Eventos</h3>
            <?php
            if (isset($actividades)):
                if (empty($actividades)):
                    echo 'No existen registros<br>';
                else:
                    ?>
                    <table border="1">
                        <tr>
                            <th>Fecha</th>
                            <th>Valor</th>
                            <th>Nro. Pasajeros</th>
                            <th>Evaluaci&oacute;n</th>
                            <th>Estado</th>
                        </tr>
                        <?php foreach ($actividades as $actividad): ?>
                            <tr>
                                <td><?= $actividad['fecha'] ?></td>
                                <td><?= $actividad['valor'] ?></td>
                                <td><?= $actividad['pasajeros'] ?></td>
                                <td><?= $actividad['evaluacion'] ?></td>
                                <td><?= $actividad['nombre'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                <?php endif; ?>
            </table>
        </div> 
    </div>
</div>
