<?php
require_once '../config/connection.php';

$text = "Every goal, every action, every thought, every feeling one experiences, whether it be consciously or unconsciously known, is an attempt to increase one's level of peace of mind.";

if(strlen($text) == 0) die("length of string is 0");
if(strlen($text) > 995) die("length of string should be less than 995 characters");

// replacing multiple spaces with single space
$text = preg_replace('!\s+!',' ', $text);
$text = mysql_real_escape_string($text);

// count the number of words.
$temp = explode(' ', $text);
$wordsLen = sizeof($temp);

$query = mysql_query("SELECT * FROM para WHERE `content`='$text'");
if(mysql_numrows($query) != 0)
	die("This para already exists");

$insert = mysql_query("INSERT INTO para (`words`,`content`) VALUES ('$wordsLen', '$text')");
if(!$insert) echo "not able to insert into table: ".mysql_error();
else echo "successfully inserted";
?>
