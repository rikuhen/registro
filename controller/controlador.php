<?php

require_once $_SERVER["DOCUMENT_ROOT"].'/controller/conexion.php';

/**
 * 
 */
class Controlador 
{
	
	private $con;

	function __construct()
	{
		$this->con = new Conexion();
	}


	public function listar()
	{
		$datos = $this->con->rawQuery('SELECT * FROM registro order by id');
		return $datos;
	}


	public function buscar($id)
	{
	
		$existe = $this->con->rawQueryOne("SELECT * FROM registro where id = ?",[$id]);
		return $existe;
	}


	public function buscarCedula($cedula)
	{
		$existe = $this->con->rawQueryOne("SELECT cedula FROM registro where cedula = ?",[$cedula]);
		return $existe;
	}


	public function guardar($data)
	{
		$this->con->rawQuery("INSERT INTO registro 
				(cedula,apellido_paterno,apellido_materno,nombres,profesion,telefono,edad,responsable) 
				values (?,?,?,?,?,?,?,?)
			",[
				$data['cedula'],
				$data['apellido_paterno'],
				$data['apellido_materno'],
				$data['nombres'],
				$data['profesion'],
				$data['telefono'],
				$data['edad'],	
				$data['responsable'],	
			]);
		$this->con->commit();

		$existe = $this->con->rawQueryOne("SELECT cedula FROM registro where cedula = ?",[$data['cedula']]);

		if (count($existe)) {
			return true;
		}
		return false;

	}


	public function eliminar($id)
	{
		$this->con->rawQuery("DELETE from registro where id = ?",[$id]);
		$this->con->commit();
		return true;

	}

	public function editar($data)
	{
		$this->con->rawQuery("UPDATE registro 
				SET cedula = ?,apellido_paterno = ?  ,apellido_materno = ?,nombres = ?,profesion =? ,telefono = ?,edad = ?, responsable = ? WHERE id = ? 
			",[
				$data['cedula'],
				$data['apellido_paterno'],
				$data['apellido_materno'],
				$data['nombres'],
				$data['profesion'],
				$data['telefono'],
				$data['edad']	,
				$data['responsable']	,
				$data['id']	,
			]);
		$this->con->commit();
		return true;
	}


	public function ingresarLogin($usuario, $clave)
	{
		$usuario = $this->con->rawQueryOne("SELECT * FROM usuario where usuario = ? and clave = ?",[$usuario, $clave]);

		if ($usuario) {
			return $usuario;
		}
		return false;
	}


	public function existeSession()
	{
		if (isset($_SESSION['usuario'])) {
			return true;
		} else {
			return false;
		}
	}


	public function salir()
	{
		unset($_SESSION['usuario']);
		unset($_SESSION['rol']);
		session_destroy();
		return true;
	}
	
}