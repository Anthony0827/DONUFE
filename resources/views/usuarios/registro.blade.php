<x-layouts.default title="Registro">
<h2>Registrar usuario</h2>
    <form action="{{ route('usuarios.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Email:</strong>
                    <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}">
                    @error('email')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>nombres:</strong>
                    <input type="nombres" name="nombres" class="form-control" placeholder="nombres" value="{{ old('nombres') }}">
                    @error('nombres')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Contraseña:</strong>
                    <input type="password" name="clave" class="form-control" placeholder="Contraseña" value="{{ old('clave') }}">
                    @error('clave')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Repite contraseña:</strong>
                    <input type="password" name="clave_confirmation" class="form-control" placeholder="Repite contraseña" value="{{ old('clave_confirmation') }}">
                    @error('clave_confirmation')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <br/>
                    <button type="submit" class="btn btn-primary ml-3">Registrar</button>
                </div>
            </div>       
        </div>
    </form>
</x-layouts.default>