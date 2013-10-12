<?php
/**
*	String Constant
*
**/
$socket_conn_error = "Socket Connect Failed\n";

$email_match = "/^[0-9a-zA-Z]+@(([0-9a-zA-Z]+)[.])+[a-z]{2,4}$/i";

$email_tips = "Your Email :";

$password_tips = "Password (More than 7 number)";



if(!function_exists('email_error')){
	function email_error(){
		echo "-----------------------------------------------------\n";
                echo "|Please Input Correct Password ![More Than 7 Number]|\n";
                echo "-----------------------------------------------------\n";
	}
}

if(!function_exists('password_error')){
	function password_error(){
		 echo "-----------------------------------------------------\n";
                 echo "|          Please Input Correct Email !             |\n";
                 echo "-----------------------------------------------------\n";

	}
}

if(!function_exists('login_successfully')){
	function login_successfully(){
		echo "Login Successfully! \n";
	}
}

if(!function_exists('login_failed')){
	function login_failed(){
		echo "Login Failed! \n";
	}
}

if(!function_exists('conn_successfully')){
	function conn_successfully(){
		echo "Connected Successfully\n";
	}
}

?>
