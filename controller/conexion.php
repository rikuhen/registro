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
			// 'username' => 'thejlmed',
			'username' => 'root',
			// 'password' => 'Jlvb5jorgeluis.',
			'password' => '',
			// 'db' => 'thejlmed_registro',
			'db' => 'registro',
		];

		return parent::__construct($parametros);
	}
}