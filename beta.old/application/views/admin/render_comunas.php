<?php if (isset($comunas) && !empty($comunas)): ?>
    <div>
        <?php
        echo form_fieldset('Comunas');
        foreach ($comunas as $comuna):
            $data = array(
                'name' => $comuna['nombreMeta'],
                'id' => $comuna['nombreMeta'],
                'value' => $comuna['idMetaKey'],
            );
            echo form_checkbox($data);
        endforeach;
        echo form_fieldset_close();
        ?>
    </div>
<?php endif; ?>
