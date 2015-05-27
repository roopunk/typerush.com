<?php
session_start();
require_once '../config/config.php';
$config = new config();
require_once $config->appUrl.'config/connection.php';

if(!empty($_SESSION['paraid']))
	$paraid = $_SESSION['paraid'];
else 
	die(json_encode(array('status'=>0, 'code'=>'NO_PARA', 'message'=>'Paragraph information not received! '.$_SESSION['paraid'])));

$paraid = mysql_real_escape_string($paraid);
$fetch = mysql_query("SELECT * FROM run WHERE `paraid`='$paraid' ORDER BY `time`");
if(!$fetch) die(json_encode(array('status'=>0, 'code'=>'MYSQL_FAIL', 'message'=>mysql_error())));

if(mysql_num_rows($fetch)!=0) {
    $result = array();
    $result['content'] = "<table border='1px'><tr><th>Name</th><th>Time</th><th>WPM</th></tr>";
    while($row = mysql_fetch_assoc($fetch))
        $result['content'] .= "<tr><td>".$row['userid']."</td><td>".$row['time']."</td><td>".$row['wpm']."</td></tr>";
    $result['content'] .= "</table>";
} else {
    $result['content'] = "no scores yet";
}
$result['status'] = 1;
echo json_encode($result);    
?>
