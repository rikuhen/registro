<?php
	
	ob_start();
	session_start();

	require_once $_SERVER["DOCUMENT_ROOT"].'/controller/controlador.php';
	require_once $_SERVER["DOCUMENT_ROOT"].'/controller/coordinador.php';

	$controlador = new Controlador();

	$haySesion = $controlador->existeSession();

	if (!$haySesion) {
		header("Location: login.php");
	}

	$coordinador = new Coordinador();

	//sesion
	$rol = isset($_SESSION['rol']) ? $_SESSION['rol'] : null;

	$readonly = "readonly";

	if ($rol == 'admin') {
		$readonly = null;		
	}


	

	$registro = null;
	$accion = "INGRESO DE";
	$cedula = null;
	$apellido = null;
	$nombre = null;
	$ocupacion = null;
	$idEl = null;

	if (isset($_GET) && array_key_exists('id', $_GET)) {
		$idEl = $_GET['id'];
		$registro = $coordinador->buscar($idEl);
		$cedula = $registro['cedula'];
		$apellido = $registro['apellido'];
		$nombre = $registro['nombre'];
		$ocupacion = $registro['ocupacion'];

		$accion = "EDICIÓN DE";
	}

	if (isset($_GET) && array_key_exists('existe', $_GET)) {
		if ($_GET['existe'] == 'yes') {
?>
		<script>
			alert("El Coordinador ya ha sido ingresada");
		</script>
<?php
		}
	}
?>


<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Suscripción</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<!-- <link rel="stylesheet" href="css/style.css"> -->
</head>
<body>
	<div class="container p-3">
		<form action="controller/procesar-coordinador.php" method="POST">
			<div class="row">
					<h1 class="text-center col-12"><?php echo $accion; ?> COORDINADORES DEL GRUPO MARCELO ROBAYO</h1>
					<?php if ($idEl): ?>
					<input type="hidden" name="id" value="<?php echo $idEl; ?>">
					<?php endif ?>
					<div class="col-lg-4 col-md-4 col-sm-5 col-xs-6 form-group">
						<label for="cedula">Cédula</label>
						<input type="text" class="form-control" id="cedula" name="cedula" autofocus="" pattern="\d*" maxlength="10" value="<?php echo $cedula ?>" <?php echo $readonly ?>>
					</div>

					<div class="col-lg-4 col-md-4 col-sm-5 col-xs-6 form-group">
						<label for="apellido">Apellidos</label>
						<input type="text" class="form-control" id="apellido" name="apellido" value="<?php echo $apellido; ?>" <?php echo $readonly ?>>
							
					</div>

					<div class="col-lg-4 col-md-4 col-sm-5 col-xs-6 form-group">
						<label for="nombre">Nombres</label>
						<input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $nombre; ?>" <?php echo $readonly ?>>
							
					</div>

					<div class="col-lg-4 col-md-4 col-sm-5 col-xs-6 form-group">
						<label for="ocupacion">Profesión</label>
						<input type="text" class="form-control" id="ocupacion" name="ocupacion" value="<?php echo $ocupacion ?>" <?php echo $readonly ?>>
					</div>

			</div>
				<div class="col-12 text-center">
					<?php if ($rol == 'admin'): ?>
						<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
					<?php endif ?>
					<a href="coordinador.php" class="btn btn-primary"><i class="fa fa-left"></i> Retornar</a>
				</div>
			</div>
			
		</form>
	</div>
</body>
</html>