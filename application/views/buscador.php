<span class="mayus resultado">Buscando por comuna</span>
        <?php echo form_open('chefs/busquedaForm', array('class' => 'overflowauto')); ?>
        <div>
            <input type="text" placeholder="Fecha" name="agenda" id="agenda" class="fecha-buscador">
            <select name="comuna">
                <option value="">TU COMUNA</option>
                <?php foreach ($comunas as $comuna): ?>
                    <option value="<?= $comuna['idMetaKey'] ?>"><?= $comuna['nombreMeta']; ?></option>
                <?php endforeach; ?>
            </select>
            <!-- <input type="text" placeholder="Tu Comuna" name="comuna" class="comuna-buscador">-->
            <select name="tag">
                <option value="">TAGS</option>
                <?php foreach ($tagsBuscar as $tag): ?>
                    <option value="<?= $tag['idMetaKey'] ?>"><?= $tag['nombreMeta']; ?></option>
                <?php endforeach; ?>
            </select>
            <input type="text" placeholder="Nombre del chef" class="nombrechef-buscador">
            
            <input type="submit" class="enviar-buscador">
        
        </div>