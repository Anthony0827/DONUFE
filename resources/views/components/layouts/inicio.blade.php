<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/output.css') }}">
    @yield('styles')
<style>
        /* Sobrescribir el pseudo-elemento ::before */
        *::before {
            content: none !important;
        }
    </style>
     <nav class="relative flex items-center justify-between h-20 px-4 bg-white shadow-md fixed w-full top-0 z-50">
        <!-- Logo -->
        <a href="#">
            <img src="{{ asset('images/logo vertical color.png') }}" alt="Logotipo de Kulture" class="h-12">
        </a>
        <!-- Main title text -->
        <h1 class="absolute hidden text-3xl left-24 text-kulture-color-cuatro md:block">Inicio</h1>
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
    </nav>
</head>
<body>
    <!-- Contenido del dashboard -->
   <!-- Contenedor principal -->

       <div class="container-main">


        <!-- Menú y contenido principal -->
        @yield('content')
    </div>

    <!-- Carga de scripts globales -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
 
    
    @yield('scripts')
</body>
</html>