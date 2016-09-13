<div class="row">
    <div class="col-md-12">
        <table class="table table-striped table-bordered nowrap responsive-datatable" width="100%"
               id="{{$table_id or ""}}">
            <thead>
            <tr>
                @foreach($prettyFields as $col)
                    <th>{{$col}}</th>
                @endforeach
                @if(count($botones)>0)
                    <th style="width: 5%;">Acciones</th>
                @endif
            </tr>
            </thead>
            <tbody>
            @foreach($collection as $object)
                <tr data-id='{{$object->id}}'>
                    @foreach($prettyFields as $key=>$col)
                        <td class="{{$object->isDecimalField($key) ? "decimal-format":""}}">{!!$object->getValueAt($key)!!}</td>
                    @endforeach
                    @if(count($botones)>0)
                        <td>
                            @foreach($botones as $icon => $boton)
                                <a class="btn btn-xs btn-primary glyphicon glyphicon-{{$icon}}" title="{{$boton}}"
                                   data-id='{{$object->id}}'></a>
                            @endforeach
                        </td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>