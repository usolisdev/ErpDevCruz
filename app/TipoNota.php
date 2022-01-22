<?php
namespace App;
class TipoNota
{
	public $Compra=1;
	public $Venta=2;

	public function getCompra(){
		return $this->Compra;
	}
	public function getVenta(){
		return $this->Venta;
	}
}
?>
