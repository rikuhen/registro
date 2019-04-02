<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/lib/database/MysqliDb.php';

/**
 * 
 */
class Conexion extends MysqliDb
{
	
	
	function __construct()
	{
		$parametros = [
			'host' => 'localhost',
			'username' => 'root',
			'password' => '',
			'db' => 'registro',
		];

		return parent::__construct($parametros);
	}
}