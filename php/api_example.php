<?php
	require_once("api.class.php"); 

	$API = new API("http://www.liber.in/api/endpoint.php", 1); // set our API endpoint as http://www.domain.tld, and receive our data as an object.
	$data = array( 
			"message" => "Hello, world!", 
			"repeat"  => 3
		); 
	$API->Send($data); 
	print_r($API->Get()); 
?>