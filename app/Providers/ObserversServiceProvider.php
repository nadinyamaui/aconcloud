<?php namespace App\Providers;

use App\Listeners\Models\AlarmaObserver;
use App\Listeners\Models\ArchivoObserver;
use App\Listeners\Models\AyudaObserver;
use App\Listeners\Models\BaseObserver;
use App\Listeners\Models\ClasificacionIngresoEgresoObserver;
use App\Listeners\Models\CorteReciboObserver;
use App\Listeners\Models\EmailObserver;
use App\Listeners\Models\FondoObserver;
use App\Listeners\Models\InquilinoObserver;
use App\Listeners\Models\MensajeChatObserver;
use App\Listeners\Models\ModuloObserver;
use App\Listeners\Models\MovimientoCuentaObserver;
use App\Listeners\Models\PagoObserver;
use App\Listeners\Models\PeriodoJuntaObserver;
use App\Listeners\Models\ReciboObserver;
use App\Listeners\Models\TipoAyudaObserver;
use App\Listeners\Models\UserObserver;
use App\Models\App\Ayuda;
use App\Models\App\Banco;
use App\Models\App\CargoJunta;
use App\Models\App\Grupo;
use App\Models\App\Inquilino;
use App\Models\App\InquilinoUser;
use App\Models\App\Modulo;
use App\Models\App\TipoAyuda;
use App\Models\App\User;
use App\Models\Inquilino\Alarma;
use App\Models\Inquilino\Archivo;
use App\Models\Inquilino\ClasificacionIngresoEgreso;
use App\Models\Inquilino\CorteRecibo;
use App\Models\Inquilino\Cuenta;
use App\Models\Inquilino\Email;
use App\Models\Inquilino\Fondo;
use App\Models\Inquilino\MensajeChat;
use App\Models\Inquilino\MovimientosCuenta;
use App\Models\Inquilino\Pago;
use App\Models\Inquilino\PeriodoJunta;
use App\Models\Inquilino\PeriodoJuntaUser;
use App\Models\Inquilino\Preferencia;
use App\Models\Inquilino\Recibo;
use App\Models\Inquilino\TipoVivienda;
use App\Models\Inquilino\Vivienda;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Support\ServiceProvider;

class ObserversServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Dispatcher $dispatcher)
    {
        Banco::observe(new BaseObserver($dispatcher));
        CargoJunta::observe(new BaseObserver($dispatcher));
        Grupo::observe(new BaseObserver($dispatcher));
        Inquilino::observe(new InquilinoObserver($dispatcher));
        InquilinoUser::observe(new BaseObserver($dispatcher));
        User::observe(new UserObserver($dispatcher));
        ClasificacionIngresoEgreso::observe(new ClasificacionIngresoEgresoObserver($dispatcher));
        Cuenta::observe(new BaseObserver($dispatcher));
        Fondo::observe(new FondoObserver($dispatcher));
        MovimientosCuenta::observe(new MovimientoCuentaObserver($dispatcher));
        TipoVivienda::observe(new BaseObserver($dispatcher));
        Vivienda::observe(new BaseObserver($dispatcher));
        CorteRecibo::observe(new CorteReciboObserver($dispatcher));
        Preferencia::observe(new BaseObserver($dispatcher));
        Recibo::observe(new ReciboObserver($dispatcher));
        Modulo::observe(new ModuloObserver($dispatcher));
        Pago::observe(new PagoObserver($dispatcher));
        Ayuda::observe(new AyudaObserver($dispatcher));
        TipoAyuda::observe(new TipoAyudaObserver($dispatcher));
        Alarma::observe(new AlarmaObserver($dispatcher));
        PeriodoJunta::observe(new PeriodoJuntaObserver($dispatcher));
        PeriodoJuntaUser::observe(new BaseObserver($dispatcher));
        Archivo::observe(new ArchivoObserver($dispatcher));
        MensajeChat::observe(new MensajeChatObserver($dispatcher));
        Email::observe(new EmailObserver($dispatcher));
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

}
