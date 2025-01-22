@extends('components.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            loadContent("{{ route('candidatos.home') }}");
        });
    </script>
    <div id="content-container"></div> <!-- Contenedor para contenido dinámico -->
@endsection