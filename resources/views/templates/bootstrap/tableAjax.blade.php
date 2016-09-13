<div class="row">
    <div class="col-md-12">
        <input type="hidden" value="{{json_encode($prettyFields)}}" name="table_columns" id="table_columns">
        <table data-has_show="{{$hasShow}}" data-has_edit="{{$hasEdit}}" data-has_delete="{{$hasDelete}}"
               class="table table-striped table-bordered nowrap responsive-datatable" width="100%"
               data-url="{{$urlAjax}}" data-modal="{{$modal}}" data-edit_url="{{$urlCrud}}">
            <thead>
            <tr>
                @foreach($prettyFields as $col)
                    @if(is_string($col))
                        <th>{!!$col!!}</th>
                    @else
                        <th>{{$col->label}}</th>
                    @endif
                @endforeach
                @if($hasShow || $hasEdit || $hasDelete)
                    <th style="width: 10%;">Acciones</th>
                @endif
            </tr>
            </thead>
        </table>
    </div>
</div>
@if($hasAdd)
    @include('templates.bootstrap.btnagregar',array('url'=>$urlAdd,'nombre'=>$nombreAdd))
@endif