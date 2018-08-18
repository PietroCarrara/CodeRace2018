<?php

// Cria um animal
// {"nome":"pietro", "peso":700, "nasc":"2000-04-13","token":"2ukjbbn0hgbbcijq2fdl59rvv4"}
// {"id":"11","success":true}
$router->post('/animal/create', function() {

	$data = json_decode($_POST['data']);

	sessionInit($data);

	$animal = R::dispense('animal');

	// Mandatory
	$animal->dono = $_SESSION['user'];
	$animal->nome = $data->nome;
	$animal->nasc = new DateTime($data->nasc);
	$animal->raca = newRaca($data->raca->id);
	$animal->vivo = true;
	
	if (isset($data->peso)) $animal->ownPesoList[] = newPeso($data->peso);

	if (isset($data->vivo)) $animal->vivo = $data->vivo;

	if (isset($data->pai)) $animal->pai = R::load('animal', $data->pai);
	if (isset($data->mae)) $animal->mae = R::load('animal', $data->mae);

	if (isset($data->medicacoes)) $animal->ownMedicacaoList = newMedicacao($animal, $data->medicacoes);

	R::store($animal);

	echo newSuccess([ 'id' => $animal->id ]);
});

$router->post('/animal/update/{id}', function($id) {

	$data = json_decode($_POST['data']);

	sessionInit($data);

	$animal = R::load('animal', $id);

	if ($animal->dono_id != $_SESSION['user']->id) {
		echo newError('Esse animal não é seu!');
		return;
	}

	if (isset($animal->nome)) $animal->nome = $data->nome;
	if (isset($animal->nasc)) $animal->nasc = new DateTime($data->nasc);
	if (isset($animal->raca)) $animal->raca = newRaca($data->raca);
	
	if (isset($data->peso)) $animal->ownPesoList = newPeso($data->peso);

	if (isset($animal->vivo)) $animal->vivo = $data->vivo;

	if (isset($data->pai)) $animal->pai = R::load('animal', $data->pai);
	if (isset($data->mae)) $animal->mae = R::load('animal', $data->mae);

	if (isset($data->medicacoes)) $animal->ownMedicacaoList = newMedicacao($animal, $data->medicacoes);

	R::store($animal);

	echo newSuccess([ 'id' => $animal->id ]);
});

?>
