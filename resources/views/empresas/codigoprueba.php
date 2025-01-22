
@extends('components.layouts.default')

@section('title', 'Inicio de sesión | Kulture Team')

@php
    $hideMenuAndNavbar = true; // Define esta variable para ocultar el navbar y menú
@endphp

@section('content')

<div id="cuerpo" data-role="page" class="full-height csstransforms3d csstransitions js-ready js-nav">
        <div id="x-encabezado">
            
<!-- Header -->
<header class="fixed top-0 z-50 w-full h-20" role="navigation" id="j2d-menu-encabezado">
	<!-- Horizontal navbar -->
	<nav class="relative flex items-center justify-between h-20 px-4 bg-white">
		<!-- Logo -->
		<a href="#">
			<img src="../../../img/kulture-k.png" alt="Logotipo de Kulture">
		</a>
		<!-- Main title text -->
		<!-- <h1 class="absolute hidden text-3xl left-24 text-kulture-color-cuatro md:block">Información</h1> -->
		<!-- Hamburger button -->
		<button id="menu-btn" class="relative block mr-4 hamburger md:hidden focus:outline-none">
			<span class="absolute top-0 left-0 bg-kulture-color-cuatro hamburger-top"></span>
			<span class="absolute top-0 left-0 bg-kulture-color-cuatro hamburger-middle"></span>
			<span class="absolute top-0 left-0 bg-kulture-color-cuatro hamburger-bottom"></span>
		</button>
		<!-- User panel -->
		<div class="hidden md:block">
			<div class="flex items-center">
				<div class="relative">
					<i id="menu-icon" class="text-3xl text-gray-400 transition-all duration-300 hover:text-kulture-color-cuatro bi bi-grid mr-9"></i>
					<div id="actions-menu" class="absolute hidden py-3 text-center bg-white rounded-lg shadow-lg -right-9 top-16 w-44">
						<a href="#" class="w-32 hover:text-kulture-color-cuatro" onmouseover="window.status='';return true;" onclick="window.status='';cerrarsession();" id="cerrar"><i class="mr-2 text-lg text-kulture-color-cuatro bi bi-power"></i>Cerrar sesión</a>
					</div>
				</div>
				<div class="mr-4 text-center text-gray-800 j2d-notificaciones" id="usuario-notificaciones">
					<p class="font-light">Hola,</p><span class="font-semibold">Axia Intelligent Learning</span>&nbsp;				</div>
				<img class="transition-all duration-300 rounded-full w-14 hover:ring ring-kulture-color-cuatro" src="https://xsgames.co/randomusers/avatar.php?g=male" alt="Fotografía del perfil del usuario">
			</div>
		</div>
	</nav>
	<!-- Hamburger menu -->
	<div id="mobile-menu-container" class="relative block w-full menu-offscreen md:hidden">
		<nav class="absolute top-0 w-1/2 h-full sm:w-1/3">
			<div class="h-full md:hidden">
				<div id="hamburger-menu" class="flex-col items-center hidden w-full h-full py-8 space-y-6 bg-white sm:w-auto sm:self-center">
					<!-- Menu items -->
					<div class="flex justify-center w-full space-x-4">
						<div class="text-center text-gray-800">
							<p class="font-light">Hola,</p><span class="font-semibold">Axia Intelligent Learning</span>&nbsp;						</div>
						<img class="rounded-full w-14 h-14" src="https://xsgames.co/randomusers/avatar.php?g=male" alt="Fotografía del perfil del usuario">
					</div>
					<div class="my-2">
						<a href="#" class="text-center hover:text-kulture-color-cuatro" onmouseover="window.status='';return true;" onclick="window.status='';cerrarsession();" id="cerrar"><i class="mr-2 text-xl text-kulture-color-cuatro bi bi-power"></i>Cerrar sesión</a>
					</div>
					<!-- Links -->
					<ul class="space-y-4 text-gray-400">
						<li>
							<a class="menu-icon mobile-notebook" href="#">
								<i class="text-3xl hover:text-kulture-color-cuatro bi bi-journal-text"></i> Función 1
							</a>
						</li>
						<li>
							<a class="menu-icon mobile-chart" href="#">
								<i class="text-3xl hover:text-kulture-color-cuatro bi bi-clipboard-data"></i> Función 2
							</a>
						</li>
						<li>
							<a class="menu-icon mobile-lightbulb" href="#">
								<i class="text-3xl hover:text-kulture-color-cuatro bi bi-lightbulb"></i> Función 3
							</a>
						</li>
						<li>
							<a class="menu-icon mobile-person" href="#">
								<i class="text-3xl hover:text-kulture-color-cuatro bi bi-person"></i> Función 4
							</a>
						</li>
					</ul>
				</div>
			</div>
		</nav>
		<!-- Mobile notebook menu -->
		<nav id="mobile-notebook-menu" class="relative hidden w-1/2 h-full bg-gray-100 secondary-menu left-1/2 sm:left-1/3 sm:w-1/3 rounded-tl-4xl">
			<ul class="flex flex-col items-center pt-8 space-y-8 text-gray-400">
				<li class="text-kulture-color-cuatro">
					<span>Sección</span>
				</li>
				<li>
					<a href="./inicio.html">
						Inicio
					</a>
				</li>
				<li class="w-5/6 py-2 text-center rounded-md bg-link text-kulture-color-cuatro">
					<a href="./informacion.html">
						Información
					</a>
				</li>
				<li>
					<a href="./perfil.html">
						Perfil
					</a>
				</li>
				<li>
					<a href="./analisis-cultural.html">
						Análisis cultural
					</a>
				</li>
			</ul>
			<!-- Gray rectangle to fill the upper left corner of the main area -->
			<div class="absolute top-0 w-16 h-12 bg-gray-100 -z-10 md:left-36 lg:left-40"></div>
		</nav>
		<!-- Mobile chart menu -->
		<nav id="mobile-chart-menu" class="relative hidden w-1/2 h-full bg-gray-100 secondary-menu left-1/2 sm:left-1/3 sm:w-1/3 rounded-tl-4xl">
			<ul class="flex flex-col items-center pt-8 space-y-8 text-gray-400">
				<li class="text-kulture-color-cuatro">
					<span>Sección</span>
				</li>
				<li>
					<a href="./graficas.html">
						Gráficas
					</a>
				</li>
				<li>
					<a href="./graficas-barras.html">
						Gráficas de barras
					</a>
				</li>
				<li>
					<a href="./grafica-vertical.html">
						Gráfica vertical
					</a>
				</li>
				<li class="text-center">
					<a href="./grafica-evolucion.html">
						Gráficas de evolución
					</a>
				</li>
				<li>
					<a href="./analisis-felicidad.html">
						Análisis felicidad
					</a>
				</li>
			</ul>
			<!-- Gray rectangle to fill the upper left corner of the main area -->
			<div class="absolute top-0 w-16 h-12 bg-gray-100 -z-10 md:left-36 lg:left-40"></div>
		</nav>
		<!-- Mobile lightbulb menu -->
		<nav id="mobile-lightbulb-menu" class="relative hidden w-1/2 h-full bg-gray-100 secondary-menu left-1/2 sm:left-1/3 sm:w-1/3 rounded-tl-4xl">
			<ul class="flex flex-col items-center pt-8 space-y-8 text-gray-400">
				<li class="text-kulture-color-cuatro">
					<span>Sección</span>
				</li>
				<li>
					<a href="./ordenables.html">
						Ordenables
					</a>
				</li>
				<li>
					<a href="./box-talent.html">
						Box talent
					</a>
				</li>
				<li>
					<a href="./relaciones.html">
						Relaciones
					</a>
				</li>
			</ul>
			<!-- Gray rectangle to fill the upper left corner of the main area -->
			<div class="absolute top-0 w-16 h-12 bg-gray-100 -z-10 md:left-36 lg:left-40"></div>
		</nav>
		<!-- Mobile person menu -->
		<nav id="mobile-person-menu" class="relative hidden w-1/2 h-full bg-gray-100 secondary-menu left-1/2 sm:left-1/3 sm:w-1/3 rounded-tl-4xl">
			<ul class="flex flex-col items-center pt-8 space-y-8 text-gray-400">
				<li class="text-kulture-color-cuatro">
					<span>Sección</span>
				</li>
				<li>
					<a href="./tabla.html">
						Panel de empleados
					</a>
				</li>
				<li class="text-center">
					<a href="./matriz-talento.html">
						Matriz de talento 360º
					</a>
				</li>
				<li class="text-center">
					<a href="./matriz-felicidad-rendimiento.html">
						Matriz de felicidad - rendimiento
					</a>
				</li>
				<li>
					<a href="./feedback.html">
						Feedback
					</a>
				</li>
			</ul>
			<!-- Gray rectangle to fill the upper left corner of the main area -->
			<div class="absolute top-0 w-16 h-12 bg-gray-100 -z-10 md:left-36 lg:left-40"></div>
		</nav>
	</div>
