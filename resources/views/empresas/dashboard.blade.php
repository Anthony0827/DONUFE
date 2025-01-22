@extends('components.layouts.appempresas')

@section('title', 'Dashboard')

@section('content')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            loadContent("{{ route('empresas.home') }}");
        });
    </script>
    <div id="content-container"></div> <!-- Contenedor para contenido dinámico -->
@endsection