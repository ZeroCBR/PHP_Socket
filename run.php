<?php
	include_once("server.php");
	$port = "10008";
	$host ="192.168.1.107";
	$server = new Server($host,$port);
        $server->server_up();
        print_r("SERVER DOWN\n");
?>