</header>

<script>
    $(function() {
        $('#cerrar').on('click', function(evt) {
            window.location = "/";
        });
    });
</script>            <!-- <div class="alert alert-dismissable hide" id="espacioMensajes">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true" onclick="document.getElementById('bloquea_pantalla').style.display='none';">&times;</button><span id="icoMensaje"></span>
                <div id="mensajeAlertUsuario"></div>
            </div> -->
        </div>
        <div id="inner-cuerpo" class="flex h-full">
            <div id="menu-desplegable" class="h-full" data-role="panel">
                <div id="menu-lateral" class="h-full">
                    
<form class="h-full" name="form2" action="" method="post" id="form2">
  <div class="flex h-full">
   
    <!-- Vertical navbar -->
     <nav class="hidden w-20 bg-white md:inline-block">
        <ul class="sticky flex flex-col items-center pt-8 space-y-8 text-gray-400 top-20">
            <li>
                <a class="menu-icon notebook" href="#">
                    <i class="text-3xl transition-all duration-300 bi bi-house hover:text-kulture-color-cuatro"></i>
                </a>
            </li>
            <li>
                <a class="menu-icon chart" href="#">
                    <i class="text-3xl transition-all duration-300 bi bi-emoji-smile hover:text-kulture-color-cuatro"></i>
                </a>
            </li>
            <li>
                <a class="menu-icon lightbulb" href="#">
                    <i class="text-3xl transition-all duration-300 bi bi-graph-up hover:text-kulture-color-cuatro"></i>
                </a>
            </li>
            <li>
                <a class="menu-icon person" href="#">
                    <i class="text-3xl transition-all duration-300 bi bi-clipboard-data hover:text-kulture-color-cuatro"></i>
                </a>
            </li>
            <li>
                <a class="menu-icon agile" href="#">
                    <i class="text-3xl transition-all duration-300 hover:text-kulture-color-cuatro">  
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-radar" viewBox="0 0 16 16">
                            <path d="M6.634 1.135A7 7 0 0 1 15 8a.5.5 0 0 1-1 0 6 6 0 1 0-6.5 5.98v-1.005A5 5 0 1 1 13 8a.5.5 0 0 1-1 0 4 4 0 1 0-4.5 3.969v-1.011A2.999 2.999 0 1 1 11 8a.5.5 0 0 1-1 0 2 2 0 1 0-2.5 1.936v-1.07a1 1 0 1 1 1 0V15.5a.5.5 0 0 1-1 0v-.518a7 7 0 0 1-.866-13.847"></path>
                        </svg>
                    </i>
                </a>
            </li>
        </ul>
    </nav> 
    <!-- Notebook menu -->
    <nav id="notebook-menu" class="relative bg-gray-100 secondary-menu w-44 rounded-tl-4xl ">
        <ul class="sticky flex flex-col items-center pt-8 space-y-8 text-gray-400 top-20">
        <li class="w-5/6 py-2 text-center rounded-md bg-link text-kulture-color-cuatro">
            <a>
            Inicio
            </a>
        </li>
        <li>
            <a class="text-sm hover:text-kulture-color-cuatro" href="#" onclick="window.status='';BuscarProg('Li4vYXBwL2VtcHJlc2FzL3ZpZXdzL2hvbWVFbXByZXNhcy5waHA=','3','tb','');">
            Información
            </a>
        </li>
        <li>
            <a class="text-sm hover:text-kulture-color-cuatro" href="#" onclick="window.status='';BuscarProg('Li4vYXBwL2VtcHJlc2FzL2NvbnRyb2xsZXJzL2RhdG9zX2VtcHJlc2EucGhw','8','tb','');">
            Datos Empresa
            </a>
        </li>
        <li>
            <a class="text-sm hover:text-kulture-color-cuatro" href="#" onclick="window.status='';BuscarProg('Li4vYXBwL2VtcHJlc2FzL3ZpZXdzL2ltcG9ydGFyX3BhcnRpY2lwYW50ZXMucGhw','6','tb','');">
            Importar Participantes
            </a>
        </li>
        <li>
            <a class="text-sm hover:text-kulture-color-cuatro" href="#" onclick="window.status='';BuscarProg('Li4vYXBwL2VtcHJlc2FzL2NvbnRyb2xsZXJzL2NwYW5lbF9lbXByZXNhX2Rpc3BvY2lzaW9uX2VtcGxlYWRvcy5waHA=','7','tb','');">
            Panel de Empleados
            </a>
        </li>
        <li>
            <a class="text-sm hover:text-kulture-color-cuatro" href="#" onclick="window.status='';BuscarProg('Li4vYXBwL2VtcHJlc2FzL3ZpZXdzL2NvbmZpZ3VyYWNpb24ucGhw','35','tb','');">
            Configuración
            </a>
        </li>
        </ul>
        <!-- Gray rectangle to fill the upper left corner of the main area -->
        <div class="absolute top-0 w-16 h-12 bg-gray-100 -z-10 md:left-36 lg:left-40"></div>
    </nav>
    <!-- Chart menu -->
    <nav id="chart-menu" class="relative hidden bg-gray-100 secondary-menu w-44 rounded-tl-4xl">
        <ul class="sticky flex flex-col items-center pt-8 space-y-8 text-gray-400 top-20">
        <li class="w-5/6 py-2 text-center rounded-md bg-link text-kulture-color-cuatro">
            <a>
            Felicidad
            </a>
        </li>
          <li>
            <a class="text-sm hover:text-kulture-color-cuatro" href="#" onclick="window.status='';BuscarProg('Li4vYXBwL2VtcHJlc2FzL3BhbmVsZ3JhZmljby9jb250cm9sbGVyX3BhbmVsZ3JhZmljby5waHA','31','tb5','');">
              Analíticas
            </a>
          </li>
          <li>
            <a class="text-sm hover:text-kulture-color-cuatro" href="#" onclick="window.status='';BuscarProg('Li4vYXBwL2VtcHJlc2FzL3BhbmVsZ3JhZmljby9jb250cm9sbGVyX3BhbmVsZ3JhZmljb19mYWN0b3Jlcy5waHA=','34','tb5','');">
              Factores Sociales
            </a>
          </li>
          <li class="text-center">
            <a class="text-sm hover:text-kulture-color-cuatro" href="#" onclick="window.status='';BuscarProg('Li4vYXBwL2VtcHJlc2FzL3JlbmRpbWllbnRvL3ZpZXdfZW1wbGVhZG9zLnBocA==','41','tb5','')">
              Matriz Felicidad <br>Rendimiento
            </a>
          </li>
        </ul>
        <!-- Gray rectangle to fill the upper left corner of the main area -->
        <div class="absolute top-0 w-16 h-12 bg-gray-100 -z-10 md:left-36 lg:left-40"></div>
    </nav>
    <!-- Lightbulb menu -->
    <nav id="lightbulb-menu" class="relative hidden bg-gray-100 secondary-menu w-44 rounded-tl-4xl">
        <ul class="sticky flex flex-col items-center pt-8 space-y-8 text-gray-400 top-20">
        <li class="w-5/6 py-2 text-center rounded-md bg-link text-kulture-color-cuatro">
            <a>
            Productividad
            </a>
        </li>
          <li>
            <a class="text-sm hover:text-kulture-color-cuatro" href="#" onclick="window.status='';BuscarProg('Li4vYXBwL2VtcHJlc2FzL3ZpZXdzL3ZpZXdfY3BhbmVsX3Byb2R1Y3RpdmlkYWQucGhw','43','tb11','');">
              Analíticas
            </a>
          </li>
        </ul>
        <!-- Gray rectangle to fill the upper left corner of the main area -->
        <div class="absolute top-0 w-16 h-12 bg-gray-100 -z-10 md:left-36 lg:left-40"></div>
    </nav>
    <!-- Person menu -->
    <nav id="person-menu" class="relative hidden bg-gray-100 secondary-menu w-44 rounded-tl-4xl">
        <ul class="sticky flex flex-col items-center pt-8 space-y-8 text-gray-400 top-20">
        <li class="w-5/6 py-2 text-center rounded-md bg-link text-kulture-color-cuatro">
            <a>
            Cultura Alto Rendimiento
            </a>
        </li>
          <li>
            <a class="text-sm hover:text-kulture-color-cuatro" href="#" onclick="window.status='';BuscarProg('Li4vYXBwL2VtcHJlc2FzL2NvbnRyb2xsZXJzL3JlYWxpemFyX3JlY29ub2NpbWllbnRvLnBocA==','35','tb','');">
              Reconocimiento
            </a>
          </li>
          <li>
            <a class="text-sm hover:text-kulture-color-cuatro" href="#" onclick="BuscarProg('Li4vYXBwL2VtcHJlc2FzL2NvbnRyb2xsZXJzL2RhdG9zX2ZlZWRiYWNrLnBocA==','37','tb9','');">
              Feedback
            </a>
          </li>
          <li>
            <a class="text-sm hover:text-kulture-color-cuatro" href="#" onclick="BuscarProg('Li4vYXBwL2VtcHJlc2FzL2JveHRhbGVudC92aWV3X2VtcGxlYWRvcy5waHA=','11','tb9','');">
              Matriz de talento 360º
            </a>
          </li>
        </ul>
        <!-- Gray rectangle to fill the upper left corner of the main area -->
        <div class="absolute top-0 w-16 h-12 bg-gray-100 -z-10 md:left-36 lg:left-40"></div>
    </nav>
    <!-- MadurezAgile menu -->
    <nav id="agile-menu" class="relative hidden bg-gray-100 secondary-menu w-44 rounded-tl-4xl">
        <ul class="sticky flex flex-col items-center pt-8 space-y-8 text-gray-400 top-20">
        <li class="w-5/6 py-2 text-center rounded-md bg-link text-kulture-color-cuatro">
            <a>
            Madurez Agile
            </a>
        </li>
          <li>
            <a class="text-sm hover:text-kulture-color-cuatro" href="#" onclick="window.status='';BuscarProg('Li4vYXBwL2VtcHJlc2FzL2NvbnRyb2xsZXJzL2NwYW5lbF9lbXByZXNhX2NvbXBhdGliaWxpZGFkX2VtcGxlYWRvcy5waHA=','9','tb2','');">
              Compatibilidad Equipo
            </a>
          </li>
        </ul>
        <!-- Gray rectangle to fill the upper left corner of the main area -->
        <div class="absolute top-0 w-16 h-12 bg-gray-100 -z-10 md:left-36 lg:left-40"></div>
    </nav>
    
    
            
    
    <!-- Notebook menu | id="notebook-menu" -->
    <!--<nav id="tbl_menu_central" class="relative hidden bg-gray-100 secondary-menu w-52 rounded-tl-4xl">
      <div id="celda_menu_central_3">
                  <ul class="sticky flex flex-col items-center px-2 pt-8 space-y-8 text-gray-400 top-20">
            <li>
              <a id="tdp1" href="#" onmouseover="window.status='';return true;" onclick="window.status='';BuscarProg('Li4vYXBwL2VtcHJlc2FzL3ZpZXdzL2hvbWVFbXByZXNhcy5waHA=','3','tb','');" class="primero">
                Instrucciones
              </a>
            </li>
            <li>
              <a id="tdp8" href="#" onmouseover="window.status='';return true;" onclick="window.status='';BuscarProg('Li4vYXBwL2VtcHJlc2FzL2NvbnRyb2xsZXJzL2RhdG9zX2VtcHJlc2EucGhw','8','tb','');">
                Datos Empresa
              </a>
            </li>
            <li>
              <a id="tdp6" href="#" onmouseover="window.status='';return true;" onclick="window.status='';BuscarProg('Li4vYXBwL2VtcHJlc2FzL3ZpZXdzL2ltcG9ydGFyX3BhcnRpY2lwYW50ZXMucGhw','6','tb','');">
                Importar participantes
              </a>
            </li>
            <li>
              <a id="tdp7" href="#" onmouseover="window.status='';return true;" onclick="window.status='';BuscarProg('Li4vYXBwL2VtcHJlc2FzL2NvbnRyb2xsZXJzL2NwYW5lbF9lbXByZXNhX2Rpc3BvY2lzaW9uX2VtcGxlYWRvcy5waHA=','7','tb','');">
                Panel de empleados
              </a>
            </li>
            <li>
              <a id="tdp35" href="#" onmouseover="window.status='';return true;" onclick="window.status='';BuscarProg('Li4vYXBwL2VtcHJlc2FzL3ZpZXdzL2NvbmZpZ3VyYWNpb24ucGhw','35','tb','');">
                Configuración
              </a>
            </li>
            <li  id="felicidad" class="text-kulture-color-cuatro text-3x1">
                <a id="" href="#">Felicidad</a>
            </li>
            <li>
              <a id="tdp31" href="#" onmouseover="window.status='';return true;" onclick="window.status='';BuscarProg('Li4vYXBwL2VtcHJlc2FzL3BhbmVsZ3JhZmljby9jb250cm9sbGVyX3BhbmVsZ3JhZmljby5waHA','31','tb5','');">
                Analíticas
              </a>
            </li>
            <li>
              <a id="tdp41" href="#" onmouseover="window.status='';return true;" onclick="window.status='';BuscarProg('Li4vYXBwL2VtcHJlc2FzL3JlbmRpbWllbnRvL3ZpZXdfZW1wbGVhZG9zLnBocA==','41','tb5','')">
                Matriz Felicidad <br> Rendimiento
              </a>
            </li>
            <li  id="" class="text-kulture-color-cuatro text-3x1">
                <a id="" href="#">Madurez Agile</a>
            </li>
            <li>
              <a id="tdp9" href="#" onmouseover="window.status='';return true;" onclick="window.status='';BuscarProg('Li4vYXBwL2VtcHJlc2FzL2NvbnRyb2xsZXJzL2NwYW5lbF9lbXByZXNhX2NvbXBhdGliaWxpZGFkX2VtcGxlYWRvcy5waHA=','9','tb2','');">
                Compatibilidad de Equipo
              </a>
            </li>
            <li class="text-kulture-color-cuatro">
              <div class="text-center">
                Productividad
              </div>
            </li>
            <li>
              <a id="tdp43" href="#" onmouseover="window.status='';return true;" onclick="window.status='';BuscarProg('Li4vYXBwL2VtcHJlc2FzL3ZpZXdzL3ZpZXdfY3BhbmVsX3Byb2R1Y3RpdmlkYWQucGhw','43','tb11','');">
                Analíticas
              </a>
            </li>
            <li class="text-kulture-color-cuatro">
              <div class="text-center">
                Cultura alto rendimmiento
              </div>
            </li>
            <li>
              <a id="tdp39" href="#" onmouseover="window.status='';return true;" onclick="window.status='';BuscarProg('Li4vYXBwL2VtcHJlc2FzL2NvbnRyb2xsZXJzL3JlYWxpemFyX3JlY29ub2NpbWllbnRvLnBocA==','35','tb','');">
                Reconocimiento
              </a>
            </li>
            <li>
              <a id="tdp37" href="#" onmouseover="window.status='';return true;" window.status='' onClick="BuscarProg('Li4vYXBwL2VtcHJlc2FzL2NvbnRyb2xsZXJzL2RhdG9zX2ZlZWRiYWNrLnBocA==','37','tb9','');">
                Feedback
              </a>
            </li>
            <li>
              <a id="tdp11" href="#" onmouseover="window.status='';return true;" window.status='' onClick="BuscarProg('Li4vYXBwL2VtcHJlc2FzL2JveHRhbGVudC92aWV3X2VtcGxlYWRvcy5waHA=','11','tb9','');">
                Matriz de Talento 360º
              </a>
            </li>
            <li  id="" class="text-kulture-color-cuatro text-3x1">
                <a id="" href="#">Factores Sociales</a>
            </li>
            <li>
              <a id="tdp34" href="#" onmouseover="window.status='';return true;" onclick="window.status='';BuscarProg('Li4vYXBwL2VtcHJlc2FzL3BhbmVsZ3JhZmljby9jb250cm9sbGVyX3BhbmVsZ3JhZmljb19mYWN0b3Jlcy5waHA=','34','tb5','');">
                Analíticas
              </a>
            </li>
          </ul>
              </div>
      <div class="absolute top-0 w-20 h-12 bg-gray-100 -z-10 md:left-36 lg:left-40"></div>
    </nav>-->
  </div>
