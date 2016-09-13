<!-- begin #sidebar -->
<div id="sidebar" class="sidebar">
    <!-- begin sidebar scrollbar -->
    <div data-scrollbar="true" data-height="100%">
        <!-- begin sidebar user -->
        <ul class="nav">
            <li class="nav-profile">
                <div class="image">
                    <a href="{{url('users/perfil')}}">
                        <img src="{{$loggedUser->ruta_imagen_perfil}}">
                    </a>
                </div>
                <div class="info">
                    {{$loggedUser->nombre_completo or ""}}
                    <small>{{$loggedUser->grupo_activo or ""}}</small>
                </div>
            </li>
        </ul>
        <!-- end sidebar user -->
        <!-- begin sidebar nav -->
        <ul class="nav">
            <li class="has-sub {{Request::is('recibos/*') ? 'active':''}}">
                <a href="#">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-file-text-o"></i>
                    <span>Recibos</span>
                </a>
                <ul class="sub-menu">
                    <li class="{{Request::is('recibos/cortes/este-mes*') ? 'active':''}}">{!!link_to('recibos/cortes/este-mes','Corte de este mes')!!}</li>
                    @if(\App\Models\App\User::esJunta(true))
                        <li class="{{Request::is('recibos/cortes/create*') ? 'active':''}}">{!!link_to('recibos/cortes/create','Generar corte')!!}</li>
                    @endif
                    <li class="{{Request::is('recibos/pagos/create*') ? 'active':''}}">{!!link_to('recibos/pagos/create','Registrar Pagos')!!}</li>
                </ul>
            </li>
            @if(\App\Models\App\User::esJunta(true))
                <li class="has-sub {{Request::is('registrar/*') ? 'active':''}}">
                    <a href="#">
                        <b class="caret pull-right"></b>
                        <i class="fa fa-list"></i>
                        <span>Registrar</span>
                    </a>
                    <ul class="sub-menu">
                        <li class="{{Request::is('registrar/gastos*') ? 'active':''}}">{!!link_to('registrar/gastos/create','Gastos')!!}</li>
                        <li class="{{Request::is('registrar/ingresos*') ? 'active':''}}">{!!link_to('registrar/ingresos/create','Ingresos')!!}</li>
                        <li class="{{Request::is('registrar/estado-cuenta*') ? 'active':''}}">{!!link_to('registrar/estado-cuenta','Estado de cuenta')!!}</li>
                        <li class="{{Request::is('registrar/conciliar*') ? 'active':''}}">{!!link_to('registrar/conciliar','Conciliar Movimientos')!!}</li>
                        <li class="{{Request::is('registrar/caja-chica/reponer*') ? 'active':''}}">{!!link_to('registrar/caja-chica/reponer','Reposición de caja chica')!!}</li>
                    </ul>
                </li>
            @endif
            <li class="has-sub {{Request::is('consultas/*') ? 'active':''}}">
                <a href="#">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-search"></i>
                    <span>Consultas</span>
                </a>
                <ul class="sub-menu">
                    <li class="{{Request::is('consultas/gastos*') ? 'active':''}}">{!!link_to('consultas/gastos','Gastos')!!}</li>
                    <li class="{{Request::is('consultas/ingresos*') ? 'active':''}}">{!!link_to('consultas/ingresos','Ingresos')!!}</li>
                    <li class="{{Request::is('consultas/recibos*') ? 'active':''}}">{!!link_to('consultas/recibos','Recibos')!!}</li>
                    <li class="{{Request::is('consultas/pagos*') ? 'active':''}}">{!!link_to('consultas/pagos','Pagos')!!}</li>
                    <li class="{{Request::is('consultas/cortes*') ? 'active':''}}">{!!link_to('consultas/cortes','Corte de recibos')!!}</li>
                </ul>
            </li>
            <li class="has-sub {{Request::is('miscelaneos/*') ? 'active':''}}">
                <a href="#">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-search"></i>
                    <span>Miscelaneos</span>
                </a>
                <ul class="sub-menu">
                    <li class="{{Request::is('miscelaneos/archivos*') ? 'active':''}}">{!!link_to('miscelaneos/archivos','Archivos')!!}</li>
                </ul>
            </li>
            @if(isset($menu))
                @foreach($menu as $elem)
                    <li class="has-sub {{Request::is($elem['selector'].'*') ? 'active':''}}">
                        <a href="#">
                            <b class="caret pull-right"></b>
                            <i class="fa fa-{{$elem['icon']}}"></i>
                            <span>{{$elem['etiqueta']}}</span>
                        </a>
                        <ul class="sub-menu">
                            @foreach($elem['opciones'] as $opcion)
                                <li class="{{Request::is($opcion['ruta'].'*') ? 'active':''}}">{!!link_to($opcion['ruta'], $opcion['etiqueta'])!!}</li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            @endif
            @if(\App\Models\App\User::esJunta(true))
                <li class="has-sub {{Request::is('admin-inquilino/*') ? 'active':''}}">
                    <a href="#">
                        <b class="caret pull-right"></b>
                        <i class="fa fa-cog"></i>
                        <span>Administra Tu Condominio</span>
                    </a>
                    <ul class="sub-menu">
                        @if(!\App\Models\App\Inquilino::$current->ind_configurado)
                            <li class="{{Request::is('admin-inquilino/configurar*') ? 'active':''}}">{!!link_to('admin-inquilino/configurar/paso1','Asistente de Configuración')!!}</li>
                        @endif
                        <li class="{{Request::is('admin-inquilino/cuentas*') ? 'active':''}}">{!!link_to('admin-inquilino/cuentas','Cuentas Bancarias')!!}</li>
                        <li class="{{Request::is('admin-inquilino/tipo-viviendas*') ? 'active':''}}">{!!link_to('admin-inquilino/tipo-viviendas','Tipos de vivienda')!!}</li>
                        <li class="{{Request::is('admin-inquilino/viviendas*') ? 'active':''}}">{!!link_to('admin-inquilino/viviendas','Viviendas')!!}</li>
                        <li class="{{Request::is('admin-inquilino/fondos*') ? 'active':''}}">{!!link_to('admin-inquilino/fondos','Fondos')!!}</li>
                        <li class="{{Request::is('admin-inquilino/clasificacion-ingreso-egreso*') ? 'active':''}}">{!!link_to('admin-inquilino/clasificacion-ingreso-egreso','Clasificación de Ingresos/ Egresos')!!}</li>
                        <li class="{{Request::is('admin-inquilino/periodo-junta*') ? 'active':''}}">{!!link_to('admin-inquilino/periodo-junta','Junta de condominio')!!}</li>
                        <li class="{{Request::is('admin-inquilino/usuarios*') ? 'active':''}}">{!!link_to('admin-inquilino/usuarios','Usuarios')!!}</li>
                        <li class="{{Request::is('admin-inquilino/preferencias*') ? 'active':''}}">{!!link_to('admin-inquilino/preferencias','Preferencias')!!}</li>
                    </ul>
                </li>
            @endif
            @if(\App\Models\App\User::esAdmin())
                <li class="has-sub {{Request::is('admin/*') ? 'active':''}}">
                    <a href="#">
                        <b class="caret pull-right"></b>
                        <i class="fa fa-cog"></i>
                        <span>Administración Avanzada</span>
                    </a>
                    <ul class="sub-menu">
                        <li class="{{Request::is('admin/inquilinos*') ? 'active':''}}">{!!link_to('admin/inquilinos','Inquilinos')!!}</li>
                        <li class="{{Request::is('admin/usuarios*') ? 'active':''}}">{!!link_to('admin/usuarios','Usuarios')!!}</li>
                        <li class="{{Request::is('admin/bancos*') ? 'active':''}}">{!!link_to('admin/bancos','Bancos')!!}</li>
                        <li class="{{Request::is('admin/cargos-junta*') ? 'active':''}}">{!!link_to('admin/cargos-junta','Cargos de la Junta')!!}</li>
                        <li class="{{Request::is('admin/modulos*') ? 'active':''}}">{!!link_to('admin/modulos','Modulos del sistema')!!}</li>
                        <li class="{{Request::is('admin/ayudas*') ? 'active':''}}">{!!link_to('admin/ayudas','Ayudas/ Tutoriales')!!}</li>
                        <li class="{{Request::is('admin/tipo-ayudas*') ? 'active':''}}">{!!link_to('admin/tipo-ayudas','Tipos de ayuda/ Tutoriales')!!}</li>
                    </ul>
                </li>
            @endif
            <li class="nav-header">Licenciado a {{$inquilinoActivo->nombre}}</li>
            <li class="nav-header">Ambiente {{env('APP_ENV')}}</li>
            <!-- begin sidebar minify button -->
            <li><a href="javascript:" class="sidebar-minify-btn" data-click="sidebar-minify"><i
                            class="fa fa-angle-double-left"></i></a></li>
            <!-- end sidebar minify button -->
        </ul>
        <!-- end sidebar nav -->
    </div>
    <!-- end sidebar scrollbar -->
</div>
<div class="sidebar-bg"></div>
<!-- end #sidebar -->