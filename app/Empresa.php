<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $idcasamatriz
 * @property int $idsector
 * @property int $idcontacto
 * @property int $idrepresentante
 * @property int $identerprice
 * @property string $Nombre
 * @property string $Nit
 * @property string $Sigla
 * @property string $Telefono
 * @property string $Correo
 * @property string $Direccion
 * @property int $Niveles
 * @property string $Session
 * @property int $estado
 * @property int $IdUsuario
 * @property string $created_at
 * @property string $updated_at
 * @property Persona $persona
 * @property Enterprise $enterprise
 * @property User $user
 * @property Persona $persona
 * @property SectorEconomico $sectorEconomico
 * @property Sucursal $sucursal
 * @property Articulo[] $articulos
 * @property Categorium[] $categorias
 * @property Cliente[] $clientes
 * @property Comprobante[] $comprobantes
 * @property Cuentum[] $cuentas
 * @property Definicionatributo[] $definicionatributos
 * @property Empresamoneda[] $empresamonedas
 * @property Gestion[] $gestions
 * @property Integracion[] $integracions
 * @property Membresium[] $membresias
 * @property Moduloempresa[] $moduloempresas
 * @property Proveedore[] $proveedores
 * @property Sucursal[] $sucursals
 * @property User[] $users
 */
class Empresa extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'empresa';

    /**
     * @var array
     */
    protected $fillable = ['idcasamatriz', 'idsector', 'idcontacto', 'idrepresentante', 'identerprice', 'Nombre', 'Nit', 'Sigla', 'Telefono', 'Correo', 'Direccion', 'Niveles', 'Session', 'estado', 'IdUsuario', 'created_at', 'updated_at'];

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
    public function enterprise()
    {
        return $this->belongsTo('App\Enterprise', 'identerprice');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'IdUsuario');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function persona()
    {
        return $this->belongsTo('App\Persona', 'idrepresentante');
    }

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
    public function sucursal()
    {
        return $this->belongsTo('App\Sucursal', 'idcasamatriz');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articulos()
    {
        return $this->hasMany('App\Articulo', 'IdEmpresa');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categorias()
    {
        return $this->hasMany('App\Categorium', 'IdEmpresa');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function clientes()
    {
        return $this->hasMany('App\Cliente', 'idempresa');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comprobantes()
    {
        return $this->hasMany('App\Comprobante', 'IdEmpresa');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cuentas()
    {
        return $this->hasMany('App\Cuentum', 'IdEmpresa');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function definicionatributos()
    {
        return $this->hasMany('App\Definicionatributo', 'idempresa');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function empresamonedas()
    {
        return $this->hasMany('App\Empresamoneda', 'IdEmpresa');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gestions()
    {
        return $this->hasMany('App\Gestion', 'IdEmpresa');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function integracions()
    {
        return $this->hasMany('App\Integracion', 'IdEmpresa');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function membresias()
    {
        return $this->hasMany('App\Membresium', 'idempresa');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function moduloempresas()
    {
        return $this->hasMany('App\Moduloempresa', 'idempresa');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function proveedores()
    {
        return $this->hasMany('App\Proveedore', 'idempresa');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sucursals()
    {
        return $this->hasMany('App\Sucursal', 'idempresa');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany('App\User', 'idempresa');
    }
}
