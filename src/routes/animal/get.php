<?php

// Pega as informações de um dado animal
// {"nome":"pietro","nasc":"2000-04-13 00:00:00","pesos":{"14":{"id":"14","peso":"700","animal_id":"11"}}}
$router->post('/animal/list', function() {

	$data = json_decode($_POST['data']);

	sessionInit($data);

	$animais = R::find('animal', 'dono_id = ?', [ $_SESSION['user']->id ]);

	$res = [];

	foreach($animais as $animal) {

		$an = [];

		$an['nome'] = $animal->nome;
		$an['nasc'] = $animal->nasc;
		$an['raca'] = $animal->raca;
		$an['tipo'] = $animal->tipo;

		$an['pesos'] = $animal->ownPesoList;

		$an['medicacoes'] = $animal->ownMedicacaoList;

		if (isset($animal->pai)) $an['pai'] = $animal->pai->id;
		if (isset($animal->mae)) $an['mae'] = $animal->mae->id;

		$res[] = $an;
	}

	echo newSuccess( [ 'list' => $res ]);
});

$router->post('/animal/{id}', function($id) {

	$data = json_decode($_POST['data']);

	sessionInit($data);

	$animal = R::load('animal', $id);

	if ($animal->id == 0) {
		echo newError('Animal not found!');
		die();
	}

	if ($animal->dono_id != $_SESSION['user']->id) {
		echo newError('This animal is not yours!');
		die();
	}

	$res['nome'] = $animal->nome;
	$res['nasc'] = $animal->nasc;
	$res['raca'] = $animal->raca;
	$res['tipo'] = $animal->tipo;

	$res['pesos'] = $animal->ownPesoList;

	$res['medicacoes'] = $animal->ownMedicacaoList;

	if (isset($animal->pai)) $res['pai'] = $animal->pai->id;
	if (isset($animal->mae)) $res['mae'] = $animal->mae->id;

	echo newSuccess($res);
});

?>
