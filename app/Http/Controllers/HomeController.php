<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\AclUsuario;
use App\Models\Usuario;
use Illuminate\View\View;

/**
 * Controlador para la gestión de las vistas principales de la aplicación
 */
class HomeController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->middleware('admin')->only(['gestion']);
    }
    /**
     * Función que muestra la vista del index
     */
    public function __invoke():View
    {
        return view('index');
    }
    /**
     * Función que muestra la vista index
     */
    public function index():View
    {
        return view('index');
    }

    /**
     * Función que muestra la vista de "sobre nosotros"
     */
    public function nosotros():View
    {
        return view('nosotros');
    }



}
