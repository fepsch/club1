<div id="menuchef" class="experiencia-reservas">
    <ul>
        <li class="overflowauto">
            <div class="float-left texto-fantasia">
                <h2 class="titulo-fantasia SueEllen mayus"><?= $experiencia['nombre']; ?></h2>
                <div class="texto-fantasia-wrapper">
                    <p class="descripcion-fantasia"><?= $experiencia['descripcion']; ?></p><br>
                    <?php foreach ($experiencia['platos'] as $plato): ?>
                        <span class="titulo-plato mayus"><?= $plato['nombre']; ?></span>
                        <p class="texto-plato"><?= $plato['descripcion']; ?></p><br>
                    <?php endforeach; ?>
                </div>
            </div>
        </li>
    </ul>
</div>
