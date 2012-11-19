<?php
	require_once("Captcha.php"); 
	session_start();
	if (isset($_GET['len']) && $_GET['len'] != "") 
		$len = $_GET['len']; 
	else 
		$len = (isset($_SESSION['length']) ? $_SESSION['length'] : 4); 
	$Cap = new Captcha($len);
	$_SESSION['captcha'] = $Cap->GetKey();
	$Cap->Generate();
?>
