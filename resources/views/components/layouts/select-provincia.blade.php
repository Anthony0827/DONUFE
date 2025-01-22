<div class="form-group">
    <label for="{{ $name }}">Provincia</label>
  <select id="{{ $id ?? $name }}" name="{{ $name }}" class="form-control">
    <option value="">Selecciona una provincia</option>
    @foreach ($listado as $provincia)
        <option value="{{ $provincia->idprovincia }}" @selected($selectTipo == $provincia->idprovincia)>
            {{ $provincia->provincia }}
        </option>
    @endforeach
</select>
    @error($name)
        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
    @enderror
</div>
