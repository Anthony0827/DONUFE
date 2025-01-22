@extends('components.layouts.default')

@section('title', 'Encuesta | Kulture Team')

@php
    $hideMenuAndNavbar = true; // Variable para ocultar el navbar y menú
@endphp


@section('content')

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
        <!-- Pregunta y opciones -->
      <!-- Pregunta y opciones -->
     <div class="overflow-auto container-preguntas grid auto-rows-min content-between gap-4 p-8 w-full h-full">
            <div class="li-pregunta-container" id="area_pregunta" style="max-width: 800px; margin: 0 auto;">
                <div class="question-header text-center text-gray-700 text-xl font-semibold mb-4">
                    <span id="pregunta_text">{{ $pregunta->pregunta_texto }}</span>
                </div>
                <!-- Botones de emojis como opciones de respuesta -->

                
<div class="radioFaces-container flex justify-center items-center flex-nowrap overflow-x-auto w-full">
    @for ($i = 1; $i <= 10; $i++)
        <div class="boxRadioFaces flex flex-col items-center">
            <!-- Imagen del emoji -->
            <img class="emoji-image w-32 h-32 transition-transform cursor-pointer hover:scale-110" 
                src="{{ asset('images/emojis/' . $i . '.svg') }}" 
                alt="Emoji {{ $i }}" 
                onclick="document.getElementById('r_{{ $i }}').click()">

            <!-- Botón de radio estilizado -->
            <label for="r_{{ $i }}" class="mt-2 flex items-center">
                <input type="radio" id="r_{{ $i }}" name="respuesta_{{ $pregunta->id }}" value="{{ $i }}" class="appearance-none w-4 h-4 border border-gray-300 rounded-full checked:bg-kulture-green checked:border-kulture-green focus:outline-none focus:ring-2 focus:ring-kulture-green">
            </label>
        </div>
    @endfor
</div>

</div>
                <!-- Feedback adicional -->
                <div id="feedback_{{ $pregunta->id }}" class="feedback-container mt-6">
                    <textarea id="feedback_txt_{{ $pregunta->id }}" rows="4" class="w-full p-4 form-textarea border border-gray-300 rounded-md focus:ring-2 focus:ring-kulture-green" name="feedback" placeholder="Escribe tu feedback aquí..."></textarea>
                </div>
            </div>

            <!-- Botones de navegación -->
            <div class="flex flex-col space-y-4 md:flex-row md:space-y-0 justify-between md:items-end h-full pb-1">
                @if ($preguntaNumero > 1)
                    <button class="w-full lg:w-fit px-7 py-2.5 rounded-lg bg-kulture-green text-white shadow-md hover:bg-green-100 hover:text-kulture-green" id="btnAnterior" onclick="loadContent('{{ route('encuesta.showsatisfaccion', [$encuesta->id, $preguntaNumero - 1]) }}')">
                        <i class="bi bi-arrow-left-short"></i> Anterior
                    </button>
                @endif

                @if ($preguntaNumero < $totalPreguntas)
                    <button class="w-full lg:w-fit px-7 py-2.5 rounded-lg bg-kulture-green text-white shadow-md hover:bg-green-100 hover:text-kulture-green" id="btnSiguiente" onclick="guardarValorYContinuar('{{ route('encuesta.showsatisfaccion', [$encuesta->id, $preguntaNumero + 1]) }}', {{ $pregunta->id }})">
                        Siguiente <i class="bi bi-arrow-right-short"></i>
                    </button>
                @else
                            <button 
    class="w-full lg:w-fit px-7 py-2.5 rounded-lg bg-kulture-green text-white shadow-md hover:bg-green-100 hover:text-kulture-green" 
    id="btnFinalizar" 
    onclick="finalizarSatisfaccion({{ $pregunta->id }}, {{ Auth::user()->idcandidato }})">
    Finalizar
</button>
                @endif
            </div>
        </div>
    </div>
</section>


@endsection

@section('scripts')

@endsection