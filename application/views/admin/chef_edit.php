<div class="row">
    <div class="small-12 medium-6">
        <div class="container">
            <h1>
                <? //$titulo?>
            </h1>
            <div id="formulario">
                <?
                //print_r($chef);
                echo validation_errors();
                echo form_open_multipart();
                ?>
                <fieldset >
                    <legend>Datos de acceso</legend>
                    <label>Email <input type="text" name="mail" value="<?= set_value('mail', (isset($chef['mail']) ? $chef['mail'] : '')) ?>" /></label>
                    <label>Nombre <input type="text" name="nombre" value="<?= set_value('nombre', (isset($chef['nombre']) ? $chef['nombre'] : '')) ?>" /></label>
                    <label>Apellido Paterno <input type="text" name="apellidoPaterno" value="<?= set_value('apellidoPaterno', (isset($chef['apellidoPaterno']) ? $chef['apellidoPaterno'] : '')) ?>" /></label>
                    <label>Apellido Materno <input type="text" name="apellidoMaterno" value="<?= set_value('apellidoMaterno', (isset($chef['apellidoMaterno']) ? $chef['apellidoMaterno'] : '')) ?>" /></label>
                    <label>Password <input type="password" name="password" value="<?= set_value('password') ?>" /></label>
                    <label>Confirme Password <input type="password" name="passwordVerificacion" value="<?= set_value('passwordVerificacion') ?>" /></label>
                    <label>Link directo (www.clubdelacocina.cl/chef/<span style="font-weight: bold">link.directo</span>)<input type="text" name="link" value="<?= set_value('link', (isset($chef['link']) ? $chef['link'] : '')); ?>"/></label>
                    <label>Avatar (247x247px o relacion 1:1 | gif, png, jpg)<input type="file" name ="avatar" /></label>
                    <? if (isset($chef['avatar'])) { ?>
                        <img src="<?= base_url('/avatar/' . $chef['avatar']) ?>" class='small-12 columns' />
                    <? } ?>
            </div>
            </fieldset>
            <?php include('fields.php'); ?>
            <label id="datospersonales-chef">
                <fieldset>
                    <legend>Datos Personales</legend>
                    <?php generaTextArea($datosPersonales); ?>
                </fieldset>
            </label>
            <label id="parametros-chef">
                <fieldset>
                    <legend>Parametros generales</legend>
                    <?php generaText($parametrosText); ?>
                    <?php generaCheck($parametrosCheck); ?>
                </fieldset>
            </label>
            <label id="comunas-chef">
                <fieldset>
                    <legend>Comunas que trabaja</legend>
                    <?php generaCheck($comunas); ?>

                </fieldset>
            </label>
            <label id="tags-chef">
                <fieldset>
                    <legend>Tags</legend>
                    <?php generaCheck($tags); ?>
                </fieldset>
            </label>
            <label id="horarios-chef">
                <fieldset>
                    <legend>Horarios</legend>
                    <table>
                        <tr>
                            <th></th>
                            <th>L</th>
                            <th>M</th>
                            <th>W</th>
                            <th>J</th>
                            <th>V</th>
                            <th>S</th>
                            <th>D</th>
                            <?php $idPeriodo = NULL; ?>
                            <?php foreach ($periodos as $periodo): ?>
                                <?php if ($idPeriodo != $periodo['idPeriodo']): ?>
                                    <?php $idPeriodo = $periodo['idPeriodo']; ?>
                                </tr><tr>
                                    <td><?= date('H:i', strtotime($periodo['inicio'])) . ' - ' . date('H:i', strtotime($periodo['fin'])) ?></td>
                                    <td style="text-align: center">
                                        <input
                                            type="checkbox"
                                            name="horarios[]"
                                            value="<?= $periodo['idDiaAgenda'] . '-' . $periodo['idPeriodo']; ?>"
                                            <?= set_checkbox('horarios[]', $periodo['idPeriodo'], isset($periodo['idChef']) ? TRUE : FALSE); ?>
                                            />
                                    </td>
                                <?php else: ?>
                                    <td style="text-align: center">
                                        <input
                                            type="checkbox"
                                            name="horarios[]"
                                            value="<?= $periodo['idDiaAgenda'] . '-' . $periodo['idPeriodo']; ?>"
                                            <?= set_checkbox('horarios[]', $periodo['idPeriodo'], isset($periodo['idChef']) ? TRUE : FALSE); ?>
                                            />
                                    </td>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tr>
                    </table>
                </fieldset>
            </label>
            <label id="horarios-chef">

                <fieldset>
                    <legend>Imágenes resultado búsqueda</legend>
                    <label><span>Imagen 1 (430x272px | gif, png, jpg)</span><input type="file" name="foto_1"/></label>
                    <? if (isset($fotos['0']['dato'])) { ?>
                        <img src="<?= base_url('/images/' . $fotos['0']['dato']) ?>" class='small-12 columns' />
                    <? } ?>

                    <label><span>Imagen 2 (166x135px | gif, png, jpg)</span><input type="file" name="foto_2"/></label>
                    <? if (isset($fotos['1']['dato'])) { ?>
                        <img src="<?= base_url('/images/' . $fotos['1']['dato']) ?>" class='small-12 columns' />
                    <? } ?>

                    <label><span>Imagen 3 (166x135px | gif, png, jpg)</span><input type="file" name="foto_3"/></label>
                    <? if (isset($fotos['2']['dato'])) { ?>
                        <img src="<?= base_url('/images/' . $fotos['2']['dato']) ?>" class='small-12 columns' />
                    <? } ?>

                </fieldset>
            </label>
            <label>
                <fieldset>
                    <legend>Imagen Superior Perfil Chef (980x280px)</legend>
                    <label><span></span><input type="file" name="portada_superior"/></label>
                    <? if (isset($fotos['3']['dato'])) { ?>
                        <img src="<?= base_url('/images/' . $fotos['3']['dato']) ?>" class='small-12 columns' />
                    <? } ?>

                </fieldset>
            </label>
            <label>
                <input type="submit" class='button tiny' value="Enviar" />
            </label>
            <?= form_close(); ?>

        </div></div>
</div>
</div>
<script>
    $(document).ready(function() {
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
            relative_urls: false,
            templates: [
                {title: 'Test template 1', content: 'Test 1'},
                {title: 'Test template 2', content: 'Test 2'}
            ]
        });
    });
</script>