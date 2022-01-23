<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $tipofacturacion
 * @property int $estado
 * @property string $created_at
 * @property string $updated_at
 * @property Dosificacion[] $dosificacions
 */
class tipofacturacion extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'tipofacturacion';

    /**
     * @var array
     */
    protected $fillable = ['tipofacturacion', 'estado', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dosificacions()
    {
        return $this->hasMany('App\Dosificacion', 'idtipofacturacion');
    }
}
