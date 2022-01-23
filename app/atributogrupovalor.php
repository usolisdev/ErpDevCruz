<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $idatributogrupo
 * @property string $valor
 * @property string $created_at
 * @property string $updated_at
 * @property Atributosgrupo $atributosgrupo
 */
class atributogrupovalor extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'atributogrupovalor';

    /**
     * @var array
     */
    protected $fillable = ['idatributogrupo', 'valor', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function atributosgrupo()
    {
        return $this->belongsTo('App\Atributosgrupo', 'idatributogrupo');
    }
}
