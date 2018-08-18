<?php

$router->post('/auth/logout', function() {

	$data = json_decode($_POST['data']);
	
	sessionInit($data);

	session_destroy();

	echo newSuccess();
});

?>
