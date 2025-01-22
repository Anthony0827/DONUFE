<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'KULTURE TEAM')</title>
    <!-- Bootstrap CSS -->
   
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/output.css') }}">


<style>
        /* Sobrescribir el pseudo-elemento ::before */
        *::before {
            content: none !important;
        }

    /* Estilos para las prioridades */
    .border-red-500 {
        border: 2px solid red;
    }

    .border-blue-500 {
        border: 2px solid blue;
    }

    .border-green-500 {
        border: 2px solid lightgreen;
    }

    /* Sombreado para el título de la tarea */
  
</style>
</head>

  @if(empty($hideMenuAndNavbar))
    <nav class="relative flex items-center justify-between h-20 px-4 bg-white shadow-md fixed w-full top-0 z-50">
        <!-- Logo -->
        <a href="#">
            <img src="{{ asset('images/logo_vertical_color.png') }}" alt="Logotipo de Kulture" class="h-12">
        </a>
        <!-- Main title text -->
        <h1 class="absolute hidden text-3xl left-24 text-kulture-color-cuatro md:block">Candidatos</h1>
        <!-- Hamburger button -->
        <button id="menu-btn" class="relative block mr-4 hamburger md:hidden focus:outline-none">
            <span class="absolute top-0 left-0 bg-kulture-color-cuatro hamburger-top"></span>
            <span class="absolute top-0 left-0 bg-kulture-color-cuatro hamburger-middle"></span>
            <span class="absolute top-0 left-0 bg-kulture-color-cuatro hamburger-bottom"></span>
        </button>
        <!-- User panel -->
        <div class="hidden md:block">
            <div class="flex items-center">
                <a href="#">
                    <i class="text-3xl text-gray-400 transition-all duration-300 hover:text-kulture-color-cuatro bi bi-grid mr-9"></i>
                </a>
            </div>
        </div>
      <!-- Dropdown de perfil -->
    <div class="flex items-center space-x-4">
        <div class="relative">
            <div class="flex items-center cursor-pointer" id="userMenuToggle">
                @if(Auth::user() && Auth::user()->archivocv)
                    <img src="{{ asset('storage/' . Auth::user()->archivocv) }}" alt="Foto de perfil" class="w-8 h-8 rounded-full border-2 border-gray-300 shadow">
                @else
                    <img src="{{ asset('images/default-profile.png') }}" alt="Foto de perfil por defecto" class="w-8 h-8 rounded-full border-2 border-gray-300 shadow">
                @endif
                <span class="ml-3 text-lg font-semibold text-kulture-color-cuatro">{{ Auth::user()->nombres }}</span>

            </div>
            <!-- Opciones del menú desplegable -->
            <div class="absolute right-0 mt-2 w-48 bg-white text-black shadow-lg rounded-lg py-2 hidden" id="userMenuDropdown">
                <a href="{{ route('candidatos.inicio') }}" class="block px-4 py-2 hover:bg-kulture-color-cuatro hover:text-white rounded">
                    Ir al inicio
                </a>
                <form method="GET" action="{{ route('usuarios.logout') }}" class="block">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 hover:bg-kulture-color-cuatro hover:text-white rounded">
                        Cerrar sesión
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
<script>
    document.getElementById('userMenuToggle').addEventListener('click', function() {
        const dropdown = document.getElementById('userMenuDropdown');
        dropdown.classList.toggle('hidden');
    });
</script>
    @endif

<body>

