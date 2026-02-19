<?php
$data = $data ?? [];
$columns = $columns ?? [];
$actions = $actions ?? null;
?>

<div class="space-y-6">
    <form method="GET" class="mb-6 max-w-md">
    <div class="flex items-center space-x-2 bg-gray-50 rounded-lg px-4 py-2 border border-gray-200 focus-within:ring-2 focus-within:ring-blue-500">
        <input
            type="text"
            name="search"
            value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
            placeholder="<?= $placeholder ?? "Buscar..." ?>"
            class="bg-transparent border-none focus:ring-0 w-full text-sm py-1 outline-none text-gray-700">
    </div>
</form>
    <!-- TABLA -->
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-xs font-bold uppercase tracking-wider border-b border-gray-100">
                    <?php foreach ($columns as $col): ?>
                        <th class="px-6 py-4"><?= $col['label'] ?></th>
                    <?php endforeach; ?>

                    <?php if ($actions): ?>
                        <th class="px-6 py-4 text-right">Acciones</th>
                    <?php endif; ?>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">
                <?php if (!empty($data)): ?>
                    <?php foreach ($data as $row): ?>
                        <tr class="hover:bg-blue-50/30 transition-colors">

                            <?php foreach ($columns as $col): ?>
                                <td class="px-6 py-4">

                                    <?php
                                    // 🔥 ESTILO DINÁMICO PARA ESTADO
                                    if ($col['field'] === 'estNom') {

                                        $estadoColor = match ($row['estNom']) {
                                            'Aprobado'  => 'bg-green-100 text-green-700 border-green-200',
                                            'Pendiente' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                                            'Cancelado' => 'bg-red-100 text-red-700 border-red-200',
                                            default     => 'bg-gray-100 text-gray-600'
                                        };

                                        echo '<span class="px-3 py-1 rounded-full text-xs font-semibold border '.$estadoColor.'">
                                                '.$row['estNom'].'
                                              </span>';
                                    } else {
                                        echo $row[$col['field']];
                                    }
                                    ?>

                                </td>
                            <?php endforeach; ?>

                            <?php if ($actions): ?>
                                <td class="px-6 py-4 text-right">
                                    <?= $actions($row); ?>
                                </td>
                            <?php endif; ?>

                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="<?= count($columns) + ($actions ? 1 : 0) ?>"
                            class="px-6 py-12 text-center text-gray-500 italic">
                            No se encontraron registros.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- PAGINACIÓN (SOLO VISUAL) -->
    <div class="mt-6 flex items-center justify-between px-2">

        <p class="text-sm text-gray-500">
            Página
            <span class="font-semibold text-gray-800"><?= $paginaActual ?></span>
            de
            <span class="font-semibold text-gray-800"><?= $totalPaginas ?></span>
        </p>

        <div class="flex justify-center items-center space-x-2">

            <?php
            $esPrimera = ($paginaActual <= 1);
            $esUltima  = ($paginaActual >= $totalPaginas);
            ?>

            <!-- Anterior -->
            <a href="<?= !$esPrimera ? '?pagina=' . ($paginaActual - 1) : '#' ?>"
               class="px-3 py-1 border border-gray-300 rounded
               <?= $esPrimera
                    ? 'bg-gray-100 text-gray-400 cursor-not-allowed pointer-events-none'
                    : 'bg-gray-200 hover:bg-gray-300' ?>">
                Anterior
            </a>

            <!-- Siguiente -->
            <a href="<?= !$esUltima ? '?pagina=' . ($paginaActual + 1) : '#' ?>"
               class="px-3 py-1 border border-gray-300 rounded
               <?= $esUltima
                    ? 'bg-gray-100 text-gray-400 cursor-not-allowed pointer-events-none'
                    : 'bg-gray-200 hover:bg-gray-300' ?>">
                Siguiente
            </a>

        </div>
    </div>
</div>