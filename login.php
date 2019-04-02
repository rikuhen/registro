<?php 
	
	ob_start();
	session_start();

	require_once $_SERVER["DOCUMENT_ROOT"].'/controller/controlador.php';

	$sesion = new Controlador();	

	if ($sesion->existeSession()) {
		header("Location: index.php");
	}


	if (isset($_GET['error']) && $_GET['error'] == 'true') {
?>
	<script>
		alert("Datos Inválidos");
	</script>		
<?php	
	}
?>





<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Ingreso</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<style>
		
	.login-form {
		width: 340px;
    	margin: 50px auto;
	}
    .login-form form {
    	margin-bottom: 15px;
        background: #f7f7f7;
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        padding: 30px;
    }
    .login-form h2 {
        margin: 0 0 15px;
    }
    .form-control, .btn {
        min-height: 38px;
        border-radius: 2px;
    }
    .btn {        
        font-size: 15px;
        font-weight: bold;
    }

	</style>
</head>
<body>
	<div class="login-form">
    <form action="controller/procesar-login.php" method="post">
        <h2 class="text-center">Ingreso</h2>       
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Usuario" required="required" name="usuario" autofocus="">
        </div>
        <div class="form-group">
            <input type="password" class="form-control" placeholder="Clave" required="required" name="clave">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
        </div>
    </form>
</div>
</body>
</html>