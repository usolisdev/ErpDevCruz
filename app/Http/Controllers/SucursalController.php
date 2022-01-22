<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empresa;
use App\Gestion;
use App\Periodo;
use App\Reporte;
use App\Cuentas;
use App\enterprise;
use App\EmpresaMoneda;
use App\persona;
use App\sector_economico;
use App\sucursal;
use App\dosificacion;
use App\sistemafacturacion;
use App\tipofacturacion;
use App\seriemarca;
use App\puntodefacturacion;
use DB;
use Excel;
use DateTime;
use Carbon\Carbon;
use \Milon\Barcode\DNS2D;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Contracts\Encryption\DecryptException;

class SucursalController extends Controller
{
	//Sucursales
		public function listadesucursales(Request $request){
			try{
				$sucursales = DB::table('sucursal')
								 ->join('persona','persona.id','sucursal.idcontacto')
	                             ->where('sucursal.idempresa',$request->input('IdEmpresa'))
	                             ->select('sucursal.id','sucursal.alias','sucursal.direccion','sucursal.telefono','persona.nombres','persona.apellidos','persona.ci')
	                             ->get();

	            return response()->json([
						'mensaje'			=> "Listado de Sucursales Exitoso",
						'titulo'			=> "Success",
						'tipoMensaje'		=> "success",
						'botonConfirmacion'	=> "ok",
						'Sucursales'        => $sucursales

					]);
			}catch(Exception $e){
				return response()->json([
					'mensaje'			=> $e,
					'titulo'			=> "error",
					'tipoMensaje'		=> "error",
					'botonConfirmacion'	=> "ok"
				]);
			}
		}

		public function TraerSucursal(Request $request){
			try{
	            $sucursal = DB::table('sucursal')
								 ->join('persona','persona.id','sucursal.idcontacto')
	                             ->where('sucursal.id',$request->input('IdSucursal'))
	                             ->select('sucursal.id','sucursal.alias','sucursal.direccion','sucursal.telefono','sucursal.email','persona.nombres','persona.apellidos','persona.ci','persona.nit','persona.email as emailper','persona.telefono as telper','persona.fecha_de_nacimiento','persona.direccion as dirper','persona.celular')
	                             ->first();

				return response()->json([
					'mensaje'			=> "Traer Gestion Exitoso",
					'titulo'			=> "Success",
					'tipoMensaje'		=> "success",
					'botonConfirmacion'	=> "ok",
					'Sucursal'          => $sucursal
				]);

			}
			catch(Exception $e){
				return response()->json([
					'mensaje'			=> $e,
					'titulo'			=> "error",
					'tipoMensaje'		=> "error",
					'botonConfirmacion'	=> "ok"
				]);
			}
		}

	    public function lsucursal($idempresa1){
	    	try{
	    		$idempresa=$idempresa1;
	    		$empresa=Empresa::find($idempresa);
	    		$EmpresaNombre = $empresa->Nombre;
	    		$EmpresaSigla = $empresa->Sigla;

				$idusuario = \Auth::user()->id;
				$access = self::verificacion(2);
				if($access=="none"){
					\Auth::logout();
					$errors = [$this->username() => trans('auth.none')];
					return redirect('/login')
				            // ->withInput($request->only($this->username(), 'remember'))
				            ->withErrors($errors);
				}
	             return view('Empresas.sucursales',compact('idempresa','EmpresaNombre','EmpresaSigla','access'));
	    	}
	    	catch(Exception $e){
	           return $e;
	    	}
	    }

	    public function GuardarSucursal(Request $request){
			try{
				$idusuario = \Auth::user()->id;
				$alias = $request->input('alias');
				$dirsuc = $request->input('dirsuc');
				$telsuc = $request->input('telsuc');
				$mailsuc = $request->input('mailsuc');
				$ci = $request->input('ci');
				$nit = $request->input('nit');
				$nombres = $request->input('nombres');
				$apellidos = $request->input('apellidos');
				$email = $request->input('email');
				$celular = $request->input('celular');
				$telefono = $request->input('telefono');
				$direccion = $request->input('direccion');
				$fecnac = $request->input('fecnac');
				$idem = $request->input('idem');
				//Contacto
		    	    $contacto=0;
	    	    	if(!empty($ci)){
	    	    		$persona = DB::table('persona')
	                            ->where('persona.ci',$ci)
	                            ->first();
		                if($persona==null){
		                	$compci=self::comprobardatacrear($ci,$nit,$email);
		    	    		if($compci!=100){
		    	    			return response()->json([
									'mensaje'			=> $compci,
									'titulo'			=> "error",
									'tipoMensaje'		=> "error",
									'botonConfirmacion'	=> "ok"
								]);
		    	    		}else{
		    	    			$contacto = self::crearpersona($nombres,$apellidos,$ci,$nit,$email,$telefono,$celular,$direccion,$fecnac);
		    	    		}
		                }else{
		                	$compci=self::comprobardata($ci,$nit,$email,$persona->id);
		    	    		if($compci!=100){
		    	    			return response()->json([
									'mensaje'			=> $compci,
									'titulo'			=> "error",
									'tipoMensaje'		=> "error",
									'botonConfirmacion'	=> "ok"
								]);
		    	    		}else{
		    	    			$contacto = self::actualizarpersona($persona->id,$nombres,$apellidos,$ci,$nit,$email,$telefono,$celular,$direccion,$fecnac);
		    	    		}
		                }
	    	    	}
	    	    //sucursal
	    	    	$sucursal = 0;
	    	    	$compsuc = self::comprobardatacrearsucursal($alias,$dirsuc,$idem);
	    	    	if($compsuc!=100){
    	    			return response()->json([
							'mensaje'			=> $compsuc,
							'titulo'			=> "error",
							'tipoMensaje'		=> "error",
							'botonConfirmacion'	=> "ok"
						]);
    	    		}else{
    	    			if($contacto==0){
    	    				return response()->json([
								'mensaje'			=> "error al registrar el contacto, revise que los datos esten completos",
								'titulo'			=> "error",
								'tipoMensaje'		=> "error",
								'botonConfirmacion'	=> "ok"
							]);
    	    			}
    	    			$sucursal = self::crearsucursal($alias,$dirsuc,$telsuc,$mailsuc,0,$idem,$contacto);
    	    		}
				$sucursal = DB::table('sucursal')
								 ->join('persona','persona.id','sucursal.idcontacto')
	                             ->where('sucursal.id',$sucursal)
	                             ->select('sucursal.id','sucursal.alias','sucursal.direccion','sucursal.telefono','sucursal.email','persona.nombres','persona.apellidos','persona.ci','persona.nit','persona.email as emailper','persona.telefono as telper','persona.fecha_de_nacimiento','persona.direccion as dirper','persona.celular')
	                             ->first();

				return response()->json([
					'mensaje'			=> "Sucursal Guardada Exitosamente",
					'titulo'			=> "Success",
					'tipoMensaje'		=> "success",
					'botonConfirmacion'	=> "ok",
					'Sucursal'          => $sucursal
				]);

			}
			catch(Exception $e){
				return response()->json([
					'mensaje'			=> $e,
					'titulo'			=> "error",
					'tipoMensaje'		=> "error",
					'botonConfirmacion'	=> "ok"
				]);
			}
		}

