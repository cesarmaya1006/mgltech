<hr>
<div class="opcionesExportar mb-3">
    <div class="row mt-2">
        <div class="col-6 col-lg-1 col-md-2 text-right pr-2"><strong>Exportar:</strong></div>
        <div class="col-6 col-lg-1 col-md-2" style="display: flex; flex-direction: row;">
            <a href="#" onclick="$('{{$tablaExportar}}').tableExport({type: 'excel', escape: 'false', ignoreColumn: [{{$ignoraColumnas}}], exportHiddenCells: 'true',fileName:'{{ $nombreTabla }}'});" class="btn-accion-tabla tooltipsC mr-1" title="Exportar a Excel">
                <img class="img-fluid" src="{{Storage::url('public/imagenes/sistema/excel-logo.png')}}" alt="Exportar a Excel" width="40px" height="auto">
            </a>
            <a href="#" onclick="$('{{$tablaExportar}}').tableExport({type: 'pdf', jspdf: {orientation: 'l', margins: {left: 20, top: 10}, escape: 'false'}, ignoreColumn: [{{$ignoraColumnas}}],fileName:'{{$nombreTabla}}'});" class="btn-accion-tabla tooltipsC" title="Exportar a Pdf" >
                <img class="img-fluid" src="{{Storage::url('public/imagenes/sistema/pdf-logo.png')}}" alt="Exportar a Excel" width="40px" height="auto">
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

