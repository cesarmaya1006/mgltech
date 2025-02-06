@if (isset($empresa_edit))
    <div class="row">
        <div class="col-12">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" name="estado" id="estado" value="{{$empresa_edit->estado?'1':'0'}}" {{$empresa_edit->estado?'checked':''}}>
                <label class="form-check-label" id="labelCheck" for="estado">{{$empresa_edit->estado?'Empresa Activa':'Empresa Inactiva'}}</label>
            </div>
        </div>
    </div>
    <br>
@endif
<div class="row">
    <div class="col-5 col-md-2 form-group">
        <label class="requerido" for="docutipos_id">Tipo de identificación</label>
        <select id="docutipos_id" class="form-control form-control-sm" name="docutipos_id" required>
            <option value="">Elija tipo</option>
            @foreach ($tiposdocu as $tipoDocu)
                <option value="{{ $tipoDocu->id }}" {{isset($empresa_edit)?($empresa_edit->docutipos_id==$tipoDocu->id?'selected':''):''}}>{{ $tipoDocu->tipo_id }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-7 col-md-2 form-group">
        <label class="requerido" for="identificacion">Identificación</label>
        <input type="text" class="form-control form-control-sm" name="identificacion" id="identificacion" value="{{ old('identificacion', $empresa_edit->identificacion ?? '') }}" required>
    </div>
    <div class="col-12 col-md-4 form-group">
        <label class="requerido" for="nombre">Empresa</label>
        <input type="text" class="form-control form-control-sm" name="nombre" id="nombre" value="{{ old('nombre', $empresa_edit->nombre ?? '') }}" required>
    </div>
    <div class="col-12 col-md-4 form-group">
        <label class="requerido" for="email">Correo Electrónico</label>
        <input type="email" class="form-control form-control-sm" name="email" id="email" value="{{ old('email', $empresa_edit->email ?? '') }}" required>
    </div>
    <div class="col-12 col-md-2 form-group">
        <label class="requerido" for="telefono">Teléfono</label>
        <input type="tel" class="form-control form-control-sm" name="telefono" id="telefono" value="{{ old('telefono', $empresa_edit->telefono ?? '') }}" required>
    </div>
    <div class="col-12 col-md-4 form-group">
        <label class="requerido" for="contacto">Contacto</label>
        <input type="text" class="form-control form-control-sm" name="contacto" id="contacto" value="{{ old('contacto', $empresa_edit->contacto ?? '') }}" required>
    </div>
    <div class="col-12 col-md-4 form-group">
        <label class="requerido" for="cargo">Cargo contacto</label>
        <input type="text" class="form-control form-control-sm" name="cargo" id="cargo" value="{{ old('cargo', $empresa_edit->cargo ?? '') }}" required>
    </div>
</div>
