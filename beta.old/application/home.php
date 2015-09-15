<div id="contenedor-portada">
    <div id="slide-home" class="float-left">
        <?php foreach($slides as $slide): ?>
        <img src="<?= base_url('slides/'.$slide); ?>">
        <?php endforeach; ?>
    </div>
    <div id="conteo-home" class="bg-rojo">
        <div id="nrochefs" class="cuadro-conteo">
            <div>
                <img src="<?= base_url('images/gorroChef.png'); ?>" alt="imagen conteo chef"/>
            </div>
            <div>
                <span class="conteo"><?= $nro_chefs; ?></span>
            </div>
            <span class="contados">Chefs para elegir</span>
        </div>
        <div id="nroplatos" class="cuadro-conteo">
            <div>
                <img src="<?= base_url('images/imagenPlato.png'); ?>" alt="imagen conteo platos"/>
            </div>
            <div>
                <span class="conteo"><?= $nro_experiencias; ?></span>
            </div>
            <span class="contados">Tipos de Platos</span>
        </div>
    </div>
</div>
<div class="buscador">
    <span class="mayus SueEllen">encuentra tu chef</span>
    <?php echo form_open('chefs/busquedaForm', array('class' => 'overflowauto')); ?>
    <div class="container-fields">
        <input type="text" placeholder="Fecha" name="agenda" id="agenda" class="fecha-buscador">
        <select name="comuna">
            <option value="">TU COMUNA</option>
            <?php foreach ($comunas as $comuna): ?>
                <option value="<?= $comuna['idMetaKey'] ?>"><?= $comuna['nombreMeta']; ?></option>
            <?php endforeach; ?>
        </select>
        <!-- <input type="text" placeholder="Tu Comuna" name="comuna" class="comuna-buscador">-->
        <select name="tag">
            <option value="">TAGS</option>
            <?php foreach ($tags as $tag): ?>
                <option value="<?= $tag['idMetaKey'] ?>"><?= $tag['nombreMeta']; ?></option>
            <?php endforeach; ?>
        </select>
        <!-- <input type="text" placeholder="Tags" name="tag" class="tag-buscador"> -->
        <input type="text" placeholder="Nombre del chef" class="nombrechef-buscador">
        <input type="submit" value="Buscar" class="enviar-buscador">
    </div>
    
</div>
<script>
    $(function() {
        $("#agenda").datetimepicker({
            minDate: 0,
            lang: 'es',
            onSelectDate: function(current_time) {
                $.post('<?= base_url('chefs/horasDisponibles'); ?>', {fecha: current_time}).done(function(data){
                    console.log(data);
                });
            }
        });
    });
</script>
<div id="carrusel-home-cont"class="bg-color-general">
    <span class="mayus SueEllen">Nuestros chefs</span>
    <div id="carrusel-home" class="ca-container centerbox">
        <?php if (!empty($chefsCarrusel)): ?>
            <div class="ca-wrapper">
                <?php foreach ($chefsCarrusel as $chef): ?>
                    <div class="ca-item">
                        <div class="carruselhome-chef">
                            <div class="ca-avatar-home">
                                <img src="<?= base_url('avatar/' . $chef['avatar']); ?>" alt="avatar chef" />
                            </div>
                            <div class="ca-nombre-home bg-rojo"><?= $chef['nombre']; ?></div>
                            <div class="ca-descripcion-home overflowauto"><?= $chef['dato'] ?></div>
                            <div class="link-preparaciones float-right">
                                <a href="<?= base_url('chefs/verDatosChef/' . $chef['idUsuario']); ?>">Ver Sus Preparaciones</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    <script>
        $('#carrusel-home').contentcarousel({
            navigationAt: 4
        });
        $('#slide-home').slidesjs({
            width: 800,
            height: 336,
            play: {
                active: true,
                // [boolean] Generate the play and stop buttons.
                // You cannot use your own buttons. Sorry.
                effect: "slide",
                // [string] Can be either "slide" or "fade".
                interval: 5000,
                // [number] Time spent on each slide in milliseconds.
                auto: true,
                // [boolean] Start playing the slideshow on load.
                swap: true,
                // [boolean] show/hide stop and play buttons
                pauseOnHover: false,
                // [boolean] pause a playing slideshow on hover
                restartDelay: 2500
                        // [number] restart delay on inactive slideshow
            },
            navigation:{
                active: false,
            }
        });
    </script>