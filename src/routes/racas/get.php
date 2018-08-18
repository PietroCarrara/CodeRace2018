<?php

$router->post('/raca/get/{id}', function($id) {

	$raca = R::load('raca', $id);

	if ($raca->id == 0) {
		echo newError('Raca not found!');
		die();
	}

	echo newSuccess($raca);
});

?>
