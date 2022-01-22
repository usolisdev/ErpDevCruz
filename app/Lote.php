<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    protected $table = 'lote';
    protected $fillable = [
		'id',
		'Nrolote',
		'FechaIngreso',
		'FechaVencimiento',
		'Cantidad',
		'PrecioCompra',
		'Stock',
		'IdArticulo',
		'IdNota'
	];
}
