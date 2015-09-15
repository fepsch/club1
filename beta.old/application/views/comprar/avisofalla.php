<div>
    <div id="pasos" class="menu overflowauto">
        <ul class="centerbox overflowauto">
            <li>1</li>
            <li>2</li>
            <li>3</li>
            <li class="paso-activo">4</li>
        </ul>
    </div>
</div>
<div id="pasofinal">
    <div id="cont-fallo" class="centerbox">
        <div id="wrapper-fallo">
            <div>
                <div><img src="<?= base_url('images/barra-error-top.png'); ?>" /></div>
                <div class="overflowauto">
                    <div id="img-fallo" class="float-left">
                        <img src="<?= base_url('images/img-error.png'); ?>" alt="error" />
                    </div>
                    <div id="op-fallida-texto" class="float-left">
                        <div class="destacado-fracaso">Transacción Fracasada</div>
                        <div class="destacado-fracaso">OC Nº: <?= $oc; ?></div>
                        <p>Las posibles causas de este rechazo son:</p>
                        <ul>
                            <li>Error en el ingreso de los datos de su tarjeta de crédito o debito (fecha y/o código de seguridad).</li>
                            <li>Su tarjeta de crédito o debito no cuenta con el cupo necesario para cancelar la compra.</li>
                            <li>Tarjeta aún no habilitada en el sistema financiero.</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div><img src="<?= base_url('images/barra-error-bottom.png'); ?>" /></div>
            <div id="avanzar-compra" class="overflowauto">
                <form action="<?= base_url('comprar/finalizarCompra'); ?>" method="POST">
                    <input type="hidden" value="finalizar" name="siguiente" />
                    <div class="float-right">
                        <input type="submit" id="aceptar" value="Regresar al Home" class="btn-fallapago"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
