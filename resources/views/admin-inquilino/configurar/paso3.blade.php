@extends('admin-inquilino.configurar.layout')
@section('contenido2')
    <fieldset>
        <legend class="pull-left width-full">Tipos de vivienda de tu edificio</legend>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped table-bordered nowrap">
                    <thead>
                    <tr>
                        <th>Tipo de vivienda</th>
                        <th>Cantidad Apartamentos</th>
                        <th>% de Pago</th>
                        <th>Total % por tipo</th>
                        <th style="width: 5%;">Quitar</th>
                    </tr>
                    </thead>
                    <tbody id="contenido-tabla">
                    <tr id="template-tipo-vivienda" style="display: none;">
                        <td>
                            {!!Form::hidden('id[]',$tipo->id)!!}
                            {!!Form::simple2($tipo,'nombre[]', 12, 'text', [],[], false)!!}
                        </td>
                        <td>{!!Form::simple2($tipo,'cantidad_apartamentos[]', 12, 'text',['class'=>'cantidad-apartamentos '], [], false)!!}</td>
                        <td>{!!Form::simple2($tipo,'porcentaje_pago[]', 12, 'text',['class'=>'porcentaje-pago '], [], false)!!}</td>
                        <td>{!!Form::simple2($tipo,'total_porcentaje[]', 12, 'text',['class'=>'total-porcentaje '], [], false)!!}</td>
                        <td class="text-center">
                            <span class="btn btn-xs btn-danger glyphicon glyphicon-remove delete-tipo-vivienda"></span>
                        </td>
                    </tr>
                    @foreach($tipos as $tipo)
                        <tr>
                            <td>
                                {!!Form::hidden('id[]',$tipo->id)!!}
                                {!!Form::simple2($tipo,'nombre[]', 12, 'text', [],[], false)!!}
                            </td>
                            <td>{!!Form::simple2($tipo,'cantidad_apartamentos[]', 12, 'text',['class'=>'cantidad-apartamentos '], [], false)!!}</td>
                            <td>{!!Form::simple2($tipo,'porcentaje_pago[]', 12, 'text',['class'=>'porcentaje-pago '], [], false)!!}</td>
                            <td>{!!Form::simple2($tipo,'total_porcentaje[]', 12, 'text',['class'=>'total-porcentaje '], [], false)!!}</td>
                            <td class="text-center">
                                <span class="btn btn-xs btn-danger glyphicon glyphicon-remove delete-tipo-vivienda"></span>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th colspan="2"></th>
                        <th>Total</th>
                        <th class="decimal-format" data-m-dec="6" id="total_porcentaje_global"></th>
                    </tr>
                    </tfoot>
                </table>
                <div class="form-group">
                    <button type="button" class="btn btn-primary" id="add-tipo-vivienda"><i class="fa fa-plus"></i> Agregar un tipo de vivienda</button>
                    <button type="submit" class="btn btn-primary pull-right" name="solo_guardar" value="true"><i class="fa fa-floppy-o"></i> Guardar</button>
                </div>
            </div>
        </div>
    </fieldset>
@endsection
@section('javascript')
    {!!HTML::script('js/views/admin-inquilino/configurar/paso3.js')!!}
@endsection