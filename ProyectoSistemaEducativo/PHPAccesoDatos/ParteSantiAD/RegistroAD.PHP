<?php
    
class RegistroAD
{
	public static function crearConexion(): PDO
	{
		$host = getenv('DB_HOST') ?: 'localhost';
		$port = getenv('DB_PORT') ?: '3307';
		$dbname = getenv('DB_NAME') ?: 'sistema_educativo';
		$user = getenv('DB_USER') ?: 'root';
		$pass = getenv('DB_PASS') ?: '';

		$dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4";

		return new PDO($dsn, $user, $pass, [
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		]);
	}

	public static function existeUsuarioPorUsername(string $username): bool
	{
		$conexion = self::crearConexion();
		$sql = 'SELECT username FROM usuarios WHERE username = :username LIMIT 1';
		$stmt = $conexion->prepare($sql);
		$stmt->execute(['username' => $username]);

		return $stmt->fetch() !== false;
	}
}
