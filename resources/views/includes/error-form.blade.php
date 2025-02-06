@if ($errors->any())
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
            <font style="vertical-align: inherit;">
                <font style="vertical-align: inherit;">X</font>
            </font>
        </button>
        <h5>
            <i class="icon fas fa-ban"></i>
            <font style="vertical-align: inherit;">
                <font style="vertical-align: inherit;">!Alerta!</font>
            </font>
        </h5>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
