<?php
function renderModal($config)
{
    $titulo   = $config['titulo'] ?? 'Formulario';
    $tabla    = $config['tabla'];
    $idCampo  = $config['idCampo'];
    $campos   = $config['campos'];
?>

<div id="modalGenerico" class="fixed inset-0 z-[10000] hidden">

    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm"
        onclick="cerrarModal()"></div>

    <div class="fixed inset-0 flex items-center justify-center p-4">

        <div class="relative bg-white w-full max-w-lg rounded-2xl shadow-2xl p-6">

            <div class="flex justify-between items-center mb-6">
                <h2 id="modalTitulo" class="text-xl font-bold text-gray-800">
                    <?= $titulo ?>
                </h2>

                <button onclick="cerrarModal()" class="text-gray-400 hover:text-gray-600 text-xl">
                    ✕
                </button>
            </div>

            <form id="formGenerico" class="space-y-4">

                <input type="hidden" name="accion" value="registrar">
                <input type="hidden" name="tabla" value="<?= $tabla ?>">
                <input type="hidden" name="idCampo" value="<?= $idCampo ?>">
                <input type="hidden" name="idValor" value="">

                <?php foreach ($campos as $campo): ?>

                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">
                            <?= $campo['label'] ?>
                        </label>

                        <?php if ($campo['tipo'] === 'select'): ?>
                            <select name="<?= $campo['name'] ?>"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                <option value="">Seleccione</option>
                                <?php foreach ($campo['options'] as $opt): ?>
                                    <option value="<?= $opt['value'] ?>">
                                        <?= $opt['text'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                        <?php else: ?>
                            <input type="<?= $campo['tipo'] ?>"
                                name="<?= $campo['name'] ?>"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2"
                                <?php if (!empty($campo['required'])): ?> required <?php endif; ?>>
                        <?php endif; ?>
                    </div>

                <?php endforeach; ?>

                <div class="flex justify-end gap-3 pt-4">
                    <button type="button"
                        onclick="cerrarModal()"
                        class="px-4 py-2 rounded-lg bg-gray-200">
                        Cancelar
                    </button>

                    <button type="submit"
                        class="px-4 py-2 rounded-lg bg-blue-600 text-white">
                        Guardar
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<?php
}
?>