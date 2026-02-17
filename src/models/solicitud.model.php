<?php

function obtenerDatos($sqlBase, $registrosPorPagina = 5)
{
    require_once __DIR__ . "/conect.model.php";
    $conexion = conectar();

    // Página actual
    $paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;

    if ($paginaActual < 1) {
        $paginaActual = 1;
    }

    $offset = ($paginaActual - 1) * $registrosPorPagina;

    // Consulta total
    $sqlTotal = "SELECT COUNT(*) as total FROM ($sqlBase) as tabla";
    $resultadoTotal = $conexion->query($sqlTotal);
    $filaTotal = $resultadoTotal->fetch_assoc();
    $totalRegistros = $filaTotal['total'];

    $totalPaginas = ceil($totalRegistros / $registrosPorPagina);

    // Consulta paginada
    $sqlPaginado = $sqlBase . " LIMIT $registrosPorPagina OFFSET $offset";
    $resultado = $conexion->query($sqlPaginado);

    $datos = [];

    while ($fila = $resultado->fetch_assoc()) {
        $datos[] = $fila;
    }

    return [
        "datos" => $datos,
        "paginaActual" => $paginaActual,
        "totalPaginas" => $totalPaginas
    ];
}
