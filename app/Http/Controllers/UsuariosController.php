<?php

namespace App\Http\Controllers;

use App\Models\AclRole;
use App\Models\AclUsuario;
use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Divisiones;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

/**
 * Controlador para la gestión de usuarios
 */
class UsuariosController extends Controller
{

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Función que muestra el index de usuarios 
     * @param Request
     */
    public function index(Request $request): View
    {
        try {
            $acl = new AclUsuario();
            $usuarios = Usuario::paginate(5);

            //Filtros
            if ($request->isMethod('post')) {
                $usuarios = Usuario::nick($request->nick)
                    ->email($request->email)
                    ->paginate(5);
            }
        } catch (\Exception $e) {
            return View('errors.500');
        }
        return view('gestion.usuarios.index', compact('usuarios', 'acl'));
    }
    /**
     * Acción para mostrar la vista que permite la creación de
     * un nuevo usuario en el sistema
     */

    public function create(): View
    {
        return view('gestion.usuarios.create');
    }

    /**
     * Almacenar un recurso recién creado en el almacenamiento
     * @param Request 
     */
    public function store(Request $request): RedirectResponse
    {
        //Validación de los datos
        $request->validate([
            'nick' => 'required|max:50|unique:acl_usuarios,nick|unique:usuarios,nick',
            'nombre' => 'required|max:50',
            'email' => 'required|max:255|email|unique:acl_usuarios,email|unique:usuarios,email',
            'password' => ['required', 'string', 'min:8', 'max:50', 'regex:/^(?=.*[A-Z])(?=.*\d).{8,}$/'],
            "confirmarPassword" => 'required|same:password',
            'fecha_nacimiento' => ['required', 'date', 'before:' . Carbon::now()->subYears(18)->format('Y-m-d')],
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'role' => 'required',
            'puntos' => 'numeric|min:0',
            'victorias' => 'numeric|min:0',
            'derrotas' => 'numeric|min:0',
            'creditos' => 'numeric|min:0'
        ]);
        try {
            $usuario = $this->crearUsuario($request);
        } catch (\Exception $e) {
            return View('errors.500');
        }
        return redirect()->route('verUsuario', compact('usuario'));
    }

    /**
     * Función que muestra la vista con la indormación de 
     * un usuario
     */
    public function show(Usuario $usuario): View
    {
        $acl = AclUsuario::where('nick', '=', $usuario->nick)->first();
        return view('gestion.usuarios.show', compact('usuario', 'acl'));
    }

    /**
     * Acción para modifcar el usuario
     * 
     * @param Request
     * @param Usuario $usuario
     */
    public function update(Request $request, Usuario $usuario): RedirectResponse
    {
        //Obtener el acl correspondiente del usuario
        $acl = AclUsuario::where('nick', '=', $usuario->nick)->first();

        //Validación de datos
        $request->validate([
            'nick' => [Rule::unique('acl_usuarios')->ignore($acl), Rule::unique('usuarios')->ignore($usuario)],
            'email' => ['required', 'max:255', Rule::unique('acl_usuarios')->ignore($acl), Rule::unique('usuarios')->ignore($usuario)],
            'nombre' => 'required|max:50',
            'password' => ['nullable', 'string', 'min:8', 'max:50', 'regex:/^(?=.*[A-Z])(?=.*\d).{8,}$/'],
            "confirmarPassword" => 'nullable|same:password',
            'fecha_nacimiento' => ['required', 'date', 'before:' . Carbon::now()->subYears(18)->format('Y-m-d')],
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'role' => 'nullable',
            'puntos' => 'numeric|min:0',
            'victorias' => 'numeric|min:0',
            'derrotas' => 'numeric|min:0',
            'creditos' => 'numeric|min:0'
        ]);
        try {

            if ($request->email != $acl->email) {
                $acl->email = $request->email;
            }
            if ($request->password != null) {
                $acl->password = Hash::make($request->password);
            }
            if ($acl->cod_acl_role != AclRole::dameCodRol($request->role) && $request->role != "Rol del usuario") {
                $acl->cod_acl_role = AclRole::dameCodRol($request->role);
            }
            $acl->nombre = $request->nombre;
            $acl->save();
            $usuario->avatar = ($request->avatar == null ? 'imgBD/usuarios/default.png' : $request->avatar);
            $usuario->update($request->all());
            if ($request->hasFile('avatar')) {
                $image = $request->file('avatar');
                $fileName = $usuario->cod_usuario . '.' . $image->getClientOriginalExtension();

                $image->move(public_path('imgBD/usuarios'), $fileName);
                // Actualizar la ruta de la imagen de perfil en la base de datos
                $usuario->avatar = 'imgBD/usuarios/' . $fileName;
                $usuario->save();
            }
            $usuario->comprobarDivision();
        } catch (\Exception $e) {
            return View('errors.500');
        }
        return redirect()->route('listaUsuarios')->with('success', 'Usuario modficado con éxito');
    }

    /**
     * Accion para borrar el producto
     * @param Usuario
     */
    public function destroy(Usuario $usuario): RedirectResponse
    {
        $acl = AclUsuario::where('nick', '=', $usuario->nick)->first();
        if ($usuario->borrado) {
            $usuario->borrado = false;
        } else {
            $usuario->borrado = true;
        }
        if ($acl->borrado) {
            $acl->borrado = false;
        } else {
            $acl->borrado = true;
        }
        $acl->save();
        $usuario->save();
        return redirect()->route('listaUsuarios')
            ->with('correcto', 'Usuario borrado con éxito');
    }
    /**
     * Función privada que se encarga de la creación de un uusuario
     * con los datos que llegan desde el cliente 
     * @param Request
     * @return Usuario usuario creado
     */
    private  function crearUsuario(Request $request): Usuario
    {

        $request->merge([
            'acl_role' => AclRole::select('cod_acl_role')->where('nombre', '=', $request->role)->first()
        ]);
        $request->merge([
            'password' => Hash::make($request->password)
        ]);
        $request->merge([
            'borrado' => 1
        ]);

        $user = new AclUsuario();
        $user->nick = $request->nick;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->nombre = $request->nombre;
        $user->cod_acl_role = $request->acl_role->cod_acl_role;
        $user->borrado = 0;
        $user->save();

        $division = Divisiones::select('cod_division')
            ->where('puntos_minimos', '<=', $request->puntos)
            ->where('puntos_maximos', '>=', $request->puntos)
            ->first()
            ->value('cod_division');
        $request->request->add([
            'cod_division' => $division
        ]);
        $request->request->add([
            "borrado" => 0
        ]);
        if ($request->hasFile('avatar')) {
            $image = $request->file('avatar');
            $fileName = $request->nick . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('imgBD/usuarios'), $fileName);
        } else {
            $fileName = "default.png";
        }
        $usuario = Usuario::create($request->all());
        $usuario->avatar = 'imgBD/usuarios/' . $fileName;
        $usuario->save();
        $login = new LoginController();
        $login->otorgarIniciales($usuario->cod_usuario);
        return $usuario;
    }
}
