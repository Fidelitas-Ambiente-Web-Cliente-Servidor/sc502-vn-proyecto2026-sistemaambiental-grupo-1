<?php
require_once __DIR__ . '/../../PHPAccesoDatos/ParteSantiAD/LoginAD.PHP';

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
	$usuario = LoginAD::obtenerUsuarioPorUsername($username);
} catch (PDOException $e) {
	http_response_code(503);
	echo json_encode(['response' => '01', 'message' => 'No se pudo conectar a la base de datos.']);
	exit;
}

if ($usuario === null) {
	http_response_code(404);
	echo json_encode(['response' => '01', 'message' => 'Usuario no encontrado.']);
	exit;
}

if (!password_verify($password, $usuario['password_hash'])) {
	http_response_code(401);
	echo json_encode(['response' => '01', 'message' => 'Contrasena incorrecta.']);
	exit;
}

http_response_code(200);
$redirectUrl = '../../HTML/index.html';
$esAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH'])
	&& strtolower((string) $_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

if ($esAjax) {
	echo json_encode([
		'response' => '00',
		'message' => 'Login exitoso.',
		'redirect' => $redirectUrl
	]);
	exit;
}

header('Location: ' . $redirectUrl);
exit;