		public function EditarSucursal(Request $request){
			try{
				$idusuario = \Auth::user()->id;
				$IdSucursal = $request->input('IdSucursal');
				$alias = $request->input('alias');
				$dirsuc = $request->input('dirsuc');
				$telsuc = $request->input('telsuc');
				$mailsuc = $request->input('mailsuc');
				$ci = $request->input('ci');
				$nit = $request->input('nit');
				$nombres = $request->input('nombres');
				$apellidos = $request->input('apellidos');
				$email = $request->input('email');
				$celular = $request->input('celular');
				$telefono = $request->input('telefono');
				$direccion = $request->input('direccion');
				$fecnac = $request->input('fecnac');
				$rdcon = $request->input('rdcon');
				$idem = $request->input('idem');
				$sucursal = sucursal::find($IdSucursal);
				//Contacto
		    	    $contacto=0;
		    	    if($rdcon=="editar"){
		    	    	if(!empty($ci)){
		    	    		$persona = persona::find($sucursal->idcontacto);
		    	    		$compci=self::comprobardata($ci,$nit,$email,$persona->id);
		    	    		if($compci!=100){
		    	    			return response()->json([
									'mensaje'			=> $compci,
									'titulo'			=> "error",
									'tipoMensaje'		=> "error",
									'botonConfirmacion'	=> "ok"
								]);
		    	    		}else{
		    	    			$contacto = self::actualizarpersona($persona->id,$nombres,$apellidos,$ci,$nit,$email,$telefono,$celular,$direccion,$fecnac);
		    	    		}
		    	    	}		    	    	
		    	    }
		    	    if($rdcon=="crear"){
		    	    	if(!empty($ci)){
		    	    		$persona = DB::table('persona')
		                            ->where('persona.ci',$ci)
		                            ->first();
			                if($persona==null){
			                	$compci=self::comprobardatacrear($ci,$nit,$email);
			    	    		if($compci!=100){
			    	    			return response()->json([
										'mensaje'			=> $compci,
										'titulo'			=> "error",
										'tipoMensaje'		=> "error",
										'botonConfirmacion'	=> "ok"
									]);
			    	    		}else{
			    	    			$contacto = self::crearpersona($nombres,$apellidos,$ci,$nit,$email,$telefono,$celular,$direccion,$fecnac);
			    	    		}
			                }else{
			                	$compci=self::comprobardata($ci,$nit,$email,$persona->id);
			    	    		if($compci!=100){
			    	    			return response()->json([
										'mensaje'			=> $compci,
										'titulo'			=> "error",
										'tipoMensaje'		=> "error",
										'botonConfirmacion'	=> "ok"
									]);
			    	    		}else{
			    	    			$contacto = self::actualizarpersona($persona->id,$nombres,$apellidos,$ci,$nit,$email,$telefono,$celular,$direccion,$fecnac);
			    	    		}
			                }
		    	    	}
		    	    }
		    	//sucursal
	    	    	$sucursal = 0;
	    	    	$compsuc = self::comprobardatasucursal($alias,$dirsuc,$idem,$IdSucursal);
	    	    	if($compsuc!=100){
    	    			return response()->json([
							'mensaje'			=> $compsuc,
							'titulo'			=> "error",
							'tipoMensaje'		=> "error",
							'botonConfirmacion'	=> "ok"
						]);
    	    		}else{
    	    			if($contacto==0){
    	    				return response()->json([
								'mensaje'			=> "error al registrar el contacto, revise que los datos esten completos",
								'titulo'			=> "error",
								'tipoMensaje'		=> "error",
								'botonConfirmacion'	=> "ok"
							]);
    	    			}
    	    			$sucursal = self::actualizarsucursal($IdSucursal,$alias,$dirsuc,$telsuc,$mailsuc,0,$idem,$contacto);
    	    		}
    	    	$sucursal = DB::table('sucursal')
								 ->join('persona','persona.id','sucursal.idcontacto')
	                             ->where('sucursal.id',$sucursal)
	                             ->select('sucursal.id','sucursal.alias','sucursal.direccion','sucursal.telefono','sucursal.email','persona.nombres','persona.apellidos','persona.ci','persona.nit','persona.email as emailper','persona.telefono as telper','persona.fecha_de_nacimiento','persona.direccion as dirper','persona.celular')
	                             ->first();

				return response()->json([
					'mensaje'			=> "Sucursal Actualizada Exitosamente",
					'titulo'			=> "Success",
					'tipoMensaje'		=> "success",
					'botonConfirmacion'	=> "ok",
					'Sucursal'          => $sucursal
				]);
			}
			catch(Exception $e){
				return response()->json([
					'mensaje'			=> $e,
					'titulo'			=> "error",
					'tipoMensaje'		=> "error",
					'botonConfirmacion'	=> "ok"
				]);
			}
		}