@section('content')
<!-- Contenedor principal -->
<div class="flex h-screen bg-gray-100">
    <!-- Menú lateral -->
  <div class="flex h-screen bg-gray-100">
    <!-- Menú lateral -->
    <nav id="tbl_menu_central" class="fixed bg-gray-100 w-52 h-full rounded-tl-4xl">
        <ul class="flex flex-col items-center px-2 pt-8 space-y-8 text-gray-400">
            <li>
                <a id="tdp1" href="#" class="menu-item text-gray-600 hover:text-blue-500 transition-all duration-200"
                    onclick="loadContent('{{ route('candidatos.home') }}')">
                    Instrucciones
                </a>
            </li>
            <li class="text-center">
                <a id="tdp5" href="#" class="menu-item text-gray-600 hover:text-blue-500 transition-all duration-200"
                    onclick="loadContent('{{ route('candidatos.edit', ['idcandidato' => Auth::user()->idcandidato]) }}')">
                    Datos personales
                </a>
            </li>
            <li class="text-center">
                <a id="tdp2" href="#" class="menu-item text-gray-600 hover:text-blue-500 transition-all duration-200"
                    onclick="loadContent('{{ route('encuesta.show', ['encuestaId' => 1, 'preguntaNumero' => 1]) }}')">
                    Análisis cultural
                </a>
            </li>
            <li>
                <a id="tdp32" href="#" class="menu-item text-gray-600 hover:text-blue-500 transition-all duration-200"
                    onclick="loadContent('{{ route('encuesta.showsatisfaccion', ['encuestaId' => 2, 'preguntaNumero' => 1]) }}')">
                    Satisfacción laboral
                </a>
            </li>
            <li>
                <a id="tdp33" href="#" class="menu-item text-gray-600 hover:text-blue-500 transition-all duration-200"
                    onclick="loadContent('{{ route('encuesta.showfactoressociales', ['encuestaId' => 3, 'preguntaNumero' => 1]) }}')">
                    Factores sociales
                </a>
            </li>
            <li>
                <a id="tdp38" href="#" class="menu-item text-gray-600 hover:text-blue-500 transition-all duration-200"
                    onclick="loadContent('{{ route('encuesta.showbournout', ['encuestaId' => 4, 'preguntaNumero' => 1]) }}')">
                    Burnout
                </a>
            </li>
            <li>
                <a id="tdp36" href="#" class="menu-item text-gray-600 hover:text-blue-500 transition-all duration-200"
                    onclick="loadContent('{{ route('candidatos.feedback') }}')">
                    Feedback
                </a>
            </li>
            <li>
                <a id="tdp44" href="#" class="menu-item text-gray-600 hover:text-blue-500 transition-all duration-200"
                    onclick="loadContent('{{ route('tablero.index') }}')">
                    Tablero
                </a>
            </li>
        </ul>
    </nav>
</div>

    <!-- Contenido dinámico -->
    <main class="flex-1 bg-white p-8 overflow-auto ml-52" id="content-container" style="margin-top: 0; height: 100vh;">
        @yield('content') <!-- Asegúrate de que esta línea esté presente -->
    </main>
</div>

<!-- jQuery y jQuery UI -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">


<script>



// funcion para analisis cultural guardar respuestas ordenables.

     const idCandidato = "{{ Auth::user()->idcandidato ?? '' }}"; // Define idCandidato desde el usuario autenticado
    console.log("idCandidato desde Blade:", idCandidato); // Verifica que tenga un valor en la consola
function guardarRespuestaYContinuar(url, preguntaId) {
    const respuestaSeleccionada = $(`#respuesta_${preguntaId}`).val();
    const ordenRespuestas = $("#sortable").sortable('toArray', { attribute: 'data-id' });

    const data = {
        _token: "{{ csrf_token() }}",
        idCandidato, // Incluye el idCandidato en los datos
        ...respuestaSeleccionada && { respuestaSeleccionada },
        ...ordenRespuestas.length && { orden: ordenRespuestas }
    };

    $.post("{{ route('encuesta.guardarOrden', '') }}/" + preguntaId, data)
        .done(() => loadContent(url))
        .fail(xhr => console.error('Error al guardar la respuesta:', xhr.responseText));
}



// funcion para satisfaccion,bournout, factores seleccionar emojis y feedback..

function guardarValorYContinuar(url, preguntaId) {
    const respuestaSeleccionada = $(`input[name="respuesta_${preguntaId}"]:checked`).val();
    const feedback = $(`#feedback_txt_${preguntaId}`).val(); // Actualiza el id del feedback

    const data = {
        _token: "{{ csrf_token() }}",
        idCandidato, // Incluye el idCandidato en los datos
        respuestaSeleccionada,
        feedback // Incluye el feedback en los datos enviados
    };

    console.log("Datos enviados:", data); // Esto debe mostrar el feedback y el idCandidato correctamente en la consola

    $.post("{{ route('encuesta.guardarRespuestaDirecta', '') }}/" + preguntaId, data)
        .done(() => loadContent(url))
        .fail(xhr => console.error('Error al guardar la respuesta:', xhr.responseText));
}



