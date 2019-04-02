<?php

require_once $_SERVER["DOCUMENT_ROOT"].'/controller/conexion.php';

/**
 * 
 */
class Coordinador 
{
	
	public $con;

	function __construct()
	{
		$this->con = new Conexion();
	}

	public function listar()
	{
		$datos = $this->con->rawQuery('SELECT * FROM coordinador order by apellido, nombre, id');
		return $datos;
	}

	public function buscar($id)
	{
	
		$existe = $this->con->rawQueryOne("SELECT * FROM coordinador where id = ?",[$id]);
		return $existe;
	}

	public function buscarCedula($cedula)
	{
		$existe = $this->con->rawQueryOne("SELECT cedula FROM coordinador where cedula = ?",[$cedula]);
		return $existe;
	}

	public function guardar($data)
	{
		$this->con->rawQuery("INSERT INTO coordinador
				(cedula,nombre,apellido,ocupacion) 
				values (?,?,?,?)
			",[
				$data['cedula'],
				$data['nombre'],
				$data['apellido'],
				$data['ocupacion'],	
			]);
		$this->con->commit();

		$existe = $this->con->rawQueryOne("SELECT cedula FROM coordinador where cedula = ?",[$data['cedula']]);

		if (count($existe)) {
			return true;
		}
		return false;

	}

	public function eliminar($id)
	{
		$this->con->rawQuery("DELETE from coordinador where id = ?",[$id]);
		$this->con->commit();
		return true;

	}

	public function editar($data)
	{
		$this->con->rawQuery("UPDATE coordinador SET cedula = ? ,nombre = ? ,apellido = ?,  ocupacion = ? WHERE id = ? ",[
				$data['cedula'],
				$data['nombre'],
				$data['apellido'],
				$data['ocupacion'],	
				$data['id'],	
			]);
		$this->con->commit();

		$existe = $this->con->rawQueryOne("SELECT cedula FROM coordinador where cedula = ?",[$data['cedula']]);

		if (count($existe)) {
			return true;
		}
		return false;

	}
}