		public function EliminarSucursal(Request $request){
			try{
				$gestion=Gestion::find($request->input('IdGestion'));
	            $Periodo=DB::table('periodo')
	                        ->where('periodo.IdGestion',$request->input('IdGestion'))
	                        ->first(); 
	            $eliminado;                
	            if($Periodo==null){
	            	$eliminado=$gestion->delete();
	            }
	            else{
	            	return response()->json([
						'mensaje'			=> "Esta Gestion tiene Periodos, no se puede eliminar",
						'titulo'			=> "Error",
						'tipoMensaje'		=> "error",
						'botonConfirmacion'	=> "ok"
					]);
	            }
				if($eliminado){
					return response()->json([
						'mensaje'			=> "Gestion eliminada Exitosamente",
						'titulo'			=> "Success",
						'tipoMensaje'		=> "success",
						'botonConfirmacion'	=> "ok",
						'IdGestion'         => $gestion->id
					]);
				}     

			}
			catch(Exception $e){
				//dd($e);
				return response()->json([
					'mensaje'			=> "Error a intentar eliminar la Gestion",
					'titulo'			=> "error",
					'tipoMensaje'		=> "error",
					'botonConfirmacion'	=> "ok"
				]);
			}
		}

        public function reporteSucursal($idempresa){
            try{
                $user = \Auth::user()->nombre . " " . \Auth::user()->apellido;
                $hoy = Carbon::now('America/La_Paz')->format('d/m/Y');

                $sucursales = DB::table('sucursal')
                                    ->join('persona','persona.id','sucursal.idcontacto')
                                    ->where('sucursal.idempresa',$idempresa)
                                    ->select('sucursal.alias','sucursal.direccion','persona.nombres','persona.apellidos')
                                    ->get();


                $pdf = \PDF::loadView('Empresas.reportesucursales',compact("sucursales","user","hoy"))
                    ->setPaper('letter');
                //impresora magnetica fina "papel estrecho"
                return $pdf->stream();
            }
            catch(Exception $e){
                dd($e);
            }
        }

        public function downloadExcelSucursal($idempresa){

            $user = \Auth::user()->nombre . " " . \Auth::user()->apellido;
            $hoy = Carbon::now('America/La_Paz')->format('d/m/Y');

            $sucursales = DB::table('sucursal')
                            ->join('persona','persona.id','sucursal.idcontacto')
                            ->where('sucursal.idempresa',$idempresa)
                            ->select('sucursal.alias','sucursal.direccion','persona.nombres','persona.apellidos')
                            ->get();

            ob_end_clean();
            ob_start();

            //dd($Proveedores);

            Excel::create('Sucursales', function($excel) use ($sucursales,$user,$hoy){
                $excel->sheet('Sucursales', function($sheet) use ($sucursales,$user,$hoy){
                    $sheet->loadView('Empresas.reporteexcelsucursales',compact("sucursales","user","hoy"));
                });
            })->export('xlsx');
        }

	//Puntos de  Facturacion
		public function listadepuntosdefacturacion(Request $request){
			try{
				$puntosfacturacion = DB::table('puntodefacturacion')
										 ->join('sucursal','sucursal.id','puntodefacturacion.idsucursal')
			                             ->where([['puntodefacturacion.idsucursal',$request->input('IdSucursal')],
			                             	['puntodefacturacion.estado',0]
			                             ])
			                             ->select('puntodefacturacion.id','puntodefacturacion.alias','puntodefacturacion.codigo','sucursal.alias as aliassuc','puntodefacturacion.idsucursal')
			                             ->get();

	            return response()->json([
						'mensaje'			=> "Listado de Puntos de Facturacion Exitoso",
						'titulo'			=> "Success",
						'tipoMensaje'		=> "success",
						'botonConfirmacion'	=> "ok",
						'puntosfacturacion' => $puntosfacturacion

					]);
			}catch(Exception $e){
				return response()->json([
					'mensaje'			=> $e,
					'titulo'			=> "error",
					'tipoMensaje'		=> "error",
					'botonConfirmacion'	=> "ok"
				]);
			}
		}

		public function TraerPuntoFacturacion(Request $request){
			try{
	            $puntofacturacion = DB::table('puntodefacturacion')
										 ->join('sucursal','sucursal.id','puntodefacturacion.idsucursal')
			                             ->where('puntodefacturacion.id',$request->input('IdPuntoFacturacion'))
			                             ->select('puntodefacturacion.id','puntodefacturacion.alias','puntodefacturacion.codigo','sucursal.alias as aliassuc','puntodefacturacion.idsucursal','puntodefacturacion.estado')
			                             ->first();

				return response()->json([
					'mensaje'			=> "Traer Punto de Facturacion Exitoso",
					'titulo'			=> "Success",
					'tipoMensaje'		=> "success",
					'botonConfirmacion'	=> "ok",
					'puntofacturacion'  => $puntofacturacion
				]);

			}
			catch(Exception $e){
				return response()->json([
					'mensaje'			=> $e,
					'titulo'			=> "error",
					'tipoMensaje'		=> "error",
					'botonConfirmacion'	=> "ok"
				]);
			}
		}

	    public function lpuntosdefacturacion($idempresa1,$idsucursal){
	    	try{
	    		$idempresa=$idempresa1;
	    		$empresa=Empresa::find($idempresa);
	    		$EmpresaNombre = $empresa->Nombre;
	    		$EmpresaSigla = $empresa->Sigla;

	    		$sucursal = Sucursal::find($idsucursal);
	    		$SucursalNombre = $sucursal->alias;
				$idusuario = \Auth::user()->id;
				$access = self::verificacion(2);
				if($access=="none"){
					\Auth::logout();
					$errors = [$this->username() => trans('auth.none')];
					return redirect('/login')
				            // ->withInput($request->only($this->username(), 'remember'))
				            ->withErrors($errors);
				}
	             return view('Dosificacion.puntofacturacion',compact('idempresa','EmpresaNombre','EmpresaSigla','access','idsucursal','SucursalNombre'));
	    	}
	    	catch(Exception $e){
	           return $e;
	    	}
	    }

