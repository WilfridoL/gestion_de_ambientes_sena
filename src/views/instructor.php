<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='stylesheet' href='./src/style/output.css'>
    <title>SGA - Instructores</title>
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
        "titulo" => "Registrar Instructor",
        "tabla" => "usuarios",
        "idCampo" => "usuCed",
        "campos" => [
            [
                "label" => "Cedula",
                "name"  => "usuCed",
                "tipo"  => "number",
                "required" => true

            ],
            [
                "label" => "Nombres",
                "name"  => "usuNoms",
                "tipo"  => "text",
                "required" => true

            ],
            [
                "label" => "Apellidos",
                "name"  => "usuApes",
                "tipo"  => "text",
                "required" => true

            ],
            [
                "label" => "Correo",
                "name"  => "usuCorr",
                "tipo"  => "email",
                "required" => true
            ]
        ]
    ]);
    ?>

    <main class="pt-20 md:pl-70 h-screen overflow-y-auto p-8 space-y-6">
        <?php

        $columns = [
            ['label' => 'Cedula', 'field' => 'usuCed'],
            ['label' => 'Nombres', 'field' => 'usuNoms'],
            ['label' => 'Apellidos', 'field' => 'usuApes'],
            ['label' => 'Correo', 'field' => 'usuCorr'],
        ];

        $searchFields = ['usuCed', 'usuNoms', 'usuApes'];
        $search = $_GET['search'] ?? '';

        $where = "";

        if (!empty($search)) {
            $search = "%$search%";
            $where = "WHERE 
        usuCed LIKE '$search' OR
        usuNoms LIKE '$search' OR
        usuApes LIKE '$search'";
        }
        $sql = "
        SELECT * FROM usuarios
        $where";



        $resultado = obtenerDatos($sql, 5);

        $requests      = $resultado['datos'];
        $paginaActual  = $resultado['paginaActual'];
        $totalPaginas  = $resultado['totalPaginas'];

        $data = $requests;

        $actions = function ($row) {
            return '
    <button class="btn-cancelar px-3 py-1 text-xs font-bold text-red-600 hover:bg-red-50 rounded-lg transition"
        onclick="eliminarRegistro(' . $row['usuCed'] . ', \'usuarios\', \'usuCed\')">
        Eliminar
    </button>

    <button class="btn-cancelar px-3 py-1 text-xs font-bold text-yellow-600 hover:bg-yellow-50 rounded-lg transition"
        onclick="abrirModal(\'actualizar\', ' . $row['usuCed'] . ')">
        Actualizar
    </button>
    ';
        };
        ?>
        <!-- Encabezado -->
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-800">
                    Gestión de Instructores
                </h2>
                <p class="text-gray-500 mt-1">
                    Administra los instructores disponibles.
                </p>
            </div>

            <button onclick="abrirModal()"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-bold shadow-lg transition">
                <i class="fa-solid fa-plus mr-2"></i>
                Nuevo Instructor
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