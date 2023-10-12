<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Piloto
 * Contiene la información relacionada con la tabla pilotos de 
 * la base de datos 
 * 
 * @property int $cod_piloto
 * @property string $nombre
 * @property int $ataque
 * @property int $aumento_ataque
 * @property int $defensa
 * @property int $aumento_defensa
 * @property int $resistencia
 * @property int $aumento_resistencia
 * @property int $valor
 * @property int $coste_nivel
 * @property string $imagen
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|Habilidade[] $habilidades
 *
 * @package App\Models
 */
class Piloto extends Model
{
    protected $table = 'pilotos';
    protected $primaryKey = 'cod_piloto';

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
     * Accede a la tabla hablidades usando el cod_piloto
     */
    public function habilidades()
    {
        return $this->hasMany(Habilidade::class, 'cod_piloto');
    }

    /**
     * Accede a la informacion del usuario relacionado con el piloto usando
     *  la tabla usuarios_pilotos
     * 
     */
    public function usuarios()
    {
        return $this->belongsToMany(Usuario::class, 'usuarios_pilotos', 'cod_piloto', 'cod_usuario')
            ->withPivot('ataque_actual', 'defensa_actual', 'resistencia_actual', 'nivel');
    }

    /**
     * Función que devuelve la información de una habilidad del piloto
     * @param $atributo atributo que se quiere comprobar de la habilidad asociada al piloto
     *
     * @return string Con la información relativa al atributo que se busca o si no tiene habildiad
     */
    public function dameHabilidad(string $atributo): string
    {
        try {
            $valor = $this->habilidades->first()->$atributo;
        } catch (\Exception $e) {
            return "Sin habilidad";
        }
        return $valor;
    }

    //Scopes

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
    
    /**
     * Scopes para la N:M (usuarios_pilotos)
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
    public function scopeNivel($query, $busqueda, $comparador)
    {
        return $query->where('nivel', $comparador, $busqueda);
    }
}
