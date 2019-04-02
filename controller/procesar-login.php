<?php 
	
	ob_start();
	session_start();
	
	if (isset($_POST['usuario']) &&  isset($_POST['clave']) ) {
		require_once $_SERVER["DOCUMENT_ROOT"].'/controller/controlador.php';
		
		$sesion = new Controlador();
		
		$usuario = $_POST['usuario'];
		$clave = $_POST['clave'];

		$login = $sesion->ingresarLogin($usuario, $clave);
		

		if ($login) {
			$_SESSION['usuario'] = $login['usuario'];
			$_SESSION['rol'] = $login['rol'];
			header("Location:../index.php");
		} else {
			header("Location: ../login.php?error=true");
		}
	}





 ?>