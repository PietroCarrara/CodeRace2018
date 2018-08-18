<?php

function newPeso($peso) {
	$obj = R::dispense('peso');

	$obj->peso = $peso;

	return $obj;
}

?>
