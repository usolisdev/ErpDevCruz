<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $idvista
 * @property int $idusuario
 * @property int $tipoacceso
 * @property int $estado
 * @property string $created_at
 * @property string $updated_at
 * @property Tipodeacceso $tipodeacceso
 * @property User $user
 * @property Vistum $vistum
 */
class vistausuario extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'vistausuario';

    /**
     * @var array
     */
    protected $fillable = ['idvista', 'idusuario', 'tipoacceso', 'estado', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipodeacceso()
    {
        return $this->belongsTo('App\Tipodeacceso', 'tipoacceso');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'idusuario');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vistum()
    {
        return $this->belongsTo('App\Vistum', 'idvista');
    }
}
