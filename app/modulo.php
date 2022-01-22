<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $modulo
 * @property string $created_at
 * @property string $updated_at
 * @property Moduloempresa[] $moduloempresas
 */
class modulo extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'modulo';

    /**
     * @var array
     */
    protected $fillable = ['modulo', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function moduloempresas()
    {
        return $this->hasMany('App\Moduloempresa', 'idmodulo');
    }
}
