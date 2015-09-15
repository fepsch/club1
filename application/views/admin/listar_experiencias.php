<div class="row">
    <div class="small-12 columns">
        <div id="listar">
            <h3>Experiencias disponibles</h3>
            <?php
            if (isset($experiencias)):
                if (empty($experiencias)):
                    echo 'No existen experiencias disponibles<br>';
                else:
                    ?>
                    <table border="1">
                        <tr>
                            <th>nombre</th>
                            <th>descripcion</th>
                            <th>imagen</th>
                            
                        </tr>
                        <?php foreach ($experiencias as $experiencia): ?>
                            <tr>
                                <td><a href="<?= base_url() . 'admin/experiencias/view/' . $experiencia['idExperiencia'] ?>"><?= $experiencia['nombre'] ?></a></td>
                                <td><?= $experiencia['descripcion'] ?></td>
                                <td><div class="img-prev-plato"><img src="<?= base_url('images/experiencias/'.$experiencia['imagen']) ?>"/></div></td>
                                
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <div>
            <a href="<?= base_url('admin/experiencias/add/' . $datos_usuario['idUsuario']); ?>">
                Agregar Nueva experiencia
            </a>
        </div>
        <br>
    </div>
</div>