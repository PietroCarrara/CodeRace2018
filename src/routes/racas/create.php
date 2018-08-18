<?php

$router->post('/raca/create', function() {

	$data = json_decode($_POST['data']);

	$raca = R::findOne('raca', 'nome = ?', [ $data->nome ]);

	if ($raca != NULL) {
		echo newError('Raça já existe!');
		return;
	}

	$raca = R::dispense('raca');
	$raca->nome = $data->nome;
	R::store($raca);
	echo newSuccess($raca);
});

?>

