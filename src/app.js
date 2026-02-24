// registrar solicitud
document
  .getElementById("regSolicitud")
  .addEventListener("submit", function (e) {
    e.preventDefault();
    const formData = new FormData(this);
    // console.log(formData);

    fetch("./src/controllers/registrar.controller.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        // console.log(data);
        if (data.success) {
          cerrarModal();
          mostrarAlerta("success", data.message);
        } else {
          cerrarModal();

          mostrarAlerta("error", data.message);
        }
      })
      .catch((error) => {
        console.error("Error:", error);
      });
  });

//cancelar solicitud
document.querySelectorAll(".btn-cancelar").forEach((btn) => {
  btn.addEventListener("click", async function () {
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
  btn.addEventListener("click", function () {
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

function abrirModal() {
  const modal = document.getElementById("modalSolicitud");
  modal.classList.remove("hidden");
}

function cerrarModal() {
  const modal = document.getElementById("modalSolicitud");
  modal.classList.add("hidden");
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