// carga de todas las funciones dinamicas

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
            
            // Inicializar de nuevo el arrastrar y soltar
            initializeDragAndDrop(); 

            const preguntaId = document.querySelector('#sortable')?.getAttribute('data-pregunta-id');
            if (preguntaId) {
                initializeSortable(preguntaId); // Re-inicializa sortable después de cargar el contenido
            }

            // Inicializar el popup/modal
            initializePopup();
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
            document.getElementById("content-container").innerHTML = '<p>Error al cargar el contenido. Inténtalo nuevamente.</p>';
        });
}

 document.querySelectorAll('.menu-item').forEach(item => {
        item.addEventListener('click', function() {
            document.querySelectorAll('.menu-item').forEach(link => {
                link.classList.remove('text-kulture-color-cuatro', 'font-bold');
                link.classList.add('text-gray-600');
            });
            this.classList.add('text-kulture-color-cuatro', 'font-bold');
            this.classList.remove('text-gray-600');
        });
    });
// Función para inicializar el popup
function initializePopup() {
    const modal = document.getElementById('popupModal');
    const closeButton = document.getElementById('closeModalButton');

    if (modal) {
        modal.classList.remove('hidden'); // Mostrar el modal
    } else {
        console.warn("El modal con id 'popupModal' no se encontró en el contenido cargado.");
    }

    if (closeButton) {
        closeButton.addEventListener('click', () => {
            modal.classList.add('hidden'); // Ocultar el modal al hacer clic en el botón
        });
    } else {
        console.warn("El botón con id 'closeModalButton' no se encontró en el contenido cargado.");
    }
}

function updateMenuState(activeItemId) {
    document.querySelectorAll('.menu-item').forEach(link => {
        link.classList.remove('text-kulture-color-cuatro', 'font-bold');
        link.classList.add('text-gray-600');
    });
    const activeItem = document.querySelector(activeItemId);
    if (activeItem) {
        activeItem.classList.add('text-kulture-color-cuatro', 'font-bold');
        activeItem.classList.remove('text-gray-600');
    }
}

// registro de nueva tarea en el tablero

function registrarProductividad(event) {
    event.preventDefault();

    // Ruta de almacenamiento obtenida directamente desde Laravel
    const url = "{{ route('productividad.store') }}";

    // Recopilar los datos del formulario
    const data = {
        tipoRegistro: document.getElementById('tipoRegistro').value,
        tipoFlujo: document.getElementById('tipoFlujo').value,
        titulo: document.getElementById('titulo').value,
        texto: document.getElementById('texto').value,
        prioridad: document.getElementById('prioridad').value, // Añadir prioridad
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

            // Cerrar el modal usando Bootstrap
            const modal = bootstrap.Modal.getInstance(document.getElementById('modal-dinamico'));
            modal.hide();

            // Cargar nuevamente el contenido del tablero
            loadContent("{{ route('tablero.index') }}");  // Esto recargará el tablero con la nueva tarea
        } else {
            console.error('Error en la creación de la tarea:', data.message);
        }
    })
    .catch(error => {
        console.error('Hubo un problema con la operación fetch:', error);
    });
}


// inicio de ordenamiento de tareas en el tablero


function initializeDragAndDrop() {
    const tareas = document.querySelectorAll('.tarea'); // Seleccionar todas las tareas
    const columnas = document.querySelectorAll('.columna'); // Seleccionar todas las columnas

    // Verifica cuántas tareas se han encontrado en el DOM
    console.log('Tareas a inicializar:', tareas.length);

    if (tareas.length === 0) {
        console.warn('No se encontraron tareas para inicializar.');
    }

    // Asignar eventos de arrastre a las tareas
    tareas.forEach(tarea => {
        tarea.setAttribute('draggable', true); // Permitir que las tareas sean arrastrables
        tarea.removeEventListener('dragstart', dragStart); // Evita duplicar eventos
        tarea.addEventListener('dragstart', dragStart); // Agrega evento
    });

    // Asignar eventos de soltado a las columnas
    columnas.forEach(columna => {
        columna.removeEventListener('dragover', dragOver); // Evita duplicar eventos
        columna.removeEventListener('drop', drop); // Evita duplicar eventos
        columna.addEventListener('dragover', dragOver); // Agrega evento al arrastrar
        columna.addEventListener('drop', drop); // Agrega evento al soltar
    });
}

