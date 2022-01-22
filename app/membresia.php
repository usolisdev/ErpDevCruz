<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $idempresa
 * @property int $estado
 * @property string $fechainicio
 * @property string $fechafin
 * @property string $created_at
 * @property string $updated_at
 * @property Empresa $empresa
 */
class membresia extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'membresia';

    /**
     * @var array
     */
    protected $fillable = ['idempresa', 'estado', 'fechainicio', 'fechafin', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function empresa()
    {
        return $this->belongsTo('App\Empresa', 'idempresa');
    }
}
