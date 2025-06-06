@if (isset($grupo_edit))
    <div class="row">
        <div class="col-12">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" name="estado" id="estado" value="{{$grupo_edit->estado?'1':'0'}}" {{$grupo_edit->estado?'checked':''}}>
                <label class="form-check-label" id="labelCheck" for="estado">{{$grupo_edit->estado?'Grupo Activo':'Grupo Inactivo'}}</label>
            </div>
        </div>
    </div>
    <br>
@endif
<div class="row">
    <div class="col-5 col-md-2 form-group">
        <label for="tipo_documento_id" class="requerido">Tipo de identificación</label>
        <select id="tipo_documento_id" class="form-control form-control-sm" name="tipo_documento_id" required>
            <option value="">Elija tipo</option>
            @foreach ($tiposdocu as $tipoDocu)
                <option value="{{ $tipoDocu->id }}" {{isset($grupo_edit)?$grupo_edit->tipo_documento_id == $tipoDocu->id?'selected':'':''}}>
                    {{ $tipoDocu->abreb_id }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-7 col-md-2 form-group">
        <label for="identificacion" class="requerido">Identificación</label>
        <input type="text" class="form-control form-control-sm" value="{{ old('identificacion', $grupo_edit->identificacion ?? '') }}" name="identificacion" id="identificacion" required>
    </div>
    <div class="col-12 col-md-4 form-group">
        <label for="grupo" class="requerido">Nombre Grupo Empresarial</label>
        <input type="text" class="form-control form-control-sm" value="{{ old('grupo', $grupo_edit->grupo ?? '') }}" name="grupo" id="grupo" required>
    </div>
    <div class="col-12 col-md-4 form-group">
        <label for="email" class="requerido">Correo Electrónico</label>
        <input type="email" class="form-control form-control-sm" value="{{ old('email', $grupo_edit->email ?? '') }}" name="email" id="email" required>
    </div>
    <div class="col-12 col-md-2 form-group">
        <label for="telefono" class="requerido">Teléfono</label>
        <input type="tel" class="form-control form-control-sm" value="{{ old('telefono', $grupo_edit->telefono ?? '') }}" name="telefono" id="telefono" required>
    </div>
    <div class="col-12 col-md-4 form-group">
        <label for="direccion" class="requerido">Dirección</label>
        <input type="tel" class="form-control form-control-sm" value="{{ old('direccion', $grupo_edit->direccion ?? '') }}" name="direccion" id="direccion" required>
    </div>
    <div class="col-12 col-md-3 form-group">
        <label for="contacto" class="requerido">Contacto</label>
        <input type="text" class="form-control form-control-sm" value="{{ old('contacto', $grupo_edit->contacto ?? '') }}" name="contacto" id="contacto" required>
    </div>
    <div class="col-12 col-md-3 form-group">
        <label for="cargo" class="requerido">Cargo contacto</label>
        <input type="text" class="form-control form-control-sm" value="{{ old('cargo', $grupo_edit->cargo ?? '') }}" name="cargo" id="cargo" required>
    </div>
</div>

