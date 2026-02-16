<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='stylesheet' href='./src/style/output.css'>
    <title>SGA - Dashboard</title>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css'>
</head>

<body class="bg-gray-100 text-gray-900 overflow-hidden">

    <?php include './src/components/header.php'; ?>

    <?php 
    $activeTab = '';
    include './src/components/sidebar.php'; 
    ?>

    <!-- Contenido principal -->
   <main class="pt-20 md:pl-70 h-screen overflow-y-auto p-8">

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

    </main>

</body>
</html>