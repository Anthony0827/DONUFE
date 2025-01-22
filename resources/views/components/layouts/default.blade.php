<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">

    <link rel="stylesheet" href="{{ asset('css/output.css') }}">

    @yield('styles')

<style>
     /* Estilos para las prioridades */
 .border-red-500 {
    border: 3px solid #e63946; /* Rojo vibrante */
    border-radius: 10px; /* Esquinas redondeadas */
    box-shadow: 0 4px 6px rgba(230, 57, 70, 0.4); /* Sombra sutil */
    transition: transform 0.2s ease-in-out; /* Transición al hover */
}

.border-red-500:hover {
    transform: scale(1.05); /* Efecto de zoom al pasar el mouse */
}

.border-blue-500 {
    border: 3px solid #457b9d; /* Azul oscuro */
    border-radius: 10px; /* Esquinas redondeadas */
    box-shadow: 0 4px 6px rgba(69, 123, 157, 0.4); /* Sombra sutil */
    transition: transform 0.2s ease-in-out; /* Transición al hover */
}

.border-blue-500:hover {
    transform: scale(1.05); /* Efecto de zoom al pasar el mouse */
}

.border-green-500 {
    border: 3px solid #90ee90; /* Verde claro */
    border-radius: 10px; /* Esquinas redondeadas */
    box-shadow: 0 4px 6px rgba(144, 238, 144, 0.5); /* Sombra suave */
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out; /* Transiciones suaves */
    background-color: #f6fff6; /* Fondo verde muy claro */
}

.border-green-500:hover {
    transform: scale(1.05); /* Efecto de zoom al pasar el mouse */
    box-shadow: 0 6px 8px rgba(144, 238, 144, 0.7); /* Sombra más marcada */
}


     /* Sombreado para el título de la tarea */

     .input-resaltado {
    border: 2px solid #6b7280; /* Borde gris fuerte */
    color: #4b5563; /* Texto gris oscuro */
    font-weight: bold; /* Resalta el texto */
    background-color: #f9fafb; /* Fondo ligeramente gris */
}
 
</style>

</head>
<body>
    <!-- Contenido del dashboard -->

      <div class="flex h-[calc(100vh)] bg-gray-100">
        <!-- Menú y contenido principal -->
        @yield('content')
    </div>

    <!-- Carga de scripts globales -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

 <script>
  function handleNextButton(url, preguntaId, isLastQuestion) {
    if (isLastQuestion) {
        if (confirm('Has llegado a la última pregunta. ¿Deseas finalizar?')) {
            finalizarBournout();
        }
    } else {
        guardarValorYContinuar(url, preguntaId);
    }
}

 $(document).ready(function () {
    $('#participantes-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route('participantes.data') }}',
            type: 'GET',
            dataSrc: function (json) {
                console.log('Datos recibidos:', json); // Verifica los datos recibidos
                return json.data; // Asegúrate de retornar 'data'
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
                         { data: 'fecharegistro', name: 'fecharegistro' }

        ],
       
    });
});
 

 </script>
    
    @yield('scripts')
</body>
</html>