	    public function GuardarPuntodeFacturacion(Request $request){
			try{
				$idusuario = \Auth::user()->id;
				$alias = $request->input('alias');
				$codigo = $request->input('codigo');
				$estado = $request->input('estado');
				$idsuc = $request->input('idsuc');
	    	    //Punto de Facturacion
	    	    	$pf = 0;
	    	    	$comppf = self::comprobardatacrearpuntofacturacion($alias,$codigo,$idsuc);
	    	    	if($comppf!=100){
    	    			return response()->json([
							'mensaje'			=> $comppf,
							'titulo'			=> "error",
							'tipoMensaje'		=> "error",
							'botonConfirmacion'	=> "ok"
						]);
    	    		}else{
    	    			$pf = self::crearpuntofacturacion($codigo,$alias,$estado,$idsuc);
    	    		}
				$pf = DB::table('puntodefacturacion')
							 ->join('sucursal','sucursal.id','puntodefacturacion.idsucursal')
                             ->where('puntodefacturacion.id',$pf)
                             ->select('puntodefacturacion.id','puntodefacturacion.alias','puntodefacturacion.codigo','sucursal.alias as aliassuc','puntodefacturacion.idsucursal','puntodefacturacion.estado')
                             ->first();

				return response()->json([
					'mensaje'			=> "Punto de Facturacion Guardado Exitosamente",
					'titulo'			=> "Success",
					'tipoMensaje'		=> "success",
					'botonConfirmacion'	=> "ok",
					'puntodefacturacion'=> $pf
				]);

			}
			catch(Exception $e){
				return response()->json([
					'mensaje'			=> $e,
					'titulo'			=> "error",
					'tipoMensaje'		=> "error",
					'botonConfirmacion'	=> "ok"
				]);
			}
		}

		public function EditarPuntodeFacturacion(Request $request){
			try{
				$idusuario = \Auth::user()->id;
				$alias = $request->input('alias');
				$codigo = $request->input('codigo');
				$estado = $request->input('estado');
				$idsuc = $request->input('idsuc');
				$IdPf = $request->input('IdPf');
				$pf = sucursal::find($IdPf);
		    	//sucursal
	    	    	$pf = 0;
	    	    	$comppf = self::comprobardatapuntofacturacion($alias,$codigo,$idsuc,$IdPf);
	    	    	if($comppf!=100){
    	    			return response()->json([
							'mensaje'			=> $comppf,
							'titulo'			=> "error",
							'tipoMensaje'		=> "error",
							'botonConfirmacion'	=> "ok"
						]);
    	    		}else{
    	    			$pf = self::actualizarpuntofacturacion($IdPf,$codigo,$alias,$estado,$idsuc);
    	    		}
    	    	$pf = DB::table('puntodefacturacion')
							 ->join('sucursal','sucursal.id','puntodefacturacion.idsucursal')
                             ->where('puntodefacturacion.id',$pf)
                             ->select('puntodefacturacion.id','puntodefacturacion.alias','puntodefacturacion.codigo','sucursal.alias as aliassuc','puntodefacturacion.idsucursal','puntodefacturacion.estado')
                             ->first();

				return response()->json([
					'mensaje'			=> "Punto de Facturacion actualizado Exitosamente",
					'titulo'			=> "Success",
					'tipoMensaje'		=> "success",
					'botonConfirmacion'	=> "ok",
					'puntodefacturacion'=> $pf
				]);
			}
			catch(Exception $e){
				return response()->json([
					'mensaje'			=> $e,
					'titulo'			=> "error",
					'tipoMensaje'		=> "error",
					'botonConfirmacion'	=> "ok"
				]);
			}
		}

		public function EliminarPuntodeFacturacion(Request $request){
			try{
				$gestion=Gestion::find($request->input('IdGestion'));
	            $Periodo=DB::table('periodo')
	                        ->where('periodo.IdGestion',$request->input('IdGestion'))
	                        ->first(); 
	            $eliminado;                
	            if($Periodo==null){
	            	$eliminado=$gestion->delete();
	            }
	            else{
	            	return response()->json([
						'mensaje'			=> "Esta Gestion tiene Periodos, no se puede eliminar",
						'titulo'			=> "Error",
						'tipoMensaje'		=> "error",
						'botonConfirmacion'	=> "ok"
					]);
	            }
				if($eliminado){
					return response()->json([
						'mensaje'			=> "Gestion eliminada Exitosamente",
						'titulo'			=> "Success",
						'tipoMensaje'		=> "success",
						'botonConfirmacion'	=> "ok",
						'IdGestion'         => $gestion->id
					]);
				}     

			}
			catch(Exception $e){
				//dd($e);
				return response()->json([
					'mensaje'			=> "Error a intentar eliminar la Gestion",
					'titulo'			=> "error",
					'tipoMensaje'		=> "error",
					'botonConfirmacion'	=> "ok"
				]);
			}
		}

        public function reportePFacturacion($idempresa,$idsucursal){
            try{
                $user = \Auth::user()->nombre . " " . \Auth::user()->apellido;
                $hoy = Carbon::now('America/La_Paz')->format('d/m/Y');

                $puntosfacturacion = DB::table('puntodefacturacion')
                                        ->join('sucursal','sucursal.id','puntodefacturacion.idsucursal')
                                        ->where([['puntodefacturacion.idsucursal',$idsucursal],
                                            ['puntodefacturacion.estado',0]
                                        ])
                                        ->select('puntodefacturacion.alias','puntodefacturacion.codigo','sucursal.alias as aliassuc')
                                        ->get();


                $pdf = \PDF::loadView('Dosificacion.reportpfact',compact("puntosfacturacion","user","hoy"))
                    ->setPaper('letter');
                //impresora magnetica fina "papel estrecho"
                return $pdf->stream();
            }
            catch(Exception $e){
                dd($e);
            }
        }

        public function downloadExcelPFacturacion($idempresa,$idsucursal){

            $user = \Auth::user()->nombre . " " . \Auth::user()->apellido;
            $hoy = Carbon::now('America/La_Paz')->format('d/m/Y');

            $puntosfacturacion = DB::table('puntodefacturacion')
                                    ->join('sucursal','sucursal.id','puntodefacturacion.idsucursal')
                                    ->where([['puntodefacturacion.idsucursal',$idsucursal],
                                        ['puntodefacturacion.estado',0]
                                    ])
                                    ->select('puntodefacturacion.alias','puntodefacturacion.codigo','sucursal.alias as aliassuc')
                                    ->get();


            ob_end_clean();
            ob_start();

            //dd($Proveedores);

            Excel::create('Puntos de Facturacion', function($excel) use ($puntosfacturacion,$user,$hoy){
                $excel->sheet('Puntos de Facturacion', function($sheet) use ($puntosfacturacion,$user,$hoy){
                    $sheet->loadView('Dosificacion.reportexcelpfact',compact("puntosfacturacion","user","hoy"));
                });
            })->export('xlsx');
        }

