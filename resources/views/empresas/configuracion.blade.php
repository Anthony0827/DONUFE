

@extends('components.layouts.default')

@section('title', 'Información | Kulture Team')

@php
    $hideMenuAndNavbar = true; // Define esta variable para ocultar el navbar y menú
@endphp

@section('content')

<section class="flex justify-center min-h-screen items-center text-gray-500 bg-kulture-color-cuatro rounded-tl-4xl">
    <div class="main-container grid grid-cols-1 w-full max-w-full my-5 rounded-3xl bg-white md:w-full md:mx-10 md:my-8 low-dpi:h-md md:h-2xl">
        <div class="overflow-auto grid auto-rows-min content-between gap-6 scrollbar scrollbar-firefox m-8 low-dpi:mx-10 md:mx-10 md:pr-2 lg:mx-20">
            <div class="space-y-4">
                <p class="py-8 text-2xl text-kulture-color-cuatro">
                    Configuración
                </p>
                <form class="form-horizontal" role="form" name="FormDatosEmpresa2" id="FormDatosEmpresa2" method="post" enctype="application/x-www-form-urlencoded" action="enviarpulso.php">
                    <div class="flex flex-col gap-5 lg:flex-row">
                        <input type="hidden" name="idempresa" id="idempresa" value="27">

                        <div class="w-full space-y-4 md:mx-1">
                            <div class="py-2">
                                <p class="h-5 text-xl font-bold"> Frecuencia de envío Happines Index</p>
                            </div>
                            <div class="flex gap-5">
                                <div class="w-1/2 py-2">
                                Primer envío
                                </div>
                                <div class="w-1/2"> 
                                    <input id="inicio" name="inicio" type="text" value="31/12/2024" class="w-full border-none rounded-md form-input text-kulture-color-cuatro focus:ring-kulture-color-cuatro hasDatepicker">
                                    <hr>
                                </div>
                                
                            </div>
                            <div class="flex gap-5">
                                <div class="w-1/2 py-2">
                                Frecuencia
                                </div>
                                <div class="w-1/2">
                                    <select name="frecuencia" id="frecuencia" class="w-full border-none rounded-md form-input text-kulture-color-cuatro focus:ring-kulture-color-cuatro">
                                        <option value="7">7 días</option>
                                        <option value="14" selected="selected">14 días</option>
                                        <option value="21">21 días</option>
                                    </select>
                                        <hr>
                                </div>
                                
                            </div>
                          <!--  <div class="py-2">
                                <p class="h-5 text-xl font-bold"> Frecuencia de envío Happines Radar</p>
                            </div>
                            <div class="flex gap-5">
                                <div class="w-1/2 py-2">
                                Primer envío
                                </div>
                                <div class="w-1/2">
                                    <input id="inicio2" name="inicio2" type="text" value="30/04/2024" class="w-full border-none rounded-md form-input text-kulture-color-cuatro focus:ring-kulture-color-cuatro"  >
                                    <hr>
                                </div>
                                
                            </div>
                            <div class="flex gap-5">
                                <div class="w-1/2 py-2">
                                Frecuencia
                                </div>
                                <div class="w-1/2">
                                    <select name="frecuencia2" id="frecuencia2" class="w-full border-none rounded-md form-input text-kulture-color-cuatro focus:ring-kulture-color-cuatro"  >
                                        <option value="15"  >cada 15 días</option>
                                        <option value="30"  >cada 30 días</option>
                                        <option value="60"  >cada 60 días</option>
                                        <option value="90" selected='selected' >cada 90 días</option>
                                    </select>
                                        <hr>
                                </div>
                                
                            </div>-->
                            <div class="py-2">
                                <p class="h-5 text-xl font-bold"> Frecuencia de envío Matriz de talento 360º</p>
                            </div>
                            <div class="flex gap-5">
                                <div class="w-1/2 py-2">
                                Primer envío
                                </div>
                                <div class="w-1/2">
                                    <input id="inicio3" name="inicio3" type="text" value="31/05/2024" class="w-full border-none rounded-md form-input text-kulture-color-cuatro focus:ring-kulture-color-cuatro hasDatepicker">
                                    <hr>
                                </div>
                                
                            </div>
                            <div class="flex gap-5">
                                <div class="w-1/2 py-2">
                                Frecuencia
                                </div>
                                <div class="w-1/2">
                                    <select name="frecuencia3" id="frecuencia3" class="w-full border-none rounded-md form-input text-kulture-color-cuatro focus:ring-kulture-color-cuatro">
                                        <option value="90">cada 3 meses</option>
                                        <option value="180" selected="selected">cada 6 meses</option>
                                        <option value="365">cada 12 meses</option>
                                    </select>
                                        <hr>
                                </div>
                            </div>
                            <div class="py-8">
                                <button onclick="actualizarDatos2();" class="w-auto px-7 py-2.5 rounded-lg bg-kulture-green text-white shadow-md shadow-green-400 hover:shadow-none">Enviar</button>
                            </div>
                        </div>
                
            </div></form>			
</div></div></div></section>

@endsection