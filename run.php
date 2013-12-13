<?php
	include_once("server.php");
	$port = "10008";
	$host ="localhost";
	$server = new Server($host,$port);
        $server->server_up();
        print_r("SERVER DOWN\n");
?>
