<?php

	session_start(); 
	if (!isset($_SESSION['captcha']) || $_SESSION['captcha'] == "") 
		header("Location: http://www.jkode.us/captcha"); 

	/* $data['gotit']   = TRUE/FALSE - do we have input? */
	/* $data['len']     = TRUE/FALSE - is the length correct for the captcha? */ 
	/* $data['captcha'] = TRUE/FALSE - if so, is the captcha correct? */ 
	$data = array('gotit' => 'FALSE', 'len' => 'FALSE', 'captcha' => 'FALSE');

	header("Content-type: application/json"); 
 
	if (!isset($_POST['input']) || $_POST['input'] == "") {
		$data['gotit'] = 'FALSE'; 
	} else {
		$data['gotit'] = 'TRUE'; 
	}

	if (strlen($_POST['input']) >= strlen($_SESSION['captcha'])) {
		$data['len'] = 'TRUE';  
	}

	if (strtolower($_POST['input']) == strtolower($_SESSION['captcha']))
		$data['captcha'] = 'TRUE';


	echo json_encode($data); 
?>