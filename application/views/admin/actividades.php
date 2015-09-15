<div class="container">
  <div class="row">
        <div class='small-12 columns '>
  <div id="lista">
    <h3>Lista de Actividades</h3>
    <a href='<?=base_url('csv/'.$filename)?>' class='button tiny'>Descargar</a>
    <table class='lista-ver'>
       <tr>
        <th>Fecha</th>
        <th>Cliente</th>
        <th>Contacto</th>
        <th>Valor</th>
        <th>Experiencia</th>
        <th>Estado</th>
        <th></th>
        <th></th>
       </tr>
        <? //print_r($actividades)?>
      <?php foreach($actividades as $actividad): ?>
<? /*
 [idActividad] => 120
            [idUsuarioCliente] => 97
            [idExperiencia] => 1
            [fecha] => 2014-09-18 13:00:00
            [valor] => 15000
            [pasajeros] => 2
            [direccion] => asdfasdf 213123
            [comuna] => 10
            [nroContacto] => 12312312
            [evaluacion] => 
            [idEstado] => 4
            [comentarioActividad] => 
            [nombreEstado] => Pagada
            [nombreUsuario] => Manuel
            [nombreExperiencia] => Experiencia de test 1
*/
            ?>
      <tr>

        <td><?= date('d/m/Y', strtotime($actividad['fecha']))?></td>
        <td><?= $actividad['nombreUsuario']?></td>
        <td><?= $actividad['nroContacto']?></td>
        <td><?= $actividad['valor']?></td>
        <td><?= $actividad['nombreExperiencia']?></td>
        <td><?= $actividad['nombreEstado']?></td>

        
        <td><a href="<?= base_url() .'admin/actividades/view/' . $actividad['idActividad']; ?>" class="left button tiny "> V</a></td>
        <td><a href="<?= base_url() .'admin/actividades/edit/' . $actividad['idActividad']; ?>" class="left fi-pencil button tiny"> </a></td>

        
      
      </tr>
      <?php endforeach; ?>
    </table>
  </div>
</div>
</div>
</div>
