<?php

function conectar()
{
    require_once __DIR__ . '/../../env.php';
    $LOCALHOST = $_ENV["DB_HOST"] ?? getenv("MYSQLHOST");
    $USERNAME = $_ENV["DB_USER"] ?? getenv("MYSQLUSER");
    $PASSWORD = $_ENV["DB_PASS"] ?? getenv("MYSQLPASSWORD");
    $DATABASE = $_ENV["DB_NAME"] ?? getenv("MYSQLDATABASE");
    $PORT = $_ENV["DB_PORT"] ?? getenv("MYSQLPORT");
    $conexion = new mysqli($LOCALHOST, $USERNAME, $PASSWORD, $DATABASE, $PORT);
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }
    return $conexion;
}
