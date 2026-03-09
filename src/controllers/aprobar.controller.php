<?php
header('Content-Type: application/json');
require_once './../models/conect.model.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = $_POST['id'] ?? null;

    if (!$id || empty(trim($id))) {
        echo json_encode(["success" => false, "message" => "ID inválido"]);
        exit;
    }

    $conexion = conectar();
    $conexion->begin_transaction();

    try {
        // ✅ "s" en vez de "i" porque el ID es varchar (ej: S2635)
        $stmt = $conexion->prepare("UPDATE solicitud SET solEst = 1 WHERE solId = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();

        // ✅ Igual en el procedure
        $stmt2 = $conexion->prepare("CALL cancelar_solicitudes_duplicadas(?)");
        $stmt2->bind_param("s", $id);
        $stmt2->execute();

        $conexion->commit();

        echo json_encode([
            "success" => true,
            "message" => "Solicitud aprobada correctamente"
        ]);

    } catch (Exception $e) {
        $conexion->rollback();
        echo json_encode([
            "success" => false,
            "message" => "Error al aprobar la solicitud: " . $e->getMessage()
        ]);
    }

    exit;
}