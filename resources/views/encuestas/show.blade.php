@extends('components.layouts.default')

@section('title', 'Encuesta | Kulture Team')

@section('content')

<!-- Analisis Cultural -->


<section class="overflow-hidden flex justify-center items-center min-h-screen w-screen text-gray-500 bg-kulture-color-cuatro rounded-tl-4xl">
    <div class="flex flex-col justify-center w-11/12 max-w-full my-5 rounded-3xl bg-white md:w-5/6 md:mx-10 md:my-8 md:min-h-1xl">
        <!-- Barra de progreso -->
        <div class="flex justify-center items-center my-4 px-6">
            <div class="w-full flex justify-center items-center space-x-2">
                @for ($i = 1; $i <= $totalPreguntas; $i++)
                    <div class="flex items-center">
                        <div class="circle w-6 h-6 flex items-center justify-center rounded-full border-2 transition-all duration-300"
                            id="progress-circle-{{ $i }}"
                            style="border-color: {{ $i <= $preguntaNumero ? '#4CAF50' : '#ccc' }};
                                   background-color: {{ $i <= $preguntaNumero ? '#4CAF50' : '#fff' }};">
                            @if ($i <= $preguntaNumero)
                                <span class="text-white font-bold text-sm">{{ $i }}</span>
                            @else
                                <span class="text-gray-500 font-bold text-sm">{{ $i }}</span>
                            @endif
                        </div>
                    </div>
                @endfor
            </div>
        </div>

        <!-- Contenido principal -->
        <div class="flex flex-col">
            <div class="overflow-auto container-preguntas grid auto-rows-min content-between gap-6 m-8 md:mx-10 md:pr-2 lg:mx-20">
                <div id="content-container" class="text-gray-600 text-xl font-semibold">
                    @if (!in_array($pregunta->id, [8, 9, 10, 11, 12]))
                        <h2 class="text-center text-gray-600">{{ $encuesta->titulo }}</h2>
                    @endif

                    @if ($pregunta->respuestas->first()->tipo_respuesta === 'directa')
                        <div class="pregunta-directa mt-4 text-center md:text-start">
                            <h3 class="text-lg font-bold">Selecciona una respuesta</h3>
                            <p class="mb-2">{{ $pregunta->pregunta_texto }}</p>
                            <div>
                                <select id="respuesta_{{ $pregunta->id }}" name="respuesta_{{ $pregunta->id }}" class="form-select w-full md:w-2/3 border-gray-300 rounded-md focus:ring-kulture-color-cuatro">
                                    <option value="">Seleccione una opción</option>
                                    @foreach ($respuestas as $respuesta)
                                        <option value="{{ $respuesta->respuesta_texto }}">{{ $respuesta->respuesta_texto }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif

                    @if ($pregunta->respuestas->first()->tipo_respuesta === 'ordenable')
                        <h4 class="text-md font-bold text-gray-800 mb-4 text-center md:text-start">{{ $pregunta->pregunta_texto }}</h4>
                        <ul id="sortable" class="hover:cursor-grab bg-white rounded-lg p-4" data-pregunta-id="{{ $pregunta->id }}">
                            @foreach($respuestas as $respuesta)
                                <li class="active:text-kulture-color-cuatro active:border active:border-1 active:border-gray-300 active:rounded-lg mb-3 bg-white" data-id="{{ $respuesta->id }}">
                                    <div class="flex flex-col md:flex-row justify-center md:justify-between items-center py-2 relative text-center md:text-start">
                                        <div>
                                            <div class="block my-0 mx-auto md:inline-block text-center border border-2 rounded-full w-6 h-6 cursor-pointer text-gray-500 icon-numeral md:mr-4 text-sm">
                                                {{ $loop->iteration }}
                                            </div>
                                            <span class="md:mr-auto md:inline-block text-gray-700 text-sm">{{ $respuesta->respuesta_texto }}</span>
                                        </div>
                                        <div class="rotate-90 md:rotate-0">
                                            <i class="grip bi bi-grip-vertical text-gray-400"></i>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <!-- Botones de navegación -->
                <div class="flex flex-col space-y-4 md:flex-row md:space-y-0 justify-between md:items-end h-full pb-1">
                    @if ($preguntaNumero > 1)
                        <button class="w-full lg:w-fit px-7 py-2.5 rounded-lg bg-green-100 text-kulture-green shadow-md hover:bg-kulture-green hover:text-white" id="btnAnterior" onclick="loadContent('{{ route('encuesta.show', [$encuesta->id, $preguntaNumero - 1]) }}')">
                            <i class="bi bi-arrow-left-short"></i>&nbsp;Anterior
                        </button>
                    @endif

                    @if ($preguntaNumero < $totalPreguntas)
                        <button class="w-full lg:w-fit px-7 py-2.5 rounded-lg bg-kulture-green text-white shadow-md hover:bg-green-100 hover:text-kulture-green" id="btnSiguiente" onclick="guardarRespuestaYContinuar('{{ route('encuesta.show', [$encuesta->id, $preguntaNumero + 1]) }}', {{ $pregunta->id }})">
                            Siguiente&nbsp;<i class="bi bi-arrow-right-short"></i>
                        </button>
                    @else
                        <button 
    class="w-full lg:w-fit px-7 py-2.5 rounded-lg bg-kulture-green text-white shadow-md hover:bg-green-100 hover:text-kulture-green" 
    id="btnFinalizar" 
    onclick="finalizarEncuesta({{ $pregunta->id }}, {{ Auth::user()->idcandidato }})">
    Finalizar
</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection





@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="{{ asset('js/scripts.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const sortableElement = $("#sortable");
        if (sortableElement.length > 0) {
            sortableElement.sortable({
                update: function (event, ui) {
                    console.log('Orden actualizado:', sortableElement.sortable('toArray', { attribute: 'data-id' }));
                }
            });
        }
    });

    function loadContent(url) {
        fetch(url)
            .then(response => response.text())
            .then(data => {
                document.getElementById("content-container").innerHTML = data;
            })
            .catch(error => console.error('Error al cargar el contenido:', error));
    }
</script>
@endsection
