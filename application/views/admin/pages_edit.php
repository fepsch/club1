
<script>
    tinymce.init({
        selector: "textarea",
        theme: "modern",
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor jbimages"
        ],
        toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
        toolbar2: "print preview media | forecolor backcolor emoticons jbimages",
        image_advtab: true,
        relative_urls : false,
        templates: [
            {title: 'Test template 1', content: 'Test 1'},
            {title: 'Test template 2', content: 'Test 2'}
        ]
    });
</script>
<div class="row">
    <div class="small-12 medium-6">
<div id="container">
    <h1>
        <? //$titulo?>
    </h1>
    <div id="formulario">
        <?
        //echo $_SERVER['DOCUMENT_ROOT'];
        foreach ($pages as $page) {

            $titulo = array(
                'name' => 'titulo',
                'id' => 'titulo',
                'value' => $page['titulo'],
            );
            $bajada = array(
                'name' => 'bajada',
                'id' => 'bajada',
                'value' => $page['bajada'],
            );
            $contenido = array(
                'name' => 'contenido',
                'id' => 'contenido',
                'value' => $page['contenido'],
            );
            $orden = array(
                'name' => 'orden',
                'id' => 'orden',
            );

            echo validation_errors();
            echo form_open();
            
?>
<label>
            <fieldset>
                <legend>Datos</legend>
        <label>Título<?= form_input($titulo);?></label>
        <label>Bajada <?= form_input($bajada);?></label>
        <label>Orden <?= form_input($orden);?></label>
        <label>Contenido<?= form_textarea($contenido);?></label>
    </fieldset>
</label>
        <label>
            <input type="submit" class='button tiny' value="Enviar" />
        </label>

<?
           
            echo form_close();
        }
        ?>
    </div>
</div>
</div>
</div>