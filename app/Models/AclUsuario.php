<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class AclUsuario
 * 
 * Contiene la información relacionada con la tabla acl_usuarios de 
 * la base de datos 
 * 
 * @property int $cod_acl_usuario
 * @property string $nick
 * @property string $nombre
 * @property string $email
 * @property string $password
 * @property int $cod_acl_role
 * @property bool $borrado
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property AclRole $acl_role
 *
 * @package App\Models
 */
class AclUsuario extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;
    protected $table = 'acl_usuarios';
    protected $primaryKey = 'cod_acl_usuario';

    protected $casts = [
        'cod_acl_role' => 'int',
        'borrado' => 'bool'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $fillable = [
        'nick',
        'nombre',
        'email',
        'password',
        'cod_acl_role',
        'borrado',
        'remember_token'
    ];

    /**
     * Accede a la tabla roles con el cod_acl_role que tiene
     * un usuario
     */
    public function acl_role()
    {
        return $this->belongsTo(AclRole::class, 'cod_acl_role');
    }

    /**
     * Función que obtiene el nombre del rol que tiene un usuario
     * @return string Nombre del rol que tiene un usuario
     */
    public function dameRole(): string
    {
        return $this->acl_role()->select('nombre')->get()->value('nombre');
    }

    /**
     * Función para obtener si el rol que tiene uno usuario tiene un permiso o no
     * @param string role Cadena con el nombre del rol
     */
    public function puedePermiso(string $role)
    {
        if($role==$this->acl_role->nombre){
            return true;
        }
        return  false;
    }
    
    /**
     * Scopes
     */
    public function scopeNick($query, $busqueda)
    {
        return $query->where('nick', 'like', '%' . $busqueda . '%');
    }
    public function scopeBorrado($query, $busqueda)
    {
        return $query->where('borrado', $busqueda);
    }
    public function scopeEmail($query, $busqueda)
    {
        return $query->where('email', 'like', '%' . $busqueda . '%');
    }
    public function scopeRol($query, $busqueda)
    {
        return $query->where('cod_acl_role', $busqueda);
    }
}
