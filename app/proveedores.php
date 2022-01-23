<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $idpersona
 * @property int $identerprise
 * @property int $estado
 * @property int $alias
 * @property string $created_at
 * @property string $updated_at
 * @property Enterprise $enterprise
 * @property Persona $persona
 */
class proveedores extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['idpersona', 'identerprise', 'estado', 'alias', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function enterprise()
    {
        return $this->belongsTo('App\Enterprise', 'identerprise');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function persona()
    {
        return $this->belongsTo('App\Persona', 'idpersona');
    }
}
