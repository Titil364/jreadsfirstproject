<?php
	//$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	
	//$a = json_decode($_POST["applications"]);
	//$q = json_decode($_POST["questions"]);
	//$ans = json_decode($_POST["answers"]);
	var_dump($_POST);
	var_dump($_GET);
	//var_dump($q);
	echo json_encode("Success");

?>