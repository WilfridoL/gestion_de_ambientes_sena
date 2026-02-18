document.getElementById("formGenerico")
.addEventListener("submit", function(e){

    e.preventDefault();

    const formData = new FormData(this);

    fetch("./src/controllers/regestrarElementos.controller.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {

        if(data.success){
            alert(data.message);
            location.reload();
        } else {
            alert("Error: " + data.message);
        }

    });
});

function abrirModal(modo = "registrar", id = null) {

    const modal = document.getElementById("modalGenerico");
    const form  = document.getElementById("formGenerico");

    modal.classList.remove("hidden");
    form.reset();

    if (modo === "actualizar" && id) {

        // Cambiar acción
        form.querySelector("[name='accion']").value = "actualizar";
        form.querySelector("[name='idValor']").value = id;

        // Obtener tabla e idCampo desde inputs ocultos
        const tabla   = form.querySelector("[name='tabla']").value;
        const idCampo = form.querySelector("[name='idCampo']").value;

        const formData = new FormData();
        formData.append("accion", "obtener");
        formData.append("tabla", tabla);
        formData.append("idCampo", idCampo);
        formData.append("idValor", id);

        fetch("./src/controllers/regestrarElementos.controller.php", {
            method: "POST",
            body: formData
        })
        .then(res => res.json())
        .then(data => {

            if (data.success) {

                const registro = data.data;

                for (const key in registro) {
                    if (form[key]) {
                        form[key].value = registro[key];
                    }
                }

                document.getElementById("modalTitulo").innerText = "Actualizar Registro";

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

function cerrarModal(){
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
        body: formData
    })
    .then(response => response.json())
    .then(data => {

        if (data.success) {
            alert(data.message);
            location.reload(); // Recarga tabla
        } else {
            alert("Error: " + data.message);
        }

    })
    .catch(error => console.error(error));
}