function dragStart(event) {
    event.dataTransfer.setData('text/plain', event.target.id);
    console.log('Drag iniciado para la tarea:', event.target.id); // Añadir log para verificar
}

function dragOver(event) {
    event.preventDefault();
}

function drop(event) {
    event.preventDefault();
    const tareaId = event.dataTransfer.getData('text/plain'); // ID de la tarea arrastrada
    const tarea = document.getElementById(tareaId); // Elemento de la tarea
    const columna = event.target.closest('.columna'); // Columna de destino

    if (columna) {
        const flujo = columna.getAttribute('data-flujo'); // Obtiene el flujo de la columna
        moverTarea(tareaId, flujo); // Actualiza el flujo en el backend

        // Mueve la tarea al DOM
        const tareasContainer = columna.querySelector('.tareas');
        tareasContainer.appendChild(tarea);

        // Elimina el mensaje "No hay tareas" si existe
        const mensajeVacio = tareasContainer.querySelector('.mensaje-vacio');
        if (mensajeVacio) mensajeVacio.remove();

        // Verifica si la columna de origen quedó vacía y agrega el mensaje
        const columnaOrigen = document.getElementById(tareaId).closest('.tareas');
        if (columnaOrigen && columnaOrigen.children.length === 0) {
            const mensaje = document.createElement('p');
            mensaje.className = 'mensaje-vacio text-center text-gray-400';
            mensaje.textContent = 'No hay tareas en esta categoría.';
            columnaOrigen.appendChild(mensaje);
        }
    }
}


// Actualiza el flujo en el tablero
function moverTarea(id, flujo) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    // Limpia el prefijo "tarea-" del ID
    const cleanId = id.replace('tarea-', '');

    fetch('{{ route('productividad.mover') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
        },
        body: JSON.stringify({
            id: cleanId, // ID limpio
            flujo: flujo, // Flujo al que se mueve la tarea
        }),
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'ACTUALIZADO') {
                console.log('Tarea movida exitosamente:', data);

                // Elimina el mensaje "No hay tareas" de la columna destino
                const columnaDestino = document.querySelector(`.columna[data-flujo="${flujo}"]`);
                if (columnaDestino) {
                    const mensajeVacio = columnaDestino.querySelector('.mensaje-vacio');
                    if (mensajeVacio) mensajeVacio.remove();
                }
            } else {
                console.error('Error al mover tarea:', data.message);
            }
        })
        .catch(error => console.error('Error al mover tarea:', error));
}


// Función para cargar tareas de productividad

function getDatosProductividad(element) {
    const tipo = element.id.toLowerCase();
    const columna = document.getElementById(`col-${tipo}`); // Asegúrate de que el id sea correcto
    const idCandidato = document.querySelector('input[name="idcandidato"]').value;

    fetch(`/productividad/${tipo.toUpperCase()}?idcandidato=${idCandidato}`)
        .then(response => response.json())
        .then(datos => {
            columna.innerHTML = ''; // Limpia las tareas anteriores
            if (datos.length > 0) {
                datos.forEach(dato => {
                    const tarea = document.createElement('div');
                    tarea.className = 'tarea p-2 mb-2 bg-white rounded shadow';
                    tarea.id = `tarea-${dato.id}`;
                    tarea.setAttribute('draggable', true);
                    tarea.innerHTML = `
                        <h4 class="font-semibold text-gray-700">${dato.titulo}</h4>
                        <p class="text-gray-500">${dato.mensaje}</p>
                    `;
                    columna.appendChild(tarea);
                    console.log(`Tarea añadida: ${tarea.id}`); // Verifica que se ha añadido la tarea
                });

                // Verifica cuántas tareas fueron añadidas
                console.log('Tareas cargadas:', columna.querySelectorAll('.tarea').length); // Verificar tareas añadidas

                // Reasigna eventos drag and drop después de agregar tareas dinámicamente
                initializeDragAndDrop();
            } else {
                columna.innerHTML = '<p>No hay tareas en esta categoría.</p>';
            }
        })
        .catch(error => console.error('Error al cargar tareas:', error));
}


    // Cargar datos automáticamente al cargar la página
  


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


    // Función para continuar en la encuesta

    function continuar(encuestaId, preguntaNumero) {
        const url = "{{ route('encuesta.show', ['encuestaId' => ':encuestaId', 'preguntaNumero' => ':preguntaNumero']) }}"
            .replace(':encuestaId', encuestaId)
            .replace(':preguntaNumero', preguntaNumero);
            updateMenuState('#tdp2'); // Cambia el ID al correspondiente para la nueva vista

        loadContent(url);
    }