	//Dosificacion
        public function listadedosificacion(Request $request){
            try{
                $dosificaciones = DB::table('dosificacion')
                    ->where([
                        ['dosificacion.idpuntofacturacion',$request->input('IdPfacturacion')],
                        ['dosificacion.estado',0]
                    ])
                    ->get();

                $sistemafac = DB::table('sistemafacturacion')
                    ->where('sistemafacturacion.estado',0)
                    ->get();

                return response()->json([
                    'mensaje'			=> "Listado de Dosificaciones Exitoso",
                    'titulo'			=> "Success",
                    'tipoMensaje'		=> "success",
                    'botonConfirmacion'	=> "ok",
                    'Dosificaciones'    => $dosificaciones,
                    'Sistemafac'        => $sistemafac
                ]);
            }catch(Exception $e){
                return response()->json([
                    'mensaje'			=> $e,
                    'titulo'			=> "error",
                    'tipoMensaje'		=> "error",
                    'botonConfirmacion'	=> "ok"
                ]);
            }
        }

		public function TraerDosificacion(Request $request){
			try{
	           	$dosificacion = DB::table('dosificacion')
		                             ->where('dosificacion.id',$request->input('IdDosificacion'))
		                             ->first();

				return response()->json([
					'mensaje'			=> "Traer Dosificacion Exitoso",
					'titulo'			=> "Success",
					'tipoMensaje'		=> "success",
					'botonConfirmacion'	=> "ok",
					'Dosificacion'      => $dosificacion
				]);

			}
			catch(Exception $e){
				return response()->json([
					'mensaje'			=> $e,
					'titulo'			=> "error",
					'tipoMensaje'		=> "error",
					'botonConfirmacion'	=> "ok"
				]);
			}
		}

        public function ldosificacionsuc($idempresa1,$idsucursal,$idpfacturacionl){


            try{
                $idempresa=$idempresa1;
                $empresa=Empresa::find($idempresa);
                $EmpresaNombre = $empresa->Nombre;
                $EmpresaSigla = $empresa->Sigla;
                $sucursal = sucursal::find($idsucursal);
                $SucursalNombre = $sucursal->alias;
                $pfacturacion = puntodefacturacion::find($idpfacturacionl);
                $PfacNombre = $pfacturacion->alias;

                $ley = DB::table('leyenda')
                    ->where('leyenda.estado',0)
                    ->get();
                $sistemafac = DB::table('sistemafacturacion')
                    ->where('sistemafacturacion.estado',0)
                    ->get();

                $idusuario = \Auth::user()->id;
                $access = self::verificacion(2);
                if($access=="none"){
                    \Auth::logout();
                    $errors = [$this->username() => trans('auth.none')];
                    return redirect('/login')
                        ->withErrors($errors);
                }
                return view('Dosificacion.dosificacionsuc',compact('idempresa','EmpresaNombre','EmpresaSigla','access','ley','sistemafac','SucursalNombre','idsucursal','PfacNombre','idpfacturacionl'));
            }
            catch(Exception $e){
                return $e;
            }
        }

        public function ldosificacion($idempresa1){
            try{
                $idempresa=$idempresa1;
                $empresa=Empresa::find($idempresa);
                $EmpresaNombre = $empresa->Nombre;
                $EmpresaSigla = $empresa->Sigla;

                $ley = DB::table('leyenda')
                    ->where('leyenda.estado',0)
                    ->get();
                $sistemafac = DB::table('sistemafacturacion')
                    ->where('sistemafacturacion.estado',0)
                    ->get();

                $idusuario = \Auth::user()->id;
                $access = self::verificacion(2);
                if($access=="none"){
                    \Auth::logout();
                    $errors = [$this->username() => trans('auth.none')];
                    return redirect('/login')

                        ->withErrors($errors);
                }
                return view('Dosificacion.dosificacion',compact('idempresa','EmpresaNombre','EmpresaSigla','access','ley','sistemafac'));
            }
            catch(Exception $e){
                return $e;
            }
        }

        public function GuardarDosificacion(Request $request){
            try{
                $idusuario = \Auth::user()->id;
                $ntramite = $request->input('ntramite');
                $nauth = $request->input('nauth');
                $nfac = $request->input('nfac');
                $fle = $request->input('fle');
                $ley = $request->input('ley');
                $tday = $request->input('tday');
                $sisfac = $request->input('sisfac');
                $clave = $request->input('clave');
                $hab = $request->input('hab');
                $idem = $request->input('idem');

                $idpfacturacion = $request->input('idpfacturacion');

                $empresa = empresa::find($idem);

                $dosificaciones = DB::table('dosificacion')
                    ->where([
                        ['dosificacion.idpuntofacturacion',$idpfacturacion],
                        ['dosificacion.estado',0],
                        ['dosificacion.idsistemafacturacion',$sisfac]
                    ])
                    ->get();
                foreach ($dosificaciones as &$d) {
                    if($d->ntramite==$ntramite){
                        return response()->json([
                            'mensaje'			=> "Este Tramite ya esta registrado",
                            'titulo'			=> "error",
                            'tipoMensaje'		=> "error",
                            'botonConfirmacion'	=> "ok"
                        ]);
                    }
                }

                //Crear factura computarizada
                if ($sisfac == 1 && $hab == 1){
                    foreach ($dosificaciones as $dupdate) {

                        $dosifi = dosificacion::find($dupdate->id);

                        if ($dosifi->idsistemafacturacion == 1){
                            if ($dosifi->habilitado == 1){

                                $dosifi->habilitado = 0;

                                $dosifi->save();
                            }
                        }
                    }
                }

                //Crear Factura Manual
                if ($sisfac == 2 && $hab == 1){
                    foreach ($dosificaciones as $dupdate) {

                        $dosifi = dosificacion::find($dupdate->id);

                        if ($dosifi->idsistemafacturacion == 2){
                            if ($dosifi->habilitado == 1){

                                $dosifi->habilitado = 0;

                                $dosifi->save();
                            }
                        }
                    }
                }

                $dosificacion = new dosificacion();
                $dosificacion->ntramite = $ntramite;
                $dosificacion->nautorizacion = $nauth;
                $dosificacion->idleyenda = $ley;
                $dosificacion->tiempodias = $tday;
                $dosificacion->fechalimiteemision = $fle;
                $dosificacion->cantidadfac = $nfac;
                $dosificacion->stockfacturas = $nfac;
                $dosificacion->estado = 0;
                $dosificacion->idsistemafacturacion = $sisfac;
                $dosificacion->idsector = $empresa->idsector;
                $dosificacion->habilitado = $hab;
                $dosificacion->clave = $clave;
                $dosificacion->idpuntofacturacion = $idpfacturacion;

                $guardado = $dosificacion->save();

                if($guardado){
                    $leyenda = DB::table('leyenda')
                        ->where('leyenda.estado',0)
                        ->get();
                    $sistemafac = DB::table('sistemafacturacion')
                        ->where('sistemafacturacion.estado',0)
                        ->get();

                    return response()->json([
                        'mensaje'			=> "Dosificacion Guardada Exitosamente",
                        'titulo'			=> "Success",
                        'tipoMensaje'		=> "success",
                        'botonConfirmacion'	=> "ok",
                        'Dosificaciones'    => $dosificacion,
                        'Sistemafac'        => $sistemafac,
                        'Leyenda'           => $leyenda

                    ]);
                }

            }
            catch(Exception $e){
                return response()->json([
                    'mensaje'			=> $e,
                    'titulo'			=> "error",
                    'tipoMensaje'		=> "error",
                    'botonConfirmacion'	=> "ok"
                ]);
            }
        }

