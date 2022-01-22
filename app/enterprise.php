<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $idcontacto
 * @property string $nombre
 * @property string $nit
 * @property string $sigla
 * @property string $correo
 * @property string $telefono
 * @property string $direccion
 * @property string $created_at
 * @property string $updated_at
 * @property Persona $persona
 * @property Proveedore[] $proveedores
 */
class enterprise extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'enterprise';

    /**
     * @var array
     */
    protected $fillable = ['idcontacto', 'nombre', 'nit', 'sigla', 'correo', 'telefono', 'direccion', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function persona()
    {
        return $this->belongsTo('App\Persona', 'idcontacto');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function proveedores()
    {
        return $this->hasMany('App\Proveedore', 'identerprise');
    }
}
