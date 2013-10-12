<?php
	include_once("server.php");
 	include_once("IPC.php");	
	$port = "10008";
	$host ="localhost";
	$pid = pcntl_fork();
	if($pid == -1){
		print_r("ERROR => Failed in Forking\n");
	}
	else if($pid == 0){
		$IPC = new IPC_CONN();
		$IPC -> attach($server);
		$IPC -> listen_IPC();
		print_r("IPC START UP\n");
	        	
	}
        else {
	        $server = new Server($host,$port);
                $server->server_up();
                print_r("SERVER DOWN\n");
        }


?>
