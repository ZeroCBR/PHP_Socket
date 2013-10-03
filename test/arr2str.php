<?php
	$arr = array('name'=>'tom','num'=>'12345');
	$encode = implode(', ',$arr);
	echo $encode."\n";
	$decode = explode(', ',$encode);
	print_r($decode);
?>
