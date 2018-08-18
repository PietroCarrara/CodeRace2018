<?php

// Inicia a sessão por token
function sessionInit($data) {

	if (!isset($data->token)) {
		echo newError('No login provided!');
		die();
	}

	session_id($data->token);

	if (!isset($_SESSION['user'])) {
		echo newError('Invalid login provided!');
		die();
	}
}

?>
