<?php
session_start();
require_once '../config/config.php';
$config = new config();
require_once $config->appUrl.'config/connection.php';

$time = mysql_real_escape_string($_POST['blah']);
$name = mysql_real_escape_string($_POST['name']);
$name = (empty($name))?'anonymous':$name;

if(!empty($_SESSION['paraid']))
	$paraid = $_SESSION['paraid'];
else 
	die(json_encode(array('status'=>0, 'code'=>'NO_PARA', 'message'=>'Paragraph information not received!')));

$paraid = mysql_real_escape_string($paraid);

$para = mysql_query("SELECT * FROM para WHERE `id`='$paraid'");
if(!$para) die(json_encode(array('status'=>0, 'code'=>'MYSQL_FAILED', 'message'=> mysql_result())));

if(mysql_num_rows($para) == 0) die(json_encode(array('status'=>0, 'code'=>'INVALID_PARA')));
$row = mysql_fetch_assoc($para);
$words = $row['words'];

// since time will be in 1/10th units of a second
$time = (float)$time/10;
$wpm = (float)$words/(float)((float)$time/60);

$insert = mysql_query("INSERT INTO run (`userid`,`paraid`,`time`, `wpm`) VALUES ('$name', '$paraid', '$time', '$wpm')");
if(!$insert) $result = array('status'=>0, 'code'=>'MYSQL_FAILED', 'message'=> mysql_result());
else $result = array('status'=>1, 'code'=>'INSERTED');

if(sizeof($result) == 0) 
    $result = array('status'=>1, 'content' =>"name: $name");
    
echo json_encode($result);
?>