function finalizarEncuesta(preguntaId,idCandidato) {
    const url = "{{ route('encuesta.showsatisfaccion', ['encuestaId' => 2, 'preguntaNumero' => 1]) }}";

    // Obtener los datos de la última pregunta
    const respuestaSeleccionada = $(`#respuesta_${preguntaId}`).val();
    const ordenRespuestas = $("#sortable").sortable('toArray', { attribute: 'data-id' });

    const data = {
        _token: "{{ csrf_token() }}",
        idCandidato, // Incluye el idCandidato en los datos
        ...respuestaSeleccionada && { respuestaSeleccionada },
        ...ordenRespuestas.length && { orden: ordenRespuestas }
    };

    console.log("Datos enviados al guardar y finalizar:", data);

    // Realiza la solicitud para guardar la última respuesta
    $.post("{{ route('encuesta.guardarOrden', '') }}/" + preguntaId, data)
        .done(() => {
            console.log("Última respuesta guardada exitosamente. Redirigiendo a la siguiente vista...");

            // Actualizar el menú lateral
            updateMenuState('#tdp32'); // Cambia el ID al correspondiente para la nueva vista

            // Carga la siguiente vista después de guardar
            loadContent(url);
        })
        .fail(xhr => {
            console.error('Error al guardar la última respuesta:', xhr.responseText);
            alert('Hubo un problema al guardar tu respuesta. Por favor, intenta nuevamente.');
        });
}

function finalizarSatisfaccion(preguntaId,idCandidato) {
    // Verifica que `preguntaId` sea válido
    if (!preguntaId || preguntaId <= 0) {
        console.error("Error: preguntaId no está definido o es inválido.");
        alert("No se puede finalizar porque la pregunta no está definida.");
        return;
    }

    const url = "{{ route('encuesta.showfactoressociales', ['encuestaId' => 3, 'preguntaNumero' => 1]) }}";

    // Obtener la respuesta seleccionada
    const respuestaSeleccionada = $(`input[name="respuesta_${preguntaId}"]:checked`).val();
    const feedback = $(`#feedback_txt_${preguntaId}`).val() || null;

    // Validar que exista una respuesta seleccionada
    if (!respuestaSeleccionada) {
        console.error(`Error: No se seleccionó ninguna respuesta para la pregunta ${preguntaId}.`);
        alert("Por favor, selecciona una respuesta antes de continuar.");
        return;
    }

    const data = {
        _token: "{{ csrf_token() }}",
        idCandidato,
        respuestaSeleccionada,
        feedback
    };

    console.log("Datos enviados al guardar la última respuesta:", data);

    // Enviar los datos al servidor
    $.post("{{ route('encuesta.guardarRespuestaDirecta', '') }}/" + preguntaId, data)
        .done(() => {
            console.log("Última respuesta guardada exitosamente. Redirigiendo...");

            // Marcar satisfaccion_laboral_completado y verificar test_completado
            $.post("{{ route('encuesta.finalizarSatisfaccion', ['preguntaId' => ':preguntaId', 'idCandidato' => ':idCandidato']) }}".replace(':preguntaId', preguntaId).replace(':idCandidato', idCandidato), {
                _token: "{{ csrf_token() }}"
            }).done(() => {
                // Cambiar el color del enlace Satisfacción Laboral
                updateMenuState('#tdp33'); // Cambia el ID al correspondiente para la nueva vista

                // Redirigir al contenido
                loadContent(url);
            }).fail(xhr => {
                console.error("Error al finalizar la encuesta:", xhr.responseText);
                alert("Hubo un problema al finalizar la encuesta.");
            });
        })
        .fail(xhr => {
            console.error("Error al guardar la última respuesta:", xhr.responseText);
            alert("Hubo un problema al guardar tu respuesta.");
        });
}

