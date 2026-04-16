<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	http_response_code(405);
	echo 'Metodo no permitido. Usa POST.';
	exit;
}

$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? (string) $_POST['password'] : '';

if ($username === '' || $password === '') {
	http_response_code(400);
	echo 'Faltan datos: username y password son obligatorios.';
	exit;
}

function crearConexion(): PDO
{
	$host = getenv('DB_HOST') ?: 'localhost';
	$port = getenv('DB_PORT') ?: '3306';
	$dbname = getenv('DB_NAME') ?: 'eduambiente';
	$user = getenv('DB_USER') ?: 'root';
	$pass = getenv('DB_PASS') ?: '';

	$dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4";

	return new PDO($dsn, $user, $pass, [
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	]);
}

function obtenerUsuarioPorUsername(PDO $pdo, string $username): ?string
{
	$sql = 'SELECT username FROM usuarios WHERE username = :username LIMIT 1';
	$stmt = $pdo->prepare($sql);
	$stmt->execute(['username' => $username]);
	$fila = $stmt->fetch();

	return $fila ? (string) $fila['username'] : null;
}

try {
	$conexion = crearConexion();
	$someOne = obtenerUsuarioPorUsername($conexion, $username);
} catch (PDOException $e) {
	http_response_code(503);
	echo 'No se pudo conectar a la base de datos. Configura DB_HOST, DB_PORT, DB_NAME, DB_USER y DB_PASS.';
	exit;
}

$me = $username;

if ($someOne === null || $someOne !== $me) {
	http_response_code(401);
	echo 'Usuario no encontrado.';
	exit;
}

echo 'Usuario encontrado en base de datos. Login puede continuar.';

