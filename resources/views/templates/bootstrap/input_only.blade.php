<div class="col-md-{{$numCols}} form-group">
    @if($type=="text")
        {!! Form::text($name, Input::old($name,$value), $params)!!}
    @elseif($type=="password")
        {!! Form::password($name, $params)!!}
    @elseif($type=="textarea")
        {!! Form::textarea($name, Input::old($name,$value), $params)!!}
    @elseif($type=="file")
        {!! Form::file($name, $params)!!}
    @elseif($type=="boolean")
        <label for="{!!$name!!}">{!!$label!!}</label>
        <div class="btn-group" data-toggle="buttons">
            <label class="btn btn-default {!!Input::old($name,$value,0)==1 ? "active":""!!}">
                {!! Form::radio($attrName,1,Input::old($name,$value)==1, $params)!!} Si
            </label>
            <label class="btn btn-default {!!Input::old($name,$value,0)==0 ? "active":""!!}">
                {!! Form::radio($attrName,0,Input::old($name,$value,0)==0, $params)!!} No
            </label>
        </div>
    @endif
</div>