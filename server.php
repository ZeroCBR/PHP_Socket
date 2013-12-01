<?php
	include_once"package_helper.php";
	include_once"client_socket.php";
	include_once"DB_access.php";
	class Server {
		private $host;
		private $IPC_KEY;
		private $port;
		private $IPC_mess;
		private $socket;
		private $clients;
		private $_LISTEN;
		private $database;
		private $message_queue;

		function __construct($host,$port){
			$this->host = $host;
			$this->port = $port;
			$this->_LISTEN = true;
			$this->clients = array();
			$this->IPC_KEY =ftok("/home/john/temp/key",'a');
			$this->database = new DB_access();
  		  	$this->IPC_mess= "";
			$this->message_queue = msg_get_queue($this->IPC_KEY, 0666);
		}

		
		function send_mess(){
			$package = mess_unpacking($this->IPC_mess);
			foreach($this->clients as $client){
                                if($client->get_id() == $package["uid"]){
                                        $client->send_mess($this->IPC_mess);
                                }
                        }
		}		

		function IPC_process(){
                        if(@msg_receive($this->message_queue,0,$msg_type,1024,$this->IPC_mess,true,MSG_IPC_NOWAIT)){
                        	$this->send_mess();
			}
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
	                        $this->IPC_process();
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
			$mess = socket_read($conn,1024);
			$client = new c_socket($conn, $this->database);
			if($client -> client_authorize($mess)){
				if($client->send_mess("succeed\n")){
					$this->clients[] = $client;
				}
			} 
			else{
				$client->send_mess("Login Failed\n");
				unset($client);
				socket_close($conn);
			}
		}		

	}

?>
