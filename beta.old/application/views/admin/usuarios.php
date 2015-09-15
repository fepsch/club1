<div class="container">
    <h1>
        <? //$titulo?>
    </h1>
    <div class="row">
        <div class='small-12 columns '>
            <a class="button tiny fi-plus" href="<?= base_url() . 'admin/usuarios/add/' ?>"> Agregar</a>
        </div>
    </div>
    <div class="row">
        <div class='small-12 columns '>
            <a class="button fi-search tiny" href="<?= base_url() . 'admin/usuarios/listarUsuarios/1' ?>"> Administradores</a>
            <a class="button fi-search  tiny" href="<?= base_url() . 'admin/usuarios/listarUsuarios/2' ?>"> Chefs</a>
            <a class="button fi-search tiny" href="<?= base_url() . 'admin/usuarios/listarUsuarios/3' ?>"> Clientes</a>
        </div>
    </div>
    <div class="row">
        <div class='small-12 columns '>
            <div id="lista">
                <ul class='lista-ver '>
                    <? foreach ($usuarios as $usuario) { ?>
                        <li>
                            <div class="row ">
                                <div class="medium-5 columns">
                                    <a href="<?= base_url() . "admin/usuarios/view/" . $usuario['idUsuario']; ?>"><?= $usuario['nombre'] . " " . $usuario['apellidoPaterno'] ?> 
                                        <? if (isset($usuario['tipoNombre'])) { ?>
                                            (<?= $usuario['tipoNombre'] ?>)
                                        <? } ?>
                                    </a>
                                </div>
                                <div class="medium-2 end columns">
                                    <a href="<?= base_url() . "admin/usuarios/edit/" . $usuario['idUsuario']; ?>" class="left fi-pencil button tiny "></a>
                                    <?php if ($usuario['estado'] == 1): ?>
                                        <a href="<?= base_url() . "admin/usuarios/chgStatus/" . $usuario['idUsuario']; ?>/0" class="off left fi-minus button tiny " title="Deshabilitar"></a>
                                    <?php else: ?>
                                        <a href="<?= base_url() . "admin/usuarios/chgStatus/" . $usuario['idUsuario']; ?>/1" class="on left fi-check button tiny " title="Habilitar"></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </li>
                        <?
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>
