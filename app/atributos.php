<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $atributo
 * @property int $estado
 * @property string $created_at
 * @property string $updated_at
 * @property Definicionatributo[] $definicionatributos
 */
class atributos extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['atributo', 'estado', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function definicionatributos()
    {
        return $this->hasMany('App\Definicionatributo', 'idatributo');
    }
}
