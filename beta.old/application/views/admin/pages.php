<div class="container">
  <h1>
    <? //$titulo?>
  </h1>
  <div class="row">
        <div class='small-12 columns '>
            <a class="button tiny fi-plus" href="<?= base_url()?>admin/pages/add"> Agregar</a>
        </div>
    </div>
  <div class="row">
        <div class='small-12 columns '>
  <div id="lista">
    <ul class='lista-ver'>
      <? foreach($pages as $page){ 
	  ?>
      <li>
         <div class="row ">
        <div class="medium-5 columns">
          <?= $page['titulo']?>
        </div>
        <div class="medium-2 end columns">
            <a class="left fi-pencil button tiny " href="<?= base_url('admin/pages/edit/'.$page['idPage'])?>"></a>
            <a class="del left fi-trash button tiny" href="<?= base_url('admin/pages/del/'.$page['idPage'])?>"></a>
        </div>
      </div>
      </li>
      <? 
		}
	?>
    </ul>
  </div>
</div>
</div>
</div>
