<?php

$router->post('/remedio/create', function() {

	$data = json_decode($_POST['data']);

	sessionInit($data);

	$res = R::dispense('remedio');

	if (R::findOne('remedio', 'nome = ?', [ $data->nome ]) != NULL) {
		echo newError('Nome já tomado!');
		return;
	}

	$res->dono = $_SESSION['user'];
	$res->nome = $data->nome;
	$res->descricao = $data->descricao;

	if (isset($data->validade)) $res->validade = new DateTime($data->validade);

	if (isset($data->quantidade)) $res->quantidade = $data->quantidade;

	R::store($res);
	echo newSuccess($res);
});

?>
