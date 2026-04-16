<?php

class Coneccion
{
	public static ?PDO $instancia = null;

	public static function obtenerConexion(): PDO
	{
		if (self::$instancia instanceof PDO) {
			return self::$instancia;
		}

		$host = getenv('DB_HOST') ?: 'localhost';
		$port = getenv('DB_PORT') ?: '3307';
		$dbname = getenv('DB_NAME') ?: 'sistema_educativo';
		$user = getenv('DB_USER') ?: 'root';
		$pass = getenv('DB_PASS') ?: '';

		$dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4";

		self::$instancia = new PDO($dsn, $user, $pass, [
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		]);

		return self::$instancia;
	}
}