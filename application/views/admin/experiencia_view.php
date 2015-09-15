<div id="ver-experiencia">
    <div class="row">
        <div class="small-8 column small-centered">
            <fieldset>
                <legend>Experiencia <?= $experiencia['nombre']; ?></legend>
                <div class="row">
                    <div class="small-11 column">
                        <ul class="button-group right">
                            <li>
                                <a class="button fi-arrow-left tiny round" href="<?= base_url('admin/chefs/view/' . $experiencia['idUsuario']); ?>">
                                    Volver al perfil del chef
                                </a>
                            </li>
                            <li>
                                <a class="button fi-pencil tiny round" href="<?= base_url('admin/experiencias/edit/' . $experiencia['idExperiencia']); ?>">Modificar</a></li>
                            <li></li>
                        </ul>
                    </div>
                </div>
                <div id="datos-exp">
                    <fieldset>
                        <legend>Descripción</legend>
                        <div><?= $experiencia['descripcion']; ?></div>
                    </fieldset>
                    <fieldset>
                        <legend>Duración</legend>
                        <div class="row">
                            <div class="inline">
                                <span class="round success label">2 Personas:<?= $experiencia['tiempo2']; ?> Horas</span>
                                <span class="round success label">3 Personas: <?= $experiencia['tiempo3']; ?> Horas</span>
                                <span class="round success label">4 Personas: <?= $experiencia['tiempo4']; ?> Horas</span>
                                <span class="round success label">5 Personas: <?= $experiencia['tiempo5']; ?> Horas</span>
                                <span class="round success label">6 Personas: <?= $experiencia['tiempo6']; ?> Horas</span>
                                <span class="round success label">7 Personas: <?= $experiencia['tiempo7']; ?> Horas</span>
                                <span class="round success label">8 Personas: <?= $experiencia['tiempo8']; ?> Horas</span>
                                <span class="round success label">9 Personas: <?= $experiencia['tiempo9']; ?> Horas</span>
                                <span class="round success label">10 Personas: <?= $experiencia['tiempo10']; ?> Horas</span>
                                <span class="round success label">11 Personas: <?= $experiencia['tiempo11']; ?> Horas</span>
                                <span class="round success label">12 Personas: <?= $experiencia['tiempo12']; ?> Horas</span>
                                <span class="round success label">13 Personas: <?= $experiencia['tiempo13']; ?> Horas</span>
                                <span class="round success label">14 Personas: <?= $experiencia['tiempo14']; ?> Horas</span>
                            </div>
                        </div>
                    </fieldset>
                    <div class="img-experiencia">
                        <img src="<?= base_url('images/experiencias/' . $experiencia['imagen']); ?>" alt="Imagen de la Experiencia"/>
                    </div>
                </div>
                <?php
                $this->load->view('admin/listar_platos_experiencia', array(
                    'platos' => $platos,
                    'idExperiencia' => $experiencia['idExperiencia']));
                ?>
            </fieldset>
        </div>
    </div>
</div>