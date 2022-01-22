<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $idatributo
 * @property int $idcliente
 * @property int $idproveedor
 * @property int $idempleado
 * @property int $idpersona
 * @property int $idusuario
 * @property string $created_at
 * @property string $updated_at
 * @property Atributogrupovalor[] $atributogrupovalors
 */
class atributosgrupo extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'atributosgrupo';

    /**
     * @var array
     */
    protected $fillable = ['idatributo', 'idcliente', 'idproveedor', 'idempleado', 'idpersona', 'idusuario', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function atributogrupovalors()
    {
        return $this->hasMany('App\Atributogrupovalor', 'idatributogrupo');
    }
}
