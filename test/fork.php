<?php

$pid = pcntl_fork();
$mess = "Hello Fork";
if($pid == -1 ){
	print_r("Can not fork\n");
}
else if($pid){
	echo "Parent exit\n";
}
else{
	echo $pid;
	$counter =0;
	while($counter<10){
		$counter ++;
		echo $counter."\n";
		sleep(1);
	}
	echo "Child exit\n";
	
}

?>
