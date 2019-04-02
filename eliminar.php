<?php
	require_once $_SERVER["DOCUMENT_ROOT"].'/controller/controlador.php';

	$controlador = new Controlador();



if (isset($_GET['id'])) {
	
	$controlador->eliminar($_GET['id'])	;
	header("Location:index.php");
	die();

}