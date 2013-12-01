<?php 
	include_once("package_helper.php");
	include_once("noti_helper.php");
	class client {

		private $socket;
		private $user_info;
		private $mess;
		private $login_flag;

		function __construct(){
			$this->login_flag = false;
			$this->conn();
		 	set_time_limit (0);
		}
		
		function login(){
			$packing = packing($this->user_info);
			socket_write($this->socket,$packing,1024);
			$this->mess=socket_read($this->socket,1024);
			echo $this->mess;
			if($this->mess === "succeed\n"){
				$this->login_flag = true;
				login_successfully();
				$this->listen();
			}
			else{
				login_failed();
				$this->conn();
			}
		}

		function get_user_info(){
			$pass = false;
			while(!$pass){
				unset($this->user_info);
				fwrite(STDOUT,"Email: ");
				$this->user_info = array('email'=>trim(fgets(STDIN)));
				fwrite(STDOUT,"Password(More Than 5 Number): ");
  				$this->user_info += array('password'=>trim(fgets(STDIN)));
				$pass = $this->checkout_user_info($this->user_info);
			}
		}
		
		function checkout_user_info($info){	
			if(!isset($info))
				return false;
			else if(preg_match("/^[0-9a-zA-Z]+@(([0-9a-zA-Z]+)[.])+[a-z]{2,4}$/i",$info['email'])){
				if(strlen($info['password'])>=6){
					return true;
				}
				email_error();
				return false;
			}
			password_error();
			return false;	
		}	
		
		function listen(){
			while(1){
				while (($data = @socket_read($this->socket,1024))) {  
            				print_r("Message From Server: ".$data."\n");
				} 
			}
		}		

		function conn(){
			$this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
			$this->get_user_info();
			if(@socket_connect($this->socket, '192.168.1.107', 10008)){
				conn_successfully();
				$this->login();
			} 
			else{
				socket_close($this->socket);
			}
		}

	}
		
	$client = new client();
?>
