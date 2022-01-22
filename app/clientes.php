<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $idpersona
 * @property int $idempresa
 * @property string $created_at
 * @property string $updated_at
 * @property Empresa $empresa
 * @property Persona $persona
 */
class clientes extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['idpersona', 'idempresa', 'created_at', 'updated_at'];

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
    public function persona()
    {
        return $this->belongsTo('App\Persona', 'idpersona');
    }
}
