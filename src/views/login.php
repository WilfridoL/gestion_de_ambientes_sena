<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Login | Sistema</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gradient-to-br from-blue-600 to-indigo-700 flex items-center justify-center p-4">

  <!-- Contenedor Login -->
  <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl p-8">

    <!-- Logo / Título -->
    <div class="text-center mb-6">
      <h1 class="text-2xl font-bold text-gray-800">Sistema de Gestión</h1>
      <p class="text-gray-500 text-sm mt-1">Inicia sesión para continuar</p>
    </div>

    <!-- Alertas dinámicas -->
    <div id="alert-container"></div>

    <!-- Formulario -->
    <form action="" method="POST" class="space-y-5" data-log>

      <!-- Usuario -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
          Correo
        </label>
        <input
          type="text"
          name="userEmail"
          required
          class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none transition"
          placeholder="Ingrese su correo electronico">
      </div>

      <!-- Contraseña -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
          Contraseña
        </label>
        <input
          type="password"
          name="userPass"
          required
          class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none transition"
          placeholder="Ingrese su contraseña">
      </div>

      <!-- Botón -->
      <button
        type="submit"
        class="w-full bg-blue-600 text-white py-2 rounded-lg font-semibold hover:bg-blue-700 transition shadow-md">
        Iniciar Sesión
      </button>

    </form>

    <!-- Footer -->
    <div class="mt-6 text-center text-xs text-gray-400">
      © <?= date("Y") ?> Sistema de Gestión
    </div>

  </div>
  <script>
    document.querySelector('[data-log]')
  .addEventListener('submit', async function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    await fetch("./src/controllers/log.controller.php", {
      method: "POST",
      body: formData,
    })
    .then((response) => response.json())
    .then((data) => {

      if (data.success) {
        mostrarAlerta('success', data.message);

        // redirigir después de 1.5 segundos
        setTimeout(() => {
          window.location.href = "dashboard";
        }, 800);

      } else {
        mostrarAlerta('error', data.message);
      }

    })
    .catch((error) => {
      console.error("Error:", error);
    });
});

function mostrarAlerta(tipo, mensaje) {

  const contenedor = document.getElementById("alert-container");

  contenedor.innerHTML = "";

  const color = tipo === "success"
    ? "bg-green-100 text-green-900"
    : "bg-red-100 text-red-900";

  contenedor.innerHTML = `
    <div class="border ${color} p-3 rounded-lg text-sm">
      ${mensaje}
    </div>
  `;
}
  </script>
</body>

</html>