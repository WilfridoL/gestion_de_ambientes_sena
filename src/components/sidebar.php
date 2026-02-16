<?php
// Detectar pestaña activa desde la URL
$activeTab = $_GET['tab'] ?? 'dashboard';

$menuItems = [
    'dashboard' => [
        'name' => 'Dashboard',
        'icon' => 'fa-solid fa-chart-line'
    ],
    'solicitudes' => [
        'name' => 'Solicitudes',
        'icon' => 'fa-solid fa-file-lines'
    ],
    'mis-solicitudes' => [
        'name' => 'Mis Solicitudes',
        'icon' => 'fa-solid fa-user-check'
    ],
    'configuracion' => [
        'name' => 'Configuración',
        'icon' => 'fa-solid fa-gear'
    ],
];
?>

<aside class="fixed top-16 left-0 w-64 h-[calc(100vh-4rem)] bg-blue-900 text-white hidden md:flex flex-col shadow-2xl">

    <!-- Logo -->
    <div class="p-6">
        <div class="flex items-center space-x-3 bg-blue-800/50 p-3 rounded-xl border border-blue-700/50">
            <div class="bg-white/20 p-2 rounded-lg">
                🏫
            </div>
            <span class="font-bold text-lg tracking-tight">SGA Panel</span>
        </div>
    </div>

    <!-- Navegación -->
    <nav class="flex-1 mt-4 space-y-1 px-2">
        <?php foreach ($menuItems as $id => $item): ?>
        <a 
            href="<?= $id ?>"
            class="w-full flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 group
            <?= $activeTab === $id 
                ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/50' 
                : 'text-blue-100 hover:bg-blue-800/60 hover:text-white' ?>"
        >
            <i class="<?= $item['icon'] ?> w-5 text-center 
                <?= $activeTab === $id ? 'text-white' : 'text-blue-300 group-hover:text-white' ?>">
            </i>

            <span class="font-medium">
                <?= $item['name'] ?>
            </span>
        </a>
    <?php endforeach; ?>
    </nav>

    <!-- Estado servidor -->
    <!-- <div class="p-7 border-t border-blue-800">
        <div class="bg-blue-800/30 p-4 rounded-xl border border-blue-700/30">
            <p class="text-xs text-blue-300 uppercase font-semibold tracking-wider mb-2">
                Estado del Servidor
            </p>
            <div class="flex items-center text-sm">
                <div class="w-2 h-2 rounded-full bg-green-400 mr-2 animate-pulse"></div>
                <span>En línea</span>
            </div>
        </div>
    </div> -->

</aside>