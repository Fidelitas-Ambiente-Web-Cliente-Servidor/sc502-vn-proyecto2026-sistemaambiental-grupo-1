<?php
require_once __DIR__ . '/../Coneccion.PHP';

class LoginAD
{
    public static function crearConexion(): PDO
    {
        return Coneccion::obtenerConexion();
    }

    public static function obtenerUsuarioPorUsername(string $username): ?array
    {
        $conexion = self::crearConexion();
        $sql = 'SELECT username, password_hash FROM eduambiente_usuarios WHERE username = :username LIMIT 1';
        $stmt = $conexion->prepare($sql);
        $stmt->execute(['username' => $username]);
        $fila = $stmt->fetch();

        if (!$fila) {
            return null;
        }

        return [
            'username' => (string) $fila['username'],
            'password_hash' => (string) $fila['password_hash'],
        ];
    }
}


