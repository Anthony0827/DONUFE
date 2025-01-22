
            var idcandidato = "{{ request()->query('idcandidato') }}";

    function guardarRespuestaYContinuar(url, preguntaId) {
        const respuestaSeleccionada = $(`#respuesta_${preguntaId}`).val();
        const ordenRespuestas = $("#sortable").sortable('toArray', { attribute: 'data-id' });

        const data = {
            _token: "{{ csrf_token() }}",
            ...respuestaSeleccionada && { respuestaSeleccionada },
            ...ordenRespuestas.length && { orden: ordenRespuestas }
        };

        $.post("{{ route('encuesta.guardarOrden', '') }}/" + preguntaId, data)
            .done(() => loadContent(url))
            .fail(xhr => console.error('Error al guardar la respuesta:', xhr.responseText));
    }
function guardarValorYContinuar(url, preguntaId) {
    const respuestaSeleccionada = $(`input[name="respuesta_${preguntaId}"]:checked`).val();
    const feedback = $(`#feedback_txt_${preguntaId}`).val(); // Actualiza el id del feedback

    const data = {
        _token: "{{ csrf_token() }}",
        respuestaSeleccionada,
        feedback // Incluye el feedback en los datos enviados
    };

    console.log("Datos enviados:", data); // Esto debe mostrar el feedback correctamente en la consola

    $.post("{{ route('encuesta.guardarRespuestaDirecta', '') }}/" + preguntaId, data)
        .done(() => loadContent(url))
        .fail(xhr => console.error('Error al guardar la respuesta:', xhr.responseText));
}




    function loadContent(url) {
        console.log("Loading content from URL:", url); // Para depuración

        fetch(url)
            .then(response => {
                if (!response.ok) {
                    console.error('Network response was not ok:', response.statusText);
                    throw new Error('Network response was not ok');
                }
                return response.text();
            })
            .then(data => {
                document.getElementById("content-container").innerHTML = data;
                const preguntaId = document.querySelector('#sortable')?.getAttribute('data-pregunta-id');
                if (preguntaId) {
                    initializeSortable(preguntaId); // Re-initialize sortable after content load
                }
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
                document.getElementById("content-container").innerHTML = '<p>Error al cargar el contenido. Inténtalo nuevamente.</p>';
            });
    }

  
function getDatosProductividad(element) {
    const tipo = element.id;
    $.get(`/productividad/${tipo}?idcandidato=${idcandidato}`, function (datos) {
        // Actualizar las columnas con los datos recibidos
    });
}

function registrarProductividad() {
    const url = "{{ route('productividad.store') }}"; // Ruta de almacenamiento
    const data = {
        idcandidato: document.querySelector('input[name="idcandidato"]').value,
        tipoRegistro: document.getElementById('tipoRegistro').value,
        tipoFlujo: document.getElementById('tipoFlujo').value,
        titulo: document.getElementById('titulo').value,
        texto: document.getElementById('texto').value,
        _token: '{{ csrf_token() }}' // Token CSRF
    };

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Token CSRF en encabezados
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






    function initializeSortable(preguntaId) {
        $("#sortable").sortable({
            update: function(event, ui) {
                const ordenRespuestas = $("#sortable").sortable('toArray', { attribute: 'data-id' });

                $.ajax({
                    url: "{{ route('encuesta.guardarOrden', '') }}/" + preguntaId,
                    type: "POST",
                    data: {
                        orden: ordenRespuestas,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.success) {
                            console.log('Orden guardado exitosamente.');
                        } else {
                            console.error('Error en la respuesta del servidor.');
                            alert('Error al guardar el orden de las respuestas.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al guardar el orden de las respuestas:', error);
                        console.log(xhr.responseText);  // Muestra la respuesta completa para diagnóstico
                        alert('Error al guardar el orden de las respuestas.');
                    }
                });
            }
        });
    }

    

    function continuar(encuestaId, preguntaNumero) {
        const url = "{{ route('encuesta.show', ['encuestaId' => ':encuestaId', 'preguntaNumero' => ':preguntaNumero']) }}"
            .replace(':encuestaId', encuestaId)
            .replace(':preguntaNumero', preguntaNumero);

        loadContent(url);
    }
function finalizarEncuesta() {
    const url = "{{ route('encuesta.showsatisfaccion', ['encuestaId' => 2, 'preguntaNumero' => 1]) }}";
    loadContent(url);

}


function finalizarSatisfaccion() {
    const url = "{{ route('encuesta.showfactoressociales', ['encuestaId' => 3, 'preguntaNumero' => 1]) }}";
    loadContent(url);
}

function finalizarFactoressociales() {
    const url = "{{ route('encuesta.showbournout', ['encuestaId' => 4, 'preguntaNumero' => 1]) }}";
    loadContent(url);
}

     function finalizarBournout() {
        const url = "{{ route('candidatos.feedback') }}";
        loadContent(url);
    }

       function guardarDatosRadioButtons(preguntaId, valorSeleccionado) {
        // Marcar el valor seleccionado en la lista de radio buttons
        $(`input[name="respuesta_${preguntaId}"]`).val([valorSeleccionado]);
        console.log("Pregunta ID: " + preguntaId + ", Valor seleccionado: " + valorSeleccionado);
        // Aquí puedes enviar el valor seleccionado al servidor o guardarlo localmente
    }



   function enviarFeedback(event) {
        event.preventDefault(); // Prevenir el envío del formulario estándar

        const url = "{{ route('feedback.store') }}"; // Ruta de almacenamiento
        const data = {
            motivo: document.getElementById('motivo').value,
            comentario: document.getElementById('comentario').value,
            _token: '{{ csrf_token() }}' // Token CSRF
        };

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Token CSRF
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
            // Mostrar el mensaje de éxito sin redirigir
            document.getElementById('success-message').style.display = 'block';
            document.getElementById('feedbackForm').reset(); // Limpiar formulario
        })
        .catch(error => {
            console.error('Hubo un problema con la operación fetch:', error);
        });
    }

    function hideSuccessMessage() {
        // Ocultar el mensaje de éxito y redirigir al inicio
        document.getElementById('success-message').style.display = 'none';
        window.location.href = "{{ route('candidatos.dashboard') }}"; // Redirige al inicio después de cerrar el mensaje
    }


  