<?php
	//$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	
	$a = json_decode($_GET["applications"]);
	$q = json_decode($_GET["questions"]);
	$ans = json_decode($_GET["answers"]);
//	echo $q . "<br>";
//	echo $a;
	echo json_encode("Success");

?>