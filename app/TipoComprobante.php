<?php
namespace App;
class TipoComprobante 
{
	public $Ingreso=1;
	public $Egreso=2;
	public $Traspaso=3;
	public $Apertura=4;
	public $Ajuste=5;
	
	public function getIngreso(){
		return $this->Ingreso;
	}
	public function getEgreso(){
		return $this->Egreso;
	}
	public function getTraspaso(){
		return $this->Traspaso;
	}
	public function getApertura(){
		return $this->Apertura;
	}
	public function getAjuste(){
		return $this->Ajuste;
	}
}
?>
