<?php

// Cria um animal
// {"nome":"pietro", "peso":700, "nasc":"2000-04-13","token":"2ukjbbn0hgbbcijq2fdl59rvv4"}
// {"id":"11","success":true}
$router->post('/animal/create', function() {

	$data = json_decode($_POST['data']);

	sessionInit($data);

	$animal = R::dispense('animal');

	$animal->dono = $_SESSION['user'];
	$animal->nome = $data->nome;
	$animal->nasc = new DateTime($data->nasc);
	$animal->ownPesoList[] = newPeso($data->peso);

	R::store($animal);

	echo newSuccess([ 'id' => $animal->id ]);
});

?>
