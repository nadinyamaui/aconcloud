<?php

Route::group(['prefix' => 'api'], function ($router) {
    $router->group(['prefix' => 'sms'], function ($router) {
        $router->get('pendientes', 'SmsController@pendientes');
        $router->get('enviado/{id}', 'SmsController@enviado');
        $router->get('error/{id}', 'SmsController@error');
    });
});

Route::controllers([
    'auth'     => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

Route::group(['middleware' => ['auth']], function ($router) {

    $router->group(['prefix' => 'chat'], function ($router) {
        $router->get('usuarios', 'ChatController@usuarios');
    });

    $router->get('/', 'WelcomeController@index');
    $router->get('terminos-condiciones', 'WelcomeController@terminosCondiciones');
    $router->post('terminos-condiciones', 'WelcomeController@terminosAceptados');
    $router->get('ayudas', 'AyudasController@index');
    $router->get('ayudas/{id}', 'AyudasController@show');

    $router->resource('archivos', 'ArchivosController');
    $router->get('archivos/descargar/{id}', 'ArchivosController@descargar');
    $router->post('archivos/datatable', 'ArchivosController@datatable');

    $router->resource('alarmas', 'AlarmasController');
    $router->post('alarmas/datatable', 'AlarmasController@datatable');
    $router->get('alarmas/redirigir/{id}', 'AlarmasController@redirigir');

    $router->resource('mensajes-chat', 'MensajeChatController');

    $router->group(['prefix' => 'miscelaneos'], function ($router) {
        $router->get('archivos', 'Miscelaneos\ArchivosController@index');
    });

    $router->group(['prefix' => 'graficos'], function ($router) {
        $router->controller('tipo-viviendas', 'Graficos\TipoViviendasController');
    });

    $router->group(['prefix' => 'recibos', 'namespace' => 'Recibos'], function ($router) {
        $router->get('cortes/este-mes', 'CortesController@esteMes');
        $router->resource('cortes', 'CortesController', ['only' => ['destroy', 'create', 'store', 'show']]);
        $router->resource('pagos', 'PagosController');

        $router->get('recibos/confirmar/{id}', 'RecibosController@confirmar');
        $router->post('recibos/confirmar', 'RecibosController@postConfirmar');
    });

    $router->group(['prefix' => 'users'], function($router){
        $router->get('perfil', 'UsersController@perfil');
        $router->post('perfil', 'UsersController@guardarPerfil');
        $router->post('foto', 'UsersController@guardarFoto');
    });

    $router->group(['prefix' => 'consultas'], function ($router) {
        $router->controller('gastos', 'Consultas\GastosController');
        $router->controller('ingresos', 'Consultas\IngresosController');
        $router->group(['prefix' => 'movimientos'], function ($router) {
            $router->post('cuentas/datatable', 'Consultas\MovimientosController@cuentas');
            $router->post('fondos/datatable', 'Consultas\MovimientosController@fondos');
        });
        $router->resource('cortes', 'Consultas\CortesController', ['only' => ['index', 'show']]);
        $router->resource('recibos', 'Consultas\RecibosController', ['only' => ['index', 'show']]);
        $router->resource('pagos', 'Consultas\PagosController', ['only' => ['index', 'show']]);

        $router->get('recibos/descargar/{id}', 'Consultas\RecibosController@descargar');

        $router->post('cortes/datatable', 'Consultas\CortesController@datatable');
        $router->post('recibos/datatable', 'Consultas\RecibosController@datatable');
        $router->post('pagos/datatable', 'Consultas\PagosController@datatable');
    });

    $router->group(['prefix' => 'registrar'], function ($router) {
        $router->resource('gastos', 'Registrar\GastosController');
        $router->resource('ingresos', 'Registrar\IngresosController');
        $router->controller('estado-cuenta', 'Registrar\EstadoCuentaController');
        $router->group(['prefix' => 'conciliar'], function ($router) {
            $router->get('', 'Registrar\ConciliarController@index');
            $router->get('confirmar/{ingreso_id}/{estado_id}', 'Registrar\ConciliarController@confirmar');
            $router->post('confirmar', 'Registrar\ConciliarController@postConfirmar');
        });
        $router->get('caja-chica/reponer', 'Registrar\CajaChicaController@reponer');
        $router->post('caja-chica/reponer', 'Registrar\CajaChicaController@postReponer');
    });

    $router->group(['namespace' => 'AdminInquilino'], function ($router) {
        $router->get('admin-inquilino/viviendas/{id}', 'ViviendasController@show');
    });

    $router->group(['prefix' => 'admin-inquilino', 'middleware' => 'permisos.junta', 'namespace' => 'AdminInquilino'],
        function ($router) {

            $router->resource('cuentas', 'CuentasController');
            $router->post('cuentas/datatable', 'CuentasController@datatable');

            $router->resource('tipo-viviendas', 'TipoViviendasController', ['except' => ['show']]);
            $router->post('tipo-viviendas/datatable', 'TipoViviendasController@datatable');

            $router->resource('viviendas', 'ViviendasController');
            $router->post('viviendas/datatable', 'ViviendasController@datatable');

            $router->resource('fondos', 'FondosController');
            $router->post('fondos/datatable', 'FondosController@datatable');

            $router->resource('usuarios', 'UsuariosController');
            $router->post('usuarios/datatable', 'UsuariosController@datatable');

            $router->resource('clasificacion-ingreso-egreso', 'ClasificacionIngresoEgresoController');
            $router->post('clasificacion-ingreso-egreso/datatable',
                'ClasificacionIngresoEgresoController@datatable');

            $router->resource('periodo-junta', 'PeriodoJuntaController');
            $router->post('periodo-junta/datatable', 'PeriodoJuntaController@datatable');

            $router->resource('periodo-junta/{id}/users', 'PeriodoJuntaUsersController');
            $router->post('periodo-junta/{id}/users/datatable', 'PeriodoJuntaUsersController@datatable');

            $router->group(['prefix' => 'configurar'], function ($router) {
                $router->get('paso1', 'ConfigurarController@paso1');
                $router->get('paso2', 'ConfigurarController@paso2');
                $router->get('paso3', 'ConfigurarController@paso3');
                $router->get('paso4', 'ConfigurarController@paso4');
                $router->get('paso5', 'ConfigurarController@paso5');
                $router->get('paso6', 'ConfigurarController@paso6');
                $router->get('paso7', 'ConfigurarController@paso7');
                $router->get('paso8', 'ConfigurarController@paso8');
                $router->get('paso9', 'ConfigurarController@paso9');

                $router->get('generar-token', 'ConfigurarController@generarToken');

                $router->post('paso1', 'ConfigurarController@postPaso1');
                $router->post('paso2', 'ConfigurarController@postPaso2');
                $router->post('paso3', 'ConfigurarController@postPaso3');
                $router->post('paso4', 'ConfigurarController@postPaso4');
                $router->post('paso5', 'ConfigurarController@postPaso5');
                $router->post('paso6', 'ConfigurarController@postPaso6');
                $router->post('paso7', 'ConfigurarController@postPaso7');
                $router->post('paso8', 'ConfigurarController@postPaso8');
                $router->post('paso9', 'ConfigurarController@postPaso9');
            });

            $router->resource('preferencias', 'PreferenciasController', ['only' => ['index', 'store']]);
        });

    $router->group(['prefix' => 'admin', 'middleware' => 'permisos.admin'], function ($router) {
        $router->resource('inquilinos', 'Admin\InquilinosController');
        $router->post('inquilinos/datatable', 'Admin\InquilinosController@datatable');
        $router->get('inquilinos/{id}/instalar', 'Admin\InquilinosController@instalar');

        $router->resource('bancos', 'Admin\BancosController', ['except' => 'show']);
        $router->post('bancos/datatable', 'Admin\BancosController@datatable');

        $router->resource('cargos-junta', 'Admin\CargoJuntasController');
        $router->post('cargos-junta/datatable', 'Admin\CargoJuntasController@datatable');

        $router->resource('usuarios', 'Admin\UsuariosController');
        $router->post('usuarios/datatable', 'Admin\UsuariosController@datatable');

        $router->resource('modulos', 'Admin\ModulosController');
        $router->post('modulos/datatable', 'Admin\ModulosController@datatable');

        $router->resource('ayudas', 'Admin\AyudasController');
        $router->post('ayudas/datatable', 'Admin\AyudasController@datatable');

        $router->resource('tipo-ayudas', 'Admin\TipoAyudasController');
        $router->post('tipo-ayudas/datatable', 'Admin\TipoAyudasController@datatable');
    });
});
