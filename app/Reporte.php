<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $Reporte_id
 * @property int $Gestion_id
 * @property int $moneda_id
 * @property boolean $comprobante_id
 * @property int $Periodo_id
 * @property int $notacompra_id
 * @property string $fechaInicio
 * @property string $fechaFin
 * @property string $Tipo
 * @property int $IdUsuario
 * @property string $created_at
 * @property string $updated_at
 */
class Reporte extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'reporte';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['Reporte_id', 'Gestion_id', 'moneda_id', 'comprobante_id', 'Periodo_id', 'notacompra_id', 'fechaInicio', 'fechaFin', 'Tipo', 'IdUsuario', 'created_at', 'updated_at'];

}
