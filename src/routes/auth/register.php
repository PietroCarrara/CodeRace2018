<?php

$router->post('/auth/register', function() {

	$data = json_decode($_POST['data']);

	$user = R::findOne('usuario', 'username = ?', [ $data->username ]);

	if ($user != NULL) {
		echo newError('Username already taken!');
		return;
	}

	$user = R::dispense('usuario');

	$user->username = $data->username;
	$user->password = password_hash($data->password, PASSWORD_DEFAULT);

	R::store($user);

	echo newSuccess($user);
});

?>
