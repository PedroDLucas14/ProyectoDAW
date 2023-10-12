<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Accesorio
 * 
 * Contiene la información relacionada con la tabla Accesorios de 
 * la base de datos 
 * 
 * @property int $cod_accesorio
 * @property string $nombre
 * @property string $descripcion
 * @property int|null $ataque
 * @property int|null $aumento_ataque
 * @property int|null $defensa
 * @property int|null $aumento_defensa
 * @property int|null $resistencia
 * @property int|null $aumento_resistencia
 * @property int $valor
 * @property int|null $coste_nivel
 * @property string $imagen
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|Usuario[] $usuarios
 *
 * @package App\Models
 */

class Accesorio extends Model
{
    protected $table = 'accesorios';
    protected $primaryKey = 'cod_accesorio';

    protected $casts = [
        'ataque' => 'int',
        'aumento_ataque' => 'int',
        'defensa' => 'int',
        'aumento_defensa' => 'int',
        'resistencia' => 'int',
        'aumento_resistencia' => 'int',
        'valor' => 'int',
        'coste_nivel' => 'int'
    ];

    protected $fillable = [
        'nombre',
        'descripcion',
        'ataque',
        'aumento_ataque',
        'defensa',
        'aumento_defensa',
        'resistencia',
        'aumento_resistencia',
        'valor',
        'coste_nivel',
        'imagen'
    ];

    /**
     * Relación usuarios
     */
    public function usuarios()
    {
        return $this->belongsToMany(Usuario::class, 'usuarios_accesorios', 'cod_accesorio', 'cod_usuario')
            ->withPivot('cod_usuario_accesorio', 'ataque_actual', 'defensa_actual', 'resistencia_actual', 'nivel');
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

    public function scopeNivel($query, $busqueda, $comparador)
    {
        return $query->where('nivel', $comparador, $busqueda);
    }
}
