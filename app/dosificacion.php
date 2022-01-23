<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $idsistemafacturacion
 * @property int $idtipofacturacion
 * @property int $idmarcaserie
 * @property int $idsucursal
 * @property int $idsector
 * @property string $nautorizacion
 * @property string $ntramite
 * @property string $leyenda
 * @property int $tiempodias
 * @property string $fechalimiteemision
 * @property int $cantidadfac
 * @property int $stockfacturas
 * @property int $habilitado
 * @property int $estado
 * @property string $created_at
 * @property string $updated_at
 * @property SectorEconomico $sectorEconomico
 * @property Seriemarca $seriemarca
 * @property Sistemafacturacion $sistemafacturacion
 * @property Sucursal $sucursal
 * @property Tipofacturacion $tipofacturacion
 */
class dosificacion extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'dosificacion';

    /**
     * @var array
     */
    protected $fillable = ['idsistemafacturacion', 'idtipofacturacion', 'idmarcaserie', 'idsucursal', 'idsector', 'nautorizacion', 'ntramite', 'leyenda', 'tiempodias', 'fechalimiteemision', 'cantidadfac', 'stockfacturas', 'habilitado', 'estado', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sectorEconomico()
    {
        return $this->belongsTo('App\SectorEconomico', 'idsector');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function seriemarca()
    {
        return $this->belongsTo('App\Seriemarca', 'idmarcaserie');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sistemafacturacion()
    {
        return $this->belongsTo('App\Sistemafacturacion', 'idsistemafacturacion');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sucursal()
    {
        return $this->belongsTo('App\Sucursal', 'idsucursal');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipofacturacion()
    {
        return $this->belongsTo('App\Tipofacturacion', 'idtipofacturacion');
    }
}
