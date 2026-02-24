document
  .getElementById("formGenerico")
  .addEventListener("submit", function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch("./src/controllers/regestrarElementos.controller.php", {
      method: "POST",
      body: formData,
    })
      .then((res) => res.json())
      .then((data) => {
        if (data.success) {
          cerrarModal();
          mostrarAlerta("success", data.message);
        } else {
          cerrarModal();

          mostrarAlerta("error", data.message);
        }
      });
  });

function abrirModal(modo = "registrar", id = null) {
  const modal = document.getElementById("modalGenerico");
  const form = document.getElementById("formGenerico");

  modal.classList.remove("hidden");
  form.reset();

  if (modo === "actualizar" && id) {
    // Cambiar acción
    form.querySelector("[name='accion']").value = "actualizar";
    form.querySelector("[name='idValor']").value = id;

    // Obtener tabla e idCampo desde inputs ocultos
    const tabla = form.querySelector("[name='tabla']").value;
    const idCampo = form.querySelector("[name='idCampo']").value;

    const formData = new FormData();
    formData.append("accion", "obtener");
    formData.append("tabla", tabla);
    formData.append("idCampo", idCampo);
    formData.append("idValor", id);

    fetch("./src/controllers/regestrarElementos.controller.php", {
      method: "POST",
      body: formData,
    })
      .then((res) => res.json())
      .then((data) => {
        if (data.success) {
          const registro = data.data;

          for (const key in registro) {
            if (form[key]) {
              form[key].value = registro[key];
            }
          }

          document.getElementById("modalTitulo").innerText =
            "Actualizar Registro";
        } else {
          alert("Error al obtener datos");
        }
      });
  } else {
    form.querySelector("[name='accion']").value = "registrar";
    form.querySelector("[name='idValor']").value = "";
    // document.getElementById("modalTitulo").innerText = "Registrar Registro";
  }
}

function cerrarModal() {
  document.getElementById("modalGenerico").classList.add("hidden");
}
function eliminarRegistro(id, tabla, nomCamp) {
  if (!confirm("¿Seguro que deseas eliminar?")) return;
  const formData = new FormData();
  formData.append("accion", "eliminar");
  formData.append("tabla", tabla);
  formData.append("idCampo", nomCamp);
  formData.append("idValor", id);

  fetch("./src/controllers/regestrarElementos.controller.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        cerrarModal();
        mostrarAlerta("success", data.message);
      } else {
        cerrarModal();

        mostrarAlerta("error", data.message);
      }
    })
    .catch((error) => console.error(error));
}

function mostrarAlerta(tipo, mensaje) {
  const contenedor = document.getElementById("alert-container");

  const colorClase =
    tipo === "success"
      ? "bg-green-100 text-green-900"
      : "bg-red-100 text-red-900";

  const icono =
    tipo === "success"
      ? `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="mt-0.5 size-4">
            <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14Zm3.844-8.791a.75.75 0 0 0-1.188-.918l-3.7 4.79-1.649-1.833a.75.75 0 1 0-1.114 1.004l2.25 2.5a.75.75 0 0 0 1.15-.043l4.25-5.5Z" clip-rule="evenodd"></path>
           </svg>`
      : `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="mt-0.5 size-4">
            <path fill-rule="evenodd" d="M6.701 2.25c.577-1 2.02-1 2.598 0l5.196 9a1.5 1.5 0 0 1-1.299 2.25H2.804a1.5 1.5 0 0 1-1.3-2.25l5.197-9ZM8 4a.75.75 0 0 1 .75.75v3a.75.75 0 1 1-1.5 0v-3A.75.75 0 0 1 8 4Zm0 8a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd"></path>
           </svg>`;

  const alerta = document.createElement("div");

  alerta.innerHTML = `
        <div role="alert" class="border-2 ${colorClase} p-4 shadow-[4px_4px_0_0] mb-4 transition-opacity duration-500">
            <div class="flex items-start gap-3">
                ${icono}
                <strong class="block flex-1 leading-tight font-semibold">
                    ${mensaje}
                </strong>
            </div>
        </div>
    `;

  contenedor.appendChild(alerta);

  // desaparecer después de 3 segundos
  setTimeout(() => {
    alerta.style.opacity = "0";
    setTimeout(() => alerta.remove(), 500);
    if (tipo === "success") location.reload();
  }, 2000);
}