function finalizarSatisfaccion(preguntaId, idCandidato) {
    if (!idCandidato) {
        console.error("Error: El parámetro idCandidato no está definido.");
        alert("Hubo un problema al obtener el ID del candidato.");
        return;
    }

    const url = "{{ route('encuesta.showfactoressociales', ['encuestaId' => 3, 'preguntaNumero' => 1]) }}";

    // Obtener la respuesta seleccionada
    const respuestaSeleccionada = $(`input[name="respuesta_${preguntaId}"]:checked`).val();
    const feedback = $(`#feedback_txt_${preguntaId}`).val() || null;

    if (!respuestaSeleccionada) {
        alert("Por favor, selecciona una respuesta antes de continuar.");
        return;
    }

    const data = {
        _token: "{{ csrf_token() }}",
        idCandidato,
        respuestaSeleccionada,
        feedback
    };

    console.log("Datos enviados:", data);

    $.post("{{ route('encuesta.guardarRespuestaDirecta', '') }}/" + preguntaId, data)
        .done(() => {
            console.log("Última respuesta guardada exitosamente. Redirigiendo...");

            // Marcar satisfaccion_laboral_completado y verificar test_completado
            $.post("{{ route('encuesta.finalizarSatisfaccion', ['preguntaId' => ':preguntaId', 'idCandidato' => ':idCandidato']) }}".replace(':preguntaId', preguntaId).replace(':idCandidato', idCandidato), {
                _token: "{{ csrf_token() }}"
            }).done(() => {
                // Cambiar el color del enlace Satisfacción Laboral
                updateMenuState('#tdp33'); // Cambia el ID al correspondiente para la nueva vista

                // Redirigir al contenido
                loadContent(url);
            }).fail(xhr => {
                console.error("Error al finalizar la encuesta:", xhr.responseText);
                alert("Hubo un problema al finalizar la encuesta.");
            });
        })
        .fail(xhr => {
            console.error("Error al guardar la última respuesta:", xhr.responseText);
            alert("Hubo un problema al guardar tu respuesta.");
        });
}

function finalizarFactoressociales(preguntaId) {
    // Verifica que `preguntaId` sea válido
    if (!preguntaId || preguntaId <= 0) {
        console.error("Error: preguntaId no está definido o es inválido.");
        alert("No se puede finalizar porque la pregunta no está definida.");
        return;
    }

    const url = "{{ route('encuesta.showbournout', ['encuestaId' => 4, 'preguntaNumero' => 1]) }}";

    // Obtener la respuesta seleccionada
    const respuestaSeleccionada = $(`input[name="respuesta_${preguntaId}"]:checked`).val();
    const feedback = $(`#feedback_txt_${preguntaId}`).val() || null;

    // Validar que exista una respuesta seleccionada
    if (!respuestaSeleccionada) {
        console.error(`Error: No se seleccionó ninguna respuesta para la pregunta ${preguntaId}.`);
        alert("Por favor, selecciona una respuesta antes de continuar.");
        return;
    }

    const data = {
        _token: "{{ csrf_token() }}",
        idCandidato,
        respuestaSeleccionada,
        feedback
    };

    console.log("Datos enviados al guardar la última respuesta:", data);

    // Enviar los datos al servidor
    $.post("{{ route('encuesta.guardarRespuestaDirecta', '') }}/" + preguntaId, data)
        .done(() => {
            console.log("Última respuesta guardada exitosamente. Redirigiendo...");

            // Marcar factores_sociales_completado y verificar test_completado
            $.post("{{ route('encuesta.finalizarFactoressociales', ['preguntaId' => ':preguntaId', 'idCandidato' => ':idCandidato']) }}".replace(':preguntaId', preguntaId).replace(':idCandidato', idCandidato), {
                _token: "{{ csrf_token() }}"
            }).done(() => {
                // Cambiar el color del enlace Factores Sociales
                updateMenuState('#tdp38'); // Cambia el ID al correspondiente para la nueva vista

                // Redirigir al contenido
                loadContent(url);
            }).fail(xhr => {
                console.error("Error al finalizar la encuesta:", xhr.responseText);
                alert("Hubo un problema al finalizar la encuesta.");
            });
        })
        .fail(xhr => {
            console.error("Error al guardar la última respuesta:", xhr.responseText);
            alert("Hubo un problema al guardar tu respuesta.");
        });
}

