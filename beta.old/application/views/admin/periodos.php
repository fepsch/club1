<div class="container">
  
    <div class="row">
        <div class='small-12 columns '>
            <a class="button tiny fi-plus" href="<?= base_url('admin/periodos/add'); ?>"> Agregar</a>
        </div>
    </div>
    <div class="row">
        <div class='small-12 columns '>
  <div id="lista">
    
 <? 
      if (isset($error)){
        ?>
    <div data-alert="" class="alert-box alert round">
  
       <? echo $error; ?>
      
  <a href="" class="close">×</a>
</div>

<? }
      ?>

    <ul class='lista-ver'>
        
       
      <?php foreach($periodos as $periodo): ?>
      <div class="row ">
      <li>
        <div class="medium-5 columns">
          <?= date('H:i', strtotime($periodo['inicio'])) . ' - '. date('H:i', strtotime($periodo['fin']))?>
        </div>
        <div class="medium-2 end columns">
            <a href="<?= base_url() .'admin/periodos/edit/' . $periodo['idPeriodo']; ?>" class="left fi-pencil button tiny "></a>
            <a href="<?= base_url() .'admin/periodos/del/' . $periodo['idPeriodo']; ?>" class="del left fi-trash button tiny"></a>
        </div>
      </li>
    </div>
      <?php endforeach; ?>
    </ul>
  </div>
</div>
</div>
</div>
