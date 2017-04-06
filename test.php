<?php
	//$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	
	$obj = json_decode($_GET["json"]);
	echo json_encode($obj->title . "Test");

?>