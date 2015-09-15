<div class="row">
    <div class="small-12 columns">
        <h3>Horarios</h3>
        <table>
            <tr>
                <th>Periodos</th>
                <th>Lunes</th>
                <th>Martes</th>
                <th>Miércoles</th>
                <th>Jueves</th>
                <th>Viernes</th>
                <th>Sábado</th>
                <th>Domingo</th>
                <?php $idPeriodo = NULL; ?>
                <?php foreach ($periodos as $periodo): ?>
                    <?php if ($idPeriodo != $periodo['idPeriodo']): ?>
                        <?php $idPeriodo = $periodo['idPeriodo']; ?>
                    </tr><tr>
                        <td><?= date('H:i', strtotime($periodo['inicio'])) . ' - ' . date('H:i', strtotime($periodo['fin'])) ?></td>
                        <td style="text-align: center">
                            <?php if (isset($periodo['idChef'])): ?>
                                <span class="fi-check"></span>
                            <?php endif; ?>
                        </td>
                    <?php else: ?>
                        <td style="text-align: center">
                            <?php if (isset($periodo['idChef'])): ?>
                                <span class="fi-check"></span>
                            <?php endif; ?>
                        </td>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tr>
        </table>
        <div>
            <a class="fi-pencil" href="<?= base_url('admin/chefs/modificarCalendario/'.$datos_usuario['idUsuario']); ?>" > Modificar Calendario</a>
        </div>
    </div>
</div>