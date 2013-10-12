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
			socket_recv($this->socket,$this->mess,1024,MSG_WAITALL);
			if($this->mess === "succeed"){
				$this->login_flag = true;
				login_successfully();
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
				fwrite(STDOUT,"Password(More Than 7 Number): ");
  				$this->user_info += array('password'=>trim(fgets(STDIN)));
				$pass = $this->checkout_user_info($this->user_info);
			}
		}
		
		function checkout_user_info($info){	
			if(!isset($info))
				return false;
			else if(preg_match("/^[0-9a-zA-Z]+@(([0-9a-zA-Z]+)[.])+[a-z]{2,4}$/i",$info['email'])){
				if(strlen($info['password'])>=7){
					return true;
				}
				email_error();
				return false;
			}
			password_error();
			return false;	
		}	
	
		function conn(){
			$this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
			$this->get_user_info();
			if(@socket_connect($this->socket, '127.0.0.1', 10008)){
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
