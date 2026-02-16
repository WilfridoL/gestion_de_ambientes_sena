<?php
$requests = $requests ?? [];
$searchTerm = $_GET['search'] ?? '';

// Filtrar solicitudes (equivalente a filter() de React)
$filteredRequests = array_filter($requests, function ($req) use ($searchTerm) {
    return stripos($req['instNom'], $searchTerm) !== false ||
           stripos($req['ambNom'], $searchTerm) !== false ||
           stripos($req['solId'], $searchTerm) !== false;
});
?>

<div class="space-y-6">

        <!-- Buscador -->
        <form method="GET" class="mb-6 max-w-md">
            <div class="flex items-center space-x-2 bg-gray-50 rounded-lg px-4 py-2 border border-gray-200 focus-within:ring-2 focus-within:ring-blue-500">
                <input 
                    type="text" 
                    name="search"
                    value="<?= htmlspecialchars($searchTerm) ?>"
                    placeholder="Buscar por código, docente o salón..."
                    class="bg-transparent border-none focus:ring-0 w-full text-sm py-1 outline-none text-gray-700"
                >
            </div>
        </form>

        <!-- Tabla -->
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-xs font-bold uppercase tracking-wider border-b border-gray-100">
                        <th class="px-6 py-4">Código</th>
                        <th class="px-6 py-4">Instructor</th>
                        <th class="px-6 py-4">Ambiente</th>
                        <th class="px-6 py-4">Fecha</th>
                        <th class="px-6 py-4">Hora</th>
                        <th class="px-6 py-4">Estado</th>
                        <th class="px-6 py-4 text-right">Acciones</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    <?php if (!empty($filteredRequests)): ?>
                        <?php foreach ($filteredRequests as $req): ?>

                            <?php
                            $estadoColor = match($req['estNom']) {
                                'Aprobado' => 'bg-green-100 text-green-700 border-green-200',
                                'Pendiente' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                                'Cancelado' => 'bg-red-100 text-red-700 border-red-200',
                                default => 'bg-gray-100 text-gray-600'
                            };
                            ?>

                            <tr class="hover:bg-blue-50/30 transition-colors">
                                <td class="px-6 py-4">
                                    <span class="font-mono text-xs font-bold bg-gray-100 text-gray-600 px-2 py-1 rounded">
                                        <?= $req['solId'] ?>
                                    </span>
                                </td>

                                <td class="px-6 py-4 font-semibold text-gray-800">
                                    <?= $req['instNom'] ?>
                                </td>

                                <td class="px-6 py-4 text-gray-600">
                                    <?= $req['ambNom'] ?>
                                </td>

                                <td class="px-6 py-4 text-gray-600 font-medium">
                                    <?= $req['fecha'] ?>
                                </td>

                                <td class="px-6 py-4 text-gray-500 text-sm">
                                    <?= $req['horNom'] ?>
                                </td>

                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold border <?= $estadoColor ?>">
                                        <?= $req['estNom'] ?>
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-right">
                                    <?php if ($req['estNom'] !== 'Cancelado'): ?>
                                        <button
                                           class="btn-cancelar px-3 py-1 text-xs font-bold text-red-600 hover:bg-red-50 rounded-lg transition"
                                           data-id="<?= $req['solId'] ?>">
                                            Cancelar
                                        </button>
                                    <?php endif; ?>
                                </td>
                            </tr>

                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500 italic">
                                No se encontraron solicitudes que coincidan con la búsqueda.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Footer -->
        <div class="mt-6 flex items-center justify-between px-2">
            <p class="text-sm text-gray-500">
                Mostrando 
                <span class="font-semibold text-gray-800"><?= count($filteredRequests) ?></span> 
                de 
                <span class="font-semibold text-gray-800"><?= count($requests) ?></span> 
                solicitudes
            </p>

            <div class="flex space-x-1">
                <button class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-50 text-gray-600">Anterior</button>
                <button class="px-3 py-1 bg-blue-600 text-white rounded shadow-sm font-medium">1</button>
                <button class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-50 text-gray-600">Siguiente</button>
            </div>
        </div>

    </div>