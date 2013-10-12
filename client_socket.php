<?php
	class c_socket {
		private $user_info;	
		private $login;		//True if the user login
		private $c_id;		//client socket id
		private $conn;
	
		function __construct($conn){
			$login = false;	
			$this->conn = $conn;
		}
		
		function login(){
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
		}
			
		function destroy(){

		}	

	}
?>
