<?php if (empty($actividades)): ?>
    <div id="no-data">
        <?php if ($seccion == 'calificacion'): ?>
            <h2>Aun no puedes calificar una experiencia</h2>
        <?php else: ?>
            <h2>No existen registros aun</h2>
        <?php endif; ?>
    </div>
<?php else: ?>
    <div id="carrusel-container">
        <div id="carrusel-panel" class="ca-container centerbox">
            <div class="ca-wrapper">
                <?php
                $href = '';
                switch ($seccion):
                    case 'inbox-chef':
                    case 'inbox': $href = 'mipanel/mensajesActividad/';
                        break;
                    case 'calificacion': $href = 'mipanel/calificacionesActividad/';
                        break;
                    case 'comentarios': $href = 'mipanel/comentarios/';
                        break;
                endswitch;
                foreach ($actividades as $actividad):
                    ?>
                    <div class="ca-item ca-avatar">
                        <a href="<?= base_url($href . $actividad['idActividad']); ?>" class="thumb-chef">
                            <img src="<?= base_url('avatar/' . $actividad['usuario']['avatar']); ?>" alt="avatar chef" />
                            <div class="info-carrusel">
                                <div><?= ucwords($actividad['usuario']['nombre'] . ' ' . $actividad['usuario']['apellidoPaterno']); ?></div>
                                <div>Fecha: <?= date('d/m/Y', strtotime($actividad['fecha'])); ?></div>
                                <?php if ($this->router->method == 'calificaciones' && !$actividad['evaluada']): ?>
                                    <div>Por Calificar</div>
                                    <?php else: ?>
                                    <div>Calificada</div>
                                <?php endif; ?>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>
<script>
    $('#carrusel-panel').contentcarousel({
        navigationAt: 2
    });
</script>