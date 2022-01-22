<?php
namespace App;
class TiposReportes
{
	public $Comprobacion_De_Saldos=1;
	public $Estado_Resultado=2;
	// public $Nota_De_Compra=3;
	public $Balance_General=3;
	public $Balance_Inicial=4;
	public $Libro_Diario=5;
	public $Libro_Mayor=6;

	public function getcomprobacionDeSaldos(){
		return $this->Comprobacion_De_Saldos;
	}
	public function getestadoResultado(){
		return $this->Estado_Resultado;
	}
	public function getbalanceinicial(){
		return $this->Balance_Inicial;
	}
	public function getbalanceGeneral(){
		return $this->Balance_General;
	}
	public function getlibrodiario(){
		return $this->Libro_Diario;
	}
	public function getlibromayor(){
		return $this->Libro_Mayor;
	}
}
?>
