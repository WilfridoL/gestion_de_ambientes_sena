<?php
include './src/models/instructor.model.php';
include './src/models/ambiente.model.php';
include './src/models/horario.model.php';
$instData =  obtenerInstructores() ?? [];
$ambData =  obtenerAmbiente() ?? [];
$horData =  obtenerHorario() ?? [];
?>

<!-- Modal -->
<div id="modalSolicitud"
    class="fixed inset-0 z-[10000] hidden">

    <!-- Overlay -->
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm"
        onclick="cerrarModal()"></div>

    <!-- Contenedor centrado -->
    <div class="fixed inset-0 flex items-center justify-center p-4">

        <!-- Contenido -->
        <div class="relative bg-white w-full max-w-lg rounded-2xl shadow-2xl p-6 animate-scaleIn">

            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-800">
                    Nueva Solicitud
                </h2>

                <button onclick="cerrarModal()"
                    class="text-gray-400 hover:text-gray-600 text-xl">
                    <i class="fa-solid fa-x"></i>
                </button>
            </div>

            <form action="" id="regSolicitud" method="POST" class="space-y-4">

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">
                        Instructor
                    </label>
                    <select name="instructor"
                        required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="">Seleccione un instructor</option>
                        <?php foreach ($instData as $req): ?>
                            <option value="<?= $req['usuCed'] ?>"><?= $req['nombre'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">
                        Ficha
                    </label>
                    <input type="number"
                        name="ficha"
                        placeholder="Ingrese una ficha"
                        required
                        min="10000"
                        max="9999999999"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">
                        Ambiente
                    </label>
                    <select name="ambiente"
                        required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="">Seleccione un ambiente</option>
                        <?php foreach ($ambData as $req): ?>
                            <option value="<?= $req['ambid'] ?>"><?= $req['ambNom'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">
                        Hora
                    </label>
                    <select name="hora"
                        required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="">Seleccione una hora</option>
                        <?php foreach ($horData as $req): ?>
                            <option value="<?= $req['horid'] ?>"><?= $req['horNom'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">
                        Fecha
                    </label>
                    <input type="date"
                        name="fecha"
                        required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <button type="button"
                        onclick="cerrarModal()"
                        class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300">
                        Cancelar
                    </button>

                    <button type="submit"
                        class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">
                        Guardar
                    </button>
                </div>

            </form>
        </div>

    </div>
</div>