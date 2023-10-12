<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * Class Usuario
 * 
 * Contiene la información relacionada con la tabla usuarios de 
 * la base de datos 
 * 
 * @property int $cod_usuario
 * @property string $nick
 * @property Carbon $fecha_nacimiento
 * @property string $email
 * @property int $creditos
 * @property int $victorias
 * @property int $derrotas
 * @property int $puntos
 * @property int $cod_division
 * @property string|null $avatar
 * @property bool $borrado
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Divisiones $division
 * @property Collection|Batalla[] $batallas
 * @property Collection|RegistroBatalla[] $registro_batallas
 * @property Collection|Accesorio[] $accesorios
 * @property Collection|UsuariosNafe[] $usuarios_naves
 * @property Collection|Piloto[] $obs
 *
 * @package App\Models
 */
class Usuario extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'cod_usuario';

    protected $casts = [
        'fecha_nacimiento' => 'datetime',
        'creditos' => 'int',
        'victorias' => 'int',
        'derrotas' => 'int',
        'puntos' => 'int',
        'cod_division' => 'int',
        'borrado' => 'bool'
    ];

    protected $fillable = [
        'nick',
        'fecha_nacimiento',
        'email',
        'creditos',
        'victorias',
        'derrotas',
        'puntos',
        'cod_division',
        'avatar',
        'borrado'
    ];

    /**
     * Accede a la información relacioanda con el log_batallas con el cod_registro_batalla
     */
    public function log_batallas()
    {
        return $this->hasMany(RegistroBatalla::class, 'cod_usuario');
    }
    /**
     * Accede al registro_batalla relacionado con el usuario por el cod_usuario
     */
    public function registro_batallas()
    {
        return $this->hasMany(RegistroBatalla::class, 'cod_usuario');
    }
    /**
     * Accede a la información de la división relacioanda con el usuario por el cod_division
     */
    public function division()
    {
        return $this->belongsTo(Divisiones::class, 'cod_division');
    }

    /**
     * Accede a la información de los pilotos que posee el usuario
     */
    public function pilotos()
    {
        return $this->belongsToMany(Piloto::class, 'usuarios_pilotos', 'cod_usuario', 'cod_piloto')
            ->withPivot('cod_usuario_piloto', 'ataque_actual', 'defensa_actual', 'resistencia_actual', 'nivel');
    }
    /**
     * Accede a la información de los accesorios que posee el usuario
     */
    public function accesorios()
    {
        return $this->belongsToMany(Accesorio::class, 'usuarios_accesorios', 'cod_usuario', 'cod_accesorio')
            ->withPivot('cod_usuario_accesorio', 'ataque_actual', 'defensa_actual', 'resistencia_actual', 'nivel');
    }
    /**
     * Accede a la información de las naves que posee el usuario
     */
    public function naves()
    {
        return $this->belongsToMany(Nave::class, 'usuarios_naves', 'cod_usuario', 'cod_nave')
            ->withPivot('cod_usuario_nave', 'ataque_actual', 'defensa_actual', 'resistencia_actual', 'nivel');
    }


    /**
     * Funcion para comprobar la division actual del usuario
     *
     * @return bool True si hubo algun cambio en la BD
     *              False si no hubo cambios
     *
     */

    public function comprobarDivision(): bool
    {
        if ($this->puntos > $this->division->puntos_maximos || $this->puntos < $this->division->puntos_minimos) {
            $nuevaDiv = Divisiones::select('cod_division')->where('puntos_minimos', '<=', $this->puntos)->where('puntos_maximos', '>=', $this->puntos)->get()->value('cod_division');
            $this->cod_division = $nuevaDiv;
            $this->save();
            return true;
        }
        return false;
    }
    /**
     * Funcion privada para obtener el objeto usuario del jugador
     * conectado
     */
    public static function usuarioActivo(): Usuario
    {
        $codUsuario = Usuario::where('nick', '=', Auth::user()->nick)->select('cod_usuario')->get()->value('cod_usuario');
        $usuario = Usuario::find($codUsuario);
        return $usuario;
    }

    /**
     * Función estática para consultar el rol que tiene un 
     * usuario en el sistema 
     * @param string nick nick del usuario para buscar en la acl 
     * @return string|false string si encuentra un rol asociado valido al usuario
     *                      false si no encuentra rol para ese usuario
     */
    public static function rol(string $nick): string|false
    {
        try {
            $acl = AclUsuario::where('nick', '=', $nick)->first();
        } catch (\Exception $e) {
            return false;
        }
        return $acl->dameRole();
    }

    /**
     * Función para comprar un piloto al usuario correspondiente
     * @param int cod_piloto código del piloto que se comprara
     * @return bool true si todo fue correcto
     *              false si hubo algun problema
     */
    public function comprarPiloto(int $cod_piloto): bool
    {

        $piloto = Piloto::find($cod_piloto);
        $uusarioPiloto = new UsuariosPiloto;
        return $uusarioPiloto->comprarPiloto($piloto->cod_piloto, $this->cod_usuario);
    }
    /**
     * Función para comprar un piloto al usuario correspondiente
     * @param int cod_nave código de la nave que se comprara
     * @return bool true si todo fue correcto
     *              false si hubo algun problema
     */
    public function comprarNave(int $cod_nave): bool
    {
        $nave = Nave::find($cod_nave);
        $usuarioNaves = new UsuariosNave;
        return $usuarioNaves->comprarNave($nave->cod_nave, $this->cod_usuario);
    }
    /**
     * Función para comprar un piloto al usuario correspondiente
     * @param int cod_accesorio código del accesorio que se comprara
     * @return bool true si todo fue correcto
     *              false si hubo algun problema
     */
    public function comprarAccesorios(int $cod_accesorio)
    {
        $accesorio = Accesorio::find($cod_accesorio);
        $usuarioAccesorios = new UsuariosAccesorio;

        return $usuarioAccesorios->comprarAccesorio($accesorio->cod_accesorio, $this->cod_usuario);
    }

    /**
     * Scopes
     */
    public function scopeNick($query, $busqueda)
    {
        return $query->where('nick', 'like', '%' . $busqueda . '%');
    }
    public function scopeEmail($query, $busqueda)
    {
        return $query->where('email', 'like', '%' . $busqueda . '%');
    }
}