</form>

<script type="text/javascript">
  function ocultaMenu() {

    var cuerpo = document.getElementById("cuerpo");
    var menuGlyphicon = document.getElementById("menuGlyphicon");

    cuerpo.classList.remove("js-nav");
    menuGlyphicon.classList.remove("glyphicon-arrow-left");
    menuGlyphicon.classList.add("glyphicon-arrow-right");
  }

 

</script>                </div>
            </div>
            <div id="contenido_programa" class="w-full">
                <style type="text/css">
	.home-container-img {height: 430px;}
	#btnEmpezar{width: 180px;font-size: 17px;}
</style>

<!-- Main area -->
<section class="flex items-center justify-center text-gray-500 min-h-full-no-header bg-kulture-color-cuatro rounded-tl-4xl">
	<div class="flex flex-col justify-center w-11/12 max-w-full my-5 bg-white main-container rounded-3xl md:w-52 md:mx-10 md:my-8 low-dpi:h-md md:h-2xl">
    <div class="grid content-between gap-6 m-8 overflow-auto auto-rows-min scrollbar scrollbar-firefox low-dpi:mx-10 md:mx-10 md:pr-2 lg:mx-20">
		
        
        <div class="space-y-4">
                <p class="text-2xl text-kulture-color-cuatro">
                    Información | Kulture Team
                </p>
            </div>
            <p>
                Gracias por utilizar Kulture Team y por ayudar a mejorar la felicidad y productividad de tu equipo de trabajo, alineándolos para la consecución de objetivos claves.
            </p>
            <p>
                ¿Qué es Kulture Team?
            </p>
            <p>
                Es una herramienta SaaS que facilita una implementación eficaz de las prácticas de desarrollo ágil. Midiendo la cultura Agile, analizando el grado de madurez de los equipos a través de la compatibilidad cultural de cada empleado y la felicidad de cada grupo de trabajo, Creando una cultura de alto rendimiento y protegiendo el entorno de salud (estrés laboral) del trabajador
            </p>
            <p>
                ¡Vamos a ello!
            </p>
		</div>
	</div>
