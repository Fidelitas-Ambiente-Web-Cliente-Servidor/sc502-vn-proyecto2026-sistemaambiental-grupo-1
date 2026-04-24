<?php
require_once __DIR__ . '/../Coneccion.php';
    
class RegistroAD
{
    public static function crearConexion(): PDO
    {
        return Coneccion::obtenerConexion();
    }

    public static function existeUsuarioPorUsername(string $username): bool
    {
        $conexion = self::crearConexion();
        $sql = 'SELECT username FROM eduambiente_usuarios WHERE username = :username LIMIT 1';
        $stmt = $conexion->prepare($sql);
        $stmt->execute(['username' => $username]);

        return (bool) $stmt->fetch();
    }

    public static function registrarUsuario(string $username, string $passwordHash): bool
    {
        $conexion = self::crearConexion();
        $sql = 'INSERT INTO eduambiente_usuarios (username, password_hash) VALUES (:username, :password_hash)';
        $stmt = $conexion->prepare($sql);

        return $stmt->execute([
            'username' => $username,
            'password_hash' => $passwordHash,
        ]);
    }
}
