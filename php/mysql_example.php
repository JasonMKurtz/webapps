<?php
	require_once("mysql.class.php");

	$m = new MySQL("liber", "jason1", "localhost", "Liber"); 
	$m->Query("SELECT * FROM test"); 

	$i = 0; 
	foreach ($m->Get() as $row) { 
		echo sprintf("Row %d: {'id': %s, 'field1': %s}\n", $i, $row['id'], $row['field1']); 
		$i++; 
	}

	echo sprintf("Row 0: ID = %s, FIELD1 = %s\n", $m->Get(0)->id, $m->Get(1)->field1); 
?>