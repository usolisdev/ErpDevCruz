<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $idatributo
 * @property int $idempresa
 * @property string $definicion
 * @property int $estado
 * @property string $created_at
 * @property string $updated_at
 * @property Atributo $atributo
 * @property Empresa $empresa
 */
class definicionatributos extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'definicionatributo';

    /**
     * @var array
     */
    protected $fillable = ['idatributo', 'idempresa', 'definicion', 'estado', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function atributo()
    {
        return $this->belongsTo('App\Atributo', 'idatributo');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function empresa()
    {
        return $this->belongsTo('App\Empresa', 'idempresa');
    }
}
