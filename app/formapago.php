<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $forma
 * @property int $estado
 * @property string $created_at
 * @property string $updated_at
 * @property Notum[] $notas
 */
class formapago extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'formapago';

    /**
     * @var array
     */
    protected $fillable = ['forma', 'estado', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notas()
    {
        return $this->hasMany('App\Notum', 'formapago');
    }
}
