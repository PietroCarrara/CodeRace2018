<?php

function newError($desc) {

	$err = [];

	$err['error'] = $desc;
	$err['success'] = false;

	return json_encode($err);
}

?>
