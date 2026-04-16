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

echo 'Datos recibidos correctamente.<br>';
echo 'Username: ' . htmlspecialchars($username, ENT_QUOTES, 'UTF-8') . '<br>';
echo 'Password: ' . htmlspecialchars($password, ENT_QUOTES, 'UTF-8');