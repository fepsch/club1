<script>
    $(document).ready(function() {
        $("ul.pagination").quickPagination({pageSize: "4"});
    });
</script>
<div>
    <?php $this->load->view('mipanel/menu') ?>
    <div id="content-panel">
        <?php if (empty($actividades)): ?>
            <div id="no-data">
                <h2>No existen registros</h2>
            </div>
        <?php else: ?>
            <div id="reservas" class="overflowauto">
                <?php $contador = 1 ?>
                <ul class="pagination reservas">
                    <?php foreach ($actividades as $actividad): ?>
                        <?php $classBottom = $contador % 4 == 0 ? ' nobottomline' : ''; ?>
                        <li class="centerbox overflowauto <?= $classBottom; ?>">
                            <div class="statusreserva float-left centerbox">
                                <h4><?= $actividad['estado'] ?></h4>
                                <?php if (!($actividad['evaluada']) && $actividad['estado'] == 'Terminada') : ?>
                                    <div class="link-calificar">
                                        <a href="<?= base_url('mipanel/calificaciones'); ?>">Calificar</a>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="chefreserva float-left">
                                <div class="cheffoto float-left">
                                    <img src="<?= base_url('avatar/' . $actividad['chef']['avatar']); ?>" alt="avatar chef">
                                </div>
                            </div>
                            <div class="nombre-chef float-left mayus"><?= $actividad['chef']['nombre']; ?></div>
                            <div>
                                <div class="chefdatos float-left mayus">
                                    <div><a class="simple-ajax-popup" href="<?= base_url('mipanel/verExperiencia/' . $actividad['experiencia']['id']); ?>"><?= $actividad['experiencia']['nombre'] ?></a></div>
                                    <div class="box-datos"><?= date('d/m/Y', strtotime($actividad['fecha'])) ?></div>
                                    <div class="mayus">N° DE PERSONAS</div>
                                    <div class="box-datos"><?= $actividad['pasajeros'] ?></div>
                                </div>

                                <div class="eventoreserva float-left">
                                    <div><?= $actividad['direccion']; ?></div>
                                    <div><?= $actividad['nroContacto']; ?></div>
                                </div>
                            </div>
                        </li>
                        <?php $contador++; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</div>
