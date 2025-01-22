document.addEventListener("DOMContentLoaded", function() {
    const guardarBtn = document.getElementById("guardar-productividad");
    if (guardarBtn) {
        guardarBtn.addEventListener("click", registrarProductividad);
    }
});

function registrarProductividad(event) {
    event.preventDefault();

    // Ruta de almacenamiento
    const url = routes.productividadStore;

    // Recopilar los datos del formulario
    const data = {
        tipoRegistro: document.getElementById('tipoRegistro').value,
        tipoFlujo: document.getElementById('tipoFlujo').value,
        titulo: document.getElementById('titulo').value,
        texto: document.getElementById('texto').value,
        _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Obtener el token CSRF
    };

    // Enviar los datos al controlador mediante fetch
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Token CSRF en encabezados
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error en la respuesta de la red');
        }
        return response.json();
    })
    .then(data => {
        if (data.status === 'CREADO') {
            alert('Tarea creada con éxito');
            document.getElementById('form-productividad').reset(); // Limpiar formulario
        }
    })
    .catch(error => {
        console.error('Hubo un problema con la operación fetch:', error);
    });
}
