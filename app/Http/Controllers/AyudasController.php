<?php namespace App\Http\Controllers;

use App\Models\App\Ayuda;
use Illuminate\Http\Request;

class AyudasController extends Controller
{

    /**
     * Show the application welcome screen to the user.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $data['ayudas'] = Ayuda::aplicarFiltro($request->get('q'))->get();

        return view('ayudas.index', $data);
    }

    public function show($id)
    {
        $data['ayuda'] = Ayuda::findOrFail($id);

        return view('ayudas.show', $data);
    }

}
