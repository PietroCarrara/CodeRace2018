<?php

function newSuccess($data = []) {

	$suc = $data;

	$suc['success'] = true;

	return json_encode($suc);
}

?>
