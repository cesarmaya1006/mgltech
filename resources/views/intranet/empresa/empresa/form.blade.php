<div class="row">
    <div class="col-12 col-md-2 form-group">
        <label for="emp_grupo_id">Grupo Empresarial</label>
        <select id="emp_grupo_id" class="form-control form-control-sm" name="emp_grupo_id" required>
            <option value="">Elija grupo</option>
            @foreach ($grupos as $grupo)
                <option value="{{ $grupo->id }}" {{isset($empresa_edit)?$empresa_edit->emp_grupo_id == $grupo->id?'selected':'':''}}>
                    {{ $grupo->grupo }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-12 col-md-2 form-group">
        <label for="tipo_documento_id">Tipo de identificación</label>
        <select id="tipo_documento_id" class="form-control form-control-sm" name="tipo_documento_id" required>
            <option value="">Elija tipo</option>
            @foreach ($tiposdocu as $tipoDocu)
                <option value="{{ $tipoDocu->id }}" {{isset($empresa_edit)?$empresa_edit->tipo_documento_id == $tipoDocu->id?'selected':'':''}}>
                    {{ $tipoDocu->abreb_id }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-12 col-md-2 form-group">
        <label for="identificacion">Identificación</label>
        <input type="text" class="form-control form-control-sm" value="{{ old('identificacion', $empresa_edit->identificacion ?? '') }}" name="identificacion" id="identificacion" required>
    </div>
    <div class="col-12 col-md-4 form-group">
        <label for="empresa">Nombre Empresa</label>
        <input type="text" class="form-control form-control-sm" value="{{ old('empresa', $empresa_edit->empresa ?? '') }}" name="empresa" id="empresa" required>
    </div>
    <div class="col-12 col-md-4 form-group">
        <label for="email">Correo Electrónico</label>
        <input type="email" class="form-control form-control-sm" value="{{ old('email', $empresa_edit->email ?? '') }}" name="email" id="email" required>
    </div>
    <div class="col-12 col-md-2 form-group">
        <label for="telefono">Teléfono</label>
        <input type="tel" class="form-control form-control-sm" value="{{ old('telefono', $empresa_edit->telefono ?? '') }}" name="telefono" id="telefono" required>
    </div>
    <div class="col-12 col-md-4 form-group">
        <label for="direccion">Dirección</label>
        <input type="tel" class="form-control form-control-sm" value="{{ old('direccion', $empresa_edit->direccion ?? '') }}" name="direccion" id="direccion" required>
    </div>
    <div class="col-12 col-md-3 form-group">
        <label for="contacto">Contacto</label>
        <input type="text" class="form-control form-control-sm" value="{{ old('contacto', $empresa_edit->contacto ?? '') }}" name="contacto" id="contacto" required>
    </div>
    <div class="col-12 col-md-3 form-group">
        <label for="cargo">Cargo contacto</label>
        <input type="text" class="form-control form-control-sm" value="{{ old('cargo', $empresa_edit->cargo ?? '') }}" name="cargo" id="cargo" required>
    </div>
    <div class="col-12 col-md-6 form-group">
        <div class="row">
            <div class="col-12 form-group">
                <label for="logo" class="requerido">Logo Empresarial</label>
                <input type="file" class="form-control" id="logo" name="logo" placeholder="logo" accept="image/png,image/jpeg" onchange="mostrar()">
            </div>
            <div class="col-12">
                <div class="row d-flex justify-content-center">
                    <div class="col-10 col-md-6">
                        <img class="img-fluid fotoEmpresa" id="fotoEmpresa" src="{{ isset($empresa_edit) ?($empresa_edit->logo!=null?asset('/imagenes/empresas/'.$empresa_edit->logo) : asset('/imagenes/empresas/empresa1.png')) : asset('/imagenes/empresas/empresa1.png') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