</section>

<div class="home-title"></div>

@endsection

<script language="javascript" type="text/javascript">
    /* [#!COMMENTED 17/01/24]*/
	var leidoinstruciones = '1';
/**	function emprezar(){
		if (leidoinstruciones != '1') {

			if ((Model.content) && (Model.content.length)){
				index = Model.content.findIndex(function(element) {
					return element.codigocontenido == 'I03';
				});
				if (index>-1) {
					$("#capa_auxiliarLabel").html(atob(Model.content[index].titulo));
					$("#inside_capa_auxiliar").html(atob(Model.content[index].texto));
				}
				$("#footer_space_capa_auxiliar").html("");
				$("#bntFooter").html("Continuar...");
				$("#bntFooter").attr("onClick","continuar1();");
				$('#capa_auxiliar').modal("show");
				$("#btnEmpezar").addClass("hide");
			}
		}
	}

	function esperacargarObj() {
		if ((typeof Model != 'undefined') && Model.content && Model.content.length) {
			emprezar();    
		} else {
			setTimeout(function() {
				esperacargarObj();
			}, 500);
		}
	}*/

	function continuar1(){
		setTimeout(function() {
			index = Model.content.findIndex(function(element) {
				return element.codigocontenido == 'I04';
			});
			if (index>-1) {
				$("#capa_auxiliarLabel").html(atob(Model.content[index].titulo));
				$("#inside_capa_auxiliar").html(atob(Model.content[index].texto));
			}
			$("#footer_space_capa_auxiliar").html("");
			$("#bntFooter").attr("onClick","continuar2();");
			$('#capa_auxiliar').modal("show");
		}, 500);
	}

	function continuar2(){
		marcarLeidoInstruciones();
		BuscarProg('Li4vYXBwL2VtcHJlc2FzL2NvbnRyb2xsZXJzL2RhdG9zX2VtcHJlc2EucGhw','1','tb1','');
	}

	function marcarLeidoInstruciones(){
		var dataSave ={'accion':'leidoInstruciones'};
		var json_data = btoa(JSON.stringify(dataSave));
		$('#param').val(json_data);
		$('#menu_programa').val('Li4vYXBwL2VtcHJlc2FzL2NvbnRyb2xsZXJzL2RhdG9zX2VtcHJlc2EucGhw');
		$.post("index_datos.php", $("#pagina").serialize(), function(respuesta) {
			try{
				if (respuesta.estatus === "errorRegistro") {
					mostrarAlertUsuario('danger',respuesta.mensaje);
				} 
			} catch (e) {
				console.log(e);
			}
		}, 'json');
	}

	//esperacargarObj();
    
