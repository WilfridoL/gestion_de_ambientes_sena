<?php
include __DIR__ . '/../models/conect.model.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conexion = conectar();
    $userEma = $_POST["userEmail"] ?? '';
    $userPass = $_POST["userPass"] ?? '';

    // ✅ Prepared statement - evita SQL Injection completamente
    $stmt = $conexion->prepare("
        SELECT * FROM usuarios
        WHERE usuCorr = ?
    ");

    $stmt->bind_param("s", $userEma);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $datos = $resultado->fetch_assoc();

        // ✅ Verificar contraseña con hash (seguro)
        // OPCIÓN A: Si ya tienes passwords hasheadas con password_hash()
        if (password_verify($userPass, $datos['password'])) {
            $_SESSION["usuario"] = $datos["usuCed"];
            $_SESSION["rol"] = $datos["usuAuth"];
            echo json_encode([
                "success" => true,
                "message" => "Bienvenido " . $datos['usuNoms']
            ]);
            exit();
        }
    }

    echo json_encode([
        "success" => false,
        "message" => "Error al iniciar sesión"
    ]);
    exit();
}