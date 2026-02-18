<?php
header('Content-Type: application/json');
error_reporting(0);
ini_set('display_errors', 0);

require_once './../models/conect.model.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $conexion = conectar();

    $accion = $_POST['accion'] ?? '';
    $tabla  = $_POST['tabla'] ?? '';
    $idCampo = $_POST['idCampo'] ?? 'id'; // nombre del campo PK
    $idValor = $_POST['idValor'] ?? null;

    if (!$tabla) {
        responder(false, "Tabla no especificada");
    }

    switch ($accion) {

        /* =========================
           REGISTRAR
        ==========================*/
        case 'registrar':

            $campos = [];
            $valores = [];
            $tipos = '';
            $datos = [];

            foreach ($_POST as $key => $value) {

                if (in_array($key, ['accion', 'tabla', 'idCampo', 'idValor'])) {
                    continue;
                }

                $campos[] = $key;
                $valores[] = '?';
                $tipos .= detectarTipo($value);
                $datos[] = $value;
            }

            $sql = "INSERT INTO $tabla (" . implode(',', $campos) . ")
                    VALUES (" . implode(',', $valores) . ")";

            $stmt = $conexion->prepare($sql);

            if (!$stmt) {
                responder(false, $conexion->error);
            }
            $stmt->bind_param($tipos, ...$datos);

            $resultado = $stmt->execute();
            break;


        /* =========================
           ACTUALIZAR
        ==========================*/
        case 'actualizar':

            if (!$idValor) {
                responder(false, "ID no especificado");
            }

            $sets = [];
            $tipos = '';
            $datos = [];

            foreach ($_POST as $key => $value) {

                if (in_array($key, ['accion', 'tabla', 'idCampo', 'idValor'])) {
                    continue;
                }

                $sets[] = "$key=?";
                $tipos .= detectarTipo($value);
                $datos[] = $value;
            }

            $tipos .= detectarTipo($idValor);
            $datos[] = $idValor;

            $sql = "UPDATE $tabla SET " . implode(',', $sets) . " 
                    WHERE $idCampo=?";

            $stmt = $conexion->prepare($sql);
            $stmt->bind_param($tipos, ...$datos);

            $resultado = $stmt->execute();
            break;


        /* =========================
           ELIMINAR
        ==========================*/
        case 'eliminar':

            if (!$idValor) {
                responder(false, "ID no especificado");
            }

            $sql = "DELETE FROM $tabla WHERE $idCampo=?";
            $stmt = $conexion->prepare($sql);

            $tipo = detectarTipo($idValor);
            $stmt->bind_param($tipo, $idValor);

            $resultado = $stmt->execute();
            break;

        case 'obtener':

            $sql = "SELECT * FROM $tabla WHERE $idCampo=?";
            $stmt = $conexion->prepare($sql);

            if (!$stmt) {
                responder(false, $conexion->error);
            }

            $tipo = detectarTipo($idValor);
            $stmt->bind_param($tipo, $idValor);
            $stmt->execute();

            $resultado = $stmt->get_result()->fetch_assoc();

            echo json_encode([
                "success" => true,
                "data" => $resultado
            ]);
            exit;

        default:
            responder(false, "Acción inválida");
    }

    responder($resultado, $resultado ? "Operación exitosa" : "Error en operación");
}


/* =========================
   FUNCIONES AUXILIARES
=========================*/

function detectarTipo($valor)
{
    if (is_numeric($valor)) {
        return 'i';
    }
    return 's';
}

function responder($success, $message)
{
    echo json_encode([
        "success" => $success,
        "message" => $message
    ]);
    exit;
}
