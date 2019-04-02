<?php
	require_once $_SERVER["DOCUMENT_ROOT"].'/controller/coordinador.php';

	$controlador = new Coordinador();



if (isset($_GET['id'])) {
	
	$controlador->eliminar($_GET['id'])	;
	header("Location:coordinador.php");
	die();

}