<?php
	require_once("Rectangle.php"); 
	header("Content-type: application/json"); 
	$ret = array(); 

	if (!isset($_POST['width']) || !isset($_POST['height']) || !is_numeric($_POST['width']) || !is_numeric($_POST['height'])) {
		$ret['area'] = -1; 
		$ret['diag'] = -1; 
		echo json_encode($ret); 
		return; 
	}

	$Rect = new Rectangle($_POST['width'], $_POST['height']); 
	$ret['area'] = $Rect->CalcArea(); 
	$ret['diag'] = $Rect->CalcDiagonal(); 
	echo json_encode($ret); 
	return; 
?>	
				