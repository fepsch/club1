<div id="menuchef">
    <?php if (empty($experiencias)): ?>
        <p>El Chef no registra Experiencias</p>
    <?php else : ?>
        <?php
        $diasMinimos = new DateInterval('P3D');
        $inicio_calendario = date_add(date_create(), $diasMinimos);
        ?>
        <ul>
            <?php
            $rangoPersonas = explode('-', $parametrosChef['5']);
            $icero = (int) $rangoPersonas[0];
            $iuno = (int) $rangoPersonas[1];
            if ($this->session->userdata('fecha') && $this->session->userdata('boolHora')) {
                $fecha_default = date('d/m/Y H:i', strtotime($this->session->userdata('fecha')));
            } else if ($this->session->userdata('fecha')) {
                $fecha_default = date('d/m/Y', strtotime($this->session->userdata('fecha')));
            } else {
                $fecha_default = '';
            }
            
            $min = min($icero, $iuno);
            $max = max($icero, $iuno);
            
            $comensales_default = $min < 6 && $max > 6 ? 6 : ($max < 6 ? $max : $min);
            ?>
            <?php
            foreach ($experiencias as $experiencia) :
                $idExperiencia = $experiencia['idExperiencia'];
                ?>
                <li class="overflowauto">
                    <h2 class="titulo-fantasia SueEllen mayus"><?= $experiencia['nombre']; ?></h2>
                    <div class="float-left texto-fantasia">
                        <div class="texto-fantasia-wrapper">
                            <div class="img-experiencia overflowauto"><img src="<?= base_url('images/experiencias/' . $experiencia['imagen']); ?>" alt="imagen experiencia <?= $experiencia['nombre'] ?>"/></div>
                            <p class="descripcion-fantasia"><?= $experiencia['descripcion']; ?></p><br>
                            <?php foreach ($experiencia['platos'] as $plato): ?>
                                <span class="titulo-plato mayus"><?= $plato['nombre']; ?></span>
                                <p class="texto-plato"><?= $plato['descripcion']; ?></p><br>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="float-left info-actividad bg-rojo">
                        <div class="mayus titulo-info bg-rojo-oscuro">COTIZADOR</div>
                        <!--Form experiencia -->
                        <form class="form-compra" action="<?= base_url('chefs/verDatosChef/' . $datosChef['idUsuario']); ?>" method="POST">
                            <div class="datos-info">
                                <div class="overflowauto row-detalle">
                                    <div class="titulo-datos">Chef</div>
                                    <div class="row-info">
                                        <div class="input-vista-chef"><?= ucwords($datosChef['nombre'] . ' ' . $datosChef['apellidoPaterno']) ?></div>
                                    </div>
                                </div>
                                <div class="overflowauto row-detalle">
                                    <div class="titulo-datos">Experiencia</div>
                                    <div class="row-info">
                                        <div class="input-vista-chef"><?= $experiencia['nombre']; ?></div>
                                    </div>
                                </div>
                                <div class="overflowauto row-detalle">
                                    <div class="titulo-datos">¿Cuántos Comen?</div>
                                    <div class="row-info cantidad-invitados prompt-input">
                                        <input id="invitados<?= $idExperiencia; ?>"
                                               name="invitados<?= $idExperiencia; ?>"
                                               class="spinner-invitados"
                                               value="<?= set_value('invitados' . $idExperiencia, $comensales_default); ?>"
                                               />
                                    </div>
                                </div>
                                <div class="overflowauto row-detalle">
                                    <div class="titulo-datos">Tiempo que el chef estar&aacute; en tu casa</div>
                                    <div class="row-info horario-evento">
                                        <input id="duracion<?= $idExperiencia; ?>"
                                               name="duracion<?= $idExperiencia; ?>"
                                               class="input-vista-chef duracion"
                                               readOnly
                                               value="<?= set_value('duracion' . $idExperiencia, gmdate('H:i', $experiencia['tiempo' . $comensales_default] * 60 * 60)); ?>"
                                               /><span class="input-vista-chef duracion no-upper">Horas</span>
                                    </div>
                                </div>
                                <div class="overflowauto row-detalle">
                                    <div class="titulo-datos">Fecha y Hora</div>
                                    <div class="row-info horario-evento prompt-input">
                                        <input id="horario<?= $idExperiencia; ?>"
                                               name="horario<?= $idExperiencia; ?>"
                                               class="input-vista-chef input-normal ui-corner-all"
                                               value="<?= set_value('horario' . $idExperiencia, $fecha_default); ?>"
                                               placeholder="dd/mm/aaaa h:m"
                                               required
                                               />
                                        <input type="hidden" name="bool_hora<?= $idExperiencia; ?>" id="bool_hora<?= $idExperiencia; ?>" value="<?= set_value('bool_hora', $this->session->userdata('boolHora') !== FALSE ? '1' : '0'); ?>" />
                                        <script>
                                            var horas = [];
                                            $(function() {
                                                $("#horario<?= $idExperiencia; ?>").datetimepicker({
                                                    onGenerate: function(ct) {
                                                        if (horas.length !== 0) {
                                                            this.setOptions({
                                                                allowTimes: horas
                                                            });
                                                            horas = [];
                                                        }
                                                        var diasSemana = filtroDias();
                                                        for (var index in diasSemana) {
                                                            $(this).find(diasSemana[index]).addClass('xdsoft_disabled');
                                                        }
                                                        var fecha = ct.toISOString();
                                                        $.post('<?= base_url('chefs/diasNoDisponiblesMes'); ?>', {
                                                            fecha: fecha,
                                                            idChef: <?= $datosChef['idUsuario'] ?>
                                                        }).done(function(data) {
                                                            var diasMes = eval(data);
                                                            for (var index in diasMes) {
                                                                var fecha = new Date(diasMes[index].fecha);
                                                                var fecha_local = new Date(fecha.valueOf() + fecha.getTimezoneOffset() * 60000);
                                                                $('[data-date="' + fecha_local.getDate() + '"][data-month="' + fecha_local.getMonth() + '"]')
                                                                        .addClass('xdsoft_disabled');
                                                            }
                                                        });
                                                        $('.xdsoft_time_variant').css('margin-top', '0px');
                                                    },
                                                    onSelectDate: function(current_time, $input) {
                                                        var fecha = $input[0].value;
                                                        var dtp = this; //datetimepicker
                                                        $.post('<?= base_url('chefs/horasDisponibles'); ?>', {
                                                            fecha: fecha,
                                                            idChef: <?= $datosChef['idUsuario'] ?>
                                                        }).done(function(data) {
                                                            horas = eval(data);
                                                            var horaPre = new Date('1970/01/01 ' + horas[0]);
                                                            console.log(horaPre);
                                                            console.log(current_time);
                                                            dtp.setOptions({
                                                                timepicker: true,
                                                                allowTimes: horas,
                                                                defaultDate: current_time,
                                                                defaultTime: horaPre
                                                            });
                                                        });
                                                    },
                                                    onSelectTime: function(ct) {
                                                        $('#bool_hora<?= $idExperiencia; ?>').val('1');
                                                        this.setOptions({
                                                            format: 'd/m/Y H:i',
                                                            defaultTime: ct,
                                                            value: parseDateValue(ct)
                                                        });
                                                    },
                                                    onChangeDateTime: function(ct) {
                                                        if ($('#bool_hora<?= $idExperiencia; ?>').val() === '1') {
                                                            this.setOptions({
                                                                value: parseDateValue(ct)
                                                            });
                                                        }
                                                    },
                                                    onShow: function(ct) {
                                                            <?php if (form_error('bool_hora' . $idExperiencia) != '' OR $this->session->userdata('fecha')): ?>
                                                            var fecha = ct.toISOString();
                                                            var dtp = this; //datetimepicker
                                                            $.post('<?= base_url('chefs/horasDisponibles'); ?>', {
                                                                fecha: fecha,
                                                                idChef: <?= $datosChef['idUsuario'] ?>
                                                            }).done(function(data) {
                                                                var horas = eval(data);
                                                                dtp.setOptions({
                                                                    timepicker: true,
                                                                    allowTimes: horas,
                                                                    defaultDate: ct
                                                                });
                                                            });
                                                            <?php endif; ?>
                                                    },
                                                    format: '<?= $this->session->userdata('boolHora') ? 'd/m/Y H:i' : 'd/m/Y' ?>',
                                                    minDate: '<?= $inicio_calendario->format('Y/m/d') ?>',
                                                    lang: 'es',
                                                    dayOfWeekStart: 1,
                                                    todayButton: false,
                                                    lazyInit: true,
                                                    timepicker: false,
                                                    defaultSelect: false,
                                                    roundTime: 'floor',
                                                    allowBlank: true,
                                                    defaultDate: '<?= $this->session->userdata('fecha') !== FALSE ? date('d/m/Y', strtotime($this->session->userdata('fecha'))) : ''; ?>',
                                                    defaultTime: '<?= $this->session->userdata('boolHora') ? date('H:i', strtotime($this->session->userdata('fecha'))) : ''; ?>'
                                                });
                                            });
                                        </script>
                                    </div>
                                </div>
                                <div class="overflowauto row-detalle">
                                    <div class="titulo-datos">Precio por persona</div>
                                    <div class="row-info total-evento">
                                        <input type="text"
                                               id="precioporpersona<?= $idExperiencia; ?>"
                                               name="precioporpersona<?= $idExperiencia; ?>"
                                               class="input-vista-chef total"
                                               readonly
                                               value="<?= set_value('precioporpersona' . $idExperiencia, number_format($parametrosChef['4'] * $experiencia['tiempo' . $comensales_default] / $comensales_default, 0, ',', '.')); ?>"
                                               />
                                    </div>
                                </div>
                                <div class="overflowauto">
                                    <div class="titulo-datos">Total</div>
                                    <div class="row-info total-evento">
                                        <input type="text"
                                               id="total<?= $idExperiencia; ?>"
                                               name="total<?= $idExperiencia; ?>"
                                               class="input-vista-chef total"
                                               readonly
                                               value="<?= set_value('total' . $idExperiencia, number_format($parametrosChef['4'] * $experiencia['tiempo' . $comensales_default], 0, ',', '.')); ?>"
                                               />
                                    </div>
                                </div>
                                <input type="hidden" name="id" value="<?= $idExperiencia; ?>">
                                <input type="hidden" name="fecha<?= $idExperiencia; ?>" id="fecha<?= $idExperiencia; ?>" />
                            </div>
                            <?php if (form_error('invitados' . $idExperiencia) != '' OR form_error('horario' . $idExperiencia) != '' OR form_error('fecha' . $idExperiencia) != '' OR form_error('bool_hora' . $idExperiencia) != ''): ?>
                                <div class="compra-error">
                                    <?php
                                    echo form_error('invitados' . $idExperiencia, '<p>!', '¡</p>');
                                    echo form_error('horario' . $idExperiencia, '<p>!', '¡</p>');
                                    echo form_error('fecha' . $idExperiencia, '<p>!', '¡</p>');
                                    echo form_error('bool_hora' . $idExperiencia, '<p>!', '¡</p>');
                                    ?>
                                </div>
                            <?php endif; ?>
                            <div class="bg-rojo-oscuro-btn">
                                <?php $disabled = is_numeric($parametrosChef['4']) ? '' : 'disabled'; ?>
                                <input <?= $disabled; ?> class="btn-comprar" type="submit" value="Confirmar reserva"/>
                            </div>
                        </form>
                        <div></div>
                        <div></div>
                    </div>
                    <script>
                        $('#invitados<?= $idExperiencia; ?>').on("spinstop", function(event, ui) {
                            var total = 0;
                            var participantes = Number($(this).val());
                            switch (participantes) {
                                case 2:
                                    $('#duracion<?= $idExperiencia; ?>').val('<?= gmdate('H:i', $experiencia['tiempo2'] * 60 * 60); ?>');
                                    total = <?= $parametrosChef['4'] * $experiencia['tiempo2'] ?>;
                                    break;
                                case 3:
                                    $('#duracion<?= $idExperiencia; ?>').val('<?= gmdate('H:i', $experiencia['tiempo3'] * 60 * 60); ?>');
                                    total = <?= $parametrosChef['4'] * $experiencia['tiempo3'] ?>;
                                    break;
                                case 4:
                                    $('#duracion<?= $idExperiencia; ?>').val('<?= gmdate('H:i', $experiencia['tiempo4'] * 60 * 60); ?>');
                                    total = <?= $parametrosChef['4'] * $experiencia['tiempo4'] ?>;
                                    break;
                                case 5:
                                    $('#duracion<?= $idExperiencia; ?>').val('<?= gmdate('H:i', $experiencia['tiempo5'] * 60 * 60); ?>');
                                    total = <?= $parametrosChef['4'] * $experiencia['tiempo5'] ?>;
                                    break;
                                case 6:
                                    $('#duracion<?= $idExperiencia; ?>').val('<?= gmdate('H:i', $experiencia['tiempo6'] * 60 * 60); ?>');
                                    total = <?= $parametrosChef['4'] * $experiencia['tiempo6'] ?>;
                                    break;
                                case 7:
                                    $('#duracion<?= $idExperiencia; ?>').val('<?= gmdate('H:i', $experiencia['tiempo7'] * 60 * 60); ?>');
                                    total = <?= $parametrosChef['4'] * $experiencia['tiempo7'] ?>;
                                    break;
                                case 8:
                                    $('#duracion<?= $idExperiencia; ?>').val('<?= gmdate('H:i', $experiencia['tiempo8'] * 60 * 60); ?>');
                                    total = <?= $parametrosChef['4'] * $experiencia['tiempo8'] ?>;
                                    break;
                                case 9:
                                    $('#duracion<?= $idExperiencia; ?>').val('<?= gmdate('H:i', $experiencia['tiempo9'] * 60 * 60); ?>');
                                    total = <?= $parametrosChef['4'] * $experiencia['tiempo9'] ?>;
                                    break;
                                case 10:
                                    $('#duracion<?= $idExperiencia; ?>').val('<?= gmdate('H:i', $experiencia['tiempo10'] * 60 * 60); ?>');
                                    total = <?= $parametrosChef['4'] * $experiencia['tiempo10'] ?>;
                                    break;
                                case 11:
                                    $('#duracion<?= $idExperiencia; ?>').val('<?= gmdate('H:i', $experiencia['tiempo11'] * 60 * 60); ?>');
                                    total = <?= $parametrosChef['4'] * $experiencia['tiempo11'] ?>;
                                    break;
                                case 12:
                                    $('#duracion<?= $idExperiencia; ?>').val('<?= gmdate('H:i', $experiencia['tiempo12'] * 60 * 60); ?>');
                                    total = <?= $parametrosChef['4'] * $experiencia['tiempo12'] ?>;
                                    break;
                                case 13:
                                    $('#duracion<?= $idExperiencia; ?>').val('<?= gmdate('H:i', $experiencia['tiempo13'] * 60 * 60); ?>');
                                    total = <?= $parametrosChef['4'] * $experiencia['tiempo13'] ?>;
                                    break;
                                case 14:
                                    $('#duracion<?= $idExperiencia; ?>').val('<?= gmdate('H:i', $experiencia['tiempo14'] * 60 * 60); ?>');
                                    total = <?= $parametrosChef['4'] * $experiencia['tiempo14'] ?>;
                                    break;

                            }
                            $('#total<?= $idExperiencia; ?>').val(formatoTotal(Math.round(total)));
                            var ppp = parseInt(total / participantes);
                            $('#precioporpersona<?= $idExperiencia; ?>').val(formatoTotal(ppp));
                        });
                    </script>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('.form-compra').submit(function(event) {
            event.preventDefault();
            var form = $(this);
            var url = form.attr('action');
            $.post(url + "/ajax", form.serialize()).done(function(data) {
                try {
                    var resp = JSON.parse(data);
                    if (resp.login) {
                        $.magnificPopup.open({
                            items: {
                                src: '<?= base_url('login'); ?>'
                            },
                            type: 'ajax'
                        }, 0);
                    }
                    else {
                        window.location.href = resp.url;
                    }
                } catch (e) {
                    $('#content').html(data);
                }
            });
        });
    });
    function filtroDias() {
        var diasSemana = {
            1: '.xdsoft_day_of_week1',
            2: '.xdsoft_day_of_week2',
            3: '.xdsoft_day_of_week3',
            4: '.xdsoft_day_of_week4',
            5: '.xdsoft_day_of_week5',
            6: '.xdsoft_day_of_week6',
            7: '.xdsoft_day_of_week0'
        };
        var diasChef = eval(<?= json_encode($diasSemana); ?>);
        for (var index in diasChef) {
            delete diasSemana[diasChef[index].idDiaAgenda];
        }
        return diasSemana;
    }
    ;

    $(".spinner-invitados").spinner({
        min: <?= $min; ?>,
        max: <?= $max; ?>
    });

    function formatoTotal(total) {
        var numero = String(total).split('');
        var tmp = [];
        var cnt = 1;
        for (i = numero.length - 1; i >= 0; i--) {
            tmp[cnt] = numero[i];
            if ((numero.length - i) % 3 === 0 && i !== 0) {
                cnt++;
                tmp[cnt] = '.';
            }
            cnt++;
        }
        var totalParsed = tmp.reverse();
        return totalParsed.join('');
    }
</script>