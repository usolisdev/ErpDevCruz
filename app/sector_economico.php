<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $sector
 * @property int $mescierre
 * @property int $estado
 * @property string $created_at
 * @property string $updated_at
 */
class sector_economico extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'sector_economico';

    /**
     * @var array
     */
    protected $fillable = ['sector', 'mescierre', 'estado', 'created_at', 'updated_at'];

}
