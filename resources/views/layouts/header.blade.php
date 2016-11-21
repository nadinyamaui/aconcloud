<!-- begin #header -->
<div id="header" class="header navbar navbar-default navbar-fixed-top">
    <!-- begin container-fluid -->
    <div class="container-fluid">
        <!-- begin mobile sidebar expand / collapse button -->
        <div class="navbar-header">
            <a href="{{url('')}}">
                <img src="{{ url('build/images/logo.png') }}">
            </a>
            <button type="button" class="navbar-toggle" data-click="sidebar-toggled">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <!-- end mobile sidebar expand / collapse button -->

        <!-- begin header navigation right -->
        <ul class="nav navbar-nav navbar-right">
            <li class="{{Request::is('ayudas*') ? 'active':''}}">
                <a href="{{url('ayudas')}}" class="f-s-14">
                    <i class="fa fa-question-circle"></i>
                </a>
            </li>
            <li class="dropdown">
                <a href="javascript:" data-toggle="dropdown" class="dropdown-toggle f-s-14">
                    <i class="fa fa-bell-o"></i>
                    <span class="label">{{$cantAlarmasVencidas}}</span>
                </a>
                <ul class="dropdown-menu media-list pull-right animated fadeInDown">
                    <li class="dropdown-header">Alarmas ({{$cantAlarmasVencidas}})</li>
                    @foreach($alarmasVencidas->take(6)  as $alarma)
                        <li class="media">
                            <a href="{{url("alarmas/redirigir/".$alarma->id)}}">
                                <div class="media-left"><i
                                            class="fa {{App\Helpers\Helper::getRandomIcon()}} media-object bg-{{App\Helpers\Helper::getRandomColor()}}"></i>
                                </div>
                                <div class="media-body">
                                    <h6 class="media-heading">{{$alarma->nombre}}</h6>

                                    <p>{{$alarma->descripcion}}</p>
                                    @if($alarma->fecha_vencimiento != null)
                                        <div class="text-muted f-s-11">{{$alarma->fecha_vencimiento->diffForHumans()}}</div>
                                    @endif
                                </div>
                            </a>
                        </li>
                    @endforeach
                    <li class="dropdown-footer text-center">
                        {!!link_to("alarmas", "Ver Más")!!}
                    </li>
                </ul>
            </li>
            <li class="dropdown navbar-user">
                <a href="javascript:" class="dropdown-toggle" data-toggle="dropdown">
                    <span class="hidden-xs">{{$loggedUser->nombre_completo or ""}}</span> <b class="caret"></b>
                </a>
                <ul class="dropdown-menu animated fadeInLeft">
                    <li class="arrow"></li>
                    <li><a href="{{url('users/perfil')}}">Mi Perfil</a></li>
                    <li><a href="{{url('alarmas')}}"><span
                                    class="badge badge-danger pull-right">{{$cantAlarmasVencidas}}</span> Alarmas</a>
                    </li>
                    <li class="divider"></li>
                    <li>{!!HTML::link('auth/logout','Cerrar Sesión')!!}</li>
                </ul>
            </li>
        </ul>
        <!-- end header navigation right -->
    </div>
    <!-- end container-fluid -->
</div>
<!-- end #header -->