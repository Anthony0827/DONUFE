@extends('components.layouts.default')

@section('title', 'Panel de Participantes | Kulture Team')

@section('content')

<section class="flex items-center justify-center text-gray-500 min-h-full-no-header bg-kulture-color-cuatro rounded-tl-4xl">
    <div class="grid w-11/12 max-w-full grid-cols-1 my-5 bg-white main-container rounded-3xl md:w-5/6 md:mx-10 md:my-8 low-dpi:h-md md:h-2xl">
        <div class="grid content-between gap-6 m-8 overflow-auto auto-rows-min scrollbar scrollbar-firefox low-dpi:mx-10 md:mx-10 md:pr-2 lg:mx-20">
            <div class="space-y-4">
                <div class="space-y-3">
                    <label for="filter-department" class="text-gray-400 font-semibold">Departamento:</label>
                    <select id="filter-department" class="form-control border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-kulture-green focus:outline-none">
                        <!-- Opciones cargadas dinámicamente -->
                    </select>
                </div>
                <div class="mt-8"></div>
                    <!-- Tabla -->
                    <table id="participantes-table" class="min-w-full bg-white responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Apellidos</th>
                                <th>Email</th>
                                <th>Departamento</th>
                                <th>F. Alta</th>
                                <th>Inv</th>
                                <th>Test</th>
                                <th>C. Equipo</th>
                                <th>H. Index</th>
                                <th>T. Box</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- El cuerpo de la tabla será llenado por DataTables -->
                        </tbody>
                    </table>
                </div>
             
                <div class="mt-5">
                    <label class="text-gray-400 font-semibold text-sm">Seleccionar Todos:</label>
                    <input id="select-all" class="form-checkbox w-4 h-4 rounded border-gray-400 text-green-500 shadow-sm focus:border-green-500 focus:ring focus:ring-offset-0 focus:ring-green-100 focus:ring-opacity-50" type="checkbox">
                </div>
            </div>
              <div class="mt-5 text-center clear-right sm:text-end">
                    <button class="w-full px-7 py-2.5 rounded-lg bg-kulture-green text-white shadow-md shadow-green-400 sm:w-32">Procesar</button>
                </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<!-- Scripts adicionales si es necesario -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script>
    $(document).ready(function() {
        $('#participantes-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('participantes.data') !!}',
            columns: [
                { data: 'nombre', name: 'nombre' },
                { data: 'apellidos', name: 'apellidos' },
                { data: 'email', name: 'email' },
                { data: 'departamento', name: 'departamento' },
                { data: 'fecha_alta', name: 'fecha_alta', render: function(data, type, row) {
                    return moment(data).format('YYYY-MM-DD');
                }},
                { data: 'inv', name: 'inv' },
                { data: 'test_completado', name: 'test_completado', render: function(data, type, row) {
                    return data ? '<input type="checkbox" checked disabled>' : '<input type="checkbox" disabled>';
                }},
                { data: 'c_equipo', name: 'c_equipo' },
                { data: 'h_index', name: 'h_index' },
                { data: 't_box', name: 't_box' }
            ]
        });
    });
</script>
@endsection
