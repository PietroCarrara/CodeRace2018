<?php

function newError($desc) {

	$err = [];

	$err['error'] = $desc;

	return json_encode($err);
}

?>
