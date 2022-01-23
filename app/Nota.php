<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
   	protected $table = 'nota';
	protected $fillable = [
		'id',
		'Nronota',
		'fecha',
		'descripcion',
		'total',
		'tipo',
		'idvendedor',
		'idcliente',
		'IdEmpresa',
		'IdUsuario',
		'IdComprobante'
	];
}
