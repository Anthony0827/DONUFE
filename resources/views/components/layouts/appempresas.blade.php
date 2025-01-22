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
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">

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
            <img src="{{ asset('images/logo vertical color.png') }}" alt="Logotipo de Kulture" class="h-12">
        </a>
        <!-- Main title text -->
        <h1 class="absolute hidden text-3xl left-24 text-kulture-color-cuatro md:block">Empresas</h1>
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

<div class="flex h-screen bg-gray-100">

    <!-- Menú Lateral Izquierdo con Iconos -->
    <nav class="w-16 bg-white h-full shadow-md flex flex-col items-center py-8 space-y-8">
        <a href="#" onclick="switchMenu('home')" id="menu-home">
            <img src="https://img.icons8.com/ios/50/000000/home.png" alt="Inicio" class="w-8 h-8 hover:text-blue-500" />
        </a>
        <a href="#" onclick="switchMenu('datos')" id="menu-datos">
            <img src="https://img.icons8.com/ios/50/000000/happy.png" alt="Datos Empresa" class="w-8 h-8 hover:text-blue-500" />
        </a>
        <a href="#" onclick="switchMenu('importar')" id="menu-importar">
            <img src="https://img.icons8.com/ios/50/000000/combo-chart.png" alt="Importar" class="w-8 h-8 hover:text-blue-500" />
        </a>
        <a href="#" onclick="switchMenu('panel')" id="menu-panel">
            <img src="https://img.icons8.com/ios/50/000000/bar-chart.png" alt="Panel" class="w-8 h-8 hover:text-blue-500" />
        </a>
        <a href="#" onclick="switchMenu('configuracion')" id="menu-configuracion">
            <img src="https://img.icons8.com/ios/50/000000/settings.png" alt="Configuración" class="w-8 h-8 hover:text-blue-500" />
        </a>
    </nav>

    <!-- Menú Lateral Derecho -->
    <nav id="dynamicMenu" class="w-52 bg-gray-50 h-full shadow-inner">
        <!-- Aquí se cargarán dinámicamente las opciones del menú derecho -->
        <ul class="py-8 space-y-6">
            <!-- Opciones iniciales -->
        </ul>
    </nav>

    <!-- Contenedor Dinámico -->
    <main class="flex-1 p-8 overflow-auto bg-white" id="content-container" style="height: 100vh;">
        @yield('content') <!-- Aquí se carga el contenido dinámico -->
    </main>
</div>


<!-- jQuery y jQuery UI -->
 <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<!-- Estilos de DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">

<!-- Scripts de DataTables -->
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>



<script>



// funcion para analisis cultural guardar respuestas ordenables.

   

// carga de todas las funciones dinamicas

