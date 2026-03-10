<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("location: log");
    exit();
}

$esAdmin = $_SESSION["rol"] == 1; // ✅ Ajusta el valor según tu BD
$usuarioId = $_SESSION["usuario"];
?>
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
    $activeTab = 'dashboard';
    include './src/components/sidebar.php';
    date_default_timezone_set('America/Bogota');
    include './src/models/dashboardData.model.php';

    $total = $esAdmin ? totales() : totalesPorInstructor($usuarioId);

// Admin - sin filtro
// Instructor - con prepared statement
$newSol = $esAdmin
    ? actividad("
        SELECT CONCAT_WS(' ', usuNoms, usuApes) AS inst, ambNom 
        FROM solicitud
        JOIN usuarios ON usuCed = instIdFk
        JOIN ambientes ON ambId = ambIdFk
        ORDER BY fechCre DESC LIMIT 1")
    : actividad("
        SELECT CONCAT_WS(' ', usuNoms, usuApes) AS inst, ambNom 
        FROM solicitud
        JOIN usuarios ON usuCed = instIdFk
        JOIN ambientes ON ambId = ambIdFk
        WHERE instIdFk = ?
        ORDER BY fechCre DESC LIMIT 1",
        [$usuarioId], "s");

$newApr = $esAdmin
    ? actividad("
        SELECT ambNom FROM solicitud
        JOIN ambientes ON ambId = ambIdFk
        WHERE solEst = 1
        ORDER BY solUltMod DESC LIMIT 1")
    : actividad("
        SELECT ambNom FROM solicitud
        JOIN ambientes ON ambId = ambIdFk
        WHERE solEst = 1 AND instIdFk = ?
        ORDER BY solUltMod DESC LIMIT 1",
        [$usuarioId], "s");

$newCan = $esAdmin
    ? actividad("
        SELECT ambNom FROM solicitud
        JOIN ambientes ON ambId = ambIdFk
        WHERE solEst = 2
        ORDER BY solUltMod DESC LIMIT 1")
    : actividad("
        SELECT ambNom FROM solicitud
        JOIN ambientes ON ambId = ambIdFk
        WHERE solEst = 2 AND instIdFk = ?
        ORDER BY solUltMod DESC LIMIT 1",
        [$usuarioId], "s");

$ambMasUsa = $esAdmin ? masUsados() : masUsados($usuarioId);

    function converPorcentaje($cant, $total)
    {
        return $total > 0 ? intval(($cant / $total) * 100) : 0;
    }
    ?>

    <main class="pt-20 md:pl-70 h-screen overflow-y-auto p-8 space-y-8">
        <!-- ENCABEZADO -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-800">
                    <?= $esAdmin ? "Dashboard General" : "Mi Dashboard" ?>
                </h2>
                <p class="text-gray-500 mt-1">
                    <?= $esAdmin
                        ? "Resumen general del estado de reservas y ambientes académicos."
                        : "Resumen de tus solicitudes y ambientes reservados." ?>
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

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">
                            <?= $esAdmin ? "Total Solicitudes" : "Mis Solicitudes" ?>
                        </p>
                        <h3 class="text-3xl font-extrabold text-gray-800 mt-1"><?= $total[0]["total"] ?? 0 ?></h3>
                    </div>
                    <div class="bg-blue-100 text-blue-600 p-3 rounded-xl">
                        <i class="fa-solid fa-file-lines text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Aprobadas</p>
                        <h3 class="text-3xl font-extrabold text-green-600 mt-1"><?= $total[0]["aprobadas"] ?? 0 ?></h3>
                    </div>
                    <div class="bg-green-100 text-green-600 p-3 rounded-xl">
                        <i class="fa-solid fa-circle-check text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Pendientes</p>
                        <h3 class="text-3xl font-extrabold text-yellow-500 mt-1"><?= $total[0]["pendientes"] ?? 0 ?></h3>
                    </div>
                    <div class="bg-yellow-100 text-yellow-500 p-3 rounded-xl">
                        <i class="fa-solid fa-clock text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Canceladas</p>
                        <h3 class="text-3xl font-extrabold text-red-500 mt-1">
                            <?= $total[0]["canceladas"] ?? 0 ?>
                        </h3>
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
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">
                    <?= $esAdmin ? "Actividad Reciente del Sistema" : "Mi Actividad Reciente" ?>
                </h3>

                <div class="space-y-4">
                    <div class="flex items-start gap-4">
                        <div class="bg-blue-100 text-blue-600 p-2 rounded-lg">
                            <i class="fa-solid fa-plus"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-800 font-semibold">Nueva solicitud creada</p>
                            <?php if (!isset($newSol[0]["ambNom"])) { ?>
                                <p class="text-xs text-gray-500">No hay solicitudes registradas</p>
                            <?php } else { ?>
                                <p class="text-xs text-gray-500">
                                    <?= $esAdmin
                                        ? "Instructor " . ucwords(strtolower($newSol[0]["inst"])) . " reservó el Ambiente " . $newSol[0]["ambNom"]
                                        : "Reservaste el Ambiente " . $newSol[0]["ambNom"] ?>
                                </p>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="bg-green-100 text-green-600 p-2 rounded-lg">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-800 font-semibold">Solicitud aprobada</p>
                            <?php if (!isset($newApr[0]["ambNom"])) { ?>
                                <p class="text-xs text-gray-500">
                                    <?= $esAdmin ? "No hay solicitudes aprobadas" : "No tienes solicitudes aprobadas" ?>
                                </p>
                            <?php } else { ?>
                                <p class="text-xs text-gray-500">
                                    Reserva del Ambiente <?= $newApr[0]["ambNom"] ?> fue aprobada
                                </p>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="bg-red-100 text-red-600 p-2 rounded-lg">
                            <i class="fa-solid fa-xmark"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-800 font-semibold">Solicitud cancelada</p>
                            <?php if (!isset($newCan[0]["ambNom"])) { ?>
                                <p class="text-xs text-gray-500">
                                    <?= $esAdmin ? "No hay solicitudes canceladas" : "No tienes solicitudes canceladas" ?>
                                </p>
                            <?php } else { ?>
                                <p class="text-xs text-gray-500">
                                    Reserva del Ambiente <?= $newCan[0]["ambNom"] ?> fue cancelada
                                </p>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ambientes más usados -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">
                    <?= $esAdmin ? "Ambientes más utilizados" : "Mis ambientes más reservados" ?>
                </h3>

                <div class="space-y-4">
                    <?php
                    $colores = ['bg-blue-600', 'bg-green-500', 'bg-yellow-500'];
                    for ($i = 0; $i < 3; $i++):
                        if (!isset($ambMasUsa['datos'][$i])) break;
                        $porcentaje = converPorcentaje($ambMasUsa['datos'][$i]['total_usados'], $ambMasUsa['totalFilas'][0]['fila']);
                    ?>
                        <div>
                            <div class="flex justify-between text-sm">
                                <span>Ambiente <?= $ambMasUsa['datos'][$i]['ambNom'] ?></span>
                                <span class="font-semibold"><?= $porcentaje ?>%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                                <div class="<?= $colores[$i] ?> h-2 rounded-full" style="width: <?= $porcentaje ?>%"></div>
                            </div>
                        </div>
                    <?php endfor; ?>

                    <?php if (empty($ambMasUsa['datos'])): ?>
                        <p class="text-sm text-gray-500">No hay datos disponibles</p>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </main>

    <script>
        document.getElementById('menuToggle').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('-translate-x-full');
        });
    </script>

</body>
</html>