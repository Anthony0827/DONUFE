<div class="form-group">
    <label for="{{ $name }}">Motivo</label>
    <select name="{{ $name }}" class="form-control" id="{{ $name }}">
        <option value="">Selecciona un motivo</option>
        @foreach ($listado as $op)
            <option value="{{ $op->motivo }}" @selected($selectedMotivo == $op->motivo)>
                {{ $op->motivo }}
            </option>
        @endforeach
    </select>
    @error($name)
        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
    @enderror
</div>
