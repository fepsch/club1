<div class="row">
    <a class="button fi-arrow-left tiny round" href="<?= base_url('admin/chefs/view/16'); ?>">
        Volver al perfil del chef
    </a>
</div>
<div id="horarios-chef">
    <div class="row">
        <legend>Horarios</legend>
        <form id="diasPeriodos-Calendario">
            <table>
                <tr>
                    <th>Periodos</th>
                    <th>Lunes</th>
                    <th>Martes</th>
                    <th>Miércoles</th>
                    <th>Jueves</th>
                    <th>Viernes</th>
                    <th>Sábado</th>
                    <th>Domingo</th>
                    <?php $idPeriodo = NULL; ?>
                    <?php foreach ($agenda as $diaPeriodo): ?>
                        <?php if ($idPeriodo != $diaPeriodo['idPeriodo']): ?>
                            <?php $idPeriodo = $diaPeriodo['idPeriodo']; ?>
                        </tr><tr>
                            <td><?= date('H:i', strtotime($diaPeriodo['inicio'])) . ' - ' . date('H:i', strtotime($diaPeriodo['fin'])) ?></td>
                            <td style="text-align: center">
                                <input
                                    type="checkbox"
                                    name="horarios[]"
                                    value="<?= $diaPeriodo['idDiaAgenda'] . '-' . $diaPeriodo['idPeriodo']; ?>"
                                    <?= set_checkbox('horarios[]', $diaPeriodo['idPeriodo'], isset($diaPeriodo['idChef']) ? TRUE : FALSE); ?>
                                    />
                            </td>
                        <?php else: ?>
                            <td style="text-align: center">
                                <input
                                    type="checkbox"
                                    name="horarios[]"
                                    value="<?= $diaPeriodo['idDiaAgenda'] . '-' . $diaPeriodo['idPeriodo']; ?>"
                                    <?= set_checkbox('horarios[]', $diaPeriodo['idPeriodo'], isset($diaPeriodo['idChef']) ? TRUE : FALSE); ?>
                                    />
                            </td>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tr>
            </table>
            <div>
                <input type="button" class="button tiny" value="Guardar Calendario" id="btn-calendario"/>
            </div>
        </form>
    </div>
</div>
<div class="row">
    <form id="fechas-bloqueo">
        <div class="row">
            <div class="small-4 column">
                <div id="calendario-bloqueo"></div></div>
            <div class="small-6 column end">
                <ul class="small-block-grid-5">
                </ul>

                <input type="button" class="button tiny" value="Bloquear Días" id="btn-bloqueo"/>
            </div>
        </div>
    </form>
</div>
<div class="row">
    <div class="small-10" id="tabla-bloqueados">
        <?= $agendaNoDisponible; ?>
    </div>
</div>
<script>
    $('#calendario-bloqueo').datepicker({
        changeMonth: true,
        changeYear: true,
        firstDay: 1,
        minDate: 0,
        maxDate: 365 * 3,
        onSelect: function(dateText, inst) {
            var date = $(this).val();
            var nodo = '<li class="rem-extra-padding">' +
                    '<div class="row collapse">' +
                    '<small class="tiny">' + date + '</small>' +
                    '<small><a href=""><span class="fi-x"></span></a></small>' +
                    '<input type="hidden" name="fecha[]" value="' + date + '"/></div></li>';
            $('.small-block-grid-5').append(nodo);
            //$("#start").val(date + time.toString(' HH:mm').toString());
            $('.small-block-grid-5 li').click(function(event) {
                event.preventDefault();
                $(this).remove();
            });
        }
    });

    $('#btn-bloqueo').click(function() {
        var form = $('#fechas-bloqueo');
        var url = '<?= base_url('admin/chefs/modificarCalendario/' . $idChef); ?>';
        $.post(url, form.serialize()).done(function(data) {
            resp = data;
            console.log(resp);
            $('.small-block-grid-5 li').html('');
            /*if (resp) {*/
            alert('guardado!!');
            /*}
             else {
             alert('no guardado =(')
             }*/
        });
    });

    $('#btn-calendario').click(function() {
        var form = $('#diasPeriodos-Calendario');
        var url = '<?= base_url('admin/chefs/modificarCalendario/' . $idChef); ?>';
        $.post(url, form.serialize()).done(function(data) {
            resp = data;
            /*console.log(resp);
             if (resp) {*/
            alert('guardado!!');
            /*}
             else {
             alert('no guardado =(')
             }*/
        });
    });

    function eventoHabilitaFecha() {
        $('.activa-fecha').click(function() {
            var fecha = $(this).siblings().val();
            var resp = confirm('¿Está seguro que desea borrar el registro?');
            if (resp) {
                var url = '<?= base_url('admin/chefs/habilitarFecha/' . $idChef) ?>';
                $.post(url, {'fecha': fecha}).done(function(data) {
                    $('#tabla-bloqueados').html(data);
                    eventoHabilitaFecha();
                });
            }
        });
    }

    eventoHabilitaFecha();

</script>