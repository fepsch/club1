<div id="comentarios">
    <div class="mayus SueEllen">COMENTARIOS</div>
    <?php foreach($comentarios as $comentario): ?>
    <div class="container-comentario overflowauto">
        <div class="avatar-comentario float-left">
            <img src="<?= base_url('avatar/'.$comentario['usuario']['avatar']); ?>" alt="avatar comentarista"/>
        </div>
        <div class="body-comentario float-left">
            <div class="texto-comentario"><?= $comentario['contenido']; ?></div>
            <div class="footer-comentario"></div>
        </div>
    </div>
    <?php endforeach; ?>
</div>