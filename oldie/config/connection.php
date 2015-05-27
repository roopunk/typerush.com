<?php
$connection = mysql_connect('localhost', 'roopunkc_native', 'thenameofmine');
if(!$connection)
    die("not able to connect to the databse");
    
$dbsel = mysql_select_db('roopunkc_typerunner', $connection);
if(!$dbsel)
    die('could not select db');

?>
