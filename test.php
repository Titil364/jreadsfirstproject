<?php
	//$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	
	$a = json_decode($_GET["applications"]);
	$q = json_decode($_GET["questions"]);
	echo json_encode("Reponse : \n Title : " . $a->title . "\n Q1 Label : " . $q[0]->label);

?>