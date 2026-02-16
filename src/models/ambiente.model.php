<?php
require_once 'conect.model.php';
function obtenerAmbiente()
{
  $conexion = conectar();
  $sql = "SELECT ambid, ambNom FROM ambientes";
  $resultado = $conexion->query($sql);
  $consulta = [];
  if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
      $consulta[] = $fila;
    }
  }
  return $consulta;
}