function loadContent(url) {
    fetch(url, {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        if (response.status === 401) {
            // Si no autorizado, redirigir al login
            window.location.href = '/empresas/login';
        }
        return response.text();
    })
    .then(html => {
        document.getElementById("content-container").innerHTML = html;
                initializeDataTable();
                loadDepartments();

    })
    .catch(error => {
        console.error('Error al cargar el contenido:', error);
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


    
const menus = {
    home: [
        { text: "Inicio", route: "{{ route('empresas.home') }}" },
@if(Auth::check() && Auth::user()->idempresa)
            { 
                text: "Datos Empresa", 
                route: "{{ route('empresas.datos', ['idempresa' => Auth::user()->idempresa]) }}"
            },
        @else
            {
                text: "Datos Empresa", 
                route: "#" // Usa un marcador seguro
            },
        @endif
        { text: "Importar Participantes", route: "{{ route('empresas.importar') }}" },
        { text: "Panel de Empleados", route: "{{ route('empresas.panel') }}" },
        { text: "Configuración", route: "{{ route('empresas.configuracion') }}" }
    ],


        datos: [
            { text: "felicidad", route: "{{ route('empresas.home') }}" },
            { text: "analiticas", route: "{{ route('empresas.home') }}" },
            { text: "factoressociales", route: "{{ route('empresas.importar') }}" },
            { text: "matriz felicidad rendimiento", route: "{{ route('empresas.panel') }}" },
        ],
        importar: [
            { text: "Productividad", route: "{{ route('empresas.importar') }}" },
            { text: "Analíticas", route: "{{ route('empresas.configuracion') }}" }
        ],
        panel: [
            { text: "Cultura Alto Rendimiento", route: "{{ route('empresas.panel') }}" },
            { text: "Reconocimiento", route: "{{ route('empresas.configuracion') }}" },
                        { text: "Feedback", route: "{{ route('empresas.configuracion') }}" },

                                    { text: "Matriz de talento 360º", route: "{{ route('empresas.configuracion') }}" }

        ],
        configuracion: [
            { text: "Madurez Agile", route: "{{ route('empresas.configuracion') }}" },
            { text: "Compatibilidad Equipo", route: "{{ route('empresas.panel') }}" }
        ]
    };

    // Función para cambiar el contenido del menú derecho
    function switchMenu(menuKey) {
        const dynamicMenu = document.getElementById('dynamicMenu');
        const menuOptions = menus[menuKey] || [];

        let menuHtml = '<ul class="py-8 space-y-6">';
        if (menuOptions.length > 0) {
            menuOptions.forEach(option => {
                menuHtml += `
                    <li class="pl-6">
                        <a href="#" class="text-gray-500 hover:text-blue-500" onclick="loadContent('${option.route}')">
                            ${option.text}
                        </a>
                    </li>
                `;
            });
        } else {
            menuHtml += '<li class="pl-6 text-gray-500">Sin opciones disponibles</li>';
        }
        menuHtml += '</ul>';

        dynamicMenu.innerHTML = menuHtml;
    }

   
document.addEventListener('DOMContentLoaded', function () {
    switchMenu('home'); // Cambia el menú al de "home"
    document.getElementById('menu-home').classList.add('text-kulture-color-cuatro', 'font-bold');
});

// Llamar esta función después de cargar la tabla
function initializeDataTable() {
    var table = $('#participantes-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route('participantes.data') }}',
            type: 'GET',
            data: function (d) {
                d.idempresa = '{{ Auth::user()->idempresa }}'; // Añadir el idempresa del usuario autenticado
                d.departamento = $('#filter-department').val(); // Añadir el filtro de departamento
            },
            dataSrc: function (json) {
                console.log('Datos recibidos:', json); // Verifica los datos recibidos en la consola
                return json.data;
            },
            error: function (xhr, error, code) {
                console.error('Error en la solicitud AJAX:', xhr, error, code);
            }
        },
        columns: [
            { data: 'nombres', name: 'nombres' },
            { data: 'apellidos', name: 'apellidos' },
            { data: 'email', name: 'email' },
            { data: 'departamento', name: 'departamento' },
 { data: 'fecharegistro', name: 'fecharegistro', render: function(data, type, row) {
                    return moment(data).format('YYYY-MM-DD');
                }},            { data: 'invitacion_enviada', name: 'invitacion_enviada', render: function(data, type, row) {
                return data ? '<input type="checkbox" checked disabled>' : '<input type="checkbox" disabled>';
            }},
              { data: 'test_completado', name: 'test_completado', render: function(data, type, row) {
                    return data ? '<input type="checkbox" checked disabled>' : '<input type="checkbox" disabled>';
                }},
            {
                data: null,
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `<input type="checkbox" class="row-checkbox" data-id="${row.id}">`;
                }
            },
        ],
       
    });

    // Filtro por departamento
    $('#filter-department').on('change', function () {
        table.ajax.reload(); // Recargar la tabla con el nuevo filtro
    });

    // Seleccionar todos los checkboxes
    $('#select-all').on('change', function () {
        var rows = table.rows({ search: 'applied' }).nodes(); // Obtiene las filas visibles después de la búsqueda
        $('input[type="checkbox"]', rows).prop('checked', this.checked); // Marca/desmarca todos los checkboxes
    });

    // Evento para verificar checkboxes seleccionados
    $('#save-button').on('click', function () {
        var selectedIds = [];
        table.rows().every(function () {
            var data = this.node();
            if ($('input.row-checkbox', data).is(':checked')) {
                selectedIds.push(this.data().id); // Agrega el ID de la fila seleccionada
            }
        });
        console.log('IDs seleccionados:', selectedIds);
        // Aquí puedes realizar una acción con los IDs seleccionados
    });
}

// Función para cargar los departamentos en el filtro
function loadDepartments() {
    const filterDepartment = document.getElementById('filter-department');
    if (!filterDepartment) {
        console.error('Elemento con id "filter-department" no encontrado.');
        return;
    }

    fetch('{{ route('departamentos.list') }}', {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        filterDepartment.innerHTML = '<option value="">Todos</option>';
        data.forEach(department => {
            filterDepartment.innerHTML += `<option value="${department}">${department}</option>`;
        });
    })
    .catch(error => {
        console.error('Error al cargar los departamentos:', error);
    });
}

</script>

@yield('scripts')

</body>
</html>
