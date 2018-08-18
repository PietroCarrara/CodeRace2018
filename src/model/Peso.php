<?php

function newPeso($peso) {

	if (is_array($peso)) {

		$obj = [];

		foreach($peso as $p) {
			$tmp = R::dispense('peso');
			$tmp->peso = $p;

			$obj[] = $tmp;
		}

	} else {
		$obj = R::dispense('peso');

		$obj->peso = $peso;
	}

	return $obj;
}

?>
