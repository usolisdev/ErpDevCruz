<?php
namespace App;
class EstadosComprobante
{
	public $Abierto=1;
	public $Cerrado=2;
	public $Anulado=3;

	public function getAbierto(){
		return $this->Abierto;
	}
	public function getCerrado(){
		return $this->Cerrado;
	}
	public function getAnulado(){
		return $this->Anulado;
	}
}
?>
