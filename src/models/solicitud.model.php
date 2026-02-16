<?php
require_once 'conect.model.php';
function obtenerSolicitudes()
{
    $conexion = conectar();
    $sql = "SELECT solId,  CONCAT_WS(' ', i.`usuNoms`, i.`usuApes`) AS 'instNom',
a.`ambNom`, fecha, horNom, fichaCod , est.`estNom`  FROM solicitud s
    JOIN horarios h ON s.`horIDFk` = h.`horId`
    JOIN usuarios i ON i.`usuCed` = s.`instIdFk`
    JOIN ambientes a ON a.`ambId` = s.`ambIdFk`
    JOIN estados est ON est.`idEst` = s.`solEst`";
    $resultado = $conexion->query($sql);
    $solicitudes = [];
    if ($resultado->num_rows > 0) {
        while ($fila = $resultado->fetch_assoc()) {
            $solicitudes[] = $fila;
        }
    }
    return $solicitudes;
}
