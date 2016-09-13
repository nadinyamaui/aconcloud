<div class="col-xs-12 col-sm-{{$numCols}} col-md-{{$numCols}} form-group">
    {!!Form::label($params['id'], $attrLabel)!!}
    <p id="{{$params['id']}}">{{$attrValue}}</p>
</div>