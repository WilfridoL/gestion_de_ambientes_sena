<?php
require_once 'conect.model.php';
function obtener($sql)
{
  $conexion = conectar();
  $data = $sql;
  $resultado = $conexion->query($data);
  $consulta = [];
  if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
      $consulta[] = $fila;
    }
  }
  return $consulta;
}
