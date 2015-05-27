<?php
 function preparePara($text) {
     $temp = explode(' ', $text);
     $temp1 = array();
     foreach($temp as $t) {
         $temp1[] = "<span>$t</span>";
     }
     return implode(" ", $temp1);
 }

 function filterPara($text) {
 	$text = strip_tags(preg_replace("/\s+/", " ", preg_replace("/[^\x20-\x7E]+/", "", $text)));
 	$length = sizeof(explode(" ", $text));
 	return array($text, $length);
 }

 function getCSSJSVer($name, $type) {
 	$CI =& get_instance();
 	$is_live = $CI->config->item('is_live');
 	if(!$is_live) return $name;
 	if($type == 'js')
 		$resource = $CI->config->item('js_ver');
 	else $resource = $CI->config->item('css_ver');

 	if(!$resource[$name]) return $name;
 	else return $resource[$name];
 }
?>
