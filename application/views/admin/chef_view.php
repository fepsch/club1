<?php
include('usuarios_view.php');
?>
<table>
    <tr>
        <th>idUsuario</th>
        <th>nombre</th>
        <th>descripción</th>
        <th>tiempo</th>
    </tr>
<?php
foreach($experiencias as $experiencia): ?>
    <tr>
        <td><?= $experiencia['idUsuario']; ?></td>
        <td><?= $experiencia['nombre']; ?></td>
        <td><?= $experiencia['descripcion']; ?></td>
        <td><?= $experiencia['tiempo']; ?></td>
    </tr>
<?php
endforeach;
?>
</table>
<br>
<div>
    <a href="<?= base_url('admin/experiencias/add'.$datos_usuario['idUsuario']); ?>">
        Agregar Nueva experiencia
    </a>
</div>
<?php
foreach($metas as $meta):
    echo ucwords(str_replace('_', ' ', $meta['nombre'])).': '.$meta['dato'].'<br>';
endforeach;
?>
?>
