<script>
    $(function() {
            //clic en un enlace de la lista
            $('#masreviews').on('click', function(e) {
                    //prevenir en comportamiento predeterminado del enlace
                    e.preventDefault();
                    //obtenemos el id del elemento en el que debemos posicionarnos
                    var strAncla = $(this).attr('href');
         
                    //utilizamos body y html, ya que dependiendo del navegador uno u otro no funciona
                    $('body,html').stop(true, true).animate({
                            //realizamos la animacion hacia el ancla
                            scrollTop: $(strAncla).offset().top
                    }, 1000);
            });
    });
</script>
<div id="nombre-chef">
    <span><?= ucwords($datosChef['nombre'] . ' ' . $datosChef['apellidoPaterno']) ?></span>
</div>
<div id="slide-chef" style='position: relative'>
    <img src="<?= isset($fotos['23']) ? base_url('images/' . $fotos['27']) : ''; ?>" alt="Imagen Portada"/>
</div>
<div id="contenido-chef">
    <div id="infochef" class="overflowauto centerbox">
        <div id="contenedor-central" class="float-left">
            <div id="descripcion">
                <?php foreach($descripcionesChef as $descripcion): ?>
                <span class="titulo-descripcion"><?=$this->functions->meta_a_ui($descripcion['nombreMeta']); ?></span>
                <p><?= $descripcion['dato']; ?></p>
                <br>
                <?php endforeach; ?>
            </div>
            <div id="metas">
                <div class="mayus titulo-tags white">ESPECIALIDADES</div>
                <div><?php if (!empty($tagsChef)): ?>
                    <ul>
                            <?php foreach ($tagsChef as $tagChef): ?>
                                <li class="float-left display-tags">
                                    <a href="<?= base_url('chefs/busquedaForm/' . $tagChef['idMetaKey']); ?>"><?= $this->functions->meta_a_ui($tagChef['nombreMeta']); ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>


        </div><!-- Fin contenido central -->


    </div>

    <!-- Columna derecha con detalles respecto al servicio que entrega el chef -->
    <div id="cont-derecha" class="float-left">
        <div class="foto-ver-chef">
            <img src="<?= base_url('avatar/' . $datosChef['avatar']); ?>" /> 
        </div>
        <div id="resumen-reviews" class="bg-blanco">
            <div class="globo-conteo">
                <div class="float-left conteo">
                    <?= $datosChef['conteo'] ?>
                </div>
                <div class="float-left reviews">Reviews</div>
            </div>
            <div class="positivo">
                <div class="fork-rate"></div>
                <div><a href="#comentarios" id="masreviews">Mira comentarios de sus clientes</a></div>
            </div>
        </div>
        <div id="precio" class="bg-rojo">
            <span class="preview-clp mayus">Valor por hora</span>
            <br>
            <div class="preview-valor">
                $ <?= is_numeric($parametrosChef['4']) ? number_format(($parametrosChef['4']), 0, ',', '.') : 0; ?>
            </div>
            <div class="desc-precio">
                <p>Incluye todos los ingredientes necesarios para la experiencia.</p>
                <p>Tiempo total de la experiencia dependerá del número de comensales.</p>
            </div>
        </div>
        <div id="invitados-comunas" class="bg-rojo white overflowauto">
            <div>REQUISITOS DEL CHEF</div>
            <div id="maxpersonas">
                <span class="preview-clp mayus">RANGO DE COMENSALES</span>
                <br>
                <div class="info">
                    <img src="<?= base_url('images/max-invitados.png'); ?>"/>
                    <span class="mayus">De <?= str_replace('-', ' a ', $parametrosChef['5']) ?> Personas</span>
                </div>
            </div>
            <div id="comunas">
                <span class="preview-clp mayus">COMUNAS A LAS QUE LLEGA</span>
                <div class="info"><img src="<?= base_url('images/comunas.png'); ?>" class="float-left"/>
                    <?php if (isset($comunas)): ?>
                        <ul class="float-left">
                            <?php foreach ($comunas as $comuna) : ?>
                            <li><?= $this->functions->meta_a_ui($comuna); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Experiencias -->
    <div id="experiencias-chef" class="clear">
        <h3>Menú del Chef</h3>
        <!-- Mostrar experiencias -->
        <?php $this->load->view('detallechef/experiencias'); ?>
    </div>
    
    <!-- Mostrar Graficos de Evaluación -->
    <?php //$this->load->view('detallechef/reviews'); ?>

    <!-- Mostrar comentarios realizados al Chef -->
    <?php $this->load->view('detallechef/comentarios'); ?>
</div>
