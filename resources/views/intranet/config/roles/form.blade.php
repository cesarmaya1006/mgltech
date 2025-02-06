<div class="row">
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label class="requerido" for="name">Nombre del Rol</label>
            <input type="text" class="form-control form-control-sm" name="name" id="name" aria-describedby="helpId"
                value="{{ old('name', $rol_edit->name ?? '') }}" placeholder="Nombre de rol" required>
        </div>
    </div>
</div>
