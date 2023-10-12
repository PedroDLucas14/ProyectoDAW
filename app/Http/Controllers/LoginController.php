<?php

namespace App\Http\Controllers;

use App\Models\AclUsuario;
use App\Models\Usuario;
use App\Models\UsuariosNave;
use App\Models\UsuariosAccesorio;
use App\Models\UsuariosPiloto;
use App\Models\Piloto;
use App\Models\Nave;
use App\Models\Accesorio;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LoginController extends Controller
{

    private const NAVE_DEFECTO = 1;
    private const PILOTO_DEFECTO = 2;
    private const ACCESORIO_DEFECTO_1 = 3;
    private const ACCESORIO_DEFECTO_2 = 4;
    private const COD_ROLE_DEFECTO = 2;

    /**
     * Acción que realiza el registro de un jugador en la web
     *
     * @param Request $request
     * @param int $cod_role->Cod de Rol en la web por defecto 2 que es
     *              el número perteneciente al rol jugador
     * @return RedirectResponse
     */
    public function registrar(Request $request)
    {

        //Validar datos
        $request->validate(
            [
                'nick' => 'required|max:50|unique:acl_usuarios,nick|unique:usuarios,nick',
                'nombre' => 'required|max:50',
                'email' => 'required|max:255|email|unique:acl_usuarios,email|unique:usuarios,email',
                'password' => ['required', 'string', 'min:8', 'max:50', 'regex:/^(?=.*[A-Z])(?=.*\d).{8,}$/'],
                "confirmarPassword" => 'required|same:password',
                'fecha_nacimiento' => ['required', 'date', 'before:' . Carbon::now()->subYears(18)->format('Y-m-d')],
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ],
            [
                "same" => "La contraseñas no coinciden",
                "regex" => "La contraseña debe tener mínimo 8 caracteres y contener al menos una mayuscula  un número"
            ]
        );
        try {
            Auth::login($this->guardarEnAcl($request));
            $codUser = $this->guardarEnUsuarios($request);
            $this->otorgarIniciales($codUser);
        } catch (\Exception $e) {
        }
        return redirect("/");
    }

    /**
     * Acción que realiza el login en la web
     */
    public function login(Request $request)
    {
        $credentials = [
            'nick' => $request->nick,
            'password' => $request->password,
            'borrado' => false
        ];
        $remember = ($request->has('remember') ? true : false);

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            //Si es administrador o mantenimiento inciar sesion directamente en el Dashboard
            if (Auth::user()->puedePermiso('administrador') || Auth::user()->puedePermiso('mantenimiento')) {
                return redirect()->route('gestion');
            }
            return redirect()->intended("/");
        } else {
            return redirect()->back()
                ->withErrors([
                    "nick/contraseña " => "Nick/contraseña no son correctos"
                ]);
        }
    }
    /**
     * Accion para desconectar un usuario
     * @param Request 
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Función privada para guardar en la acl de usuarios el nuevo usuario
     * @param Request $request Datos que llega desde el formulario de registro una vez ya
     *                  validados
     */
    private function guardarEnAcl(Request $request): AclUsuario|false
    {
        $user = new AclUsuario();
        $user->nick = $request->nick;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->nombre = $request->nombre;
        $user->cod_acl_role = self::COD_ROLE_DEFECTO;
        $user->borrado = 0;
        if ($user->save()) {
            return $user;
        }
        return false;
    }
    /**
     * Funcion para guardar el nuevo usuario en la tabla de usuarios con los valores
     * por defecto
     * @param Request $request Datos que llega desde el formulario de registro una vez ya
     *                  validados
     */
    private function guardarEnUsuarios(Request $request)
    {

        $user = new Usuario();
        $user->nick = $request->nick;
        $user->fecha_nacimiento = $request->fecha_nacimiento;
        $user->email = $request->email;
        $user->creditos = 50000;
        $user->victorias = 0;
        $user->derrotas = 0;
        $user->puntos = 0;


        $user->avatar = ($request->avatar == null ? 'imgBD/usuarios/default.png' : $request->avatar);
        $user->borrado = 0;
        $user->cod_division = 1;
        $user->save();

        if ($request->hasFile('avatar')) {
            $image = $request->file('avatar');
            $fileName = $user->cod_usuario . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('imgBD/usuarios'), $fileName);

            // Actualizar la ruta de la imagen de perfil en la base de datos
            $user->avatar = 'imgBD/usuarios/' . $fileName;
            $user->save();
        }


        return $user->cod_usuario;
    }



    /**
     * Función para otorgar los objetos Iniciales a un usuario
     * 
     * @param int $cod_usuario Código de usuario al que se le quiere asignar los
     * objetos iniciales cuando un nuevo usuario se logea
     *
     */
    public function otorgarIniciales(int $cod_usuario): void
    {
        if ($cod_usuario != null) {
            //Piloto Inicial
            $obUsuario = new UsuariosPiloto;
            $ob = Piloto::find(self::PILOTO_DEFECTO);
            $obUsuario->cod_usuario = $cod_usuario;
            $obUsuario->cod_piloto = $ob->cod_piloto;
            $obUsuario->ataque_actual = $ob->ataque;
            $obUsuario->defensa_actual = $ob->defensa;
            $obUsuario->resistencia_actual = $ob->resistencia;
            $obUsuario->nivel = 1;
            $obUsuario->save();

            //Nave Inicial
            $obUsuario = new UsuariosNave;
            $ob = Nave::find(self::NAVE_DEFECTO);
            $obUsuario->cod_usuario = $cod_usuario;
            $obUsuario->cod_nave = $ob->cod_nave;
            $obUsuario->ataque_actual = $ob->ataque;
            $obUsuario->defensa_actual = $ob->defensa;
            $obUsuario->resistencia_actual = $ob->resistencia;
            $obUsuario->nivel = 1;
            $obUsuario->save();

            //Accesorios iniciales

            $obUsuario = new UsuariosAccesorio;
            $ob = Accesorio::find(self::ACCESORIO_DEFECTO_1);
            $obUsuario->cod_usuario = $cod_usuario;
            $obUsuario->cod_accesorio = $ob->cod_accesorio;
            $obUsuario->ataque_actual = $ob->ataque;
            $obUsuario->defensa_actual = $ob->defensa;
            $obUsuario->resistencia_actual = $ob->resistencia;
            $obUsuario->nivel = 1;
            $obUsuario->save();

            //Accesorio 2
            $obUsuario = new UsuariosAccesorio;
            $ob2 = Accesorio::find(self::ACCESORIO_DEFECTO_2);
            $obUsuario->cod_usuario = $cod_usuario;
            $obUsuario->cod_accesorio = $ob2->cod_accesorio;
            $obUsuario->ataque_actual = $ob2->ataque;
            $obUsuario->defensa_actual = $ob2->defensa;
            $obUsuario->resistencia_actual = $ob2->resistencia;
            $obUsuario->nivel = 1;
            $obUsuario->save();
        }
    }
}
