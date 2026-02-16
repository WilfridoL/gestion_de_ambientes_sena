<?php
require_once 'conect.model.php';
function obtenerHorario()
{
  $conexion = conectar();
  $sql = "SELECT horid, horNom FROM horarios";
  $resultado = $conexion->query($sql);
  $consulta = [];
  if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
      $consulta[] = $fila;
    }
  }
  return $consulta;
}
