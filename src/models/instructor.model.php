<?php
require_once 'conect.model.php';
function obtenerInstructores()
{
  $conexion = conectar();
  $sql = "SELECT usuCed, CONCAT_WS(' ', usuNoms, usuApes) AS nombre FROM `usuarios`
  WHERE usuAuth = 2";
  $resultado = $conexion->query($sql);
  $consulta = [];
  if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
      $consulta[] = $fila;
    }
  }
  return $consulta;
}