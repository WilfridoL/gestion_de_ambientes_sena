<?php

function obtenerDatos($sqlBase, $registrosPorPagina = 5, $params = [], $tipos = '')
{
    require_once __DIR__ . "/conect.model.php";
    $conexion = conectar();

    $paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
    if ($paginaActual < 1) $paginaActual = 1;
    $offset = ($paginaActual - 1) * $registrosPorPagina;

    // ✅ Total con prepared statement
    $sqlTotal = "SELECT COUNT(*) as total FROM ($sqlBase) as tabla";
    $stmtTotal = $conexion->prepare($sqlTotal);

    if (!empty($params)) {
        $stmtTotal->bind_param($tipos, ...$params);
    }

    $stmtTotal->execute();
    $totalRegistros = $stmtTotal->get_result()->fetch_assoc()['total'];
    $totalPaginas = ceil($totalRegistros / $registrosPorPagina);

    // ✅ Consulta paginada con prepared statement
    $sqlPaginado = $sqlBase . " LIMIT ? OFFSET ?";
    $stmtDatos = $conexion->prepare($sqlPaginado);

    if (!empty($params)) {
        // Agregar limit y offset a los parámetros existentes
        $paramsCompletos = array_merge($params, [$registrosPorPagina, $offset]);
        $tiposCompletos = $tipos . "ii";
        $stmtDatos->bind_param($tiposCompletos, ...$paramsCompletos);
    } else {
        $stmtDatos->bind_param("ii", $registrosPorPagina, $offset);
    }

    $stmtDatos->execute();
    $datos = $stmtDatos->get_result()->fetch_all(MYSQLI_ASSOC);

    return [
        "datos"        => $datos,
        "paginaActual" => $paginaActual,
        "totalPaginas" => $totalPaginas
    ];
}