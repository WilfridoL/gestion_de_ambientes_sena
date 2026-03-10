<?php
session_start();
if (
    !isset($_SESSION["usuario"])
    || $_SESSION["rol"] != 1
) {
    header("location: /");
    exit();
}
?>
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
                "maxNum" => 9999999999,
                "required" => true
            ],
            [
                "label" => "Nombres",
                "name"  => "usuNoms",
                "tipo"  => "text",
                "required" => true,
                "maxLength" => 40,
                "pattern" => "[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+"
            ],
            [
                "label" => "Apellidos",
                "name"  => "usuApes",
                "tipo"  => "text",
                "required" => true,
                "maxLength" => 40,
                "pattern" => "[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+"
            ],
            [
                "label" => "Correo",
                "name"  => "usuCorr",
                "tipo"  => "email",
                "required" => true,
                "maxLength" => 254,
                "pattern" => "^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$"
            ],
            [
                "label" => "Rol",
                "name"  => "usuAuth",
                "tipo"  => "select",
                "required" => true,
                "options" => [
                    [
                        "value" => 1,
                        "text" => "Administrador",
                    ],
                    [
                        "value" => 2,
                        "text" => "Instructor",
                    ],
                ]
            ],
            [
                "label" => "Constraseña",
                "name"  => "password",
                "tipo"  => "password",
                "required" => true,
                "maxLength" => 20
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
        $placeholder = "Buscar por cedula, nombres o apellidos...";
        $search = $_GET['search'] ?? '';

        $sql = "SELECT * FROM usuarios";

        if (!empty($search)) {
            $searchParam = "%$search%";
            $sql .= " WHERE
        usuCed LIKE ? OR
        usuNoms LIKE ? OR
        usuApes LIKE ?";

            $resultado = obtenerDatos(
                $sql,
                10,
                [$searchParam, $searchParam, $searchParam],
                "sss"
            );
        } else {
            $resultado = obtenerDatos($sql, 10);
        }

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

        <a href="/Panel de Administración">
            <button type="button" class="btn-cancelar px-3 py-1 text-sm font-bold text-blue-600 hover:bg-blue-100 rounded-lg transition">
                <i class="fa-solid fa-arrow-left"></i> Regresar a Panel de Administración
            </button>
        </a>
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-800">
                    Gestión de Instructores
                </h2>
                <p class="text-gray-500 mt-1">
                    Administra los instructores disponibles.
                </p>
            </div>

            <button onclick="abrirModal()"
                class="flex items-center justify-center space-x-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-bold shadow-lg shadow-blue-200 transition-all active:scale-95">
                <i class="fa-solid fa-plus mr-2"></i>
                Nuevo Instructor
            </button>
        </div>

        <!-- Tabla -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mt-6">

            <?php include './src/components/table.php'; ?>

        </div>
        <div id="alert-container" class="fixed top-5 right-5 w-96 z-50"></div>

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