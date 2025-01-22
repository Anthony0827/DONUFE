<div class="form-group">
    <label for="idrangoedad">Rango de Edad</label>
    <select name="{{ $name }}" class="form-control">
        <option value="">Seleccione un rango</option>
        @foreach ($listado as $op)
            <option value="{{ $op->idrangoedad }}" @selected($selectTipo == $op->idrangoedad)>
                {{ $op->rangoedad }}
            </option>
        @endforeach
    </select>
    @error('idrangoedad')
        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
    @enderror
</div>
