<div class="row">
        <div class='small-12 medium-6 columns '>
<h3>Datos del evento</h3>
Id Actividad: <?= $actividad['idActividad']; ?>
<table>
	<tr>
		<td>Cliente:</td>
		<td><a href="<?= base_url('admin/usuarios/view/'.$actividad['usuario']['idUsuario']); ?>"><?= $actividad['usuario']['nombre']; ?></a></td>
	</tr>
	<tr>
		<td>Chef:</td>
		<td><a href="<?= base_url('admin/chefs/view/'.$actividad['chef']['idUsuario']); ?>">
    <?= $actividad['chef']['nombre']; ?>
</a></td>
	</tr>
	<tr>
		<td>Experiencia:</td>
		<td><a href="#"> <?= $actividad['experiencia']['nombre']; ?></a></td>
	</tr>
	<tr>
		<td>Fecha:</td>
		<td><?= date('d/m/Y', strtotime($actividad['fecha'])); ?></td>
	</tr>
        <tr>
		<td>Hora:</td>
		<td><?= date('H:i', strtotime($actividad['fecha'])); ?></td>
	</tr>
	<tr>
		<td>Valor:</td>
		<td><?= $actividad['valor']; ?></td>
	</tr>
	<tr>
		<td>Cantidad de Pasajeros:</td>
		<td><?= $actividad['pasajeros']; ?></td>
	</tr>
	<tr>
		<td>Evaluación:</td>
		<td><?= $actividad['evaluacion']; ?></td>
	</tr>
	<tr>
		<td>Estado:</td>
		<td><?= $actividad['estado']; ?></td>
	</tr>
	<tr>
		<td>Comentario:</td>
		<td><?= $actividad['comentarioActividad']; ?></td>
	</tr>
</table>

</div>
<div class='small-12 medium-3 columns'>
<a href="<?= base_url() . 'admin/actividades/edit/' . $actividad['idActividad']; ?>" class="left fi-pencil button tiny "> Modificar</a>
<a href="<?= base_url() . 'admin/actividades/del/' . $actividad['idActividad']; ?>" class="del left fi-trash button tiny"> Eliminar</a>

</div>
</div>