</script>            </div>
            <div id="x-contenido" data-role="content">
                <!-- <div id="contenido_programa"> -->
                                <!-- </div> -->
                <form name="pagina" id="pagina" onsubmit="return false;" action="" method="post">
                    <input type="hidden" name="idusuario" id="idusuario" value="24">
                    <input type="hidden" name="ident" id="ident" value="eyJpZHVzdWFyaW8iOiIyNCIsImlkcGVyZmlsIjoiMiIsImVtYWlsIjoiaWdvci5hcnJpemFiYWxhZ2FAYXhpYXRlYW0uY29tIiwibm9tYnJlRW1wcmVzYSI6IkF4aWEgSW50ZWxsaWdlbnQgTGVhcm5pbmciLCJpZGVtcHJlc2EiOiIyNyIsInNpdHVhY2lvbkVtcHJlc2EiOiIxIiwidG9rZW4iOm51bGwsImxlaWRvaW5zdHJ1Y2lvbmVzIjoiMSJ9">
                    <input type="hidden" name="menu_ticket" id="menu_ticket" value="9a0ff546bcc13789920379df09dbe2d1">
                    <input type="hidden" name="situacionEmpresa" id="situacionEmpresa" value="1">
                    <input type="hidden" name="archivoayuda" id="archivoayuda" value="">
                    <input type="hidden" name="menu_programa" id="menu_programa" value="Li4vYXBwL2NvbW1vbi9jb250cm9sbGVycy9hcGkucGhw">
                    <input type="hidden" name="modulo_selec" id="modulo_selec" value="">
                    <input type="hidden" name="menu_programa_selec" id="menu_programa_selec" value="">
                    <input type="hidden" name="ticket" id="ticket" value="9a0ff546bcc13789920379df09dbe2d1">
                    <input type="hidden" name="param" id="param" value="eyJhY2Npb24iOiJnZXREZXBhcnRhbWVudG9zIn0=">
                </form>
            </div>
        </div>
    </div>