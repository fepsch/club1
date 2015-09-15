<script src="<?= base_url('js/raty/lib/jquery.raty.min.js') ?>"></script>
<div id="grafica-reviews" class="overflowauto">
    <div id="porciento-gral" class="caja-barras float-left bg-color-general">
        <div class="mayus SueEllen">Calificación según Usuarios</div>
        <div class="centerbox">
            <div class="float-left">0%</div>
            <div id="barra-general" class="barra-review float-left fork-rate"></div>
            <?= $porcentGral; ?>%
            <div class="lineas-verticales"></div>
            <div class="float-left font-reviews">Baja expectativa</div>
            <div class="float-right font-reviews">Sobre expectativa</div>
        </div>
    </div>
    <script>
        $(function() {
            $(".fork-rate").raty({
                path: "<?= base_url('js/raty/img') ?>",
                width: false,
                score: <?= $porcentGral * 5 / 100; ?>,
                readOnly: true
            });
        });
    </script>
    <?php if ($this->session->userdata('tipoUsuario') == 2): ?>
        <div id="porciento-detalle" class="caja-barras float-left barra-detalle bg-color-general">
            <?php foreach ($evaluaciones as $keyEval => $valEval): ?>
                <div class="font-reviews">
                    <div class="float-left"><?= $keyEval ?></div>
                    <div id="<?= strtolower(str_replace(' ', '_', $keyEval)) ?>" class="barra-review float-left"></div>
                </div>
                <script>
                    $(function() {
                        $("#<?= strtolower(str_replace(' ', '_', $keyEval)) ?>").progressbar({
                            value: <?= $valEval; ?>
                        });
                    });
                </script>
            <?php endforeach; ?>
            <div id="expectativa-detalle" class="float-right">
                <div class="lineas-verticales"></div>
                <div class="float-left">Baja expectativa</div>
                <div class="float-right">Sobre expectativa</div>
            </div>
        </div>
    <?php endif; ?>
</div>