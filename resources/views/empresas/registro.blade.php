@extends('components.layouts.default')

@section('title', 'Inicio de sesión | Kulture Team')

@php
    $hideMenuAndNavbar = true; // Define esta variable para ocultar el navbar y menú
@endphp

@section('content')
<section class="flex items-center justify-center w-screen text-gray-500 min-h-full-no-header bg-kulture-color-cuatro rounded-tl-4xl">
    <div class="flex flex-col items-center justify-center w-11/12 max-w-full my-5 bg-white main-container rounded-3xl md:w-5/6 md:mx-10 md:my-8 low-dpi:h-md md:h-2xl">
         @if (session('status'))
            <div class="w-full bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 text-center">
                {{ session('status') }}
            </div>
        @endif
        <div class="relative flex flex-col max-w-screen-xl gap-0 m-8 space-y-16 overflow-auto lg:flex-row lg:space-y-0 lg:w-5/6 scrollbar scrollbar-firefox sm:px-8 lg:px-6 lg:gap-32 low-dpi:mx-10 lg:mx-8">

<div id="formRegistro" class="lg:w-1/2">
    <p class="mb-4 text-2xl text-kulture-color-cuatro">Registro</p>
    <form role="form" id="registro" class="pb-2" autocomplete="off" method="POST" action="{{ route('empresas.store') }}">
        @csrf
        <input type="hidden" id="x-icon" name="x-icon" value="Mw==">
        <div class="flex items-center justify-between hidden px-4 py-2 mb-4 text-white rounded-lg bg-kulture-color-cuatro">
            <div class="flex items-center justify-around hidden w-11/12 px-3 py-2 mx-auto mb-6 text-white rounded-lg alert alert-danger bg-kulture-color-cuatro" id="mensajeError2">
                <div class="flex items-center justify-center w-11/12">
                    <i class="mr-2 bi bi-exclamation-triangle"></i>
                    <span>Los campos marcados en rojo son obligatorios</span>
                </div>
                <button type="button" class="w-1/12" data-dismiss="alert" aria-hidden="true">×</button>
            </div>
            <div class="alert alert-dismissable hide" id="mensajePost">
                <i class="bi bi-x-lg"></i>
                <span id="mensajeAlert"></span>
            </div>
        </div>
        <input type="hidden" id="accion" name="accion" value="registroR">

        <!-- Name input -->
        <div class="mb-3 has-feedback">
            <input type="text" class="w-full border-none rounded-md form-input focus:ring-kulture-color-cuatro text-kulture-color-cuatro" name="nombreEmpresa" id="nombreEmpresa" placeholder="Nombre / Razón Social" value="{{ old('nombreEmpresa') }}" required>
            @error('nombreEmpresa')
            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
            @enderror
            <hr class="border border-gray-300">
        </div>
        <!-- CIF input -->
        <div class="mb-3 has-feedback">
            <input type="text" class="w-full border-none rounded-md form-input focus:ring-kulture-color-cuatro text-kulture-color-cuatro" name="cif" id="cif" placeholder="CIF" value="{{ old('cif') }}" required>
            @error('cif')
            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
            @enderror
            <hr class="border border-gray-300">
        </div>
        <!-- Phone input -->
        <div class="mb-3 has-feedback">
            <input type="text" class="w-full border-none rounded-md form-input focus:ring-kulture-color-cuatro text-kulture-color-cuatro" name="telefono" id="telefono" placeholder="Teléfono" value="{{ old('telefono') }}" required>
            @error('telefono')
            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
            @enderror
            <hr class="border border-gray-300">
        </div>
        <!-- Email input -->
        <div class="mb-3 has-feedback">
            <input type="email" class="w-full border-none rounded-md form-input focus:ring-kulture-color-cuatro text-kulture-color-cuatro" name="emailRegistro" id="emailRegistro" placeholder="Email" value="{{ old('emailRegistro') }}" autocomplete="off" required>
            @error('emailRegistro')
            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
            @enderror
            <hr class="border border-gray-300">
        </div>
        <!-- Confirm email input -->
        <div class="mb-3 has-feedback">
            <input type="email" class="w-full border-none rounded-md form-input focus:ring-kulture-color-cuatro text-kulture-color-cuatro" name="emailConfirmar" id="emailConfirmar" placeholder="Confirmar email" value="{{ old('emailConfirmar') }}" autocomplete="off" required>
            @error('emailConfirmar')
            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
            @enderror
            <hr class="border border-gray-300">
        </div>
<!-- Password input -->
<div class="mb-3 has-feedback">
    <input type="password" 
           name="claveRegistro" 
           id="claveRegistro" 
           class="w-full border-none rounded-md form-input focus:ring-kulture-color-cuatro text-kulture-color-cuatro" 
           placeholder="Contraseña" 
           autocomplete="off" 
           required>
    @error('claveRegistro')
        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
    @enderror
    <hr class="border border-gray-300">
    <div class="btn btn-naranja iconEyePassw glyphicon glyphicon-eye-open" onclick="mostrarPassword('claveRegistro');"></div>
</div>

<!-- Confirm password input -->
<div class="mt-3 mb-3 has-feedback">
    <input type="password" 
           name="claveRegistro_confirmation" 
           id="claveRegistro_confirmation" 
           class="w-full border-none rounded-md form-input focus:ring-kulture-color-cuatro text-kulture-color-cuatro" 
           placeholder="Confirmar contraseña" 
           autocomplete="off" 
           required>
    @error('claveRegistro')
        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
    @enderror
    <hr class="border border-gray-300">
    <div class="btn btn-naranja iconEyePassw glyphicon glyphicon-eye-open" onclick="mostrarPassword('claveRegistro_confirmation');"></div>
