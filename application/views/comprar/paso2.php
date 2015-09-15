<div id="pasos" class="overflowauto">
    <ul class="centerbox overflowauto">
        <li>Confirma los detalles<br>de tu evento</li>
        <li class="paso-activo">Ubicaci&oacute;n del evento</li>
        <li>Realizar pago</li>
        <li>Comprobante</li>
    </ul>
</div>
<div id="ingreso-datos" class="bg-color-general">
    <div class="mayus titulo-ingreso centerbox">
        <div>¿D&Oacute;NDE SER&Aacute; TU EVENTO?</div>
        <div class="subtitulo-ubicacion">Especifica el lugar donde será realizado el evento</div>
    </div>
    <?= form_open('comprar/ingresoDatos'); ?>
    <div class="overflowauto centerbox">
        <div id="ingreso-izq" class="float-left">
            <div class="wrapper-campos">
                <div class="">Comuna</div>
                <select name="comuna" class="container-width">
                    <option value="">Seleccione</option>
                    <?php foreach ($comunas as $comuna): ?>
                        <?php $selected = $comuna['idMetaKey'] === $this->session->userdata('comuna') ? TRUE : FALSE; ?>
                        <option value="<?= $comuna['idMetaKey'] ?>" <?= set_select('comuna', $comuna['idMetaKey'], $selected); ?>><?= $this->functions->meta_a_ui($comuna['nombreMeta']); ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="error-validacion"><?= form_error('comuna') ?></div>
            </div>
            <div class="float-left">
                <div class="wrapper-campos">
                    <div>Teléfono de contacto</div>
                    <select name="codigo" class="codigo">
                        <option>2</option>
                        <option>9</option>
                    </select>
                    <input type="text" name="nrocontacto" class="input-width168" value='<?= set_value('nrocontacto'); ?>' maxlength="8" placeholder="8 dígitos"/>
                    <div class="error-validacion"><?= form_error('nrocontacto') ?></div>
                </div>
            </div>
        </div>
        <div id="ingreso-der" class="float-left">
            <div class="wrapper-campos float-left">
                <div class="float-left overflowauto">
                    <div>Dirección</div>
                    <input type="text" name="calle"  class="input-width200" placeholder="Calle" value='<?= set_value('calle'); ?>'/>
                    <div class="error-validacion"><?= form_error('calle') ?></div>
                </div>
            </div>
            <div class="wrapper-campos float-left">
                <div class="overflowauto">
                    <div class="float-left overflowauto input-width90">
                        <div>N°</div>
                        <input type="text" name="nrocasa" placeholder="N°" class="" value='<?= set_value('nrocasa'); ?>'/>
                    </div>
                    <div class="float-left overflowauto input-width90">
                        <div>Casa/Depto</div>
                        <input type="text" name="nrodepto" placeholder="N° Casa/Dpto" class="" value='<?= set_value('nrodepto'); ?>'/>
                    </div>
                </div>
                <div class="error-validacion error-nro"><?= form_error('nrocasa') ?></div>
            </div>
            <div style="clear:both;">
                <!--<div>Fecha</div>
                <select class="input-width90" disabled>
                <?php $fecha = $this->session->userdata('fecha'); ?>
                    <option><?= ''//date('d', strtotime($fecha))      ?></option>
                </select>
                <select class="input-width90" disabled>
                    <option><?= ''//date('m', strtotime($fecha))      ?></option>
                </select>
                <select class="input-width90" disabled>
                    <option><?= ''//date('Y', strtotime($fecha))      ?></option>
                </select> -->
            </div>
        </div>
    </div>
    <div id="avanzar-compra" class="overflowauto">
        <input id="siguiente" type="submit" class="float-right" value="Siguiente">
    </div>
    <?= form_close(); ?>
</div>
