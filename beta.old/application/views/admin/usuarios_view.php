<div class="row">
    <h3> Datos Personales </h3>
    <div class="small-9 columns">

        <?
        $dataUsuario = array(
            array('Avatar', "<img src='" . base_url() . "avatar/" . $datos_usuario['avatar'] . "'"),
            array('Nombre', $datos_usuario['nombre']),
            array('Apellidos', $datos_usuario['apellidoPaterno'] . " " . $datos_usuario['apellidoMaterno']),
            array('Mail', $datos_usuario['mail']),
            array('Link directo', $datos_usuario['link'])
        );
        $this->table->set_heading('', '');
        echo $this->table->generate($dataUsuario);
        ?>

    </div>
    <div class="small-3 columns">
        <a href="<?= base_url() . 'admin/usuarios/edit/' . $datos_usuario['idUsuario']; ?>" class="left fi-pencil button tiny "></a>
        <?php if ($datos_usuario['estado'] == 1): ?>
            <a href="<?= base_url() . 'admin/usuarios/chgStatus/' . $datos_usuario['idUsuario']; ?>/0" class="off left fi-minus button tiny" title="Deshabilitar"></a>
        <?php else: ?>
            <a href="<?= base_url() . 'admin/usuarios/chgStatus/' . $datos_usuario['idUsuario']; ?>/1" class="on left fi-check button tiny" title="Habilitar"></a>
        <?php endif; ?>
    </div>
</div>