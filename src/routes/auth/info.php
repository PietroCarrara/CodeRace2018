<?php

$router->post('/auth/info', function() {

	$data = json_decode($_POST['data']);
	
	sessionInit($data);

	echo newSuccess($_SESSION['user']);
});

?>
