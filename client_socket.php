<?php
	include_once"DB_access.php";
	class c_socket {
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
		
		function login(){
			$query = $this->db -> where("users",array("email"=>$this->user_info['email']));
			if($query){
				$pass =md5(md5($user_info['password'].$query['salt']));
				if($pass === $query['hashed_password']){
					return true;
				}
			}
			return false;
		}

		function get_id(){
			return $c_id;
		}

		function get_mail(){
			return mail;
		}
		
		function send_mess($mess){

		}
		
		function run(){
			if(!$this->conn)return false;
			else{
				echo 'Running !';
			}
		}
	
		function client_authorize($packing){
                        $this->user_info = unpacking_login($packing);
                	if(!$this->login()){
				return false;
			}	
			return true;
		}
			
		function destroy(){

		}	

	}
?>
