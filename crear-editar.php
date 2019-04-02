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
	$coordinadores = $coordinador->listar();

	//sesion
	$rol = isset($_SESSION['rol']) ? $_SESSION['rol'] : null;

	$readonly = "readonly";

	if ($rol == 'admin') {
		$readonly = null;		
	}


	

	$registro = null;
	$accion = "INGRESO DE";
	$cedula = null;
	$aPaterno = null;
	$aMaterno = null;
	$nombres = null;
	$profesion = null;
	$telefono = null;
	$edad = null;
	$responsable = null;
	$idEl = null;

	if (isset($_GET) && array_key_exists('id', $_GET)) {
		$idEl = $_GET['id'];
		$registro = $controlador->buscar($idEl);
		$id = $registro['id'];
		$cedula = $registro['cedula'];
		$aPaterno = $registro['apellido_paterno'];
		$aMaterno = $registro['apellido_materno'];
		$nombres = $registro['nombres'];
		$profesion = $registro['profesion'];
		$telefono = $registro['telefono'];
		$edad = $registro['edad'];
		$responsable = $registro['responsable_id'];

		$accion = "EDICIÓN DE";
	}

	if (isset($_GET) && array_key_exists('existe', $_GET)) {
		if ($_GET['existe'] == 'yes') {
?>
		<script>
			alert("La persona ya ha sido ingresada");
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
		<form action="controller/procesar.php" method="POST">
			<div class="row">
					<h1 class="text-center col-12"><?php echo $accion; ?> GRUPO MARCELO ROBAYO</h1>
					<?php if ($idEl): ?>
					<input type="hidden" name="id" value="<?php echo $idEl; ?>">
					<?php endif ?>
					<div class="col-lg-4 col-md-4 col-sm-5 col-xs-6 form-group">
						<label for="cedula">Cédula</label>
						<input type="text" class="form-control" id="cedula" name="cedula" autofocus="" pattern="\d*" maxlength="10" value="<?php echo $cedula ?>" <?php echo $readonly ?>>
					</div>

					<div class="col-lg-4 col-md-4 col-sm-5 col-xs-6 form-group">
						<label for="apellido_paterno">Apellido Paterno</label>
						<input type="text" class="form-control" id="apellido_paterno" name="apellido_paterno" value="<?php echo $aPaterno; ?>" <?php echo $readonly ?>>
							
					</div>

					<div class="col-lg-4 col-md-4 col-sm-5 col-xs-6 form-group">
						<label for="apellido_materno">Apellido Materno</label>
						<input type="text" class="form-control" id="apellido_materno" name="apellido_materno" value="<?php echo $aMaterno; ?>" <?php echo $readonly ?>>
							
					</div>

					<div class="col-lg-4 col-md-4 col-sm-5 col-xs-6 form-group">
						<label for="nombres">Nombres</label>
						<input type="text" class="form-control" id="nombres" name="nombres" value="<?php echo $nombres; ?>" <?php echo $readonly ?>>
							
					</div>

					<div class="col-lg-4 col-md-4 col-sm-5 col-xs-6 form-group">
						<label for="profesion">Profesión</label>
						<input type="text" class="form-control" id="profesion" name="profesion" value="<?php echo $profesion ?>" <?php echo $readonly ?>>
					</div>

					<div class="col-lg-4 col-md-4 col-sm-5 col-xs-6 form-group">
						<label for="telefono">Teléfono</label>
						<input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $telefono; ?>" <?php echo $readonly ?>>
					</div>

					<div class="col-lg-4 col-md-4 col-sm-5 col-xs-6 form-group">
						<label for="edad">Responsable</label>
						<select class="form-control" id="responsable" name="responsable">
							<?php foreach ($coordinadores as $key => $value): ?>
								<option value="<?php echo $value['id'] ?>" <?php ($value['id'] == $responsable) ?> <?php ?> selected ><?php echo $value['apellido'] .' '.$value['nombre'] ?></option>
							<?php endforeach ?>
						</select>
						<!-- <input type="text"  value="<?php echo $responsable; ?>" <?php echo $readonly ?>> -->
					</div>
					
					<div class="col-lg-1 col-md-4 col-sm-5 col-xs-6 form-group">
						<label for="edad">Edad</label>
						<input type="text" class="form-control" id="edad" name="edad" value="<?php echo $edad; ?>" <?php echo $readonly ?>>
					</div>

			</div>
				<div class="col-12 text-center">
					<?php if ($rol == 'admin'): ?>
						<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
					<?php endif ?>
					<a href="index.php" class="btn btn-primary"><i class="fa fa-left"></i> Retornar</a>
				</div>
			</div>
			
		</form>
	</div>
</body>
</html>