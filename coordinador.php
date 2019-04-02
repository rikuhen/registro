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
	$listado = $coordinador->listar();

	if (isset($_GET['exito'])) {
		
		if ($_GET['exito'] == 'yes') {
			
?>
	<script> alert("Registro Guardado Correctamente"); </script>
<?php 		
	} else {
?>
		<script>
			alert("NO SE HA GUARDADO EL REGISTRO");
		</script>
<?php
		}

	}
 ?>

 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8">
 	<title>Coordinadores</title>
 	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
 </head>
 <body>
 	<div class="container p-3">
 		<div class="row">
 			<div class="table-responsive">
				<h1 class="text-center col-12">GRUPO MARCELO ROBAYO</h1>
				<h2 class="text-center col-12">Coordinadores</h2>
				<?php if ($_SESSION['rol'] == 'admin'): ?> 
					<ul>
						<li><a href="index.php">Registro</a></li>
					</ul>
				<?php endif ?>
				<h5 class="text-center">Hola <b><?php echo strtoupper($_SESSION['usuario']); ?></b>	</h5>
				<div class="col-12 text-right">
					<?php if ($_SESSION['rol'] == 'admin'): ?>
						<a href="crear-editar-coordinador.php" class="btn btn-primary"><i class="fa fa-plus"></i> Crear</a>
					<?php endif ?>
						<a href="salir.php" class="btn btn-default"><i class="fa fa-sign-out"></i> Salir</a>
				</div>
				<div class="col-12 m-3">
					<table class="table">
						<thead>
							<tr>
								<th>Registro</th>
								<th>Cédula</th>
								<th>Apellido</th>
								<th>Nombre</th>
								<th>Ocupación</th>
								<th>Acción</th>
							</tr>
						</thead>
						<tbody>
							<?php if (is_array($listado) && count($listado) > 0): ?>
								<?php foreach ($listado as $key => $valor): ?>
								<tr>
									<td><?php echo ($key + 1) ?></td>
									<td><?php echo $valor['cedula'] ?></td>
									<td><?php echo $valor['apellido'] ?></td>
									<td><?php echo $valor['nombre'] ?></td>
									<td><?php echo $valor['ocupacion'] ?></td>
									<td>
										<?php if ($_SESSION['rol'] == 'admin'): ?>
											<a class="btn btn-warning btn-sm" href="crear-editar-coordinador.php?id=<?php echo $valor['id'] ?>"><i class="fa fa-edit"></i> Editar</a>
											<a class="btn btn-danger btn-sm delete" data-key="<?php echo $valor['id'] ?>"><i class="fa fa-remove"></i> Eliminar</a>
										<?php else: ?>
											<a class="btn btn-default btn-sm" href="crear-editar-coordinador.php?id=<?php echo $valor['id'] ?>"><i class="fa fa-eye"></i> Ver</a>
										<?php endif; ?>
									</td>
								</tr>
								<?php endforeach ?>
							<?php else: ?>
								<tr>
									<td colspan="6" class="text-center"><p class="text-secondary">No existen datos</p></td>
								</tr>
							<?php endif ?>
						</tbody>
					</table>
				</div>
			</div>
 		</div>
 	</div>
 	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/app.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('.delete').on('click', function(event) {
				event.preventDefault();
				
				var btn = $(event.currentTarget);
				var confir = confirm("Está seguro? ");

				if(confir) {
					window.location.href = "eliminar-coordinador.php?id="+btn.data('key');
				}
			});
		});
	</script>
 </body>
 </html>