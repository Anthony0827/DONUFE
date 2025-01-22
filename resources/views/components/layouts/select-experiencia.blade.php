<div class="form-group">
    <label for="idexperiencia">Experiencia</label>
    <select name="{{ $name }}" class="form-control">
        <option value="">Seleccione un rango</option>
        @foreach ($listado as $op)
            <option value="{{ $op->idexperiencia }}" @selected($selectTipo == $op->idexperiencia)>
                {{ $op->descripcion }}
            </option>
        @endforeach
    </select>
    @error('idexperiencia')
        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
    @enderror
</div>
