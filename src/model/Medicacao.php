<?php

function newMedicacao($animal, $meds) {

	$res = [];

	foreach ($meds as $med) {
		$med = R::dispense('medicacao');

		$med->animal = $animal;
		$med->remedio = R::load('remedio', $med->id);

		$med->dia = new DateTime($med->date);

		$res[] = $med;
	}

	return $res;
}

?>

