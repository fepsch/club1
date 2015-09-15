<?php
function generaCheck($metas) {
    echo "<ul>";
    foreach ($metas as $meta) {
        $openTag = '<';
        $type = 'input type="checkbox"';
        $name = ' name="'.str_replace(' ', '_', strtolower($meta['nombreTipo'])).'[]"';
        $value = ' value="' . $meta['idMetaKey'] . '" ';
        $setValue = set_checkbox(str_replace(' ', '_', strtolower($meta['nombreTipo'])).'[]', $meta['idMetaKey'], isset($meta['dato']) ? TRUE : FALSE);
        $closeTag = '/>';
        $nombreField = ucwords(str_replace('_', ' ', $meta['nombreMeta']));
        echo '<li>'.$openTag.$type.$name.$value.$setValue.$closeTag.$nombreField.'</li>';
    }
    echo "</ul>";
}

function generaText($metas) {
    foreach ($metas as $meta) {
        $formato = ''; //para indicar el formato del rango de comensales
        if($meta['idMetaKey'] == 5)
            $formato = ' (N-N)';
        $openTag = '<';
        $type = 'input type="text"';
        $name = ' name="'.str_replace(' ', '_', strtolower($meta['nombreTipo'].'['.$meta['idMetaKey'].']"'));
        $value = ' value="'.set_value(str_replace(' ', '_', strtolower($meta['nombreTipo'].'['.$meta['idMetaKey'].']')), isset($meta['dato']) ? $meta['dato'] : '').'" ';
        $closeTag = '/>';
        $nombreField = ucwords(str_replace('_', ' ', $meta['nombreMeta'])) . $formato;
        echo $nombreField.$openTag.$type.$name.$value.$closeTag;
    }
}
?>