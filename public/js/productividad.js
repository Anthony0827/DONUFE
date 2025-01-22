   




function getDatosProductividad(element) {
    const tipo = element.id.toLowerCase(); // Obtener el tipo de flujo (BACKLOG, PLANIFICADA, etc.)
    const columna = document.getElementById(`col-${tipo}`);
    const idCandidato = document.querySelector('input[name="idcandidato"]').value;
    const url = `/productividad/${tipo.toUpperCase()}?idcandidato=${idCandidato}`;

    // Limpiar la columna antes de agregar nuevos datos
    columna.innerHTML = '';

    // Hacer la solicitud AJAX para obtener los datos
    $.get(url)
        .done(function(datos) {
            // Si los datos existen, renderízalos en la columna
            if (datos.length > 0) {
                datos.forEach(dato => {
                    const tarea = document.createElement('div');
                    tarea.className = 'tarea p-2 mb-2 bg-white rounded shadow';
                    tarea.innerHTML = `
                        <h4 class="text-lg font-semibold">${dato.titulo}</h4>
                        <p class="text-sm text-gray-600">${dato.mensaje}</p>
                    `;
                    columna.appendChild(tarea);
                });
            } else {
                // Si no hay datos, muestra un mensaje indicando que no hay tareas
                const sinDatos = document.createElement('p');
                sinDatos.className = 'text-gray-500 text-center';
                sinDatos.innerText = 'No hay tareas en esta categoría.';
                columna.appendChild(sinDatos);
            }
        })
        .fail(function() {
            // Si ocurre un error, muestra un mensaje en la columna correspondiente
            const errorMensaje = document.createElement('p');
            errorMensaje.className = 'text-red-500 text-center font-semibold';
            errorMensaje.innerText = 'Error al cargar las tareas. Intenta de nuevo más tarde.';
            columna.appendChild(errorMensaje);
        });
}

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

    // Recopilar los datos del formulario, sin idcandidato, ya que se obtiene del usuario autenticado en el servidor
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
        } else {
            console.error('Error en la creación de la tarea:', data.message);
        }
    })
    .catch(error => {
        console.error('Hubo un problema con la operación fetch:', error);
    });
}



    


 
