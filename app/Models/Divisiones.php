<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Divisiones
 * 
 * Contiene la información relacionada con la tabla divisiones de 
 * la base de datos 
 * 
 * @property int $cod_division
 * @property string $nombre
 * @property int $puntos_maximos
 * @property int $puntos_minimos
 * @property string|null $imagen
 *
 * @property Collection|Usuario[] $usuarios
 *
 * @package App\Models
 */
class Divisiones extends Model
{
	protected $table = 'divisiones';
	protected $primaryKey = 'cod_division';
	public $timestamps = false;

	protected $casts = [
        'puntos_minimos'=>'int',
		'puntos_maximos' => 'int'
	];

	protected $fillable = [
		'nombre',
        'puntos_minimos',
		'puntos_maximos',
		'imagen'
	];

	/**
	 * Accede al usuarios relacionados con la division por el cod_division
	 * 
	 */
	public function usuarios()
	{
		return $this->hasMany(Usuario::class, 'cod_division');
	}

	/**
	 * Función estática que devuelve el cod_division que llega como parametro
	 * en forma de cadena 
	 * @param string $division Cadena que representa el texto de una division(oro,plata etc...)
	 * @return int|false int si encuentra un cod_division relacionado con la cadena 
	 * 						false si no cuentra una division que corresponda con el campo nombre
	 */
    public static function getCodDivision(string $division):int|false{

        $division=self::where('nombre','=',$division)->get()->value('cod_division');
        if($division!=null){
            return $division;
        }
        return false;
    }
}