function finalizarFactoressociales(preguntaId, idCandidato) {
    if (!idCandidato) {
        console.error("Error: El parámetro idCandidato no está definido.");
        alert("Hubo un problema al obtener el ID del candidato.");
        return;
    }

    const url = "{{ route('encuesta.showbournout', ['encuestaId' => 4, 'preguntaNumero' => 1]) }}";

    // Obtener la respuesta seleccionada
    const respuestaSeleccionada = $(`input[name="respuesta_${preguntaId}"]:checked`).val();
    const feedback = $(`#feedback_txt_${preguntaId}`).val() || null;

    if (!respuestaSeleccionada) {
        alert("Por favor, selecciona una respuesta antes de continuar.");
        return;
    }

    const data = {
        _token: "{{ csrf_token() }}",
        idCandidato,
        respuestaSeleccionada,
        feedback
    };

    console.log("Datos enviados:", data);

    $.post("{{ route('encuesta.guardarRespuestaDirecta', '') }}/" + preguntaId, data)
        .done(() => {
            console.log("Última respuesta guardada exitosamente. Redirigiendo...");

            // Marcar factores_sociales_completado y verificar test_completado
            $.post("{{ route('encuesta.finalizarFactoressociales', ['preguntaId' => ':preguntaId', 'idCandidato' => ':idCandidato']) }}".replace(':preguntaId', preguntaId).replace(':idCandidato', idCandidato), {
                _token: "{{ csrf_token() }}"
            }).done(() => {
                // Cambiar el color del enlace Factores Sociales
                updateMenuState('#tdp38'); // Cambia el ID al correspondiente para la nueva vista

                // Redirigir al contenido
                loadContent(url);
            }).fail(xhr => {
                console.error("Error al finalizar la encuesta:", xhr.responseText);
                alert("Hubo un problema al finalizar la encuesta.");
            });
        })
        .fail(xhr => {
            console.error("Error al guardar la última respuesta:", xhr.responseText);
            alert("Hubo un problema al guardar tu respuesta.");
        });
}


function finalizarBournout(preguntaId, idCandidato) {
    if (!idCandidato) {
        console.error("Error: El parámetro idCandidato no está definido.");
        alert("Hubo un problema al obtener el ID del candidato.");
        return;
    }

    const url = "{{ route('candidatos.edit', ':idcandidato') }}".replace(':idcandidato', idCandidato);

    // Obtener la respuesta seleccionada
    const respuestaSeleccionada = $(`input[name="respuesta_${preguntaId}"]:checked`).val();
    const feedback = $(`#feedback_txt_${preguntaId}`).val() || null;

    if (!respuestaSeleccionada) {
        alert("Por favor, selecciona una respuesta antes de continuar.");
        return;
    }

    const data = {
        _token: "{{ csrf_token() }}",
        idCandidato,
        respuestaSeleccionada,
        feedback
    };

    console.log("Datos enviados:", data);

    $.post("{{ route('encuesta.guardarRespuestaDirecta', '') }}/" + preguntaId, data)
        .done(() => {
            console.log("Última respuesta guardada exitosamente. Redirigiendo...");

            // Marcar bournout_completado y test_completado como 1
            $.post("{{ route('encuesta.finalizarBournout', ['preguntaId' => ':preguntaId', 'idCandidato' => ':idCandidato']) }}".replace(':preguntaId', preguntaId).replace(':idCandidato', idCandidato), {
                _token: "{{ csrf_token() }}"
            }).done(() => {
                // Cambiar el color del enlace Burnout
                updateMenuState('#tdp5'); // Cambia el ID al correspondiente para la nueva vista

                // Redirigir al contenido
                loadContent(url);
            }).fail(xhr => {
                console.error("Error al finalizar la encuesta:", xhr.responseText);
                alert("Hubo un problema al finalizar la encuesta.");
            });
        })
        .fail(xhr => {
            console.error("Error al guardar la última respuesta:", xhr.responseText);
            alert("Hubo un problema al guardar tu respuesta.");
        });
}

    // Función para guardar datos de radio buttons

       function guardarDatosRadioButtons(preguntaId, valorSeleccionado) {
        // Marcar el valor seleccionado en la lista de radio buttons
        $(`input[name="respuesta_${preguntaId}"]`).val([valorSeleccionado]);
        console.log("Pregunta ID: " + preguntaId + ", Valor seleccionado: " + valorSeleccionado);
        // Aquí puedes enviar el valor seleccionado al servidor o guardarlo localmente
    }

    // Función para enviar feedback



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


    document.addEventListener('DOMContentLoaded', function () {
    const flujos = ['BACKLOG', 'PLANIFICADA', 'EN_PROGRESO', 'BLOQUEO', 'TERMINADA'];

    // Cargar datos automáticamente para cada flujo
    flujos.forEach(flujo => {
        const elemento = document.getElementById(flujo);
        if (elemento) {
            cargarDatosProductividad(flujo);
        }
    });
});

