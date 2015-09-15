<div>
    <div id="pasos" class="overflowauto">
    <ul class="centerbox overflowauto">
        <li>Confirma los detalles<br>de tu evento</li>
        <li>Ubicaci&oacute;n del evento</li>
        <li class="paso-activo">Realizar pago</li>
        <li>Comprobante</li>
    </ul>
</div>
</div>
<div id="ingreso-datos" class="bg-color-general">
    <div class="mayus titulo-ir-pago">Realiza el pago en línea y agenda tu evento</div>
    <div id="ingreso-datos-centro" class="overflowauto">
        <div id="msje-izquierda" class="float-left">
            <div>
                <img src="<?= base_url('images/mensaje-conf-pago.png'); ?>" alt="background"/>
            </div>
            <div id="texto-ingreso-datos">
                <p>Para realizar el pago será redireccionado al sitio de Transbank.</p>
                <p>Presione "Pagar" si desea continuar</p>
            </div>
                <div class="logo-wp-pago"><img src="<?= base_url('images/logo-tb.jpg'); ?>" alt="logo transbank"/></div>
        </div>
        <div id="detalle-derecha" class="float-right">
            <div class="info-actividad bg-rojo">
                <table>
                    <tr>
                        <th class="mayus titulo-info bg-rojo-oscuro tit-datos-fin" colspan="2">detalle de evento</th>
                    </tr>
                    <tr class="datos-confirm">
                        <td class="titulo-datos">CHEF</td>
                        <td class="row-info">
                            <div class="input-finalizacompra"><?= $nombreChef ?></div>
                        </td>
                    </tr>
                    <tr class="datos-confirm">
                        <td class="titulo-datos">EXPERIENCIA</td>
                        <td class="row-info">
                            <div class="input-finalizacompra"><?= $experiencia['nombre'] ?></div>
                        </td>
                    </tr>
                    <tr class="datos-confirm">
                        <td class="titulo-datos">¿CUÁNTOS COMEN?</td>
                        <td class="row-info">
                            <div class="input-finalizacompra"><?= $this->session->userdata('invitados'); ?></div>
                        </td>
                    </tr>
                    <tr class="datos-confirm">
                        <td class="titulo-datos">FECHA</td>
                        <td class="row-info">
                            <div class="input-finalizacompra"><?= date('d/m/Y', strtotime($actividad['fecha'])); ?></div>
                        </td>
                    </tr>
                    <tr class="datos-confirm">
                        <td class="titulo-datos">HORARIO</td>
                        <td class="row-info">
                            <div class="input-finalizacompra"><?= date('H:i', strtotime($this->session->userdata('horario'))); ?> HRS.</div>
                        </td>
                    </tr>
                    <tr class="datos-confirm">
                        <td class="titulo-datos">TIEMPO QUE EL CHEF ESTARÁ EN TU CASA</td>
                        <td class="row-info">
                            <div class="input-finalizacompra"><?= gmdate('H:i', $experiencia['tiempo' . $this->session->userdata('invitados')] * 60 * 60); ?> HRS.</div>
                        </td>
                    </tr>
                    <tr class="datos-confirm">
                        <td class="titulo-datos">DIRECCIÓN</td>
                        <td class="row-info"><div class="input-finalizacompra"><?= $actividad['direccion']; ?></div></td>
                    </tr>
                    <tr class="datos-confirm">
                        <td class="titulo-datos">COMUNA</td>
                        <td class="row-info"><div class="input-finalizacompra"><?= $comuna['nombreMeta']; ?></div></td>
                    </tr>
                    <!-- <tr>
                        <td class="titulo-datos">COMUNA</td>
                        <td class="row-info"><div class="input-finalizacompra"><?= ''//comuna;            ?></div></td>
                    </tr> -->
                    <tr class="datos-confirm">
                        <td class="titulo-datos">TELÉFONO</td>
                        <td class="row-info"><div class="input-finalizacompra"><?= $actividad['nroContacto']; ?></div></td>
                    </tr>
                    <tr class="datos-confirm">
                        <td class="titulo-datos">PRECIO POR PERSONA</td>
                        <td class="row-info">
                            <div class="input-finalizacompra">$ <?= number_format($this->session->userdata('total') / $this->session->userdata('invitados'), 0, ',', '.'); ?></div>
                        </td>
                    </tr>
                    <tr class="datos-confirm">
                        <td class="titulo-datos">TOTAL</td>
                        <td class="row-info">
                            <div class="input-finalizacompra">$ <?= number_format($this->session->userdata('total'), 0, ',', '.'); ?></div>
                        </td>
                    </tr>
                </table>
            </div>
        <div>
            <!-- form con hidden fields -->
            <?= validation_errors(); ?>
            <?= form_open(base_url('TB/cgi-bin/tbk_bp_pago.cgi'), array('class' => 'form-paso3')); ?>
            <input type="hidden" name="TBK_TIPO_TRANSACCION" value="<?php echo $TBK_TIPO_TRANSACCION; ?>"/>
            <input type="hidden" name="TBK_MONTO" value="<?php echo $TBK_MONTO; ?>"/>
            <input type="hidden" name="TBK_ORDEN_COMPRA" value="<?php echo $TBK_ORDEN_COMPRA; ?>"/>
            <input type="hidden" name="TBK_ID_SESION" value="<?php echo $TBK_ID_SESION; ?>"/>
            <input type="hidden" name="TBK_URL_EXITO" value="<?php echo $TBK_URL_EXITO; ?>"/>
            <input type="hidden" name="TBK_URL_FRACASO" value="<?php echo $TBK_URL_FRACASO; ?>"/>
            <!-- fin form -->

            <div id="avanzar-compra">
                <input id="siguiente" type="submit" class="float-right btn-pagar" value="Pagar" />
            </div>
            <?= form_close(); ?>
        </div>
        </div>
    </div>
</div>