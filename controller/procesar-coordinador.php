<?php

$data = $_POST;

require_once $_SERVER["DOCUMENT_ROOT"].'/controller/coordinador.php';

$coordinador = new Coordinador();



if (isset($data['id']) && array_key_exists('id', $data)) {
	//editar
	
	$editar =  $coordinador->editar($data);
	header("Location:../coordinador.php?exito=yes");
	die();
} else {
	$cedula =  $coordinador->buscarCedula($data['cedula']);

	if ($cedula) {
		header("Location:../crear-editar-coordinador.php?existe=yes");
		die();
	} else {
		
		$exito  = $coordinador->guardar($data);

		if ($exito) {
			header("Location:../coordinador.php?exito=yes");
			die();
		} else {
			header("Location:../coordinador.php?exito=no");
			die();
		}
	}

}