<?php

class Coneccion
{
    public static ?PDO $instancia = null;

    public static function obtenerConexion(): PDO
    {
        if (self::$instancia instanceof PDO) {
            return self::$instancia;
        }

    
        $host = getenv('DB_HOST') ?: 'db';
        $port = getenv('DB_PORT') ?: '3306'; 
        $dbname = getenv('DB_NAME') ?: 'appdb';
        $user = getenv('DB_USER') ?: 'appuser';
        $pass = getenv('DB_PASS') ?: 'apppass';

        $dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4";

        self::$instancia = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);

        return self::$instancia;
    }
}
