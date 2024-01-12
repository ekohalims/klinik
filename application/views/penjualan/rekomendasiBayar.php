<?php
	$total = $_POST['total'];

	$pecahanMataUang = array(1000,2000,5000,10000,20000,50000,100000);

	if($total < 100000){
		foreach($pecahanMataUang as $dt){
			if($total > $dt){
				echo $dt;
			}
		}
	} elseif($total > 100000){
			
	} elseif($total > 1000000){

	} elseif($total > 10000000){

	} elseif()
?>