<?php
require_once __DIR__ . "/conect.model.php";

function totales()
{
  $conexion = conectar();
  $sql = "SELECT 
(SELECT COUNT(*) FROM solicitud) AS total, 
(SELECT COUNT(*) FROM solicitud
WHERE solEst = 1) AS aprobadas, 
(SELECT COUNT(*) FROM solicitud
WHERE solEst = 0) AS pendientes, 
(SELECT COUNT(*) FROM solicitud
WHERE solEst = 2) AS canceladas ";
  $resultado = $conexion->query($sql);

  $datos = [];

  while ($fila = $resultado->fetch_assoc()) {
    $datos[] = $fila;
  }

  return $datos;
}


function actividad($sql)
{
  $conexion = conectar();
  $resultado = $conexion->query($sql);

  $datos = [];

  while ($fila = $resultado->fetch_assoc()) {
    $datos[] = $fila;
  }

  return $datos;
}


function masUsados () {
  $conexion = conectar();
  $sql = "
  SELECT COUNT(*) AS total_usados, ambNom FROM solicitud
  JOIN ambientes ON ambId = ambIdFk
  GROUP BY ambIdFk
  ORDER BY total_usados DESC
  LIMIT 3";
  $totalFilas = "SELECT COUNT(*) as fila FROM solicitud";
  $total = $conexion->query($totalFilas);

  $resultado = $conexion->query($sql);

  $datos = [];
  $datoFila = [];

  while ($fila = $resultado->fetch_assoc()) {
    $datos[] = $fila;
  }
  while ($fila = $total->fetch_assoc()) {
    $datoFila[] = $fila;
  }


  return [
    "datos" => $datos,
    "totalFilas" => $datoFila
  ];
}