<?php

function conectar()
{
    $LOCALHOST = 'localhost';
    $USERNAME = 'root';
    $PASSWORD = '';
    $DATABASE = 'senaphpProyecto';
    $conexion = new mysqli($LOCALHOST, $USERNAME, $PASSWORD, $DATABASE);
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }
    return $conexion;
}
