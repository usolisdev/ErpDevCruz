<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $seriemarca
 * @property int $estado
 * @property string $created_at
 * @property string $updated_at
 * @property Dosificacion[] $dosificacions
 */
class seriemarca extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'seriemarca';

    /**
     * @var array
     */
    protected $fillable = ['seriemarca', 'estado', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dosificacions()
    {
        return $this->hasMany('App\Dosificacion', 'idmarcaserie');
    }
}
