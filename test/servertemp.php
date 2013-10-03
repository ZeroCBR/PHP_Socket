<?php
/**
**   This part is the defination of variable
**
**/
	$mess = array('name'=>'john',  'number'=>'123456');
	$package = json_encode($mess);
	$_LISTEN = true;
	set_time_limit(0);
	$host = "localhost";
	$port = "10008";

/**
**   For Running the script
**
**/
	setup();


/**
**
**   Function implemention
**
**/
		

	//Initialize the socket server
	function setup(){
		GLOBAL $host,$port;
		server_start($host,$port);
	}


	//Start listening and accept the connections
	function server_start($host, $port){
		GLOBAL $_LISTEN;
		GLOBAL $package;
		$str = "I receive your message ";
		if(($socket = socket_create(AF_INET, SOCK_STREAM,0))<0){
			echo "Error in creating socket =>".socket_strerror($socket);
			exit();
		}
		if(($fed = socket_bind($socket, $host, $port))<0){
			echo "Error in binding socket =>".socket_strerror($socket);
			exit();
		}
		if(($fed = socket_listen($socket, 9))<0){
			echo "Error in listenning socket =>".socket_strerror($socket);
			exit();
		}
		socket_set_nonblock($socket);
		echo "Waiting for connection !"."\n";
		while($_LISTEN){
			$conn = @socket_accept($socket);
			if(!$conn){
				usleep(200);	
			}
			else if($conn > 0){
				socket_write($conn,$package, strlen($package));
				$_LISTEN = false;
			}	
			else {
				echo "Error in connecting =>".socket_strerror($conn);
				die;
			}
		}
		socket_close($conn);
		socket_close($socket);
	}

?>
