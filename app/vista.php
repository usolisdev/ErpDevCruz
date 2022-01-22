<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $idvistapadre
 * @property string $vista
 * @property int $nivel
 * @property string $created_at
 * @property string $updated_at
 * @property Vistum $vistum
 * @property Rolvistum[] $rolvistas
 */
class vista extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'vista';

    /**
     * @var array
     */
    protected $fillable = ['idvistapadre', 'vista', 'nivel', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vistum()
    {
        return $this->belongsTo('App\Vistum', 'idvistapadre');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rolvistas()
    {
        return $this->hasMany('App\Rolvistum', 'idvista');
    }
}
