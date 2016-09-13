<div class="vertical-box-column width-250">
    <!-- begin wrapper -->
    <div class="wrapper bg-silver text-center">
        <a href="{{url('modulos/mensajeria/mensajes/create')}}" class="btn btn-success p-l-40 p-r-40 btn-sm">
            Nuevo mensaje
        </a>
    </div>
    <!-- end wrapper -->
    <!-- begin wrapper -->
    <div class="wrapper">
        <p><b>Carpetas</b></p>
        <ul class="nav nav-pills nav-stacked nav-sm">
            <li class="{{Input::get('bandeja')=="entrada" ? 'active':''}}"><a
                        href="{{url("modulos/mensajeria/mensajes?bandeja=entrada")}}"><i
                            class="fa fa-inbox fa-fw m-r-5"></i> Bandeja de Entrada <span
                            class="badge pull-right">{{$noLeidos}}</span></a></li>
            <li class="{{Input::get('bandeja')=="salida" ? 'active':''}}"><a
                        href="{{url("modulos/mensajeria/mensajes?bandeja=salida")}}"><i
                            class="fa fa-send fa-fw m-r-5"></i> Enviados</a></li>
            <li class="{{Input::get('bandeja')=="papelera" ? 'active':''}}"><a
                        href="{{url("modulos/mensajeria/mensajes?bandeja=papelera")}}"><i
                            class="fa fa-trash fa-fw m-r-5"></i> Papelera</a></li>
        </ul>
    </div>
    <!-- end wrapper -->
</div>