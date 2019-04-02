<?php

$data = $_POST;

require_once $_SERVER["DOCUMENT_ROOT"].'/controller/controlador.php';

$controlador = new Controlador();



if (isset($data['id']) && array_key_exists('id', $data)) {
	//editar
	
	$editar =  $controlador->editar($data);
	header("Location:../index.php?exito=yes");
	die();
} else {
	$cedula =  $controlador->buscarCedula($data['cedula']);

	if ($cedula) {
		header("Location:../crear-editar.php?existe=yes");
		die();
	} else {
		
		$exito  = $controlador->guardar($data);

		if ($exito) {
			header("Location:../index.php?exito=yes");
			die();
		} else {
			header("Location:../index.php?exito=no");
			die();
		}
	}

}