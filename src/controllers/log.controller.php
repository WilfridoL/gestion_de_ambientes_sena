<?php
include __DIR__ . '/../models/conect.model.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $conexion = conectar();
  $userEma = $_POST["userEmail"];
  $userPass = $_POST["userPass"];

  $sql = "
  SELECT * FROM usuarios
  WHERE usuCorr = '$userEma'
  AND password = '$userPass'";

  $resultado = $conexion->query($sql);
  if ($resultado->num_rows > 0) {
    $datos = $resultado->fetch_assoc();
    $_SESSION["usuario"] = $datos["usuCed"];
    $_SESSION["rol"] = $datos["usuAuth"];
    echo json_encode([
      "success" => true,
      "message" => "Bienvenido " . $datos['usuNoms']
    ]);
    exit();
  }
  echo json_encode([
    "success" => false,
    "message" => "Error al iniciar sesión"
  ]);
  exit();
}
