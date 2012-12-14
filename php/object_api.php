<?php
	require_once("api.class.php"); 
	$API = new API("http://www.liber.in/api/count.php", 1); 

	$API->Send("message", "blah"); 
	echo sprintf("Server Response: Received '%s' (upper: '%s', lower: '%s', length: %s)\n", 
				$API->Get()->raw, $API->Get()->upper, $API->Get()->lower, $API->Get()->length); 
?>