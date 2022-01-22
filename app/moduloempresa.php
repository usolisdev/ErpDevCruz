<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $idempresa
 * @property int $idmodulo
 * @property int $estado
 * @property string $created_at
 * @property string $updated_at
 * @property Empresa $empresa
 * @property Modulo $modulo
 */
class moduloempresa extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'moduloempresa';

    /**
     * @var array
     */
    protected $fillable = ['idempresa', 'idmodulo', 'estado', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function empresa()
    {
        return $this->belongsTo('App\Empresa', 'idempresa');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function modulo()
    {
        return $this->belongsTo('App\Modulo', 'idmodulo');
    }
}
