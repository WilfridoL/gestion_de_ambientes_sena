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

   <main class="pt-20 md:pl-70 h-screen overflow-y-auto p-8 space-y-8">

    <!-- ENCABEZADO -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-extrabold text-gray-800">
                Dashboard General
            </h2>
            <p class="text-gray-500 mt-1">
                Resumen general del estado de reservas y ambientes académicos.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <div class="bg-white px-4 py-2 rounded-xl shadow-sm border text-sm text-gray-600">
                <i class="fa-regular fa-calendar mr-2"></i>
                <?= date('d M Y') ?>
            </div>
        </div>
    </div>

    <!-- TARJETAS RESUMEN -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

        <!-- Total Solicitudes -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Solicitudes</p>
                    <h3 class="text-3xl font-extrabold text-gray-800 mt-1">128</h3>
                </div>
                <div class="bg-blue-100 text-blue-600 p-3 rounded-xl">
                    <i class="fa-solid fa-file-lines text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Aprobadas -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Aprobadas</p>
                    <h3 class="text-3xl font-extrabold text-green-600 mt-1">86</h3>
                </div>
                <div class="bg-green-100 text-green-600 p-3 rounded-xl">
                    <i class="fa-solid fa-circle-check text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Pendientes -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Pendientes</p>
                    <h3 class="text-3xl font-extrabold text-yellow-500 mt-1">24</h3>
                </div>
                <div class="bg-yellow-100 text-yellow-500 p-3 rounded-xl">
                    <i class="fa-solid fa-clock text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Canceladas -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Canceladas</p>
                    <h3 class="text-3xl font-extrabold text-red-500 mt-1">18</h3>
                </div>
                <div class="bg-red-100 text-red-500 p-3 rounded-xl">
                    <i class="fa-solid fa-ban text-xl"></i>
                </div>
            </div>
        </div>

    </div>

    <!-- SECCIÓN PRINCIPAL -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Actividad Reciente -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">
                Actividad Reciente
            </h3>

            <div class="space-y-4">

                <div class="flex items-start gap-4">
                    <div class="bg-blue-100 text-blue-600 p-2 rounded-lg">
                        <i class="fa-solid fa-plus"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-800 font-semibold">
                            Nueva solicitud creada
                        </p>
                        <p class="text-xs text-gray-500">
                            Instructor Juan Pérez reservó el Ambiente A-203
                        </p>
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <div class="bg-green-100 text-green-600 p-2 rounded-lg">
                        <i class="fa-solid fa-check"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-800 font-semibold">
                            Solicitud aprobada
                        </p>
                        <p class="text-xs text-gray-500">
                            Reserva del Ambiente B-101 fue aprobada
                        </p>
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <div class="bg-red-100 text-red-600 p-2 rounded-lg">
                        <i class="fa-solid fa-xmark"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-800 font-semibold">
                            Solicitud cancelada
                        </p>
                        <p class="text-xs text-gray-500">
                            Reserva del Ambiente C-305 fue cancelada
                        </p>
                    </div>
                </div>

            </div>
        </div>

        <!-- Ambientes más usados -->
        <div class="bg-white rounded-2xl shadow-sm border p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">
                Ambientes más utilizados
            </h3>

            <div class="space-y-4">

                <div>
                    <div class="flex justify-between text-sm">
                        <span>Ambiente A-203</span>
                        <span class="font-semibold">85%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: 85%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between text-sm">
                        <span>Ambiente B-101</span>
                        <span class="font-semibold">70%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                        <div class="bg-green-500 h-2 rounded-full" style="width: 70%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between text-sm">
                        <span>Ambiente C-305</span>
                        <span class="font-semibold">55%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                        <div class="bg-yellow-500 h-2 rounded-full" style="width: 55%"></div>
                    </div>
                </div>

            </div>
        </div>

    </div>

</main>

</body>
</html>