<?php
require_once __DIR__ . '/../../PHPAccesoDatos/ParteSantiAD/RegistroAD.PHP';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	http_response_code(405);
	echo json_encode(['response' => '01', 'message' => 'Metodo no permitido.']);
	exit;
}

$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? (string) $_POST['password'] : '';

if ($username === '' || $password === '') {
	http_response_code(400);
	echo json_encode(['response' => '01', 'message' => 'Faltan datos: username y password son obligatorios.']);
	exit;
}

try {
	$usuarioExistente = RegistroAD::existeUsuarioPorUsername($username);
} catch (PDOException $e) {
	http_response_code(503);
	echo json_encode(['response' => '01', 'message' => 'No se pudo conectar a la base de datos.']);
	exit;
}


if ($usuarioExistente) {
	http_response_code(409);
	echo json_encode(['response' => '01', 'message' => 'El username ya existe. Elige otro distinto.']);
	exit;
}
$passwordHash = password_hash($password, PASSWORD_DEFAULT);

try {
	$registrado = RegistroAD::registrarUsuario($username, $passwordHash);
} catch (PDOException $e) {
	if ($e->getCode() === '23000') {
		http_response_code(409);
		echo json_encode(['response' => '01', 'message' => 'El username ya existe. Elige otro distinto.']);
		exit;
	}

	http_response_code(500);
	echo json_encode(['response' => '01', 'message' => 'No se pudo registrar el usuario.']);
	exit;
}

if (!$registrado) {
	http_response_code(500);
	echo json_encode(['response' => '01', 'message' => 'No se pudo registrar el usuario.']);
	exit;
}

http_response_code(201);
echo json_encode(['response' => '00', 'message' => 'Usuario registrado correctamente.']);

