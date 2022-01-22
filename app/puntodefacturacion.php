<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class puntodefacturacion extends Model
{
    protected $table = 'puntodefacturacion';
    protected $fillable = [
		'id',
		'codigo',
		'alias',
		'estado'
	];
}