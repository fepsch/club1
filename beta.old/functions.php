<?php
if ( function_exists('register_sidebars') )
	register_sidebars(2, array(
		"before_title" => "<h2><span>",
		"after_title"  => "</span><small></small></h2>"
	));


add_action("wpcf7_before_send_mail", "wpcf7_do_something_else");  
  
function wpcf7_do_something_else($wpcf7_data) {  
  
   include_once(getcwd().'/pdf/phpToPDF.php');
  
   $datos = get_object_vars($wpcf7_data);
   $datos = $datos['posted_data'];
   $html = file_get_contents(getcwd().'/pdf/formato_carta.html');
   $isapre = $datos['isapre'];
   $nombre_completo = $datos['nombre_completo'];
   $rut = $datos['rut'];
   $precio_base_actual = $datos['precio_base_actual'];
   $precio_base_adecuado = $datos['precio_base_adecuado'];
   $nombre_plan = $datos['nombre_plan'];
   $precio_final_actual = $datos['precio_final_actual'];
   $fecha_emision = $datos['fecha_emision_carta'];
   $fecha_entrega = $datos['fecha_entrega_carta'];
   $precio_final_adecuado = $datos['precio_final_adecuado'];
   
   
   $html = str_replace("{{ISAPRE}}",$isapre, $html);
   $html = str_replace("{{NOMBRE_COMPLETO}}",$nombre_completo, $html);
   $html = str_replace("{{RUT}}", $rut, $html);
   $html = str_replace("{{PRECIO_BASE_ACTUAL}}",$precio_base_actual, $html);
   $html = str_replace("{{PRECIO_BASE_ADECUADO}}",$precio_base_adecuado, $html);
   $html = str_replace("{{NOMBRE_PLAN}}",$nombre_plan, $html);
   $html = str_replace("{{PRECIO_FINAL_ACTUAL}}",$precio_final_actual, $html);
   $html = str_replace("{{FECHA_EMISION}}",$fecha_emision, $html);
   $html = str_replace("{{FECHA_DE_ENTREGA}}",$fecha_entrega, $html);
   $html = str_replace("{{PRECIO_FINAL_ADECUADO}}", $precio_final_adecuado, $html);
   //echo $html; die();
   $path = '/pdf/pdf/';
   $filename = rand(1,999999999).'.pdf';
   
   phptopdf_html($html,$path, $filename);
   $wpcf7_data->uploaded_files['pdf_datos'] = $path . $filename;

}
?>

