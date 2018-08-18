<?php

$router->post('/auth/login', function() {

	$data = json_decode($_POST['data']);

	$user = R::findOne('usuario', 'username = ?', [ $data->username ]);

	if ($user != NULL) {

		if (password_verify($data->password, $user->password)) {
			@session_start();
			$_SESSION['user'] = $user;
			$id = session_id();
			echo newSuccess([ 'token' => $id ]);

		} else {
			echo newError('Wrong password!');
		}
	} else {
		echo newError('User not found!');
	}
});

?>
