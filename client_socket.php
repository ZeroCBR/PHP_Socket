<?php
	include_once"DB_access.php";
	class c_socket{
		private $user_info;	
		private $login;		//True if the user login
		private $c_id;		//client socket id
		private $conn;
		private $db;
		function __construct($conn,$db){
			$login = false;	
			$this->conn = $conn;
			$this->db = $db;
		}
		
		function __destruct(){
			socket_close($this->conn);
		}
	
		function login(){
			$query = $this->db -> where("users",array("email"=>$this->user_info['email']));
			if($query){
				$pass = md5(md5($this->user_info['password']).$query['salt']);
				if($pass === $query['hashed_password']){
					$this->c_id = $query['id'];
					return true;
				}
			}
			return false;
		}

		function get_id(){
			return $this->c_id;
		}
		
		function send_mess($mess){
			echo"Send Message: ".$mess."\n";
			if(!($size=socket_write($this->conn,$mess,1024))){
				echo "Error: ".socket_strerror(socket_last_error())."\n";
				return false;
			}
			else return true;
		}
		
		function client_authorize($packing){
                        $this->user_info = unpacking_login($packing);
                	if(!$this->login()){
				return false;
			}	
			return true;
		}

	}
?>
