@extends('components.layouts.default')

@section('title', 'Información | Kulture Team')

@php
    $hideMenuAndNavbar = true;
@endphp

<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')

<section class="overflow-hidden flex justify-center items-center min-h-screen w-screen text-gray-500 bg-kulture-color-cuatro">
    <div class="flex flex-col justify-center w-full my-5 rounded-3xl bg-white shadow-xl border border-gray-300">
        <!-- Contenido del tablero -->
        <div class="tablero grid grid-cols-5 gap-4 p-4 w-full mx-auto overflow-hidden">
            @foreach(['BACKLOG', 'PLANIFICADA', 'EN_PROGRESO', 'BLOQUEO', 'TERMINADA'] as $flujo)
            <div 
                class="columna flex flex-col flex-grow justify-start p-4 bg-gray-50 rounded-xl shadow-md border border-gray-200" 
                data-flujo="{{ $flujo }}"
                ondragover="allowDrop(event)" 
                ondrop="drop(event, '{{ strtolower($flujo) }}')">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-lg font-semibold text-center">{{ ucfirst(strtolower($flujo)) }}</span>
                    <i class="text-2xl text-kulture-color-cuatro bi-{{
                        $flujo == 'BACKLOG' ? 'hand-index' : 
                        ($flujo == 'PLANIFICADA' ? 'lightbulb' : 
                        ($flujo == 'EN_PROGRESO' ? 'hammer' : 
                        ($flujo == 'BLOQUEO' ? 'exclamation-triangle' : 'journal-check'))) }}"></i>
                </div>
                <div class="tareas flex flex-col space-y-2 h-full overflow-y-auto" id="col-{{ strtolower($flujo) }}">
                    @if(isset($datos[$flujo]) && count($datos[$flujo]) > 0)
                        @foreach($datos[$flujo] as $tarea)
                        <div 
                            class="tarea p-2 mb-2 bg-white rounded shadow {{ $tarea->prioridad == 'ALTA' ? 'border-red-500' : ($tarea->prioridad == 'MEDIA' ? 'border-blue-500' : 'border-green-500') }}" 
                            id="tarea-{{ $tarea->id }}" 
                            draggable="true" 
                            ondragstart="drag(event)">
                            <h4 class="font-semibold" style="color: #2d3748; font-size: 1.1rem;">{{ $tarea->titulo }}</h4>
                            <p class="text-gray-600" style="word-break: break-word; line-height: 1.5;">
                                {{ $tarea->mensaje }}
                            </p>
                        </div>
                        @endforeach
                    @else
                    <p class="mensaje-vacio text-center text-gray-400">No hay tareas en esta categoría.</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        <!-- Botón para crear nueva tarea -->
        <div class="flex justify-center mt-4">
            <button class="btn-crear bg-kulture-green text-white px-5 py-2 rounded-lg shadow-md hover:bg-green-600 transition" 
                type="button" data-bs-toggle="modal" data-bs-target="#modal-dinamico">Crear Nueva</button>
        </div>
    </div>
</section>

<!-- Modal para crear tarea -->
<div class="modal fade" id="modal-dinamico" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content rounded-lg p-4">
            <div class="modal-header text-center">
                <h1 class="modal-title fs-5 text-kulture-color-cuatro">Nueva Tarea</h1>
            </div>
            <div class="modal-body">
                <form id="form-productividad">
                    <input type="hidden" name="idcandidato" value="{{ Auth::user()->idcandidato }}">
                    <div class="form-group">
                        <label for="tipoRegistro">Tipo de Registro</label>
                        <select name="tipoRegistro" id="tipoRegistro" class="form-select">
                            <option value="TAREAS">Tareas</option>
                            <option value="HISTORIA_USUARIO">Historias de usuario</option>
                            <option value="INCIDENCIA">Incidencia</option>
                            <option value="HISTORIA_TECNICA">Historias técnicas</option>
                            <option value="VULNERABILIDADES">Vulnerabilidades</option>
                        </select>
                    </div>
                    <div class="form-group mt-3">
                        <label for="tipoFlujo">Flujo</label>
                        <select name="tipoFlujo" id="tipoFlujo" class="form-select">
                            <option value="BACKLOG">Backlog</option>
                            <option value="PLANIFICADA">Planificada</option>
                            <option value="EN_PROGRESO">En progreso</option>
                            <option value="BLOQUEO">Bloqueo</option>
                            <option value="TERMINADA">Terminada</option>
                        </select>
                    </div>
                  <div class="form-group mt-3">
    <label for="titulo">Título</label>
    <input type="text" name="titulo" id="titulo" class="form-control input-resaltado">
</div>
                    <div class="form-group mt-3">
                        <label for="prioridad">Prioridad</label>
                        <select name="prioridad" id="prioridad" class="form-select">
                            <option value="ALTA">Alta</option>
                            <option value="MEDIA">Media</option>
                            <option value="BAJA">Baja</option>
                        </select>
                    </div>
                    <div class="form-group mt-3">
                        <label for="texto">Comentario</label>
                        <textarea name="texto" id="texto" class="form-control"></textarea>
                    </div>
                </form>
            </div>
           <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
    <button type="button" id="guardar-productividad" class="btn btn-primary" onclick="registrarProductividad(event)">Guardar</button>
</div>

        </div>
    </div>
</div>

@endsection
@section('scripts')

@endsection
