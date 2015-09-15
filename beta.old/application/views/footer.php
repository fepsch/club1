</div>
</div>
<div id="wrapper-footer">
    <div id="footer" class="bg-color-general mayus">
        <div id="links-paginas" class="centerbox">
            <?php $pages = $this->page_model->getPage(); ?>
            <ul>
                <?php foreach ($pages as $page) : ?>
                    <li class="float-left"><a href="<?= base_url('home/page/' . $page['idPage']); ?>"><?= $page['titulo']; ?></a></li>
                <?php endforeach; ?>
                <li class="float-left"><a href="<?= base_url('home/contacto'); ?>">Contacto</a></li>
            </ul>
        </div>
    </div>
</div>
<?php
$periodos = $this->periodos_model->get();
$inicios = array();
$fines = array();
foreach ($periodos as $periodo) {
    $inicios[] = (int) $periodo['inicio'];
    $fines[] = (int) $periodo['fin'];
}
$minTime = min($inicios);
$maxTime = max($fines);
?>

<?php
$diasMinimos = new DateInterval('P3D');
$inicio_calendario = date_add(date_create(), $diasMinimos);
?>

<script>
    $(function() {
        var diasSemana = {
            1: '.xdsoft_day_of_week1',
            2: '.xdsoft_day_of_week2',
            3: '.xdsoft_day_of_week3',
            4: '.xdsoft_day_of_week4',
            5: '.xdsoft_day_of_week5',
            6: '.xdsoft_day_of_week6',
            7: '.xdsoft_day_of_week0'
        };
        $.post('<?= base_url('home/fechasCalendarioBusqueda'); ?>', {
        }).done(function(data) {
            var diasMes = eval(data);
            for (var index in diasMes) {
                delete diasSemana[diasMes[index].idDiaAgenda];
            }
        });

        var horas = [];

        $("#agenda").datetimepicker({
            onGenerate: function(ct) {
                if (horas.length !== 0) {
                    this.setOptions({
                        allowTimes: horas
                    });
                    horas = [];
                }
                for (var index in diasSemana) {
                    $(this).find(diasSemana[index]).addClass('xdsoft_disabled');
                }
                var fecha = ct.toISOString();
                $.post('<?= base_url('home/diasNoDisponibles'); ?>', {
                    fecha: fecha
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
            onSelectDate: function(current_time) {
                var fecha = current_time.toISOString();
                var dtp = this; //datetimepicker
                $.post('<?= base_url('home/horariosCalendarioBusqueda'); ?>', {
                    fecha: fecha
                }).done(function(data) {
                    horas = eval(data);
                    if ($('#bool_hora').val() !== '1') {
                        dtp.setOptions({
                            timepicker: true,
                            allowTimes: horas,
                            defaultDate: current_time
                        });
                    } else {
                        dtp.setOptions({
                            allowTimes: horas
                        });
                    }
                });
            },
            onSelectTime: function(ct) {
                $('#bool_hora').val('1');
                this.setOptions({
                    format: 'd/m/Y H:i',
                    defaultTime: ct,
                    value: parseDateValue(ct)
                });
            },
            onChangeDateTime: function(ct) {
                if ($('#bool_hora').val() === '1') {
                    this.setOptions({
                        value: parseDateValue(ct)
                    });
                }
            },
            format: 'd/m/Y',
            minDate: '<?= $inicio_calendario->format('Y/m/d') ?>',
            lang: 'es',
            dayOfWeekStart: 1,
            todayButton: false,
            lazyInit: true,
            timepicker: false,
            defaultSelect: false,
            roundTime: 'floor',
            allowBlank: true
        });
    });
    $(function() {
        $('.input_autocomplete').autocomplete({
            source: "<?= base_url('chefs/autocompleteNombre'); ?>"
        });
    });

    function parseDateValue(value) {
        dt = value.toISOString();
        return moment(dt).format('DD/MM/YYYY HH:mm');
    }
</script>
<div id="mensaje-carga" style="display:none;"> 
    <img src="<?= base_url('images/cargando.gif'); ?>" alt="cargando" /><span>Cargando...</span>
</div> 
</div><div id="fb-root"></div>
<script src="http://connect.facebook.net/es_LA/all.js"></script>
<script>
    (function(i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function() {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
        a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

    ga('create', 'UA-58231904-1', 'auto');
    ga('require', 'displayfeatures');
    ga('send', 'pageview');

</script>
</body>
</html>