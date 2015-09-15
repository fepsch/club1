<div class="row">
    <div class="small-12 medium-6">
<div id="container">
    
    <div id="formulario">

        <?php
        echo validation_errors();
        echo form_open();
        ?>
        <fieldset>
            <legend>Datos Actividad</legend>
        <label>Cliente
        <input type="text" name="usuario" value="<?= set_value('usuario', isset($actividad['usuario']['nombre']) ? $actividad['usuario']['nombre'] : ''); ?>" readonly/>
        </label>
        <label>
        Chef
        <input type="text" name="chef" value="<?= set_value('chef', isset($actividad['chef']['nombre']) ? $actividad['chef']['nombre'] : ''); ?>" readonly/>
        </label>
        <label>
        Nombre Experiencia
        <input type="text" name="experiencia" value="<?= set_value('experiencia', isset($actividad['experiencia']['nombre']) ? $actividad['experiencia']['nombre'] : ''); ?>" readonly/>
        </label>
        <label>
        Fecha del Evento
        <input type="text" name="fecha" value="<?= set_value('fecha', isset($actividad['fecha']) ? date('d/m/Y', strtotime($actividad['fecha'])) : ''); ?>" />
        </label>
        <label>
        Valor del Evento
        <input type="number" name="valor" value="<?= set_value('valor', isset($actividad['valor']) ? $actividad['valor'] : ''); ?>" />
        </label>
        <label>
        Cantidad de Personas
        <input type="number" name="pasajeros" value="<?= set_value('pasajeros', isset($actividad['pasajeros']) ? $actividad['pasajeros'] : ''); ?>" />
        </label>
        <label>
        Estado de la Actividad
        <select name="estado">
            <option value="">Seleccione</option>
            <?php foreach($actividad['estados'] as $estado): ?>
            <option value="<?= $estado['idEstadoActividad']; ?>" 
            <?= set_select('estado', $estado['idEstadoActividad'], ($estado['idEstadoActividad'] == $actividad['idEstado'] ? TRUE : FALSE))?>>
                    <?= $estado['nombre']; ?>
            </option>
            <?php endforeach; ?>
        </select>
        </label>
        <label>
        Comentario
        <textarea name='comentarioActividad' id='comentarioActividad'><?= set_value('comentarioActividad', isset($actividad['comentarioActividad']) ? $actividad['comentarioActividad'] : ''); ?></textarea>
        </label>
        
        </fieldset>
        <input type="submit" class='button tiny' value="Enviar" />
        <?php
        
        
        
       
        echo form_close();
        ?>
    </div>
</div>