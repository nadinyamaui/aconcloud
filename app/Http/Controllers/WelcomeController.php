<?php namespace App\Http\Controllers;

use App\Models\App\Inquilino;

class WelcomeController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Welcome Controller
    |--------------------------------------------------------------------------
    |
    | This controller renders the "marketing page" for the application and
    | is configured to only allow guests. Like most of the other sample
    | controllers, you are free to modify or remove it as you desire.
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application welcome screen to the user.
     *
     * @return Response
     */
    public function index()
    {
        return view('index');
    }

    /**
     * Show the application welcome screen to the user.
     *
     * @return Response
     */
    public function terminosCondiciones()
    {
        $data['inquilino'] = Inquilino::$current;
        return view('terminos-condiciones', $data);
    }

    /**
     * Show the application welcome screen to the user.
     *
     * @return Response
     */
    public function terminosAceptados()
    {
        $user = auth()->user();
        $user->terminos_aceptados = true;
        $user->save();
        return redirect('');
    }

}
