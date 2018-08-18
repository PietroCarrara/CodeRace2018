<?php

$router->post('/animal/{id}/pesos/add', function($id) {

	$data = json_decode($_POST['data']);

	sessionInit($data);

	$animal = R::load('animal', $id);

	if ($animal->dono_id != $_SESSION['user']->id) {
		echo newError('This animal is not yours!');
		die();
	}

	$peso = newPeso($data->peso);

	$animal->ownPesoList[] = $peso;

	R::store($animal);

	echo newSuccess($peso);
});

?>

