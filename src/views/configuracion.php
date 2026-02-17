<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='stylesheet' href='./src/style/output.css'>
    <title>SGA - Configuracion</title>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css'>
</head>

<body class="bg-gray-100 text-gray-900 overflow-hidden">

<?php include './src/components/header.php'; ?>
<?php 
$activeTab = 'config';
include './src/components/sidebar.php'; 
?>

<main class="pt-20 md:pl-70 h-screen overflow-y-auto p-8 space-y-8">

    <!-- Encabezado -->
    <div>
        <h2 class="text-3xl font-extrabold text-gray-800">
            Configuraciones del Sistema
        </h2>
        <p class="text-gray-500 mt-1">
            Administra los ambientes e instructores registrados en el sistema.
        </p>
    </div>

    <!-- Tarjetas -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-6">

        <!-- Gestionar Ambientes -->
        <a href="ambientes"
           class="bg-white p-8 rounded-2xl shadow-sm border hover:shadow-lg transition group">
            
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-bold text-gray-800 group-hover:text-blue-600 transition">
                        Gestionar Ambientes
                    </h3>
                    <p class="text-gray-500 mt-2 text-sm">
                        Registrar, actualizar y eliminar ambientes académicos.
                    </p>
                </div>

                <div class="bg-blue-100 text-blue-600 p-4 rounded-xl group-hover:scale-110 transition">
                    <i class="fa-solid fa-building text-2xl"></i>
                </div>
            </div>

        </a>

        <!-- Gestionar Instructores -->
        <a href="/configuracion/instructores.php"
           class="bg-white p-8 rounded-2xl shadow-sm border hover:shadow-lg transition group">
            
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-bold text-gray-800 group-hover:text-green-600 transition">
                        Gestionar Instructores
                    </h3>
                    <p class="text-gray-500 mt-2 text-sm">
                        Administrar instructores registrados en el sistema.
                    </p>
                </div>

                <div class="bg-green-100 text-green-600 p-4 rounded-xl group-hover:scale-110 transition">
                    <i class="fa-solid fa-user-tie text-2xl"></i>
                </div>
            </div>

        </a>

    </div>

</main>

</body>

</html>