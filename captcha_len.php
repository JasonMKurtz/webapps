<?php
	session_start(); 
	if (!isset($_SESSION['captcha'])) 
		header("Location: http://www.jkode.us/captcha/"); 

	header("Content-type: application/json"); 
	$ret = array(); 
	$cur_len = strlen($_SESSION['captcha']); 
	if (!isset($_POST['dir'])) // 1 = increase, 0 = decrease
		$new_len = -1; // returning -1 does nothing

	$new_len = 0; 
	$max = 0; // set to 1 when it has reached the max value: 8
	$min = 0; // set to 1 when it has reached the min value: 1
	switch ($_POST['dir']) {
		case 1: 
			$new_len = $cur_len + 1; 
			if ($new_len == 8)
				$max = 1; 
			break; 
		case 0: 
			$new_len = $cur_len - 1; 
			if ($new_len == 0) {
				$min = 1; 
				$new_len += 1; 
			}
			break; 
	}


	$ret = array(); 
	$ret['len'] = $new_len; 
	$ret['max'] = $max; 
	$ret['min'] = $min; 
	$_SESSION['length'] = $new_len; 
	echo json_encode($ret); 
?>