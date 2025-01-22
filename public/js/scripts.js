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
    const url = "{{ route('encuestas.showsatisfaccion') }}";
    loadContent(url);
}

     function finalizarSatisfaccion() {
        const url = "{{ route('encuestas.showfactoressociales') }}";
        loadContent(url);
    }

       function guardarDatosRadioButtons(preguntaId, valorSeleccionado) {
        // Marcar el valor seleccionado en la lista de radio buttons
        $(`input[name="respuesta_${preguntaId}"]`).val([valorSeleccionado]);
        console.log("Pregunta ID: " + preguntaId + ", Valor seleccionado: " + valorSeleccionado);
        // Aquí puedes enviar el valor seleccionado al servidor o guardarlo localmente
    }
