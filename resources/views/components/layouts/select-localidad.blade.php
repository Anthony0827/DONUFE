<div class="form-group">
    <label for="{{ $id }}">Localidad</label>
    <select id="{{ $id }}" name="{{ $name }}" class="form-control">
        <option value="">Selecciona una localidad</option>
        @foreach ($listado as $localidad)
            <option value="{{ $localidad->idlocalidad }}" @selected($selectTipo == $localidad->idlocalidad)>
                {{ $localidad->localidad }}
            </option>
        @endforeach
    </select>
    @error($name)
        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
    @enderror
</div>
