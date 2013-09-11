<?php

$pid = pcntl_fork();
$mess = "Hello Fork";
if($pid == -1 ){
	print_r("Can not fork\n");
}
else if($pid){
	for($i=0;$i<10;$i++){
	 	print_r("Main Thread Counter $i \n");
		sleep(1);
	}
	pcntl_wait($status);
}
else{
	system("php counter.php $mess"); 
}

?>
