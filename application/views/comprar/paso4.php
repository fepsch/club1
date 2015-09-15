<div>
    <div id="pasos" class="overflowauto">
    <ul class="centerbox overflowauto">
        <li>Confirma los detalles<br>de tu evento</li>
        <li>Ubicaci&oacute;n del evento</li>
        <li>Realizar pago</li>
        <li class="paso-activo">Comprobante</li>
    </ul>
</div>
</div>
<div id="pasofinal" class="overflowauto">
    <div class="mayus titulo-ingreso centerbox">
        <div>¡Listo! El Chef que has escogido está reservado para el evento. Te escribiremos en un plazo de 24 horas, ¡quédate atento!</div>
    </div>
    <div id="detalles">
        <div id="cont-confirmacion" class="float-left">
            <div class="info-actividad bg-rojo">
                <table>
                    <tr>
                        <th class="mayus titulo-info bg-rojo-oscuro tit-datos-fin" colspan="2">detalle de compra</th>
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
                            <div class="input-finalizacompra"><?= $invitados; ?></div>
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
                            <div class="input-finalizacompra"><?= date('H:i', strtotime($horario)); ?> HRS.</div>
                        </td>
                    </tr>
                    <tr class="datos-confirm">
                        <td class="titulo-datos">TIEMPO QUE EL CHEF ESTARÁ EN TU CASA</td>
                        <td class="row-info">
                            <div class="input-finalizacompra"><?= gmdate('H:i', $experiencia['tiempo' . $invitados] * 60 * 60); ?> HRS.</div>
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
                        <td class="row-info"><div class="input-finalizacompra"><?= ''//comuna;                 ?></div></td>
                    </tr> -->
                    <tr class="datos-confirm">
                        <td class="titulo-datos">TELÉFONO</td>
                        <td class="row-info"><div class="input-finalizacompra"><?= $actividad['nroContacto']; ?></div></td>
                    </tr>
                    <tr class="datos-confirm">
                        <td class="titulo-datos">PRECIO POR PERSONA</td>
                        <td class="row-info">
                            <div class="input-finalizacompra">$ <?= number_format($total / $invitados, 0, ',', '.'); ?></div>
                        </td>
                    </tr>
                    <tr class="datos-confirm">
                        <td class="titulo-datos">TOTAL</td>
                        <td class="row-info">
                            <div class="input-finalizacompra">$ <?= number_format($total, 0, ',', '.'); ?></div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <?php $this->load->view('comprar/resumen_TB'); ?>
        <div id="finalizar-compra" class="float-left">
            <div class="success-grp">
                <a href="<?= base_url('mipanel/perfil'); ?>" id="fin-ver-perfil"><input type="submit" class="boton-fin" value="Ver mi perfil"/></a>
                <a href="<?= base_url('mipanel/reservas'); ?>" id="fin-ver-reservas"><input type="submit" class="boton-fin" value="Ver mis reservas"/></a>
                <form action="<?= base_url('comprar/finalizarCompra'); ?>" method="POST" class="form-finalizar">
                    <input type="hidden" value="finalizar" name="siguiente" />
                    <input type="submit" id="fin-volver-home" class="boton-fin" value="Volver al Home" />
                </form>
            </div>
        </div>
    </div>
    <div id="aviso-terminos-condiciones"><p>En caso de requerir devoluciones o reembolsos primero revisa los "Términos y Condiciones" y cualquier duda contactanos a <a href="mailto:hola@clubdelacocina.cl">hola@clubdelacocina.cl</a></p></div>
</div>
