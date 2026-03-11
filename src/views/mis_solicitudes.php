<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("location: log");
    exit();
}
if ($_SESSION["rol"] != 2) {
    header("location: /");
    exit();
}

?>

<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='stylesheet' href='./src/style/output.css'>
    <title>SGA - Mis solicitudes</title>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css'>
</head>

<body class="bg-gray-100 text-gray-900">

    <?php include './src/components/header.php'; ?>

    <?php
    include './src/models/instructor.model.php';
    include './src/models/ambiente.model.php';
    include './src/models/horario.model.php';
    $instData =  obtenerInstructores() ?? [];
    $ambData =  obtenerAmbiente() ?? [];
    $horData =  obtenerHorario() ?? [];
    $activeTab = 'mis-solicitudes';
    include './src/components/sidebar.php';
    include './src/components/modalConfig.php';
    function cargar($data, $valueKey, $textKey)
    {
        $options = [];

        foreach ($data as $e) {
            $options[] = [
                "value" => $e[$valueKey],
                "text"  => $e[$textKey]
            ];
        }

        return $options;
    }
    renderModal([
        "titulo" => "Nueva solicitud",
        "tabla" => "solicitud",
        "idCampo" => "solId",
        "campos" => [
            [
                "label" => "id",
                "tipo"  => "text",
                "name"  => "solId",
                "valueDefault" => 'S' . random_int(1000, 10000),
                "mostrar" => false
            ],
            [
                "label" => "Instructor",
                "name"  => "instIdFk",
                "tipo"  => "select",
                "required" => true,
                "options" => cargar($instData, "usuCed", "nombre"),
                "selectDefault" => "Seleccione un instructor..."
            ],
            [
                "label" => "Ficha",
                "name"  => "fichaCod",
                "tipo"  => "number",
                "required" => true,
                "maxLength" => 9999999999
            ],
            [
                "label" => "Ambiente",
                "name"  => "ambIdFk",
                "tipo"  => "select",
                "required" => true,
                "options" => cargar($ambData, "ambid", "ambNom"),
                "selectDefault" => "Seleccione una ambiente..."
            ],
            [
                "label" => "Hora",
                "name"  => "horIDFk",
                "tipo"  => "select",
                "required" => true,
                "options" => cargar($horData, "horid", "horNom"),
                "selectDefault" => "Seleccione una hora..."
            ],
            [
                "label" => "Fecha",
                "name"  => "fecha",
                "tipo"  => "date",
                "required" => true
            ],
            [
                "label" => "estado",
                "name"  => "solEst",
                "tipo"  => "number",
                "valueDefault" => 1,
                "mostrar" => false
            ]
        ]
    ]);

    ?>

    <!-- Contenido principal -->
    <main class="pt-20 md:pl-70 min-h-screen p-8">

        <?php
        include "./src/models/solicitud.model.php";

        $search = $_GET['search'] ?? '';

        $sql = "
    SELECT solId,
        CONCAT_WS(' ', i.usuNoms, i.usuApes) AS instNom,
        a.ambNom,
        fecha,
        horNom,
        fichaCod,
        est.estNom
    FROM solicitud s
    JOIN horarios h ON s.horIDFk = h.horId
    JOIN usuarios i ON i.usuCed = s.instIdFk
    JOIN ambientes a ON a.ambId = s.ambIdFk
    JOIN estados est ON est.idEst = s.solEst
    WHERE instIdFk =" . $_SESSION["usuario"];

        if (!empty($search)) {
            $searchParam = "%$search%";
            $sql .= " AND (
        solId LIKE ? OR
        CONCAT_WS(' ', i.usuNoms, i.usuApes) LIKE ? OR
        a.ambNom LIKE ? OR
        fichaCod LIKE ?
    )";
            $sql .= " ORDER BY fechCre DESC";

            // ✅ 4 parámetros tipo string
            $resultado = obtenerDatos(
                $sql,
                10,
                [$searchParam, $searchParam, $searchParam, $searchParam],
                "ssss"
            );
        } else {
            $sql .= " ORDER BY fechCre DESC";

            // ✅ Sin parámetros
            $resultado = obtenerDatos($sql, 10);
        }

        $requests      = $resultado['datos'];
        $paginaActual  = $resultado['paginaActual'];
        $totalPaginas  = $resultado['totalPaginas'];

        $data = $requests;

        $columns = [
            ['label' => 'Código', 'field' => 'solId'],
            ['label' => 'Instructor', 'field' => 'instNom'],
            ['label' => 'Ambiente', 'field' => 'ambNom'],
            ['label' => 'Fecha', 'field' => 'fecha'],
            ['label' => 'Hora', 'field' => 'horNom'],
            ['label' => 'Ficha', 'field' => 'fichaCod'],
            ['label' => 'Estado', 'field' => 'estNom'],
        ];

        $searchFields = ['solId', 'ambNom', 'fichaCod'];
        $placeholder = "Buscar por código, ficha o salón...";

        $actions = function ($row) {
            if (
                $row['estNom'] !== 'Cancelado'
                && $row['estNom'] !== 'Aprobado'
                && $_SESSION["rol"] == 1
            ) {
                return '<button class="btn-cancelar px-3 py-1 text-xs font-bold text-red-600 hover:bg-red-50 rounded-lg transition"
                data-id="' . $row['solId'] . '">
                Cancelar
                </button>
                <button class="btn-aceptar px-3 py-1 text-xs font-bold text-green-600 hover:bg-green-100 rounded-lg transition"
                data-id="' . $row['solId'] . '">
                Aprobar
                </button>';
            }
            if ($row['estNom'] === 'Aprobado' || $row['estNom'] === 'Pendiente') {
                return '<button class="btn-cancelar px-3 py-1 text-xs font-bold text-red-600 hover:bg-red-50 rounded-lg transition"
                data-id="' . $row['solId'] . '">
                Cancelar
                </button>';
            }
            if ($row['estNom'] === 'Cancelado') {
                return '<button class="btn-reasignar px-3 py-1 text-xs font-bold text-red-600 hover:bg-red-50 rounded-lg transition"
                data-id="' . $row['solId'] . '"
                 onclick="abrirModal(\'actualizar\', \'' . $row['solId'] . '\')">
                Reasignar
                </button>';
            }
        };
        ?>


        <!-- Encabezado -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-800">
                    Historial de Solicitudes de Ambientes
                </h2>
                <p class="text-gray-500 mt-1">
                    Administra y supervisa el historial de tus reservas de ambientes académicos.
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
        <div id="alert-container" class="fixed top-5 right-5 w-96 z-50"></div>

    </main>

    <script src="./src/crudController.js"></script>
    <script>
        document.getElementById('menuToggle').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('-translate-x-full');
        });

        document.querySelectorAll(".btn-cancelar").forEach((btn) => {
            btn.addEventListener("click", async function() {
                const id = this.dataset.id;

                if (!confirm("¿Seguro que deseas cancelar la solicitud?")) {
                    return;
                }

                await fetch("./src/controllers/cancelar.controller.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded",
                        },
                        body: `id=${id}`,
                    })
                    .then((res) => res.json())
                    .then((data) => {
                        if (data.success) {
                            mostrarAlerta("success", data.message);
                        } else {
                            mostrarAlerta("error", data.message);
                        }
                    });
            });
        });

        document.querySelectorAll(".btn-aceptar").forEach((btn) => {
            btn.addEventListener("click", function() {
                const id = this.dataset.id;

                if (!confirm("¿Seguro que deseas aceptar la solicitud?")) {
                    return;
                }

                fetch("./src/controllers/aprobar.controller.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded",
                        },
                        body: `id=${id}`,
                    })
                    .then((res) => res.json())
                    .then((data) => {
                        if (data.success) {
                            mostrarAlerta("success", data.message);
                        } else {
                            mostrarAlerta("error", data.message);
                        }
                    });
            });
        });
    </script>
</body>

</html>