<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='stylesheet' href='./src/style/output.css'>
    <title>SGA - Mis solicitudes</title>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css'>
</head>

<body class="bg-gray-100 text-gray-900">

    <?php include './src/components/header.php'; ?>

    <?php
    $activeTab = '';
    include './src/components/sidebar.php';
    ?>

    <!-- Contenido principal -->
    <main class="pt-20 md:pl-70 min-h-screen p-8">

        <?php
        include "./src/models/solicitud.model.php";

        $search = $_GET['search'] ?? '';

        $where = "";

        if (!empty($search)) {
            $search = "%$search%";
            $where = "WHERE 
        solId LIKE '$search' OR
        a.ambNom LIKE '$search' OR
        fichaCod LIKE '$search'";
        }

        $sql = "
        SELECT solId,
            CONCAT_WS(' ', i.usuNoms, i.usuApes) AS instNom,
            a.ambNom,
            fecha,
            horNom,
            fichaCod,
            est.estNom
        FROM solicitud s
        JOIN horarios h ON s.horIDFk = h.horId
        JOIN usuarios i ON i.usuCed = s.instIdFk
        JOIN ambientes a ON a.ambId = s.ambIdFk
        JOIN estados est ON est.idEst = s.solEst
        WHERE usuCed = '798999'
        $where
        ORDER BY fechCre DESC
        ";

        $resultado = obtenerDatos($sql, 5);

        $requests      = $resultado['datos'];
        $paginaActual  = $resultado['paginaActual'];
        $totalPaginas  = $resultado['totalPaginas'];

        $data = $requests;

        $columns = [
            ['label' => 'Código', 'field' => 'solId'],
            ['label' => 'Instructor', 'field' => 'instNom'],
            ['label' => 'Ambiente', 'field' => 'ambNom'],
            ['label' => 'Fecha', 'field' => 'fecha'],
            ['label' => 'Hora', 'field' => 'horNom'],
            ['label' => 'Ficha', 'field' => 'fichaCod'],
            ['label' => 'Estado', 'field' => 'estNom'],
        ];

        $searchFields = ['solId', 'instNom', 'ambNom', 'fichaCod'];

        $actions = function ($row) {
            if ($row['estNom'] !== 'Cancelado') {
                return '<button class="btn-cancelar px-3 py-1 text-xs font-bold text-red-600 hover:bg-red-50 rounded-lg transition"
                data-id="' . $row['solId'] . '">
                Cancelar
                </button>';
            }
        };
        ?>


        <!-- Encabezado -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-800">
                    Historial de Solicitudes de Ambientes
                </h2>
                <p class="text-gray-500 mt-1">
                    Administra y supervisa el historial de tus reservas de ambientes académicos.
                </p>
            </div>
<!-- 
            <button onclick="abrirModal()"
                class="flex items-center justify-center space-x-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-bold shadow-lg shadow-blue-200 transition-all active:scale-95">
                <span><i class="fa-solid fa-plus"></i></span>
                <span>Agregar Solicitud</span>
            </button> -->
        </div>

        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mt-6">
            <?php include './src/components/table.php'; ?>
        </div>

    </main>

    <?php // include "./src/components/modal.php"; ?>
    <script src="./src/app.js"></script>
</body>

</html>