<script src="<?= base_url('js/raty/lib/jquery.raty.min.js') ?>"></script>
<div id="result" class="overflowauto">
    <div id="barra-info" class="mayus overflowauto">
        <div class="float-left resultado-texto">
            <span>Chefs disponibles en <?= isset($comunaNombre) ? $comunaNombre : 'todas las comunas'; ?></span>
            <span>para el día: <?= isset($fecha) ? $fecha : 'sin fecha'?></span>
        </div>
        <div class="float-right div-orden">
            <form action="<?= base_url('') ?>">
                <div class="constraint-select">
                    <select name="ordenar" class="ordenar">
                        <?php $orden = $this->session->userdata('orden'); ?>
                        <option value="">Ordenar por</option>
                        <option value="1" <?php if ($orden && $orden == 1) { echo 'selected'; } ?>>Alfabeticamente</option>
                        <option value="2" <?php if ($orden && $orden == 2) { echo 'selected'; } ?>>Precio</option>
                    </select>
                </div>
            </form>
        </div>
    </div>
    <div id="result-container" class="overflowauto ">
        <div id="filtro-tags" class="float-left">
            <div><span class="mayus titulo-tags">Especialidades</span></div>
            <div id="display-tags">
                <?php foreach ($tags as $tag) : ?>
                    <?php
                    $tagsSession = $this->session->userdata('tag') ? $this->session->userdata('tag') : array();
                    $checked = in_array($tag['idMetaKey'], $tagsSession) ? 'checked' : '';
                    
                    ?>
                    <div class="tag-row">
                        <label for="tag<?= $tag['idMetaKey']; ?>"><?= $this->functions->meta_a_ui($tag['nombreMeta']); ?></label>
                        <input 
                            type="checkbox" 
                            name="tags" 
                            <?= $checked; ?> 
                            id="tag<?= $tag['idMetaKey']; ?>" 
                            value="<?= $tag['idMetaKey']; ?>"
                            <?= $tag['idMetaKey'] == $this->session->userdata('tagSeleccionado') ? 'disabled' : ''; ?>
                            />
                    </div>
                    <script>
                        $("#tag<?= $tag['idMetaKey'] ?>").click(function() {
                            var url = '';
                            $.blockUI({ message: $('#mensaje-carga') }); 
                            if ($(this).is(':checked'))
                                url = "<?= base_url('chefs/filtroTag/agregar'); ?>";
                            else
                                url = "<?= base_url('chefs/filtroTag/quitar'); ?>";
                            $.post(url, {tags: $(this).val()}).done(function(data) {
                                $('#result').html(data);
                                $.unblockUI();
                            });
                        });
                    </script>
                <?php endforeach; ?>
            </div>
            <!--<div class="vermas">
                <span>ver+</span>
            </div>-->
        </div>
        <div id="resultados" class="float-left">
            <?php if (empty($chefs)): ?>
                <div id="no-chefs">
                    <h3>No existen chefs que se ajusten a su criterio de búsqueda</h3>
                </div>
            <?php else: ?>
                <ul class="pagination">
                    <?php foreach ($chefs as $chef): ?>
                        <li class="preview-chef">
                            <a href="<?= base_url('chefs/verDatosChef/' . $chef['idUsuario']); ?>">
                                <div class="avatar-preview">
                                    <?
                                    if ($chef['avatar'] == '')
                                        $imgChef = '10-top-celebrity-chefs.jpg';
                                    else
                                        $imgChef = $chef['avatar'];
                                    ?>
                                    <img src="<?= base_url('avatar/' . $imgChef); ?>" alt="miniatura avatar chef" />
                                </div>
                                <div class="overflowauto">
                                    <div class="float-left main-dish">
                                        <img src="<?= isset($chef['fotos']['23']) ? base_url('images/' . $chef['fotos']['23']) : ''; ?>" alt="foto plato 1"/>
                                    </div>
                                    <div class="second-dish float-left">
                                        <img src="<?= isset($chef['fotos']['24']) ? base_url('images/' . $chef['fotos']['24']) : ''; ?>" alt="foto plato 2"/>
                                    </div>
                                    <div class="third-dish float-left">
                                        <img src="<?= isset($chef['fotos']['25']) ? base_url('images/' . $chef['fotos']['25']) : ''; ?>" alt="foto plato 3"/>
                                    </div>
                                </div>
                                <div>
                                    <div class="preview-left-bot overflowauto float-left">
                                        <span class="preview-nombre">
                                            <?= ucwords($chef['nombre'] . " " . $chef['apellidoPaterno'] . (!empty($chef['apellidoMaterno']) ? " " . $chef['apellidoMaterno'][0] : '')) . "."; ?>
                                        </span>
                                        <div id="grafica-review<?= $chef['idUsuario']; ?>" class="review-prev">
                                            <div id="barra-general<?= $chef['idUsuario']; ?>"></div>
                                        </div>
                                        <script>
                                            $(function() {
                                                $("#barra-general<?= $chef['idUsuario']; ?>").raty({
                                                    path: "<?= base_url('js/raty/img') ?>",
                                                    width: false,
                                                    score: <?= $chef['porcentGral'] * 5 / 100; ?>,
                                                    readOnly: true,
                                                    size: 24
                                                });
                                            });
                                        </script>
                                    </div>
                                    <div class="precio-preview float-left bg-rojo">
                                        <span class="preview-clp mayus">Precio CLP</span>
                                        <br>
                                        <div class="preview-valor">
                                            $ <?= is_numeric($chef['precio']) ? number_format($chef['precio'], 0, ',', '.') : 0; ?>
                                        </div>
                                        <div class="desc-precio-preview">Precio por hora.</div>
                                    </div>
                                </div>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("ul.pagination").quickPagination({pageSize: "10"});
    });

    $(document).ready(function() {
        $('.ordenar').change(function() {
            $.post("<?= base_url('chefs/ordenar') ?>", {ordenar: $(this).val()}).done(function(data) {
                $('#result').html(data);
            });
        });
    });

    var win = $(window),
            fxel = $(".buscador"),
            eloffset = fxel.offset().top;

    win.scroll(function() {
        if (eloffset < win.scrollTop()) {
            fxel.addClass("fixed");
            $('.magic-fixed').css('display', 'block');
        } else {
            fxel.removeClass("fixed");
            $('.magic-fixed').css('display', 'none');
        }
    });

    $(function() {
        $("#agenda").datetimepicker({
            minDate: 0,
            lang: 'es',
            scrollTime: false,
        });
    });

    $(function() {
        $('.nombrechef-buscador').autocomplete({
            source: "<?= base_url('chefs/autocompleteNombre'); ?>"
        });
    });
</script>