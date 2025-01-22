
<div class="form-group">
    <label for="idsector">Sector</label>
    <select name="{{ $name }}" class="form-control">
        <option value="">Seleccione un rango</option>
        @foreach ($listado as $op)
            <option value="{{ $op->idsector }}" @selected($selectTipo == $op->idsector)>
                {{ $op->nombre }}
            </option>
        @endforeach
    </select>
    @error('idsector')
        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
    @enderror
</div>
