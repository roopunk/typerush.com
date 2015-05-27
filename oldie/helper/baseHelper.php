<?php
 function preparePara($text) {
     $temp = explode(' ', $text);
     $temp1 = array();
     foreach($temp as $t) {
         $temp1[] = "<span>$t</span>";
     }
     return implode(" ", $temp1);
 }
?>