        public function EditarDosificacion(Request $request){
            try{
                $idusuario = \Auth::user()->id;
                $IdDosificacion = $request->input('IdDosificacion');
                $ntramite = $request->input('ntramite');
                $nauth = $request->input('nauth');
                $nfac = $request->input('nfac');
                $fle = $request->input('fle');
                $ley = $request->input('ley');
                $tday = $request->input('tday');
                $sisfac = $request->input('sisfac');
                $clave = $request->input('clave');
                $hab = $request->input('hab');
                $idem = $request->input('idem');
                $empresa = empresa::find($idem);
                $idpfacturacion = $request->input('idpfacturacion');

                $dosificaciones = DB::table('dosificacion')
                    ->where([
                        ['dosificacion.idpuntofacturacion',$idpfacturacion],
                        ['dosificacion.estado',0],
                         ['dosificacion.idsistemafacturacion',$sisfac]
                    ])
                    ->get();
                $dosificacion = dosificacion::find($IdDosificacion);
                foreach ($dosificaciones as $d) {
                    if($d->id!=$dosificacion->id){
                        if($d->ntramite==$ntramite){
                            return response()->json([
                                'mensaje'			=> "Este Tramite ya esta registrado",
                                'titulo'			=> "error",
                                'tipoMensaje'		=> "error",
                                'botonConfirmacion'	=> "ok"
                            ]);
                        }
                    }
                }

                 //Actualizar factura computarizada
                if ($sisfac == 1 && $hab == 1){
                    foreach ($dosificaciones as $dupdate) {

                        $dosifi = dosificacion::find($dupdate->id);

                        if ($dosifi->idsistemafacturacion == 1){
                            if ($dosifi->habilitado == 1){

                                $dosifi->habilitado = 0;

                                $dosifi->save();
                            }
                        }
                    }
                }

                //Actualizar Factura Manual
                if ($sisfac == 2 && $hab == 1){
                    foreach ($dosificaciones as $dupdate) {

                        $dosifi = dosificacion::find($dupdate->id);

                        if ($dosifi->idsistemafacturacion == 2){
                            if ($dosifi->habilitado == 1){

                                $dosifi->habilitado = 0;

                                $dosifi->save();
                            }
                        }
                    }
                }

                $dosificacion->ntramite = $ntramite;
                $dosificacion->nautorizacion = $nauth;
                $dosificacion->idleyenda = $ley;
                $dosificacion->tiempodias = $tday;
                $dosificacion->fechalimiteemision = $fle;
                $dosificacion->cantidadfac = $nfac;
                $dosificacion->stockfacturas = $nfac;
                $dosificacion->estado = 0;
                $dosificacion->idsistemafacturacion = $sisfac;
                $dosificacion->idsector = $empresa->idsector;
                $dosificacion->habilitado = $hab;
                $dosificacion->clave = $clave;
                $dosificacion->idpuntofacturacion = $idpfacturacion;
                $guardado = $dosificacion->save();

                if($guardado){
                    $leyenda = DB::table('leyenda')
                        ->where('leyenda.estado',0)
                        ->get();
                    $sistemafac = DB::table('sistemafacturacion')
                        ->where('sistemafacturacion.estado',0)
                        ->get();
                    return response()->json([
                        'mensaje'			=> "Dosificacion Actualizada Exitosamente",
                        'titulo'			=> "Success",
                        'tipoMensaje'		=> "success",
                        'botonConfirmacion'	=> "ok",
                        'Dosificaciones'    => $dosificacion,
                        'Sistemafac'        => $sistemafac,
                        'Leyenda'           => $leyenda

                    ]);
                }

            }
            catch(Exception $e){
                return response()->json([
                    'mensaje'			=> $e,
                    'titulo'			=> "error",
                    'tipoMensaje'		=> "error",
                    'botonConfirmacion'	=> "ok"
                ]);
            }
        }

        public function EliminarDosificacion(Request $request){
            try{
                $dosificacion=dosificacion::find($request->input('IdDosif'));
                $eliminado=false;
                $dosificacion->estado=1;
                $dosificacion->save();
                $eliminado=true;
                if($eliminado==true){
                    return response()->json([
                        'mensaje'			=> "Dosificación eliminada Exitosamente",
                        'titulo'			=> "Success",
                        'tipoMensaje'		=> "success",
                        'botonConfirmacion'	=> "ok",
                        'IdDosificacion'    => $dosificacion->id
                    ]);
                }

            }
            catch(Exception $e){
                //dd($e);
                return response()->json([
                    'mensaje'			=> "Error a intentar eliminar la Dosificación",
                    'titulo'			=> "error",
                    'tipoMensaje'		=> "error",
                    'botonConfirmacion'	=> "ok"
                ]);
            }
        }

