// registrar solicitud
document.getElementById('regSolicitud').addEventListener('submit', function (e) {
    e.preventDefault()
    const formData = new FormData(this);
    // console.log(formData);
    
    fetch('./src/controllers/registrar.controller.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {

        if (data.success) {

            alert(data.message);

            cerrarModal();

            // 🔥 recargar tabla sin recargar página
            location.reload();

        } else {
            alert(data.message);
        }

    })
    .catch(error => {
        console.error("Error:", error);
    });

})

//cancelar solicitud
document.querySelectorAll('.btn-cancelar')
.forEach(btn => {

    btn.addEventListener('click', function() {

        const id = this.dataset.id;

        if (!confirm("¿Seguro que deseas cancelar la solicitud?")) {
            return;
        }

        fetch('./src/controllers/cancelar.controller.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `id=${id}`
        })
        .then(res => res.json())
        .then(data => {

            if (data.success) {
                alert(data.message);
                location.reload(); // o eliminar fila manualmente
            } else {
                alert("Error");
            }

        });

    });

});

document.querySelectorAll('.btn-aceptar')
.forEach(btn => {

    btn.addEventListener('click', function() {

        const id = this.dataset.id;

        if (!confirm("¿Seguro que deseas cancelar la solicitud?")) {
            return;
        }

        fetch('./src/controllers/aprobar.controller.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `id=${id}`
        })
        .then(res => res.json())
        .then(data => {

            if (data.success) {
                alert(data.message);
                location.reload(); // o eliminar fila manualmente
            } else {
                alert("Error");
            }

        });

    });

});

function abrirModal() {
    const modal = document.getElementById('modalSolicitud');
    modal.classList.remove('hidden');
}

function cerrarModal() {
    const modal = document.getElementById('modalSolicitud');
    modal.classList.add('hidden');
}