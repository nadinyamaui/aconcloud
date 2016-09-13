<!-- begin col-12 -->
<div class="col-md-{{$cols}}">
    <div class="panel panel-inverse">
        @include('templates.panel-header', ['titulo'=>'Archivos'])
        <div class="panel-body">
            {!!HTML::tableAjax('App\Models\Inquilino\Archivo', App\Models\Inquilino\Archivo::columnasArchivo(), true, true, true, false, "archivos?item_type=".$item_type."&item_id=".$item_id, true)!!}
        </div>
    </div>
</div>