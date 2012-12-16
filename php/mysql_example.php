<?php
	require_once("mysql.class.php");
	require_once("config.inc.php"); 

	$m = new MySQL($config['mysql_user'], $config['mysql_password'], $config['mysql_host'], $config['mysql_database']); 
	$m->Query("SELECT * FROM test"); 

	$i = 0; 
	foreach ($m->Get() as $row) { 
		echo sprintf("Row %d: {'id': %s, 'field1': %s}\n", $i, $row['id'], $row['field1']); 
		$i++; 
	}

	echo sprintf("Row 0: ID = %s, FIELD1 = %s\n", $m->Get(0)->id, $m->Get(0)->field1); 
?>
