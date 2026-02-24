<?php
require_once './../models/conect.model.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $conexion = conectar();

    $instructor = $_POST['instructor'];
    $ambiente   = $_POST['ambiente'];
    $hora       = $_POST['hora'];
    $fecha      = $_POST['fecha'];
    $ficha      = $_POST['ficha'];

    $stmt = $conexion->prepare("
    SELECT solId 
    FROM solicitud
    WHERE ambIdFk = $ambiente
    AND fecha = '$fecha'
    AND solEst = 1
    AND horIDFk = $hora
");


    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {

        echo json_encode([
            "success" => false,
            "message" => "El ambiente ya está ocupado en ese horario."
        ]);
        exit();
    }

    $id = 'S' . random_int(1000, 10000);
    $sql = "INSERT INTO solicitud (instIdFk, ambIdFk, horIDFk, fecha, solEst, solId, fichaCod)
            VALUES ($instructor, $ambiente, $hora, '$fecha', 0, '$id', $ficha)";

    if ($conexion->query($sql)) {
        echo json_encode([
            "success" => true,
            "message" => "Solicitud registrada correctamente"
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Error al registrar"
        ]);
    }
}
