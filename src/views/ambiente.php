<!DOCTYPE html>
<html lang='en'>

<head>
  <meta charset='UTF-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
  <link rel='stylesheet' href='./src/style/output.css'>
  <title>SGA - Configuracion</title>
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css'>
</head>

<?php
include "./src/models/solicitud.model.php";
?>

<body class="bg-gray-100 text-gray-900 overflow-hidden">

  <?php include './src/components/header.php'; ?>
  <?php
  $activeTab = 'configuracion';
  include './src/components/sidebar.php';
  include './src/components/modalConfig.php';

  renderModal([
    "titulo" => "Registrar Ambiente",
    "tabla" => "ambientes",
    "idCampo" => "ambId",
    "campos" => [
      [
        "label" => "Nombre",
        "name"  => "ambNom",
        "tipo"  => "text",
        "required" => true
      ],
      [
        "label" => "Capacidad",
        "name"  => "ambCap",
        "tipo"  => "number",
        "required" => true
      ]
    ]
  ]);
  ?>

  <main class="pt-20 md:pl-70 h-screen overflow-y-auto p-8 space-y-6">
    <?php

    $columns = [
      ['label' => 'Código', 'field' => 'ambId'],
      ['label' => 'Ambiente', 'field' => 'ambNom'],
      ['label' => 'Capacidad', 'field' => 'ambCap'],
    ];

    $searchFields = ['ambId', 'ambNom', 'ambCap'];

    $search = $_GET['search'] ?? '';
    $where = "";

    if (!empty($search)) {
      $search = "%$search%";
      $where = "WHERE 
        ambId LIKE '$search' OR
        ambNom LIKE '$search' OR
        ambCap LIKE '$search'";
    }
    $sql = "
    SELECT * FROM ambientes
    $where
    ";
    $resultado = obtenerDatos($sql, 5);

    $requests      = $resultado['datos'];
    $paginaActual  = $resultado['paginaActual'];
    $totalPaginas  = $resultado['totalPaginas'];

    $data = $requests;

    $actions = function ($row) {
      return '
    <button class="btn-cancelar px-3 py-1 text-xs font-bold text-red-600 hover:bg-red-50 rounded-lg transition"
        onclick="eliminarRegistro(' . $row['ambId'] . ', \'ambientes\', \'ambId\')">
        Eliminar
    </button>

    <button class="btn-cancelar px-3 py-1 text-xs font-bold text-yellow-600 hover:bg-yellow-50 rounded-lg transition"
        onclick="abrirModal(\'actualizar\', ' . $row['ambId'] . ')">
        Actualizar
    </button>
    ';
    };
    ?>
    <!-- Encabezado -->
    <div class="flex justify-between items-center">
      <div>
        <h2 class="text-3xl font-extrabold text-gray-800">
          Gestión de Ambientes
        </h2>
        <p class="text-gray-500 mt-1">
          Administra los ambientes académicos disponibles.
        </p>
      </div>

      <button onclick="abrirModal()"
        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-bold shadow-lg transition">
        <i class="fa-solid fa-plus mr-2"></i>
        Nuevo Ambiente
      </button>
    </div>

    <!-- Tabla -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mt-6">

      <?php include './src/components/table.php'; ?>

    </div>

  </main>
  <script src="./src/crudController.js"></script>
  <script>
    document.getElementById('menuToggle').addEventListener('click', function() {
      const sidebar = document.getElementById('sidebar');
      sidebar.classList.toggle('-translate-x-full');
    });
  </script>
</body>

</html>