<div class="form-group">
    <label for="ideducacion">Educación</label>
    <select name="{{ $name }}" class="form-control">
        <option value="">Seleccione un rango</option>
        @foreach ($listado as $op)
            <option value="{{ $op->ideducacion }}" @selected($selectTipo == $op->ideducacion)>
                {{ $op->descripcion }}
            </option>
        @endforeach
    </select>
    @error('iddepartamento')
        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
    @enderror
</div>
