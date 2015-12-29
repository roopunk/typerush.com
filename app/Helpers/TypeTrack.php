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