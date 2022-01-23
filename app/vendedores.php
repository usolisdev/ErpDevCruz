<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $idpersona
 * @property int $idempresa
 * @property string $created_at
 * @property string $updated_at
 */
class vendedores extends Model
{
    /**
     * @var array
     */
    protected $table = 'vendedores';
    protected $fillable = ['idpersona', 'idempresa', 'created_at', 'updated_at'];

}
