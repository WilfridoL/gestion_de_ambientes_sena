<?php
require_once __DIR__ . "/conect.model.php";

function totales()
{
    $conexion = conectar();
    $resultado = $conexion->query("SELECT 
        (SELECT COUNT(*) FROM solicitud) AS total, 
        (SELECT COUNT(*) FROM solicitud WHERE solEst = 1) AS aprobadas, 
        (SELECT COUNT(*) FROM solicitud WHERE solEst = 0) AS pendientes, 
        (SELECT COUNT(*) FROM solicitud WHERE solEst = 2) AS canceladas");

    $datos = $resultado->fetch_all(MYSQLI_ASSOC);
    $resultado->free(); // ✅ liberar resultado
    return $datos;
}

function totalesPorInstructor($usuarioId)
{
    $conexion = conectar();
    $stmt = $conexion->prepare("SELECT 
        COUNT(*) AS total, 
        SUM(solEst = 1) AS aprobadas, 
        SUM(solEst = 0) AS pendientes, 
        SUM(solEst = 2) AS canceladas
        FROM solicitud WHERE instIdFk = ?");

    $stmt->bind_param("s", $usuarioId);
    $stmt->execute();
    $datos = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $datos;
}

function actividad($sql, $params = [], $tipos = '')
{
    $conexion = conectar();

    if (!empty($params)) {
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param($tipos, ...$params);
        $stmt->execute();
        $datos = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
    } else {
        $resultado = $conexion->query($sql);
        $datos = $resultado->fetch_all(MYSQLI_ASSOC);
        $resultado->free();
    }

    return $datos;
}

function masUsados($usuarioId = null)
{
    $conexion = conectar();

    if ($usuarioId) {
        $stmt = $conexion->prepare("
            SELECT COUNT(*) AS total_usados, ambNom 
            FROM solicitud
            JOIN ambientes ON ambId = ambIdFk
            WHERE instIdFk = ?
            GROUP BY ambIdFk
            ORDER BY total_usados DESC
            LIMIT 3");
        $stmt->bind_param("s", $usuarioId);
        $stmt->execute();
        $datos = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        $stmt2 = $conexion->prepare("SELECT COUNT(*) AS fila FROM solicitud WHERE instIdFk = ?");
        $stmt2->bind_param("s", $usuarioId);
        $stmt2->execute();
        $datoFila = $stmt2->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt2->close();

    } else {
        $resultado = $conexion->query("
            SELECT COUNT(*) AS total_usados, ambNom 
            FROM solicitud
            JOIN ambientes ON ambId = ambIdFk
            GROUP BY ambIdFk
            ORDER BY total_usados DESC
            LIMIT 3");
        $datos = $resultado->fetch_all(MYSQLI_ASSOC);
        $resultado->free();

        $total = $conexion->query("SELECT COUNT(*) AS fila FROM solicitud");
        $datoFila = $total->fetch_all(MYSQLI_ASSOC);
        $total->free();
    }

    return [
        "datos"      => $datos,
        "totalFilas" => $datoFila
    ];
}