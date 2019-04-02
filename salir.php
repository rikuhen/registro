<?php

	ob_start();
	session_start();

	require_once $_SERVER["DOCUMENT_ROOT"].'/controller/controlador.php';

	$sesion = new Controlador();	


	$sesion->salir();

	header('Location:login.php');
	die();