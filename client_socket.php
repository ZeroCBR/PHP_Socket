<?php
	class c_socket {
	
		private $mail;		//user email
		private $login;		//True if the user login
		private $c_id;		//client socket id
		private $passwrod;
		private $conn;
	
		function __construct($conn){
			$login = false;	
			$this->conn = $conn;
		}
		
		function login($mail,$pass){
			$this->mail = $mail;
			$this->pass = $pass;
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
			
		function destroy(){

		}	

	}
?>