        public function reporteDosificacion($idempresa,$idsucursal,$idpfacturacion){
            try{
                $user = \Auth::user()->nombre . " " . \Auth::user()->apellido;
                $hoy = Carbon::now('America/La_Paz')->format('d/m/Y');

                $dosificaciones = DB::table('dosificacion')
                                    ->join('sistemafacturacion','sistemafacturacion.id','dosificacion.idsistemafacturacion')
                                    ->where([
                                        ['dosificacion.idpuntofacturacion',$idpfacturacion],
                                        ['dosificacion.estado',0]
                                    ])
                                    ->Select('dosificacion.ntramite','dosificacion.nautorizacion','dosificacion.stockfacturas','sistemafacturacion.sistemafacturacion','dosificacion.fechalimiteemision')
                                    ->get();


                $pdf = \PDF::loadView('Dosificacion.reportedosifi',compact("dosificaciones","user","hoy"))
                    ->setPaper('letter');
                //impresora magnetica fina "papel estrecho"
                return $pdf->stream();
            }
            catch(Exception $e){
                dd($e);
            }
        }

        public function downloadExcelDosificacion($idempresa,$idsucursal,$idpfacturacion){

            $user = \Auth::user()->nombre . " " . \Auth::user()->apellido;
            $hoy = Carbon::now('America/La_Paz')->format('d/m/Y');

            $dosificaciones = DB::table('dosificacion')
                                ->join('sistemafacturacion','sistemafacturacion.id','dosificacion.idsistemafacturacion')
                                ->where([
                                    ['dosificacion.idpuntofacturacion',$idpfacturacion],
                                    ['dosificacion.estado',0]
                                ])
                                ->Select('dosificacion.ntramite','dosificacion.nautorizacion','dosificacion.stockfacturas','sistemafacturacion.sistemafacturacion','dosificacion.fechalimiteemision')
                                ->get();


            ob_end_clean();
            ob_start();

            //dd($Proveedores);

            Excel::create('Dosificaciones', function($excel) use ($dosificaciones,$user,$hoy){
                $excel->sheet('Dosificaciones', function($sheet) use ($dosificaciones,$user,$hoy){
                    $sheet->loadView('Dosificacion.reporteexceldosifi',compact("dosificaciones","user","hoy"));
                });
            })->export('xlsx');
        }

