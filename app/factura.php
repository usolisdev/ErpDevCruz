<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $nfactura
 * @property int $nautorizacion
 * @property string $ncontrol
 * @property float $total
 * @property int $casamatriz
 * @property int $idsucursal
 * @property int $idventa
 * @property int $idempresa
 * @property string $created_at
 * @property string $updated_at
 */
class factura extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'factura';

    /**
     * @var array
     */
    protected $fillable = ['nfactura', 'nautorizacion', 'ncontrol', 'total', 'casamatriz', 'idsucursal', 'idventa', 'idempresa', 'created_at', 'updated_at'];

}
