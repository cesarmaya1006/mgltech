@if (session('rol_principal_id')== 1 ||session('rol_principal_id')== 2)
    <div class="row">
        @if ($area_edit->empresa->grupo != null)
        <div class="col-12 col-md-3 form-group">
            <label class="requerido" for="emp_grupo_id">Grupo Empresarial</label>
            <select id="emp_grupo_id" class="form-control form-control-sm"
                    data_url="{{ route('grupo_empresas.getEmpresas') }}">
                    <option value="">Elija un Grupo Empresarial</option>
                    <option value="x">Sin grupo Empresarial</option>
                    @foreach ($grupos as $grupo)
                        <option value="{{ $grupo->id }}">
                            {{ $grupo->grupo }}
                        </option>
                    @endforeach
                </select>
        </div>

        @endif
        <div class="col-12 col-md-3 form-group {{isset($area_edit)==null?'d-none':''}}" id="caja_empresas">
            <label for="empresa_id" id="label_empresa_id">Empresa</label>
            @if ($area_edit->empresa->grupo != null)
                <select id="empresa_id" name="empresa_id" class="form-control form-control-sm" data_url="{{ route('areas.getAreas') }}">
                    @if (isset($area_edit))
                        <option value="">Elija empresa</option>
                        @foreach ($area_edit->empresa->grupo->empresas as $empresa)
                            <option value="{{ $empresa->id }}" {{$area_edit->empresa_id==$empresa->id? 'selected':''}}>
                                {{ $empresa->empresa }}
                            </option>
                        @endforeach
                    @else
                        <option value="">Elija grupo</option>
                    @endif
                </select>
            @else
                <span class="form-control form-control-sm">{{$area_edit->empresa->empresa}}</span>
            @endif

        </div>
    </div>
@else
    <div class="row">
        <div class="col-12 col-md-3 form-group" id="caja_empresas">
            <label for="empresa_id">Empresa</label>
            <select id="empresa_id" name="empresa_id" class="form-control form-control-sm" data_url="{{ route('areas.getAreas') }}" required>
                <option value="">Elija empresa</option>
                    @foreach ($grupo->empresas as $empresa)
                        <option value="{{ $empresa->id }}" {{isset($area_edit)?($area_edit->empresa_id==$empresa->id? 'selected':''):''}}>
                            {{ $empresa->empresa }}
                        </option>
                    @endforeach
            </select>
        </div>
    </div>
@endif
<hr  id="hr_cajaAreas">
<div class="row" id="row_caja_areas">
    <div class="col-12 col-md-3 form-group" id="caja_areas">
        <label for="area_id">Área Superior</label>
        <select id="area_id" class="form-control form-control-sm" name="area_id">
            <option value="">Elija área</option>
            @if (isset($area_edit))
                @foreach ($area_edit->empresa->areas as $area)
                    <option value="{{ $area->id }}" {{$area_edit->area_id==$area->id? 'selected':''}}>
                        {{ $area->area }}
                    </option>
                @endforeach
            @endif
        </select>
    </div>
    <div class="col-12 col-md-3 form-group" id="caja_area_nueva">
        <label class="requerido" for="area">Nombre del Área</label>
        <input type="text" class="form-control form-control-sm" value="{{ old('area', $area_edit->area ?? '') }}" name="area" id="area" required>
    </div>
</div>
