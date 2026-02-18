<?php
header('Content-Type: application/json');
require_once './../models/conect.model.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = $_POST['id'] ?? null;

    $conexion = conectar();

    $sql = "UPDATE solicitud 
            SET solEst = 1
            WHERE solId = '$id'";

    if ($conexion->query($sql)) {
        echo json_encode([
            "success" => true,
            "message" => "Solicitud cancelada correctamente"
        ]);
    } else {
        echo json_encode([
            "success" => false
        ]);
    }

    exit;
}