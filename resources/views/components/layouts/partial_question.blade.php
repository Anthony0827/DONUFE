<!-- resources/views/encuestas/partial_question.blade.php -->
<!--<div class="li-pregunta-container" id="area_pregunta">
    <div class="question-header text-center text-gray-600 text-xl font-semibold mb-4">
        <span id="pregunta_text">{{ $pregunta->pregunta_texto }}</span>
    </div>

    <div class="radioFaces-container">
        @for ($i = 1; $i <= 10; $i++)
            <x-emoji-button :pregunta-id="$pregunta->id" :emoji-id="$i" />
        @endfor
    </div>

    <div id="feedback_{{ $pregunta->id }}" class="feedback-container mt-6">
        <textarea id="feedback_txt_{{ $pregunta->id }}" rows="4" class="w-full form-textarea border-gray-400 rounded-md" name="feedback" placeholder="Feedback..."></textarea>
    </div>
</div>

<div class="flex justify-between mt-4">
    @if ($preguntaNumero > 1)
        <x-navigation-button 
            :route="route('encuesta.showbournout', [$encuesta->id, $preguntaNumero - 1])" 
            text="Anterior" 
            direction="previous" />
    @endif

    @if ($preguntaNumero < $totalPreguntas)
        <x-navigation-button 
            :route="route('encuesta.showbournout', [$encuesta->id, $preguntaNumero + 1])" 
            text="Siguiente" 
            direction="next" />
    @else
        <x-navigation-button 
            :route="route('encuesta.finalizar')" 
            text="Finalizar" 
            direction="next" />
    @endif
</div>