</div>


        <!-- Business selector -->
        <div class="mb-10">
            <select class="w-full border-none rounded-md form-select has-feedback focus:ring-kulture-color-cuatro text-kulture-color-cuatro" name="tipoEmpresa" id="tipoEmpresa" required>
                <option disabled selected value="">Tipo de empresa</option>
                <option value="1" {{ old('tipoEmpresa') == 1 ? 'selected' : '' }}>Inicial (1 - 10 empleados)</option>
                <option value="2" {{ old('tipoEmpresa') == 2 ? 'selected' : '' }}>Startup (11 - 50 empleados)</option>
                <option value="3" {{ old('tipoEmpresa') == 3 ? 'selected' : '' }}>Media (51 - 150 empleados)</option>
                <option value="4" {{ old('tipoEmpresa') == 4 ? 'selected' : '' }}>Grande (más de 150 empleados)</option>
            </select>
            @error('tipoEmpresa')
            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
            @enderror
            <hr class="border border-gray-300">
        </div>
        <!-- Select input -->
        <div class="mb-10 has-feedback">
            <div class="flex flex-col items-center justify-center w-full gap-3 mx-auto my-4">
                <!-- Challenge -->
                <div>
                    <div class="alert alert-info hide text-naranja" id="mensajeErrorCaptcha">Debes seleccionar el nombre del objeto para demostrar que no eres un robot.</div>
                </div>
                <!-- Image -->
                <div class="flex justify-around w-4/5 text-center">
                    <img class="block mx-auto mb-2" src="../jcapImg/valida_ingreso/objeto3.png" title="Debes seleccionar el nombre del objeto para demostrar que eres un humano">
                    <div class="w-1/2">
                        <h4>Captcha:</h4>
                        <select id="miobjeto" class="w-full border-none rounded-md form-select focus:ring-kulture-color-cuatro text-kulture-color-cuatro" name="miobjeto" required>
                            <option value=""></option>
                            <option value="fresa" {{ old('miobjeto') == 'fresa' ? 'selected' : '' }}>fresa</option>
                            <option value="libro" {{ old('miobjeto') == 'libro' ? 'selected' : '' }}>libro</option>
                            <option value="pluma" {{ old('miobjeto') == 'pluma' ? 'selected' : '' }}>pluma</option>
                            <option value="aguacate" {{ old('miobjeto') == 'aguacate' ? 'selected' : '' }}>aguacate</option>
                            <option value="manzana" {{ old('miobjeto') == 'manzana' ? 'selected' : '' }}>manzana</option>
                            <option value="paraguas" {{ old('miobjeto') == 'paraguas' ? 'selected' : '' }}>paraguas</option>
                            <option value="dado" {{ old('miobjeto') == 'dado' ? 'selected' : '' }}>dado</option>
                            <option value="globo" {{ old('miobjeto') == 'globo' ? 'selected' : '' }}>globo</option>
                            <option value="pera" {{ old('miobjeto') == 'pera' ? 'selected' : '' }}>pera</option>
                            <option value="naranja" {{ old('miobjeto') == 'naranja' ? 'selected' : '' }}>naranja</option>
                            <option value="llave" {{ old('miobjeto') == 'llave' ? 'selected' : '' }}>llave</option>
                            <option value="mariposa" {{ old('miobjeto') == 'mariposa' ? 'selected' : '' }}>mariposa</option>
                        </select>
                        @error('miobjeto')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <hr class="border border-gray-300">
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-6 space-y-3 form-group has-feedback">
            <div class="col-sm-12">
                <div class="checkbox">
                    <input type="checkbox" class="w-5 h-5 mr-1 border-gray-400 rounded shadow-md form-checkbox text-kulture-color-cuatro focus:border-red-600 focus:ring focus:ring-offset-0 focus:ring-red-100 focus:ring-opacity-50" id="condicionesContratacion" name="condicionesContratacion" onchange="if (this.checked==false) {this.value=''} else {this.value=1};" value="1" required>
                    <span>Acepto las <a target="_blank" class="text-kulture-color-cuatro hover:border-b hover:border-b-kulture-color-cuatro" href="https://konectadores.kulture.es/condiciones-generales/">condiciones generales de contratación</a></span>
                    <span class="text-naranja">y las</span>
                    <a target="_blank" class="text-kulture-color-cuatro hover:border-b hover:border-b-kulture-color-cuatro" href="https://konectadores.kulture.es/aviso-legal/">condiciones legales</a>.
                </div>
            </div>
            @error('condicionesContratacion')
            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
            @enderror
            <div class="form-group has-feedback">
                <div class="col-sm-12">
                    <div class="checkbox">
                        <input type="checkbox" class="w-5 h-5 mr-1 border-gray-400 rounded shadow-md form-checkbox text-kulture-color-cuatro focus:border-red-600 focus:ring focus:ring-offset-0 focus:ring-red-100 focus:ring-opacity-50" id="politicaEmails" name="politicaEmails" onchange="if (this.checked==false) {this.value=''} else {this.value=1};" value="1" required>
                        <span>Acepto la <a target="_blank" class="text-kulture-color-cuatro hover:border-b hover:border-b-kulture-color-cuatro" href="https://www.kulture.es/politica-privacidad/">política de privacidad y envío de emails</a>.</span>
                    </div>
                </div>
                @error('politicaEmails')
                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <!-- Send button -->
        <button style="padding: 10px 0;" type="submit" id="crearCuenta" data-loading-text="Enviando..." class="flex items-center justify-center w-full text-white transition transform rounded-lg shadow-md px-7 bg-kulture-color-cuatro hover:text-kulture-color-cuatro hover:bg-white hover:shadow-gray-400"><i class="mr-1 text-2xl md:text-base md:mr-2 bi bi-send"></i> Enviar</button>
    </form>
</div>


</section>

@endsection