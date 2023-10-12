<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Batalla
 * 
 * Contiene la información relacionada con la tabla batalla de 
 * la base de datos 
 * 
 * @property int $cod_batalla
 * @property Carbon $hora_inicio
 * @property Carbon|null $hora_final
 * @property Carbon $fecha
 * @property bool $estado
 * @property int|null $usuario_ganador
 * @property int $tiempo_batalla
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Usuario|null $usuario
 * @property Collection|RegistroBatalla[] $registro_batallas
 *
 * @package App\Models
 */
class Batalla extends Model
{
    protected $table = 'batalla';
    protected $primaryKey = 'cod_batalla';

    protected $casts = [
        'hora_inicio' => 'datetime',
        'hora_final' => 'datetime',
        'fecha' => 'datetime',
        'estado' => 'bool',
        'usuario_ganador' => 'int',
        'tiempo_batalla' => 'int'
    ];

    protected $fillable = [
        'hora_inicio',
        'hora_final',
        'fecha',
        'estado',
        'usuario_ganador',
        'tiempo_batalla'
    ];

    /**
     * Accede al usuarios relacionado con la batalla por su cod_usuario
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'cod_usuario');
    }
    /**
     * Accede a los registro_batalla relacionados con la batalla
     */
    public function registro_batallas()
    {
        return $this->hasMany(RegistroBatalla::class, 'cod_batalla');
    }

    /**
     * Función que devuelve el nombre del jugador asociado con el campo
     * usuario_ganador
     * @return string|false string con el nombre del usuario_ganador de la batalla
     *                      false si no encuentra al jugador  
     */
    public function nickUsuarioGanador(): false|string
    {
        $usu=Usuario::find($this->usuario_ganador);

        if($usu){
            return $usu->nick;
        }
        return false;
    }
}
