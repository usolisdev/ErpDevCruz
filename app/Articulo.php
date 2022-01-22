<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    protected $table = 'articulo';
	protected $fillable = [
		'id',
		'nombre',
		'descripcion',
		'cantidad',
		'precioventa',
		'demanda',
		'tiempoespera',
		'costoorden',
		'costoinventario',
		'puntonuevopedido',
		'IdEmpresa',
		'IdUsuario',
		'IdCategoria'
	];
}
