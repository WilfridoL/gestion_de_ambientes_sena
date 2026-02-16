<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='stylesheet' href='./src/style/output.css'>
    <title>SGA - Solicitudes</title>
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
        $requests = obtenerSolicitudes();
        ?>

        <!-- Encabezado -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-800">
                    Gestión de Solicitudes de Salones
                </h2>
                <p class="text-gray-500 mt-1">
                    Administra y supervisa todas las reservas de ambientes académicos.
                </p>
            </div>

            <button onclick="abrirModal()"
                class="flex items-center justify-center space-x-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-bold shadow-lg shadow-blue-200 transition-all active:scale-95">
                <span><i class="fa-solid fa-plus"></i></span>
                <span>Agregar Solicitud</span>
            </button>
        </div>

        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mt-6">
            <?php include './src/components/table.php'; ?>
        </div>

    </main>

    <?php include "./src/components/modal.php"; ?>
    <script src="./src/app.js"></script>
</body>

</html>