<div class="form-group">
    <label for="idperfil">Perfil</label>
    <select name="{{ $name }}" class="form-control">
        <option value="">Seleccione un rango</option>
        @foreach ($listado as $op)
            <option value="{{ $op->idperfil }}" @selected($selectTipo == $op->idperfil)>
                {{ $op->perfil }}
            </option>
        @endforeach
    </select>
    @error('idperfil')
        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
    @enderror
</div>
