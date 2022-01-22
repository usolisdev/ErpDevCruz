<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cuentas extends Model
{
    protected $table = 'cuenta';
    protected $fillable = [
		'id',
		'Codigo',
		'Nombre',
		'Nivel',
		'TipoCuenta',
		'IdUsuario',
		'IdEmpresa',
		'IdCuentaPadre'
	];
}
