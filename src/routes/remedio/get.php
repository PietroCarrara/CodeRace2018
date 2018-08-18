<?php

$router->post('/remedio/list', function() {
	
	$data = json_decode($_POST['data']);

	sessionInit($data);

	$remedio = R::find('remedio', 'dono_id = ?', [ $_SESSION['user']->id ]);

	echo newSuccess($remedio);
});

$router->post('/remedio/{id}', function($id) {
	
	$data = json_decode($_POST['data']);

	sessionInit($data);

	$remedio = R::load('remedio', $id);

	if ($remedio->id == 0) {
		echo newError('Remédio não existe!');
		return;
	}

	if ($remedio->dono_id != $_SESSION['user']->id) {
		echo newError('Este remédio não é seu!');
		return;
	}

	echo newSuccess($remedio);
});

?>
