<div class="row">
    <div class="small-12 columns">
        <div id="listar">
            <h3>Listado de Eventos entregados</h3>
            <?php
            if (isset($actividades_chef)):
                if (empty($actividades_chef)):
                    echo 'No existen registros de eventos entregados<br>';
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
                        <?php foreach ($actividades_chef as $actividad): ?>
                            <tr>
                                <td><?= date('d/m/Y H:i', strtotime($actividad['fecha'])); ?></td>
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
