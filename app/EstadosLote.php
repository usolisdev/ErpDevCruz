<?php
namespace App;
class EstadosLote
{
	public $Activo=1;
	public $Agotado=2;
	public $Anulado=3;

	public function getActivo(){
		return $this->Activo;
	}
	public function getAgotado(){
		return $this->Agotado;
	}
	public function getAnulado(){
		return $this->Anulado;
	}
}
?>