	//sucursal
		public function crearsucursal($alias,$direccion,$telefono,$email,$estado,$empresa,$contacto=0){
			try{
				$sucursal = new sucursal();
				$sucursal->direccion=$direccion;
				$sucursal->alias=$alias;
				$sucursal->estado=$estado;
				$sucursal->idempresa=$empresa;
				if(!empty($telefono)){
					$sucursal->telefono=$telefono;
				}
				if(!empty($email)){
					$sucursal->email=$email;
				}
				if(!empty($contacto)){
					if($contacto!=0){
						$sucursal->idcontacto=$contacto;	
					}
				}
				$sucursal->save();
				return $sucursal->id;
			}catch(Exception $e){
				return -100;
			}
		}
		public function actualizarsucursal($idsucursal,$alias,$direccion,$telefono,$email,$estado,$empresa,$contacto=0){
			try{
				$sucursal = sucursal::find($idsucursal);
				$sucursal->estado=$estado;
				$sucursal->idempresa=$empresa;
				if(!empty($direccion)){
					$sucursal->direccion=$direccion;
				}
				if(!empty($alias)){
					$sucursal->alias=$alias;
				}
				if(!empty($telefono)){
					$sucursal->telefono=$telefono;
				}
				if(!empty($email)){
					$sucursal->email=$email;
				}
				if(!empty($contacto)){
					if($contacto!=0){
						$sucursal->idcontacto=$contacto;	
					}
				}
				$sucursal->save();
				return $sucursal->id;
			}catch(Exception $e){
				return -100;
			}
		}
		public function comprobardatacrearsucursal($alias=0,$direccion=0,$idempresa){
			try
			{
				$sucursales = DB::table('sucursal')
	                             ->where([['sucursal.idempresa',$idempresa],['sucursal.estado',0]])
	                             ->get();
                foreach ($sucursales as &$s) {
            		if($s->alias==$alias){
            			return "Este alias ya esta registrado";
            		}
            		if($s->direccion==$direccion){
            			return "Esta direccion ya esta registrada";
            		}
                }
                return 100;
			}catch(Exception $e){
				return -100;
			}
		}
		public function comprobardatasucursal($alias=0,$direccion=0,$idempresa,$idsucursal){
			try
			{
				$sucursales = DB::table('sucursal')
	                             ->where([['sucursal.idempresa',$idempresa],['sucursal.estado','0']])
	                             ->get();
                foreach ($sucursales as &$s) {
                	if($s->id!=$idsucursal){
                		if($s->alias==$alias){
	            			return "Este alias ya esta registrado";
	            		}
	            		if(trim(strtolower($s->direccion))==trim(strtolower($direccion))){
	            			return "Esta direccion ya esta registrada";
	            		}
                	}
                }
                return 100;
			}catch(Exception $e){
				return -100;
			}
		}
	//punto de  factuacion
		public function crearpuntofacturacion($codigo,$alias,$estado,$idsucursal){
			try{
				$pf = new puntodefacturacion();
				$pf->codigo=$codigo;
				$pf->alias=$alias;
				$pf->estado=$estado;
				$pf->idsucursal=$idsucursal;
				$pf->save();
				return $pf->id;
			}catch(Exception $e){
				return -100;
			}
		}
		public function actualizarpuntofacturacion($idpuntofacturacion,$codigo,$alias,$estado,$idsucursal){
			try{
				$pf = puntodefacturacion::find($idpuntofacturacion);
				$pf->codigo=$codigo;
				$pf->alias=$alias;
				$pf->estado=$estado;
				$pf->idsucursal=$idsucursal;
				$pf->save();	
				return $pf->id;
			}catch(Exception $e){
				return -100;
			}
		}
		public function comprobardatacrearpuntofacturacion($alias=0,$codigo=0,$idsucursal){
			try
			{
				$pfs = DB::table('puntodefacturacion')
	                             ->where([['puntodefacturacion.idsucursal',$idsucursal],['puntodefacturacion.estado',0]])
	                             ->get();
                foreach ($pfs as &$pf) {
            		if($pf->alias==$alias){
            			return "Este alias ya esta registrado";
            		}
            		if($pf->codigo==$codigo){
            			return "Este codigo ya esta registrado";
            		}
                }
                return 100;
			}catch(Exception $e){
				return -100;
			}
		}
		public function comprobardatapuntofacturacion($alias=0,$codigo=0,$idsucursal,$idpuntofacturacion){
			try
			{
				$pfs = DB::table('puntodefacturacion')
	                             ->where([['puntodefacturacion.idsucursal',$idsucursal],['puntodefacturacion.estado','0']])
	                             ->get();
                foreach ($pfs as &$pf) {
                	if($pf->id!=$idpuntofacturacion){
                		if($pf->alias==$alias){
	            			return "Este alias ya esta registrado";
	            		}
	            		if(trim(strtolower($pf->codigo))==trim(strtolower($codigo))){
	            			return "Este codigo ya esta registrado";
	            		}
                	}
                }
                return 100;
			}catch(Exception $e){
				return -100;
			}
		}
	//persona
		public function crearpersona($nombres,$apellidos,$ci,$nit,$email,$tel,$cel,$dir,$fnc){
			try{
				$persona = new persona();
				$persona->ci=$ci;
				if(!empty($nit)){
					$persona->nit=$nit;
				}
				if(!empty($nombres)){
					$persona->nombres=$nombres;
				}
				if(!empty($apellidos)){
					$persona->apellidos=$apellidos;
				}
				if(!empty($tel)){
					$persona->telefono=$tel;
				}
				if(!empty($cel)){
					$persona->celular=$cel;
				}
				if(!empty($dir)){
					$persona->direccion=$dir;
				}
				if(!empty($email)){
					$persona->email=$email;
				}
				if(!empty($fnc)){
					$persona->fecha_de_nacimiento=$fnc;
				}
				$persona->save();
				return $persona->id;
			}catch(Exception $e){
				return -100;
			}
		}
		public function actualizarpersona($idpersona,$nombres,$apellidos,$ci,$nit,$email,$tel,$cel,$dir,$fnc){
			try{
				$persona = persona::find($idpersona);
				$persona->ci=$ci;
				if(!empty($nit)){
					$persona->nit=$nit;
				}
				if(!empty($nombres)){
					$persona->nombres=$nombres;
				}
				if(!empty($apellidos)){
					$persona->apellidos=$apellidos;
				}
				if(!empty($tel)){
					$persona->telefono=$tel;
				}
				if(!empty($cel)){
					$persona->celular=$cel;
				}
				if(!empty($dir)){
					$persona->direccion=$dir;
				}
				if(!empty($email)){
					$persona->email=$email;
				}
				if(!empty($fnc)){
					$persona->fecha_de_nacimiento=$fnc;
				}
				$persona->save();
				return $persona->id;
			}catch(Exception $e){
				return -100;
			}
		}
		public function comprobardatacrear($ci=0,$nit=0,$email=0){
			try
			{
				$personas = DB::table('persona')
                            	->get();
                foreach ($personas as &$p) {
                	if(!empty($ci)){
						if($p->ci==$ci){
	            			return "Este CI ya esta registrado";
	            		}
					}
            		if(!empty($nit)){
	            		if($p->nit==$nit){
	            			return "Este NIT ya esta registrado";
	            		}
	            	}
	            	if(!empty($email)){
	            		if($p->email==$email){
	            			return "Este email ya esta registrado";
	            		}
	            	}
                }
                return 100;
			}catch(Exception $e){
				return -100;
			}
		}
		public function comprobardata($ci=0,$nit=0,$email=0,$idpersona){
			try
			{
				$personas = DB::table('persona')
                            	->get();
                foreach ($personas as &$p) {
                	if($p->id!=$idpersona){
                		if(!empty($ci)){
	                		if($p->ci==$ci){
	                			return "Este CI ya esta registrado";
	                		}
	                	}
	                	if(!empty($nit)){
	                		if($p->nit==$nit){
	                			return "Este NIT ya esta registrado";
	                		}
	                	}
	                	if(!empty($email)){
	                		if($p->email==$email){
	                			return "Este email ya esta registrado";
	                		}
	                	}
                	}
                }
                return 100;
			}catch(Exception $e){
				return -100;
			}
		}
    //verificacion
		public function verificacion($vista=0){
	      try{
	        $idempresa = \Auth::user()->idempresa;
	        $TipoUsuario = \Auth::user()->TipoUsuario;
	        $iduser = \Auth::user()->id;
	        $hoy = Carbon::now('America/La_Paz');
	        $res = "none";
	        if($TipoUsuario==1){
	          $res = "total";
	        }else{
	          $membresia = DB::table('membresia')
	                      ->where([['membresia.idempresa',$idempresa],['membresia.estado',1]])
	                      ->first();
	          
	          $date = DateTime::createFromFormat('y-m-d H:i:s',date('y-m-d H:i:s', strtotime($membresia->fechafin)));
	          $fechafin=$hoy->diff($date)->format("%Y-%M-%D %H:%I:%S");
	          if($hoy<$date){
	            if($vista!=0){
	              $vistausuario = DB::table('vistausuario')
	                      ->where([['vistausuario.idusuario',$iduser],['vistausuario.idvista',$vista]])
	                      ->first();
	              if($vistausuario->estado==0){
	              	$res="none1";
	              }else{
	          		  if($vistausuario->tipoacceso==1){
		                $res="total";
		              }
		              if($vistausuario->tipoacceso==2){
		                $res="parcial";
		              }
		              if($vistausuario->tipoacceso==3){
		                $res="consulta";
		              }
	              }
	            }else{
	              $res="total";
	            }
	          }else{
	            if($fechafin>'00-00-10 00:00:00'){
	              $res="none";
	            }else{
	            	if($res!="none1"){
	        			$res="consulta";
	            	}
	            }
	          } 
	        }
	        //dd($res);
	        return $res;
	      }catch(Exception $e){
	        return "none";
	      } 
	    }

	    public function username() {
	        return 'name';
	    }
}

