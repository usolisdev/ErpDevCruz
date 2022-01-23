<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $nombres
 * @property string $apellidos
 * @property string $email
 * @property string $celular
 * @property string $telefono
 * @property string $fecha de nacimiento
 * @property string $ci
 * @property string $nit
 * @property string $direccion
 * @property string $created_at
 * @property string $updated_at
 * @property Cliente[] $clientes
 * @property Empresa[] $empresas
 * @property Empresa[] $empresas
 * @property User[] $users
 */
class persona extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'persona';

    /**
     * @var array
     */
    protected $fillable = ['nombres', 'apellidos', 'email', 'celular', 'telefono', 'fecha de nacimiento', 'ci', 'nit', 'direccion', 'created_at', 'updated_at'];

    // /**
    //  * @return \Illuminate\Database\Eloquent\Relations\HasMany
    //  */
    // public function clientes()
    // {
    //     return $this->hasMany('App\Cliente', 'idpersona');
    // }

    // /**
    //  * @return \Illuminate\Database\Eloquent\Relations\HasMany
    //  */
    // public function empresas()
    // {
    //     return $this->hasMany('App\Empresa', 'idcontacto');
    // }

    // /**
    //  * @return \Illuminate\Database\Eloquent\Relations\HasMany
    //  */
    // public function empresas()
    // {
    //     return $this->hasMany('App\Empresa', 'idrepresentante');
    // }

    // /**
    //  * @return \Illuminate\Database\Eloquent\Relations\HasMany
    //  */
    // public function users()
    // {
    //     return $this->hasMany('App\User', 'idpersona');
    // }
}
