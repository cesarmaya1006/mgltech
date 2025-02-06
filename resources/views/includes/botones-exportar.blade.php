<hr>
<div class="opcionesExportar mb-3">
    <div class="row mt-2">
        <div class="col-12 col-lg-1 col-md-1 text-md-right text-lg-right pr-md-2 pr-lg-2"><strong>Exportar:</strong></div>
        <div class="col-12 col-lg-1 col-md-1" style="display: flex; flex-direction: row;">
            <a class="mb-sm-3" href="#" onclick="$('{{$tablaExportar}}').tableExport({type: 'excel', escape: 'false', ignoreColumn: [{{$ignoraColumnas}}], exportHiddenCells: 'true',fileName:'{{ $nombreTabla }}'});" class="btn-accion-tabla tooltipsC mr-1" title="Exportar a Excel">
                <img class="img-fluid" src="{{Storage::url('public/imagenes/sistema/excel-logo.png')}}" alt="Exportar a Excel" width="40px" height="auto">
            </a>
            <a href="#" onclick="$('{{$tablaExportar}}').tableExport({type: 'pdf', jspdf: {orientation: 'l', margins: {left: 20, top: 10}, escape: 'false'}, ignoreColumn: [{{$ignoraColumnas}}],fileName:'{{$nombreTabla}}'});" class="btn-accion-tabla tooltipsC" title="Exportar a Pdf" >
                <img class="img-fluid" src="{{Storage::url('public/imagenes/sistema/pdf-logo.png')}}" alt="Exportar a PDF" width="40px" height="auto">
            </a>
        </div>
        <div class="col-lg-7 text-right pr-2"></div>
        <div class="col-lg-3 mt-sm-5">
            <a href="{{route($varPaginaCrear,['pagVolver' => $varPaginaVolver])}}" class="btn btn-block btn-info btn-sm" style="max-width: 150px">
                <i class="fa fa-fw fa-plus-circle"></i> Nuevo registro
            </a>
        </div>
    </div>
</div>
@section('scripts_exportar_tabla')
<!-- ................................................................................................................... -->
<!-- Scripts para Exportar la Tabla -->
<script type="text/javascript" src="{{Storage::url('public/table_export/xlsx.core.min.js')}}"></script>
<script type="text/javascript" src="{{Storage::url('public/table_export/FileSaver.min.js')}}"></script>
<script type="text/javascript" src="{{Storage::url('public/table_export/jspdf.min.js')}}"></script>
<script type="text/javascript" src="{{Storage::url('public/table_export/jspdf.plugin.autotable.js')}}"></script>
<script type="text/javascript" src="{{Storage::url('public/table_export/es6-promise.auto.min.js')}}"></script>
<script type="text/javascript" src="{{Storage::url('public/table_export/html2canvas.min.js')}}"></script>
<script type="text/javascript" src="{{Storage::url('public/table_export/tableExport.js')}}"></script>
<!-- ................................................................................................................... -->
@endsection

