<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Registro;
use App\Http\Requests\SecondStepRequest;
use App\Models\App\Inquilino;
use App\Models\App\User;
use App\Models\Inquilino\Vivienda;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Routing\ResponseFactory;

class AuthController extends Controller
{

    /**
     * Create a new authentication controller instance.
     *
     * @param  \Illuminate\Contracts\Auth\Guard $auth
     * @param  \Illuminate\Contracts\Auth\Registrar $registrar
     *
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
        $this->middleware('guest', ['except' => ['getLogout', 'getNuevacontrasena', 'postNuevacontrasena']]);
    }

    /**
     * Show the application login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogin()
    {
        $data['inquilino'] = Inquilino::$current;
        $data['usuario'] = new User();

        return view('auth.login', $data);
    }

    /**
     * Handle the login for user
     * @return Redirect Redirect to Index or redirect to
     * the previously requested page
     */
    public function postLogin(Request $request)
    {
        $result = User::login($request->only(['email', 'password']));
        if ($result === true && $this->auth->check()) {
            $user = $this->auth->user();
            if ($user->ind_cambiar_password) {
                return redirect('auth/nuevacontrasena');
            }

            return redirect()->intended('');
            //Autenticacion en dos pasos
        } elseif($result instanceof User && $result->ind_autenticacion_en_dos_pasos){
            $result->enviarCodigoEnDosPasos();
            session()->set('user_id', $result->id);
            return redirect('auth/second-step');
        } else {
            return redirect()->back()->withInput()->withErrors($result);
        }
    }

    public function getLogout()
    {
        $this->auth->logout();
        return redirect('auth/login');
    }

    public function getRegistro(ResponseFactory $response, $token, $id)
    {
        $data['inquilino'] = Inquilino::$current;
        if ($data['inquilino']->id != $id || $data['inquilino']->token_acceso != $token) {
            return $response->view('errors.403');
        }
        $data['usuario'] = new User();
        $data['vivienda'] = new Vivienda();

        return view('auth.registro', $data);
    }

    public function postRegistro(Registro $request)
    {
        $vivienda = Vivienda::whereTipoViviendaId($request->get('tipo_vivienda_id'))->whereNull("piso")->whereNull("torre")->first();
        if (is_null($vivienda)) {
            $vivienda = new Vivienda();
            $vivienda->addError('tipo_vivienda_id',
                'Ya no hay viviendas disponibles de este tipo, seguro que este es tu tipo de vivienda');

            return redirect()->back()->withErrors($vivienda->getErrors())->withInput();
        }
        $usuario = User::updateCreate($request->all());
        if (!$usuario->hasErrors()) {
            $vivienda->piso = $request->get('piso');
            $vivienda->torre = $request->get('torre');
            $vivienda->numero_apartamento = $request->get('numero_apartamento');
            $vivienda->propietario_id = $usuario->id;
            $vivienda->usuarios()->attach($usuario);
            $vivienda->save();
            $this->auth->login($usuario);

            return redirect()->intended();
        }

        return redirect()->back()->withErrors($usuario->getErrors())->withInput();
    }

    public function getNuevacontrasena()
    {
        $user = $this->auth->user();

        return view('auth.nueva-contrasena', compact('user'));
    }

    public function postNuevacontrasena(Request $request)
    {
        $user = $this->auth->user();
        if ($user->cambiarPassword($request->get('password'), $request->get('password_confirmation'))) {
            return redirect()->intended('');
        }

        return redirect()->back()->withErrors($user->getErrors());
    }

    public function getSecondStep()
    {
        $data['user'] = User::findOrFail(session('user_id'));
        $data['user']->token_autenticacion_en_dos_pasos = "";
        return view('auth.second-step', $data);
    }

    public function postSecondStep(SecondStepRequest $request)
    {
        $user = User::findOrFail(session('user_id'));
        if($user->codigoValido($request->get('token_autenticacion_en_dos_pasos'))){
            auth()->login($user);
            return redirect()->intended('');
        }
        return redirect()->back()->withErrors(['token_autenticacion_en_dos_pasos'=>"C&oacute;digo Inv&aacute;lido"]);
    }
}
