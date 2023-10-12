<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Nave
 * Contiene la información relacionada con la tabla Naves de 
 * la base de datos 
 * 
 * @property int $cod_nave
 * @property string $nombre
 * @property int $ataque
 * @property int|null $aumento_ataque
 * @property int $defensa
 * @property int|null $aumento_defensa
 * @property int $resistencia
 * @property int $aumento_resistencia
 * @property int $num_accesorios
 * @property int $valor
 * @property int $coste_nivel
 * @property string $imagen
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @package App\Models
 */
class Nave extends Model
{
    protected $table = 'naves';
    protected $primaryKey = 'cod_nave';

    protected $casts = [
        'ataque' => 'int',
        'aumento_ataque' => 'int',
        'defensa' => 'int',
        'aumento_defensa' => 'int',
        'resistencia' => 'int',
        'aumento_resistencia' => 'int',
        'num_accesorios' => 'int',
        'valor' => 'int',
        'coste_nivel' => 'int'
    ];

    protected $fillable = [
        'nombre',
        'ataque',
        'aumento_ataque',
        'defensa',
        'aumento_defensa',
        'resistencia',
        'aumento_resistencia',
        'num_accesorios',
        'valor',
        'coste_nivel',
        'imagen'
    ];

    /**
     * Accede al usuario relacionado con una nave usando la tabla usuarios_naves
     */
    public function usuarios()
    {
        return $this->belongsToMany(Usuario::class, 'usuarios_naves', 'cod_nave', 'cod_usuario')
            ->withPivot('ataque_actual', 'defensa_actual', 'resistencia_actual', 'nivel');
    }

    /**
     * Scopes
     */

    public function scopeNombre($query, $busqueda)
    {
        return $query->where('nombre', 'like', '%' . $busqueda . '%');
    }
    public function scopeAtaque($query, $busqueda, $comparador)
    {
        return $query->where('ataque', $comparador, $busqueda);
    }
    public function scopeValor($query, $busqueda, $comparador)
    {
        return $query->where('valor', $comparador, $busqueda);
    }
    public function scopeDefensa($query, $busqueda, $comparador)
    {
        return $query->where('defensa', $comparador, $busqueda);
    }
    public function scopeResistencia($query, $busqueda, $comparador)
    {
        return $query->where('resistencia', $comparador, $busqueda);
    }
    public function scopeNivel($query, $busqueda, $comparador)
    {
        return $query->where('nivel', $comparador, $busqueda);
    }

   /**
    * Scopes para la tabla N:M (usuarios_naves)
    */

    public function scopeAtaqueActual($query, $busqueda, $comparador)
    {
        return $query->where('ataque_actual', $comparador, $busqueda);
    }
    public function scopeDefensaActual($query, $busqueda, $comparador)
    {
        return $query->where('defensa_actual', $comparador, $busqueda);
    }
    public function scopeResistenciaActual($query, $busqueda, $comparador)
    {
        return $query->where('resistencia_actual', $comparador, $busqueda);
    }
}