// Función para cargar datos de productividad

function cargarDatosProductividad(flujo) {
    const tipo = flujo.toUpperCase(); // Tipo de flujo en mayúsculas (como lo espera el backend)
    const columna = document.getElementById(`col-${flujo.toLowerCase()}`); // Seleccionar la columna
    const url = `/productividad/${tipo}`; // URL de la API

    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error(`Error al cargar datos para el flujo ${tipo}`);
            }
            return response.json();
        })
        .then(datos => {
            columna.innerHTML = ''; // Limpiar la columna antes de cargar nuevos datos
            if (datos.length > 0) {
                datos.forEach(dato => {
                    const tarea = document.createElement('div');
                    tarea.className = 'p-3 rounded-lg bg-white shadow-sm border border-gray-200 text-sm';
                    tarea.id = `tarea-${dato.id}`;
                    tarea.innerHTML = `
                        <h4 class="font-semibold text-gray-700">${dato.titulo}</h4>
                        <p class="text-gray-500">${dato.mensaje}</p>
                    `;
                    columna.appendChild(tarea);
                });
            } else {
                columna.innerHTML = '<p class="text-gray-500">No hay tareas en esta categoría.</p>';
            }
        })
        .catch(error => console.error(`Error al cargar datos para el flujo ${tipo}:`, error));
}

    

   

    // Define la función allowDrop
    function allowDrop(event) {
        event.preventDefault();
    }

    // Define la función drag
    function drag(event) {
        event.dataTransfer.setData('text', event.target.id);
    }

function finalizarEncuesta(preguntaId, idCandidato) {
    if (!idCandidato) {
        console.error("Error: El parámetro idCandidato no está definido.");
        alert("Hubo un problema al obtener el ID del candidato.");
        return;
    }

    const url = "{{ route('encuesta.showsatisfaccion', ['encuestaId' => 2, 'preguntaNumero' => 1]) }}";

    // Obtener la respuesta seleccionada
    const respuestaSeleccionada = $(`#respuesta_${preguntaId}`).val();
    const ordenRespuestas = $("#sortable").sortable('toArray', { attribute: 'data-id' });

    const data = {
        _token: "{{ csrf_token() }}",
        idCandidato,
        ...respuestaSeleccionada && { respuestaSeleccionada },
        ...ordenRespuestas.length && { orden: ordenRespuestas }
    };

    console.log("Datos enviados:", data);

    $.post("{{ route('encuesta.guardarOrden', '') }}/" + preguntaId, data)
        .done(() => {
            console.log("Última respuesta guardada exitosamente. Redirigiendo...");

            // Marcar analisis_cultural_completado y verificar test_completado
            $.post("{{ route('encuesta.finalizarEncuesta', ['preguntaId' => ':preguntaId', 'idCandidato' => ':idCandidato']) }}".replace(':preguntaId', preguntaId).replace(':idCandidato', idCandidato), {
                _token: "{{ csrf_token() }}"
            }).done(() => {
                // Cambiar el color del enlace Análisis Cultural
                updateMenuState('#tdp32'); // Cambia el ID al correspondiente para la nueva vista

                // Redirigir al contenido
                loadContent(url);
            }).fail(xhr => {
                console.error("Error al finalizar la encuesta:", xhr.responseText);
                alert("Hubo un problema al finalizar la encuesta.");
            });
        })
        .fail(xhr => {
            console.error("Error al guardar la última respuesta:", xhr.responseText);
            alert("Hubo un problema al guardar tu respuesta.");
        });
}
</script>

@yield('scripts')

</body>
</html>