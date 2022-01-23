<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $idcontacto
 * @property int $idempresa
 * @property string $alias
 * @property string $direccion
 * @property string $telefono
 * @property string $email
 * @property int $estado
 * @property string $created_at
 * @property string $updated_at
 * @property Persona $persona
 * @property Empresa $empresa
 * @property Empresa[] $empresas
 */
class sucursal extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'sucursal';

    /**
     * @var array
     */
    protected $fillable = ['idcontacto', 'idempresa', 'alias', 'direccion', 'telefono', 'email', 'estado', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function persona()
    {
        return $this->belongsTo('App\Persona', 'idcontacto');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function empresa()
    {
        return $this->belongsTo('App\Empresa', 'idempresa');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function empresas()
    {
        return $this->hasMany('App\Empresa', 'idcasamatriz');
    }
}
