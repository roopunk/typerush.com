<?php
	session_start();
	require_once ('config/config.php');
	$config = new config();
    require_once $config->appUrl.'config/connection.php';
   	require_once $config->appUrl.'helper/baseHelper.php';
	require_once $config->appUrl.'models/trackModel.php';
	$trackModel = new trackModel();
	$data['track'] = $trackModel->getTrack();
	$_SESSION['paraid'] = $data['track']['paraid'];

	include $config->appUrl.'views/head.php';
	include $config->appUrl.'views/header.php';
	$trackModel->getTracksDropDown();
	include $config->appUrl.'views/track.php'; 
	include $config->appUrl.'views/footer.php';	
?>
      
