<?php
	include_once"package_helper.php";
	include_once"client_socket.php";
	include_once"DB_access.php";
	class Server implements SplObserver{
		private $host;
		private $port;
		private $socket;
		private $_LISTEN;
		private $clients;
		private $database;
		function __construct($host,$port){
			$this->host = $host;
			$this->port = $port;
			$this->_LISTEN = true;
			$this->clients = array();
			pcntl_signal(SIGCHLD,SIG_IGN);
			$this->database = new DB_access();
		}

		function update(SplSubject $subject){
			echo $subject->get_mess();
		}

		function server_up(){
	                if(($this->socket = socket_create(AF_INET, SOCK_STREAM,0))<0){
	                        echo "Error in creating socket => ".socket_strerror($this->socket);
	                        exit();
	                }
	                if(($fed = socket_bind($this->socket, $this->host, $this->port))<0){
	                        echo "Error in binding socket => ".socket_strerror($this->socket);
	                        exit();
	                }
	                if(($fed = socket_listen($this->socket, 9))<0){
	                        echo "Error in listenning socket => ".socket_strerror($this->socket);
	                        exit();
	                }
	                socket_set_nonblock($this->socket);
	                while($this->_LISTEN){
	                        $conn = @socket_accept($this->socket);
	                        if(!$conn){
	                                usleep(500);
	                        }
	                        else if($conn > 0){
	                        	$this->process_client($conn);
				}
	                        else {
     	                 	        echo "Error in connecting => ".socket_strerror($conn);
       	         	                die;
        	                }
	                }
                	socket_close($this->socket);
        	}
		
		function server_down(){
			$this->_LISTEN = false;
		}
		
		function process_client($conn){
			$pid = pcntl_fork();	
			if($pid == -1){
				echo "Fork Error!\n";
			}
			else if($pid == 0){
				socket_recv($conn,$mess,1024,MSG_DONTWAIT);
				$client = new c_socket($conn, $this->database);
				if($client -> client_authorize($mess)){
					socket_write($conn,"succeed",1024);
					echo "One Client Login\n";		
				}
				else{
					socket_write($conn,"Login Failed",1024);
					echo "Socket write\n";
					socket_close($conn);
					echo "Socket Close\n";
				}
			}
		}		

	}

?>
