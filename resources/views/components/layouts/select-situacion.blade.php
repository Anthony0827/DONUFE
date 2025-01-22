
<div class="form-group">
    <label for="idsituacion">Situación</label>
    <select name="{{ $name }}" class="form-control">
        <option value="">Seleccione un rango</option>
        @foreach ($listado as $op)
            <option value="{{ $op->idsituacion }}" @selected($selectTipo == $op->idsituacion)>
                {{ $op->descripcion }}
            </option>
        @endforeach
    </select>
    @error('idsituacion')
        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
    @enderror
</div>
