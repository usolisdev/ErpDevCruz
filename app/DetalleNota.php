<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleNota extends Model
{
    protected $table = 'detallenota';
    protected $fillable = [
		'id',
		'Cantidad',
		'Precio',
		'IdArticulo',
		'IdLote',
		'IdNota'
	];
}
