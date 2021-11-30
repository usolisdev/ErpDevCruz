<?php

namespace App\Http\Controllers;

use Excel;
use DateTime;
use Throwable;
use App\Cuentas;
use App\Empresa;
use App\Gestion;
use App\Periodo;
use App\persona;
use App\Reporte;
use App\clientes;
use App\sucursal;
use App\atributos;
use Carbon\Carbon;
use App\enterprise;
use App\proveedores;
use App\EmpresaMoneda;
use App\atributosgrupo;
use \Milon\Barcode\DNS2D;
use App\sector_economico;
use App\definicionatributos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Contracts\Encryption\DecryptException;

class EmpresaController extends Controller
{
	// empresas
		public function listarempresas(){
			try{
				$empresas = DB::table('empresa')
	                      ->where('empresa.estado','0')
	                      ->get();
	            //return $empresas;
	            return response()->json([
						'mensaje'			=> "Listado de Empresas Exitoso",
						'titulo'			=> "Success",
						'tipoMensaje'		=> "success",
						'botonConfirmacion'	=> "ok",
						'data'          => $empresas

					]);
			}catch(Throwable $e){
				return response()->json([
					'mensaje'			=> $e,
					'titulo'			=> "error",
					'tipoMensaje'		=> "error",
					'botonConfirmacion'	=> "ok"
				]);
			}
		}

		// public function TraerEmpresa(Request $request){
		// 	try{
	    //         $empresa=DB::table('ofertas')
	    //                     ->where('ofertas.id',$request->input('IdEmpresa'))
	    //                     ->first();

		// 		return response()->json([
		// 			'mensaje'			=> "Empresa Actualizada Exitosamente",
		// 			'titulo'			=> "Success",
		// 			'tipoMensaje'		=> "success",
		// 			'botonConfirmacion'	=> "ok",
		// 			'Empresa'           => $empresa
		// 		]);

		// 	}
		// 	catch(Exception $e){
		// 		return response()->json([
		// 			'mensaje'			=> $e,
		// 			'titulo'			=> "error",
		// 			'tipoMensaje'		=> "error",
		// 			'botonConfirmacion'	=> "ok"
		// 		]);
		// 	}
		// }

	    public function GuardarActualizarEmpresa(Request $request){

			try{
				$idusuario = Auth::user()->id;
                $hoy = Carbon::now('America/La_Paz');

                if ($request->input('IdEmpresa') != "" || $request->input('IdEmpresa') != null) {

                    $empresa=DB::table('empresa')
	                        ->where('empresa.id',$request->input('IdEmpresa'))
	                        ->first();

                    if(strtolower($empresa->Nombre)==strtolower($request->input('NombreEmpresa'))){
                    }
                    else{
                        $nombre = DB::table('empresa')
                                    ->where(strtolower('empresa.Nombre'),strtolower($request->input('NombreEmpresa')))
                                    ->first();
                        if($nombre!=null){
                            return response()->json([
                                'mensaje'			=> "Ya existe una empresa con este nombre",
                                'titulo'			=> "Error",
                                'tipoMensaje'		=> "error",
                                'botonConfirmacion'	=> "ok"
                            ]);
                        }
                    }

                    if(strtolower($empresa->Nit)==strtolower($request->input('NitEmpresa'))){
                    }
                    else{
                        $nit = DB::table('empresa')
                                    ->where(strtolower('empresa.Nit'),strtolower($request->input('NitEmpresa')))
                                    ->first();
                        if($nit!=null){
                            return response()->json([
                                'mensaje'			=> "Ya existe una empresa con este nit",
                                'titulo'			=> "Error",
                                'tipoMensaje'		=> "error",
                                'botonConfirmacion'	=> "ok"
                            ]);
                        }
                    }
                    if(strtolower($empresa->Sigla)==strtolower($request->input('SiglaEmpresa'))){
                    }
                    else{
                        $sigla = DB::table('empresa')
                                    ->where(strtolower('empresa.Sigla'),strtolower($request->input('SiglaEmpresa')))
                                    ->first();
                        if($sigla!=null){
                            return response()->json([
                                'mensaje'			=> "Ya existe una empresa con esta sigla",
                                'titulo'			=> "Error",
                                'tipoMensaje'		=> "error",
                                'botonConfirmacion'	=> "ok"
                            ]);
                        }
                    }
                    $empresaac=Empresa::where('empresa.id', $request->input('IdEmpresa'))->first();

                    $empresaac->Nombre		= $request->input('NombreEmpresa');
                    $empresaac->Nit		    = $request->input('NitEmpresa');
                    $empresaac->Sigla		= $request->input('SiglaEmpresa');
                    $empresaac->Telefono	= $request->input('TelefonoEmpresa'). " ";
                    $empresaac->Correo	    = $request->input('CorreoEmpresa'). " ";
                    $empresaac->Direccion	= $request->input('DireccionEmpresa'). " ";
                    //$empresaac->Niveles	= $request->input('NivelesEmpresa');

                    $guardado = $empresaac->save();

                    if($guardado){
                        return response()->json([
                            'mensaje'			=> "Empresa Actualizada Exitosamente",
                            'titulo'			=> "Update",
                            'tipoMensaje'		=> "success",
                            'botonConfirmacion'	=> "ok",
                            'Empresa'           => $empresaac
                        ]);
                    }
                }
                else {

                    $nombre = DB::table('empresa')
	                            ->where(strtolower('empresa.Nombre'),strtolower($request->input('NombreEmpresa')))
	                            ->first();
                    $nit = DB::table('empresa')
                                    ->where(strtolower('empresa.Nit'),strtolower($request->input('NitEmpresa')))
                                    ->first();
                    $sigla = DB::table('empresa')
                                    ->where(strtolower('empresa.Sigla'),strtolower($request->input('SiglaEmpresa')))
                                    ->first();
                    if($nombre!=null){
                        return response()->json([
                            'mensaje'			=> "Ya existe una empresa con este nombre",
                            'titulo'			=> "Error",
                            'tipoMensaje'		=> "error",
                            'botonConfirmacion'	=> "ok"
                        ]);
                    }
                    if($nit!=null){
                        return response()->json([
                            'mensaje'			=> "Ya existe una empresa con este nit",
                            'titulo'			=> "Error",
                            'tipoMensaje'		=> "error",
                            'botonConfirmacion'	=> "ok"
                        ]);
                    }
                    if($sigla!=null){
                        return response()->json([
                            'mensaje'			=> "Ya existe una empresa con esta sigla",
                            'titulo'			=> "Error",
                            'tipoMensaje'		=> "error",
                            'botonConfirmacion'	=> "ok"
                        ]);
                    }

                    $empresa = new Empresa;
                    $empresa->Nombre		= $request->input('NombreEmpresa');
                    $empresa->Nit		    = $request->input('NitEmpresa');
                    $empresa->Sigla		    = $request->input('SiglaEmpresa');
                    $empresa->Telefono	    = $request->input('TelefonoEmpresa') . " ";
                    $empresa->Correo	    = $request->input('CorreoEmpresa'). " ";
                    $empresa->Direccion		= $request->input('DireccionEmpresa'). " ";
                    $empresa->Niveles	    = $request->input('NivelesEmpresa');
                    $empresa->estado	    = 0;
                    $empresa->IdUsuario	    = $idusuario;
                    $empresa->created_at    = $hoy;

                    $guardado = $empresa->save();

                    //$cuentas = self::Agregar5cuentasInicio($empresa->id);
                    $monedas = self::AgregarRelacionMoneda($empresa->id,$request->input('MonedaEmpresa'));

                    if($guardado){
                        return response()->json([
                            'mensaje'			=> "Empresa Guardada Exitosamente",
                            'titulo'			=> "Success",
                            'tipoMensaje'		=> "success",
                            'botonConfirmacion'	=> "ok",
                            'Empresa'           => $empresa
                        ]);
                    }
                }

			}
			catch(Throwable $e){
				//dd($e);
				return response()->json([
					'mensaje'			=> $e,
					'titulo'			=> "error",
					'tipoMensaje'		=> "error",
					'botonConfirmacion'	=> "ok"
				]);
			}
		}

		// public function EditarEmpresa(Request $request){
		// 	try{
	    //         $empresa=DB::table('empresa')
	    //                     ->where('empresa.id',$request->input('IdEmpresa'))
	    //                     ->first();
	    //         if(strtolower($empresa->Nombre)==strtolower($request->input('NombreEmpresa'))){
	    //         }else{
	    //         	$nombre = DB::table('empresa')
	    //                         ->where(strtolower('empresa.Nombre'),strtolower($request->input('NombreEmpresa')))
	    //                         ->first();
	    //             if($nombre!=null){
	    //         	return response()->json([
		// 				'mensaje'			=> "Ya existe una empresa con este nombre",
		// 				'titulo'			=> "Error",
		// 				'tipoMensaje'		=> "error",
		// 				'botonConfirmacion'	=> "ok"
		// 			]);
	    //         }
	    //         }
	    //         if(strtolower($empresa->Nit)==strtolower($request->input('NitEmpresa'))){
	    //     	}
	    //         else{
	    //         	$nit = DB::table('empresa')
	    //                         ->where(strtolower('empresa.Nit'),strtolower($request->input('NitEmpresa')))
	    //                         ->first();
	    //             if($nit!=null){
	    //         	return response()->json([
		// 				'mensaje'			=> "Ya existe una empresa con este nit",
		// 				'titulo'			=> "Error",
		// 				'tipoMensaje'		=> "error",
		// 				'botonConfirmacion'	=> "ok"
		// 			]);
	    //         }
	    //         }
	    //         if(strtolower($empresa->Sigla)==strtolower($request->input('SiglaEmpresa'))){
	    // 	    }
	    // 	    else{
	    // 	    	$sigla = DB::table('empresa')
	    //                         ->where(strtolower('empresa.Sigla'),strtolower($request->input('SiglaEmpresa')))
	    //                         ->first();
		// 			if($sigla!=null){
		// 				return response()->json([
		// 					'mensaje'			=> "Ya existe una empresa con esta sigla",
		// 					'titulo'			=> "Error",
		// 					'tipoMensaje'		=> "error",
		// 					'botonConfirmacion'	=> "ok"
		// 				]);
		// 			}
	    // 	    }
	    // 	    $empresaac=Empresa::where('empresa.id', $request->input('IdEmpresa'))
		// 						->first();

		// 		$empresaac->Nombre		= $request->input('NombreEmpresa');
		// 		$empresaac->Nit		    = $request->input('NitEmpresa');
		// 		$empresaac->Sigla		    = $request->input('SiglaEmpresa');
		// 		$empresaac->Telefono	    = $request->input('TelefonoEmpresa'). " ";
		// 		$empresaac->Correo	    = $request->input('CorreoEmpresa'). " ";
		// 		$empresaac->Direccion		= $request->input('DireccionEmpresa'). " ";
		// 		$empresaac->Niveles	    = $request->input('NivelesEmpresa');

		// 		$guardado = $empresaac->save();

		// 		if($guardado){
		// 			return response()->json([
		// 				'mensaje'			=> "Empresa Actualizada Exitosamente",
		// 				'titulo'			=> "Success",
		// 				'tipoMensaje'		=> "success",
		// 				'botonConfirmacion'	=> "ok",
		// 				'Empresa'           => $empresaac
		// 			]);
		// 		}

		// 	}
		// 	catch(Exception $e){
		// 		return response()->json([
		// 			'mensaje'			=> $e,
		// 			'titulo'			=> "error",
		// 			'tipoMensaje'		=> "error",
		// 			'botonConfirmacion'	=> "ok"
		// 		]);
		// 	}
		// }

		public function EliminarEmpresa(Request $request){
			try{

                $SectoresSelect = $request->input(('IdRowSelected'));

                foreach ($SectoresSelect as $l) {

                    $empresa=Empresa::find($l);

                    $empresa->estado=1;
                    $empresa->save();
                }

                $Mensaje = "Empresas eliminadas Exitosamente";

                return response()->json([

                        'mensaje'			=> $Mensaje,
                        'titulo'			=> "Success",
                        'tipoMensaje'		=> "success",
                        'botonConfirmacion'	=> "ok"
                ]);


			}
			catch(Throwable $e){
				//dd($e);
				return response()->json([
					'mensaje'			=> "Error a intentar eliminar la Empresa",
					'titulo'			=> "error",
					'tipoMensaje'		=> "error",
					'botonConfirmacion'	=> "ok"
				]);
			}
		}

		// public function reporteEmpresa(){
		// 	try{
		// 		$user = \Auth::user()->nombre . " " . \Auth::user()->apellido;
		// 		$hoy = Carbon::now('America/La_Paz')->format('d/m/Y');
		// 		$empresas = DB::table('empresa')
	    //                   ->where('empresa.estado','0')
	    //                   ->get();
		// 		$pdf = \PDF::loadView('Empresas.reporteempresas',compact("empresas","user","hoy"))
		// 	       ->setPaper('letter');
		// 	       //impresora magnetica fina "papel estrecho"
        //     	return $pdf->stream();
		// 	}
		// 	catch(Exception $e){
	    //         dd($e);
		// 	}
		// }

		// public function downloadExcelempresas(){
		// 	$user = \Auth::user()->nombre . " " . \Auth::user()->apellido;
		// 	$hoy = Carbon::now('America/La_Paz')->format('d/m/Y');
	    //     $empresas = Empresa::select("Sigla","Nombre","Nit","Telefono","Correo")
	    //     					->where("estado",0)
	    //     					->get();
	    //     ob_end_clean();
	    //     ob_start();
		// 	Excel::create('Empresas', function($excel) use ($empresas,$user,$hoy){
		// 	   $excel->sheet('Empresas', function($sheet) use ($empresas,$user,$hoy){
		// 	       $sheet->loadView('Empresas.repempexcel',compact("empresas","user","hoy"));
		// 	     });
		// 	})->export('xlsx');
	    // }

		// public function Agregar5cuentasInicio($idem){
		// 	try{
		// 		//$cuenta->IdCuentaPadre = $idPadre;
		// 		$idusuario = \Auth::user()->id;
		// 		//cuenta 1 Activo
		// 		$cuenta = new Cuentas();
	    //         $cuenta->Codigo = "1.0.0";
	    //         $cuenta->Nombre = "Activo";
	    //         $cuenta->Nivel  = 1;
	    //         $cuenta->TipoCuenta = 1;
	    //         $cuenta->IdUsuario = $idusuario;
	    //         $cuenta->IdEmpresa = $idem;
	    //         $cuenta->IdCuentaPadre = null;
	    //         $cuenta->save();
	    //         // cuenta 2 Pasivo
	    //         $cuenta = new Cuentas();
	    //         $cuenta->Codigo = "2.0.0";
	    //         $cuenta->Nombre = "Pasivo";
	    //         $cuenta->Nivel  = 1;
	    //         $cuenta->TipoCuenta = 1;
	    //         $cuenta->IdUsuario = $idusuario;
	    //         $cuenta->IdEmpresa = $idem;
	    //         $cuenta->IdCuentaPadre = null;
	    //         $cuenta->save();
		// 		// cuenta 3 Patrimonio
		// 		$cuenta = new Cuentas();
	    //         $cuenta->Codigo = "3.0.0";
	    //         $cuenta->Nombre = "Patrimonio";
	    //         $cuenta->Nivel  = 1;
	    //         $cuenta->TipoCuenta = 1;
	    //         $cuenta->IdUsuario = $idusuario;
	    //         $cuenta->IdEmpresa = $idem;
	    //         $cuenta->IdCuentaPadre = null;
	    //         $cuenta->save();
		// 		// cuenta 4 Ingreso
		// 		$cuenta = new Cuentas();
	    //         $cuenta->Codigo = "4.0.0";
	    //         $cuenta->Nombre = "Ingreso";
	    //         $cuenta->Nivel  = 1;
	    //         $cuenta->TipoCuenta = 1;
	    //         $cuenta->IdUsuario = $idusuario;
	    //         $cuenta->IdEmpresa = $idem;
	    //         $cuenta->IdCuentaPadre = null;
	    //         $cuenta->save();
		// 		// cuenta 5 Egreso
		// 		$cuentacinco = new Cuentas();
	    //         $cuentacinco->Codigo = "5.0.0";
	    //         $cuentacinco->Nombre = "Egreso";
	    //         $cuentacinco->Nivel  = 1;
	    //         $cuentacinco->TipoCuenta = 1;
	    //         $cuentacinco->IdUsuario = $idusuario;
	    //         $cuentacinco->IdEmpresa = $idem;
	    //         $cuentacinco->IdCuentaPadre = null;
	    //         $cuentacinco->save();
		// 		// cuenta 5.1 Costos
		// 		$cuenta = new Cuentas();
	    //         $cuenta->Codigo = "5.1.0";
	    //         $cuenta->Nombre = "Costos";
	    //         $cuenta->Nivel  = 2;
	    //         $cuenta->TipoCuenta = 1;
	    //         $cuenta->IdUsuario = $idusuario;
	    //         $cuenta->IdEmpresa = $idem;
	    //         $cuenta->IdCuentaPadre = $cuentacinco->id;
	    //         $cuenta->save();
		// 		// cuenta 5.2 Gastos
		// 		$cuenta = new Cuentas();
	    //         $cuenta->Codigo = "5.2.0";
	    //         $cuenta->Nombre = "Gastos";
	    //         $cuenta->Nivel  = 2;
	    //         $cuenta->TipoCuenta = 1;
	    //         $cuenta->IdUsuario = $idusuario;
	    //         $cuenta->IdEmpresa = $idem;
	    //         $cuenta->IdCuentaPadre = $cuentacinco->id;
	    //         $cuenta->save();

	    //         return "100";
		// 	}
		// 	catch(Exception $e){
		// 		return "-100";
		// 		//dd($e);
		// 	}
		// }

		public function AgregarRelacionMoneda($idem,$idmoneda){
			try{
				$idusuario = Auth::user()->id;
				$hoy = Carbon::now('America/La_Paz');
				// relacion moneda
				$moneda = new EmpresaMoneda();
	            $moneda->Activo = 1;
	            $moneda->FechaRegistro  = $hoy;
	            $moneda->IdEmpresa = $idem;
	            $moneda->IdMonedaPrincipal = $idmoneda;
	            $moneda->IdMonedaAlternativa = null;
	            $moneda->IdUsuario = $idusuario;
	            $moneda->save();

	            return "100";
			}
			catch(Throwable $e){
				return "-100";
				//dd($e);
			}
		}
	// agenda
	// 	public function lagendaadmin($idempresa){
	// 		try{
	// 			$empresa = Empresa::find($idempresa);
	//         	$EmpresaSigla = $empresa->Sigla;
	//         	$EmpresaNombre = $empresa->Nombre;
	// 			$access = self::verificacion(1);
	// 			if($access=="none"){
	// 				\Auth::logout();
	// 				$errors = [$this->username() => trans('auth.none')];
	// 				return redirect('/login')
	// 			            // ->withInput($request->only($this->username(), 'remember'))
	// 			            ->withErrors($errors);
	// 			}
	// 			if($access=="none1"){
	// 				$sinacceso = 'No tiene Permiso para acceder a esta funcion';
	// 				return redirect()->back()->with(compact('sinacceso'));
	// 			}
	// 			return view('Empresas.agenda',compact('idempresa','EmpresaSigla','EmpresaNombre','access'));

	// 		}catch(Exception $e){
	// 			return Redirect::back();
	// 		}
	// 	}

	// 	public function lagenda(){
	// 		try{
	// 			$empresa = Empresa::find($idempresa);
	//         	$EmpresaSigla = $empresa->Sigla;
	//         	$EmpresaNombre = $empresa->Nombre;
	// 			$access = self::verificacion();
	// 			if($access=="none"){
	// 				\Auth::logout();
	// 				$errors = [$this->username() => trans('auth.none')];
	// 				return redirect('/login')
	// 			            // ->withInput($request->only($this->username(), 'remember'))
	// 			            ->withErrors($errors);
	// 			}
	// 			return view('Empresas.agenda',compact('idempresa','EmpresaSigla','EmpresaNombre','access'));

	// 		}catch(Exception $e){
	// 			return Redirect::back();
	// 		}
	// 	}

	// 	public function TraerAgenda(Request $request){
	// 		try{
	// 			$empresa = Empresa::find($request->input('IdEmpresa'));
	// 			$contacto=0;
	// 			$representante=0;
	// 			if($empresa->idcontacto!=null){
	// 				$contacto = persona::find($empresa->idcontacto);
	// 			}
	// 			if($empresa->idrepresentante!=null){
	// 				$representante = persona::find($empresa->idrepresentante);
	// 			}
	// 			return response()->json([
	// 					'mensaje'			=> "Agenda guardada Exitosamente",
	// 					'titulo'			=> "Success",
	// 					'tipoMensaje'		=> "success",
	// 					'botonConfirmacion'	=> "ok",
	// 					'empresa'           => $empresa,
	// 					'contacto'          => $contacto,
	// 					'representante'     => $representante
	// 				]);
	// 		}catch(Exception $e){
	// 			return response()->json([
	// 				'mensaje'			=> "Error a intentar Guardar la Agenda",
	// 				'titulo'			=> "error",
	// 				'tipoMensaje'		=> "error",
	// 				'botonConfirmacion'	=> "ok"
	// 			]);
	// 		}
	// 	}

	// 	public function GuardarAgenda(Request $request){
	// 		try{
	// 			$idem = $request->input('idem');
	// 			$nomem = $request->input('nomem');
	// 			$nitem = $request->input('nitem');
	// 			$sigla = $request->input('sigla');
	// 			$telem = $request->input('telem');
	// 			$mailem = $request->input('mailem');
	// 			$direm = $request->input('direm');
	// 			$nomcom = $request->input('nomcom');
	// 			$apcom = $request->input('apcom');
	// 			$cicom = $request->input('cicom');
	// 			$nitcom = $request->input('nitcom');
	// 			$mailcom = $request->input('mailcom');
	// 			$telcom = $request->input('telcom');
	// 			$celcom = $request->input('celcom');
	// 			$dircom = $request->input('dircom');
	// 			$fnccom = $request->input('fnccom');
	// 			$nomrep = $request->input('nomrep');
	// 			$aprep = $request->input('aprep');
	// 			$cirep = $request->input('cirep');
	// 			$nitrep = $request->input('nitrep');
	// 			$mailrep = $request->input('mailrep');
	// 			$telrep = $request->input('telrep');
	// 			$celrep = $request->input('celrep');
	// 			$dirrep = $request->input('dirrep');
	// 			$fncrep = $request->input('fncrep');
	// 			$rdcon = $request->input('rdcon');
	// 			$rdrep = $request->input('rdrep');
	// 			//empresa
	// 				$empresa = Empresa::find($idem);
	// 				if(strtolower($empresa->Nombre)==strtolower($nomem)){
	// 	            }else{
	// 	            	$nombre = DB::table('empresa')
	// 	                            ->where(strtolower('empresa.Nombre'),strtolower($nomem))
	// 	                            ->first();
	// 	                if($nombre!=null){
	// 		            	return response()->json([
	// 							'mensaje'			=> "Ya existe una empresa con este nombre",
	// 							'titulo'			=> "Error",
	// 							'tipoMensaje'		=> "error",
	// 							'botonConfirmacion'	=> "ok"
	// 						]);
	// 		            }
	// 	            }
	// 	            if(strtolower($empresa->Nit)==strtolower($nitem)){
	// 	        	}
	// 	            else{
	// 	            	$nit = DB::table('empresa')
	// 	                            ->where(strtolower('empresa.Nit'),strtolower($nitem))
	// 	                            ->first();
	// 	                if($nit!=null){
	// 		            	return response()->json([
	// 							'mensaje'			=> "Ya existe una empresa con este nit",
	// 							'titulo'			=> "Error",
	// 							'tipoMensaje'		=> "error",
	// 							'botonConfirmacion'	=> "ok"
	// 						]);
	// 		            }
	// 	            }
	// 	            if(strtolower($empresa->Sigla)==strtolower($sigla)){
	// 	    	    }
	// 	    	    else{
	// 	    	    	$sigla = DB::table('empresa')
	// 	                            ->where(strtolower('empresa.Sigla'),strtolower($sigla))
	// 	                            ->first();
	// 					if($sigla!=null){
	// 						return response()->json([
	// 							'mensaje'			=> "Ya existe una empresa con esta sigla",
	// 							'titulo'			=> "Error",
	// 							'tipoMensaje'		=> "error",
	// 							'botonConfirmacion'	=> "ok"
	// 						]);
	// 					}
	// 	    	    }
	// 	    	    if(!empty($nomem)){
	// 	    	    	$empresa->Nombre=$nomem;
	// 	    	    }
	// 	    	    if(!empty($nitem)){
	// 	    	    	$empresa->Nit=$nitem;
	// 	    	    }
	// 	    	    if(!empty($sigla)){
	// 	    	    	$empresa->Sigla=$sigla;
	// 	    	    }
	// 	    	    if(!empty($telem)){
	// 	    	    	$empresa->Telefono=$telem;
	// 	    	    }
	// 	    	    if(!empty($mailem)){
	// 	    	    	$empresa->Correo=$mailem;
	// 	    	    }
	// 	    	    if(!empty($direm)){
	// 	    	    	$empresa->Direccion=$direm;
	// 	    	    }
	// 	    	//Contacto
	// 	    	    $contacto=0;
	// 	    	    if($rdcon=="editar"){
	// 	    	    	if(!empty($cicom)){
	// 	    	    		$persona = persona::find($empresa->idcontacto);
	// 	    	    		$compci=self::comprobardata($cicom,$nitcom,$mailcom,$persona->id);
	// 	    	    		if($compci!=100){
	// 	    	    			return response()->json([
	// 								'mensaje'			=> $compci,
	// 								'titulo'			=> "error",
	// 								'tipoMensaje'		=> "error",
	// 								'botonConfirmacion'	=> "ok"
	// 							]);
	// 	    	    		}else{
	// 	    	    			$contacto = self::actualizarpersona($persona->id,$nomcom,$apcom,$cicom,$nitcom,$mailcom,$telcom,$celcom,$dircom,$fnccom);
	// 	    	    		}
	// 	    	    	}
	// 	    	    }
	// 	    	    if($rdcon=="crear"){
	// 	    	    	if(!empty($cicom)){
	// 	    	    		$persona = DB::table('persona')
	// 	                            ->where('persona.ci',$cicom)
	// 	                            ->first();
	// 		                if($persona==null){
	// 		                	$compci=self::comprobardatacrear($cicom,$nitcom,$mailcom);
	// 		    	    		if($compci!=100){
	// 		    	    			return response()->json([
	// 									'mensaje'			=> $compci,
	// 									'titulo'			=> "error",
	// 									'tipoMensaje'		=> "error",
	// 									'botonConfirmacion'	=> "ok"
	// 								]);
	// 		    	    		}else{
	// 		    	    			$contacto = self::crearpersona($nomcom,$apcom,$cicom,$nitcom,$mailcom,$telcom,$celcom,$dircom,$fnccom);
	// 		    	    		}
	// 		                }else{
	// 		                	$compci=self::comprobardata($cicom,$nitcom,$mailcom,$persona->id);
	// 		    	    		if($compci!=100){
	// 		    	    			return response()->json([
	// 									'mensaje'			=> $compci,
	// 									'titulo'			=> "error",
	// 									'tipoMensaje'		=> "error",
	// 									'botonConfirmacion'	=> "ok"
	// 								]);
	// 		    	    		}else{
	// 		    	    			$contacto = self::actualizarpersona($persona->id,$nomcom,$apcom,$cicom,$nitcom,$mailcom,$telcom,$celcom,$dircom,$fnccom);
	// 		    	    		}
	// 		                }
	// 		                $empresa->idcontacto=$contacto;
	// 	    	    	}
	// 	    	    }
	// 	    	//Representante
	// 	    	    $representante=0;
	// 	    	    if($rdrep=="editar"){
	// 	    	    	if(!empty($cirep)){
	// 		    	    	$persona = persona::find($empresa->idrepresentante);
	// 	    	    		$compci=self::comprobardata($cirep,$nitrep,$mailrep,$persona->id);
	// 	    	    		if($compci!=100){
	// 	    	    			return response()->json([
	// 								'mensaje'			=> $compci,
	// 								'titulo'			=> "error",
	// 								'tipoMensaje'		=> "error",
	// 								'botonConfirmacion'	=> "ok"
	// 							]);
	// 	    	    		}else{
	// 	    	    			$representante = self::actualizarpersona($persona->id,$nomrep,$aprep,$cirep,$nitrep,$mailrep,$telrep,$celrep,$dirrep,$fncrep);
	// 	    	    		}
	// 		    	    }
	// 	    	    }
	// 	    	    if($rdrep=="crear"){
	// 	    	    	if(!empty($cirep)){
	// 		    	    	$persona = DB::table('persona')
	// 		                            ->where('persona.ci',$cirep)
	// 		                            ->first();
	// 		                if($persona==null){
	// 		                	$compci=self::comprobardatacrear($cirep,$nitrep,$mailrep);
	// 		    	    		if($compci!=100){
	// 		    	    			return response()->json([
	// 									'mensaje'			=> $compci,
	// 									'titulo'			=> "error",
	// 									'tipoMensaje'		=> "error",
	// 									'botonConfirmacion'	=> "ok"
	// 								]);
	// 		    	    		}else{
	// 		    	    			$representante = self::crearpersona($nomrep,$aprep,$cirep,$nitrep,$mailrep,$telrep,$celrep,$dirrep,$fncrep);
	// 		    	    		}
	// 		                }else{
	// 		                	$compci=self::comprobardata($cirep,$nitrep,$mailrep,$persona->id);
	// 		    	    		if($compci!=100){
	// 		    	    			return response()->json([
	// 									'mensaje'			=> $compci,
	// 									'titulo'			=> "error",
	// 									'tipoMensaje'		=> "error",
	// 									'botonConfirmacion'	=> "ok"
	// 								]);
	// 		    	    		}else{
	// 		    	    			$representante = self::actualizarpersona($persona->id,$nomrep,$aprep,$cirep,$nitrep,$mailrep,$telrep,$celrep,$dirrep,$fncrep);
	// 		    	    		}
	// 		                }
	// 		                $empresa->idrepresentante=$representante;
	// 		            }
	// 	    	    }
	// 	    	//enterprice
	// 	    	    $enterprice=0;
	// 	    	    if($empresa->identerprice!=null){
	// 	    	    	$enter = enterprise::find($empresa->identerprice);
	//     	    		$compenter=self::comprobardataenterprice($empresa->Nit,$empresa->Nombre,$empresa->Sigla,$enter->id);
	//     	    		if($compenter!=100){
	//     	    			return response()->json([
	// 							'mensaje'			=> $compenter,
	// 							'titulo'			=> "error",
	// 							'tipoMensaje'		=> "error",
	// 							'botonConfirmacion'	=> "ok"
	// 						]);
	//     	    		}else{
	//     	    			$cont = 0;
	//     	    			if($empresa->idcontacto!=null){
	//     	    				$cont = $empresa->idcontacto;
	//     	    			}
	//     	    			$enterprice = self::actualizarenterprice($enter->id,$empresa->Nombre,$empresa->Nit,$empresa->Sigla,$empresa->Correo,$empresa->Telefono,$empresa->Direccion,$cont);
	//     	    		}
	// 	    	    }else{
	// 	    	    	$enter = DB::table('enterprise')
	// 	                            ->where('enterprise.Nit',$empresa->Nit)
	// 	                            ->first();
	// 	                if($enter==null){
	// 	                	$compenter=self::comprobardatacrearenterprice($empresa->Nit,$empresa->Nombre,$empresa->Sigla);
	// 	    	    		if($compenter!=100){
	// 	    	    			return response()->json([
	// 								'mensaje'			=> $compenter,
	// 								'titulo'			=> "error",
	// 								'tipoMensaje'		=> "error",
	// 								'botonConfirmacion'	=> "ok"
	// 							]);
	// 	    	    		}else{
	// 	    	    			$cont = 0;
	// 	    	    			if($empresa->idcontacto!=null){
	// 	    	    				$cont = $empresa->idcontacto;
	// 	    	    			}
	// 	    	    			$enterprice = self::crearenterprise($empresa->Nombre,$empresa->Nit,$empresa->Sigla,$empresa->Correo,$empresa->Telefono,$empresa->Direccion,$cont);
	// 	    	    		}
	// 	                }else{
	// 	                	$compenter=self::comprobardataenterprice($empresa->Nit,$empresa->Nombre,$empresa->Sigla,$enter->id);
	// 	    	    		if($compenter!=100){
	// 	    	    			return response()->json([
	// 								'mensaje'			=> $compenter,
	// 								'titulo'			=> "error",
	// 								'tipoMensaje'		=> "error",
	// 								'botonConfirmacion'	=> "ok"
	// 							]);
	// 	    	    		}else{
	// 	    	    			$cont = 0;
	// 	    	    			if($empresa->idcontacto!=null){
	// 	    	    				$cont = $empresa->idcontacto;
	// 	    	    			}
	// 	    	    			$enterprice = self::actualizarenterprice($enter->id,$empresa->Nombre,$empresa->Nit,$empresa->Sigla,$empresa->Correo,$empresa->Telefono,$empresa->Direccion,$cont);
	// 	    	    		}
	// 	                }
	// 	                $empresa->identerprice=$enterprice;
	// 	    	    }
	// 	    	//casa matriz
	// 	    	    $matriz=0;
	// 	    	    if(empty($direm)){
	// 	    	    	return response()->json([
	// 						'mensaje'			=> "Es necesaria la direccion para configurar la casa matriz",
	// 						'titulo'			=> "error",
	// 						'tipoMensaje'		=> "error",
	// 						'botonConfirmacion'	=> "ok"
	// 					]);
	// 	    	    }
	// 	    	    if(empty($telem)){
	// 	    	    	return response()->json([
	// 						'mensaje'			=> "Es necesario el telefono para configurar la casa matriz",
	// 						'titulo'			=> "error",
	// 						'tipoMensaje'		=> "error",
	// 						'botonConfirmacion'	=> "ok"
	// 					]);
	// 	    	    }
	// 	    	    if(empty($mailem)){
	// 	    	    	return response()->json([
	// 						'mensaje'			=> "Es necesaria el mail para configurar la casa matriz",
	// 						'titulo'			=> "error",
	// 						'tipoMensaje'		=> "error",
	// 						'botonConfirmacion'	=> "ok"
	// 					]);
	// 	    	    }
	// 	    	    if($empresa->idcasamatriz==null){
	// 	    	    	$matriz = self::crearsucursal("Casa Matriz",$direm,$telem,$mailem,0,$empresa->id,$contacto);
	// 	    	    }else{
	// 	    	    	$matriz = self::actualizarsucursal($empresa->idcasamatriz,"",$direm,$telem,$mailem,0,$empresa->id,$contacto);
	// 	    	    }
	// 	    	$empresa->idcasamatriz=$matriz;
	// 	    	$empresa->save();
	// 			if($contacto!=0){
	// 				$contacto = persona::find($contacto);
	// 			}

	// 			if($representante!=0){
	// 				$representante = persona::find($representante);
	// 			}

	// 			return response()->json([
	// 					'mensaje'			=> "Agenda guardada Exitosamente",
	// 					'titulo'			=> "Success",
	// 					'tipoMensaje'		=> "success",
	// 					'botonConfirmacion'	=> "ok",
	// 					'empresa'           => $empresa,
	// 					'contacto'          => $contacto,
	// 					'representante'     => $representante
	// 				]);
	// 		}catch(Exception $e){
	// 			return response()->json([
	// 				'mensaje'			=> "Error a intentar Guardar la Agenda",
	// 				'titulo'			=> "error",
	// 				'tipoMensaje'		=> "error",
	// 				'botonConfirmacion'	=> "ok"
	// 			]);
	// 		}
	// 	}
	// // sector-economico
	// 	public function lsectoreconomico($idempresa){
	// 		try{
	// 			$empresa = Empresa::find($idempresa);
	//         	$EmpresaSigla = $empresa->Sigla;
	//         	$EmpresaNombre = $empresa->Nombre;
	//         	$idusuario = \Auth::user()->id;
	//         	$access = self::verificacion(2);
	//         	$hoy = Carbon::now('America/La_Paz');
	//         	$year = $hoy->format('Y');
	//         	$sector = 0;
	//         	$fi = 0;
	//         	$membresia = $membresia = DB::table('membresia')
	// 					                      ->where([['membresia.estado','1'],['membresia.idempresa',$empresa->id]])
	// 					                      ->first();
	//         	if($membresia!=null){
	//         		$fi = $membresia->fechainicio;
	//         	}
	//         	if($empresa->idsector!=null){
	//         		$sector = sector_economico::find($empresa->idsector)->mescierre;
	//         	}
	// 			if($access=="none"){
	// 				\Auth::logout();
	// 				$errors = [$this->username() => trans('auth.none')];
	// 				return redirect('/login')
	// 			            ->withErrors($errors);
	// 			}
	// 			if($access=="none1"){
	// 				$sinacceso = 'No tiene Permiso para acceder a esta funcion';
	// 				return redirect()->back()->with(compact('sinacceso'));
	// 			}
	// 			$access="total";
	// 			return view('Empresas.sector_economico',compact('idempresa','EmpresaSigla','idusuario','EmpresaNombre','access','sector','fi','year'));

	// 		}catch(Exception $e){
	// 			return response()->json([
	// 				'mensaje'			=> $e,
	// 				'titulo'			=> "error",
	// 				'tipoMensaje'		=> "error",
	// 				'botonConfirmacion'	=> "ok"
	// 			]);
	// 		}
	// 	}
	// 	public function listarsectores(Request $request){
	// 		try{
	//             $empresa = Empresa::find($request->input('IdEmpresa'));
	//             $mcierre = $request->input('mcierre');
	//             $hoy = Carbon::now('America/La_Paz');
	//             $Month = $hoy->format('m');
	//         	$fi = $hoy->format('d-m-Y');
	//         	$fi = explode("-", $fi);
	//         	$fi[0] = 1;
	//         	$fi[1] = $mcierre;
	//         	$fi = implode("-", $fi);
	//         	if($mcierre==12){
	//         		$fi = Carbon::parse($fi)->subYear()->addMonth()->startOfMonth();
	//         	}else{
	//         		$fi = Carbon::parse($fi)->addMonth()->startOfMonth();
	//         		if($mcierre<10){
	//         			$mcierre = "0" . $mcierre;
	//         		}
	//         	}
	//         	if($Month>$mcierre){
	//         		$fi = Carbon::parse($fi)->format('d-m-Y');
	//         		$ff = Carbon::parse($fi)->addYear()->subMonth()->endOfMonth()->format('d-m-Y');
	//         	}else{
	//         		if($mcierre!=12){
	//         			$ff = Carbon::parse($fi)->subMonth()->endOfMonth()->format('d-m-Y');
	//         			$fi = Carbon::parse($fi)->subYear()->format('d-m-Y');
	//         		}else{
	//         			$ff = Carbon::parse($fi)->subMonth()->addYear()->endOfMonth()->format('d-m-Y');
	//         			$fi = Carbon::parse($fi)->format('d-m-Y');
	//         		}
	//         	}
	// 			$Sectores = DB::table('sector_economico')
	// 		                      ->where([
	// 		                      		['sector_economico.estado','0'],
	// 		                      		['sector_economico.mescierre',$mcierre]
	// 		                      	])
	// 		                      ->get();
	//             //return $empresas;
	//             return response()->json([
	// 					'mensaje'			=> "Listado de Empresas Exitoso",
	// 					'titulo'			=> "Success",
	// 					'tipoMensaje'		=> "success",
	// 					'botonConfirmacion'	=> "ok",
	// 					'Empresa'           => $empresa,
	// 					'Sectores'          => $Sectores,
	// 					'fi'                => $fi,
	// 					'ff'                => $ff
	// 				]);
	// 		}catch(Exception $e){
	// 			return response()->json([
	// 				'mensaje'			=> $e,
	// 				'titulo'			=> "error",
	// 				'tipoMensaje'		=> "error",
	// 				'botonConfirmacion'	=> "ok"
	// 			]);
	// 		}
	// 	}
	// 	public function guardarsector(Request $request){
	// 		try{
	// 			$empresa = Empresa::find($request->input('IdEmpresa'));
	// 			$empresa->idsector = $request->input('rd');
	// 			$empresa->save();
	// 			return response()->json([
	// 					'mensaje'			=> "Sector guardado Exitosamente",
	// 					'titulo'			=> "Success",
	// 					'tipoMensaje'		=> "success",
	// 					'botonConfirmacion'	=> "ok"
	// 				]);
	// 		}catch(Exception $e){
	// 			return response()->json([
	// 				'mensaje'			=> "Error a intentar Guardar la Agenda",
	// 				'titulo'			=> "error",
	// 				'tipoMensaje'		=> "error",
	// 				'botonConfirmacion'	=> "ok"
	// 			]);
	// 		}
	// 	}
	// // definicion Atributos
	// 	public function listadeatributos(Request $request){
	// 		try{
	// 			$definiciones = DB::table('definicionatributo')
	// 							 ->join('atributos','atributos.id','definicionatributo.idatributo')
	//                              ->where([['definicionatributo.IdEmpresa',$request->input('IdEmpresa')],
	//                              	['atributos.estado',0]])
	//                              ->select('definicionatributo.id','definicionatributo.definicion','definicionatributo.estado','atributos.id as idattr','atributos.atributo')
	//                              ->get();

	//             return response()->json([
	// 					'mensaje'			=> "Listado de Definiciones Exitoso",
	// 					'titulo'			=> "Success",
	// 					'tipoMensaje'		=> "success",
	// 					'botonConfirmacion'	=> "ok",
	// 					'Definiciones'      => $definiciones

	// 				]);
	// 		}catch(Exception $e){
	// 			return response()->json([
	// 				'mensaje'			=> $e,
	// 				'titulo'			=> "error",
	// 				'tipoMensaje'		=> "error",
	// 				'botonConfirmacion'	=> "ok"
	// 			]);
	// 		}
	// 	}

	// 	public function TraerAtributo(Request $request){
	// 		try{
	//             $definicion=DB::table('definicionatributo')
	//                         ->where('definicionatributo.id', $request->input('IdDefinicion'))
	//                         ->first();

	// 			return response()->json([
	// 				'mensaje'			=> "Traer Definicion Exitoso",
	// 				'titulo'			=> "Success",
	// 				'tipoMensaje'		=> "success",
	// 				'botonConfirmacion'	=> "ok",
	// 				'Definicion'           => $definicion
	// 			]);

	// 		}
	// 		catch(Exception $e){
	// 			return response()->json([
	// 				'mensaje'			=> $e,
	// 				'titulo'			=> "error",
	// 				'tipoMensaje'		=> "error",
	// 				'botonConfirmacion'	=> "ok"
	// 			]);
	// 		}
	// 	}

	//     public function latributos($idempresa){
	//     	try{
	//     		$empresa=Empresa::find($idempresa);
	//     		$EmpresaNombre = $empresa->Nombre;
	//     		$EmpresaSigla = $empresa->Sigla;
	//     		$atributos = atributos::where("estado",0)->get();
	// 			$idusuario = \Auth::user()->id;
	// 			$access = self::verificacion(2);
	// 			if($access=="none"){
	// 				\Auth::logout();
	// 				$errors = [$this->username() => trans('auth.none')];
	// 				return redirect('/login')
	// 			            // ->withInput($request->only($this->username(), 'remember'))
	// 			            ->withErrors($errors);
	// 			}
	//              return view('CRM.definicionatributos',compact('atributos','idempresa','EmpresaNombre','EmpresaSigla','access'));
	//     	}
	//     	catch(Exception $e){
	//            return $e;
	//     	}
	//     }

	//     public function GuardarAtributo(Request $request){
	// 		try{
	// 			$idusuario = \Auth::user()->id;

	// 			$definicionatributo = new definicionatributos();
	// 			$definicionatributo->idatributo	  = $request->input('Atributo');
	// 			$definicionatributo->definicion	  = $request->input('Definicion');
	// 			$definicionatributo->estado	      = 0;
	// 			$definicionatributo->idempresa	  = $request->input('idem');

	// 			$guardado = $definicionatributo->save();

	// 			$definicion = DB::table('definicionatributo')
	// 							 ->join('atributos','atributos.id','definicionatributo.idatributo')
	//                              ->where([['definicionatributo.id',$definicionatributo->id],
	//                              	['atributos.estado',0]])
	//                              ->select('definicionatributo.id','definicionatributo.definicion','definicionatributo.estado','atributos.id as idattr','atributos.atributo')
	//                              ->first();

	// 			if($guardado){
	// 				return response()->json([
	// 					'mensaje'			=> "Definicion Creada Correctamente",
	// 					'titulo'			=> "Success",
	// 					'tipoMensaje'		=> "success",
	// 					'botonConfirmacion'	=> "ok",
	// 					'Definicion'        => $definicion
	// 				]);
	// 			}

	// 		}
	// 		catch(Exception $e){
	// 			return response()->json([
	// 				'mensaje'			=> $e,
	// 				'titulo'			=> "error",
	// 				'tipoMensaje'		=> "error",
	// 				'botonConfirmacion'	=> "ok"
	// 			]);
	// 		}
	// 	}

	// 	public function EditarAtributo(Request $request){
	// 		try{
	// 			$idusuario = \Auth::user()->id;
	// 			$definicion = definicionatributos::find($request->input('IdDefinicion'));
	// 			$definicion->idatributo	  = $request->input('Atributo');
	// 			$definicion->definicion	  = $request->input('Definicion');
	// 			$definicion->idempresa	  = $request->input('idem');

	// 			$guardado = $definicion->save();

	// 			$definicion = DB::table('definicionatributo')
	// 							 ->join('atributos','atributos.id','definicionatributo.idatributo')
	//                              ->where([['definicionatributo.id',$definicion->id],
	//                              	['atributos.estado',0]])
	//                              ->select('definicionatributo.id','definicionatributo.definicion','definicionatributo.estado','atributos.id as idattr','atributos.atributo')
	//                              ->first();

	// 			if($guardado){
	// 				return response()->json([
	// 					'mensaje'			=> "Definicion Actualizada Correctamente",
	// 					'titulo'			=> "Success",
	// 					'tipoMensaje'		=> "success",
	// 					'botonConfirmacion'	=> "ok",
	// 					'Definicion'           => $definicion
	// 				]);
	// 			}

	// 		}
	// 		catch(Exception $e){
	// 			return response()->json([
	// 				'mensaje'			=> $e,
	// 				'titulo'			=> "error",
	// 				'tipoMensaje'		=> "error",
	// 				'botonConfirmacion'	=> "ok"
	// 			]);
	// 		}
	// 	}

	// 	public function EliminarAtributo(Request $request){
	// 		try{
	// 			$definicion=definicionatributos::find($request->input('IdDefinicion'));
	// 			$definicion->estado=1;
	// 			$definicion->save();
	// 			return response()->json([
	// 				'mensaje'			=> "Definicion eliminada Exitosamente",
	// 				'titulo'			=> "Success",
	// 				'tipoMensaje'		=> "success",
	// 				'botonConfirmacion'	=> "ok",
	// 				'IdDefinicion'      => $definicion->id
	// 			]);

	// 		}
	// 		catch(Exception $e){
	// 			//dd($e);
	// 			return response()->json([
	// 				'mensaje'			=> "Error a intentar eliminar la Definicion",
	// 				'titulo'			=> "error",
	// 				'tipoMensaje'		=> "error",
	// 				'botonConfirmacion'	=> "ok"
	// 			]);
	// 		}
	// 	}

	// 	public function listattrtree(Request $request){
	// 		$atributos = DB::table('atributos')
	// 						->where('atributos.estado',0)
	//                         ->get();
	//         $idem = $request->input('idem');
	//         $cliente = clientes::where("idempresa",$idem)->get();
	//         if(count($cliente)==0){
	//         	return response()->json([
	// 				'mensaje'			=> "es Necesario tener al menos un cliente Configurado",
	// 				'titulo'			=> "error",
	// 				'tipoMensaje'		=> "error",
	// 				'botonConfirmacion'	=> "ok"
	// 			]);
	//         }
    //         self::guardardefinicionatributosgrupo($cliente[0]->id,1,$idem);
	// 		$definicionatributos='<ul>';
	// 	    foreach ($atributos as $a) {
	// 	    	$childs = DB::table('definicionatributo')
	//         				  ->join('atributos', 'atributos.id','definicionatributo.idatributo')
	// 	                      ->where([['definicionatributo.idempresa', $idem],
	// 	                      		   ['definicionatributo.estado', 0],
	// 	                      		   ["atributos.id",$a->id]])
	// 	                      ->select('definicionatributo.id','definicionatributo.definicion','atributos.id as attrid','atributos.atributo')
	// 	                      ->get();
	// 	    	if(count($childs) > 0){
	// 	    		$atributosgrupo = DB::table('atributosgrupo')
	// 	    							->where([['atributosgrupo.idcliente',$cliente[0]->id],
	// 	    									 ['atributosgrupo.estado',0]])
	// 	    							->get();
	// 	    		if(count($atributosgrupo)>0){
	// 	    			$definicionatributos .='<li id="a'.$a->id . '"  class="leaf"><a>' . $a->atributo . '</a>';
    //         			$definicionatributos .= self::childView($childs, $idem);
	// 	    		}else{
	// 	    			$definicionatributos .='<li id="a'.$a->id . '"  class="leaf disjstree"><a class="disjstree">' . $a->atributo;
    //         			$definicionatributos .= self::childView($childs, $idem);
	// 	    		}
    //         	}else{
    //         		$definicionatributos .='<li id="a'.$a->id . '"  class="leaf disjstree"><a class="disjstree">' . $a->atributo;
    //         		$definicionatributos .='</a></li>';
    //         	}
	// 	    }
	// 	    $definicionatributos .='</ul>';
	// 	    // dd($definicionatributos);
	// 	    return response()->json([
	// 			'mensaje'			=> "Usuario Encontrado Exitosamente",
	// 			'titulo'			=> "Success",
	// 			'tipoMensaje'		=> "success",
	// 			'botonConfirmacion'	=> "ok",
    //             'Defattr'           => $definicionatributos
	// 		]);
	// 	}

	// 	public function guardardefinicionatributosgrupo($idgrupo,$grupo,$idempresa){
	// 		try{
	// 			$defattr = DB::table('definicionatributo')
	// 								->where('idempresa',$idempresa)
	// 								->get();
	// 			//cliente
	// 				if($grupo==1){
	// 					foreach ($defattr as &$a) {
	// 						$relacion = DB::table('atributosgrupo')
	// 									  ->where([
	// 									  		['atributosgrupo.idatributo', $a->id],
	// 				                            ['atributosgrupo.idcliente', $idgrupo]
	// 				                        ])
	// 				                      ->first();
	// 				        if($relacion==null){
	// 				        	$df=definicionatributos::find($a->id);
	// 				        	$newrel = new atributosgrupo();
	// 				        	$newrel->idatributo = $a->id;
	// 				        	$newrel->idcliente = $idgrupo;
	// 				        	if($df->estado==1){
	// 				        		$newrel->estado = 1;
	// 				        	}else{
	// 				        		$newrel->estado = 0;
	// 				        	}
	// 				        	$newrel->save();
	// 				        }
	// 					}
	// 				}
	// 			//Proveedor
	// 				if($grupo==2){
	// 					foreach ($defattr as &$a) {
	// 						$relacion = DB::table('atributosgrupo')
	// 									  ->where([
	// 									  		['atributosgrupo.idatributo', $a->id],
	// 				                            ['atributosgrupo.idproveedor', $idgrupo]
	// 				                        ])
	// 				                      ->first();
	// 				        if($relacion==null){
	// 				        	$df=definicionatributos::find($a->id);
	// 				        	$newrel = new atributosgrupo();
	// 				        	$newrel->idatributo = $a->id;
	// 				        	$newrel->idproveedor = $idgrupo;
	// 				        	if($df->estado==1){
	// 				        		$newrel->estado = 1;
	// 				        	}else{
	// 				        		$newrel->estado = 0;
	// 				        	}
	// 				        	$newrel->save();
	// 				        }
	// 					}
	// 				}
	// 			//Empleado
	// 				if($grupo==3){
	// 					foreach ($defattr as &$a) {
	// 						$relacion = DB::table('atributosgrupo')
	// 									  ->where([
	// 									  		['atributosgrupo.idatributo', $a->id],
	// 				                            ['atributosgrupo.idempleado', $idgrupo]
	// 				                        ])
	// 				                      ->first();
	// 				        if($relacion==null){
	// 				        	$df=definicionatributos::find($a->id);
	// 				        	$newrel = new atributosgrupo();
	// 				        	$newrel->idatributo = $a->id;
	// 				        	$newrel->idempleado = $idgrupo;
	// 				        	if($df->estado==1){
	// 				        		$newrel->estado = 1;
	// 				        	}else{
	// 				        		$newrel->estado = 0;
	// 				        	}
	// 				        	$newrel->save();
	// 				        }
	// 					}
	// 				}
	// 			//Persona
	// 				if($grupo==4){
	// 					foreach ($defattr as &$a) {
	// 						$relacion = DB::table('atributosgrupo')
	// 									  ->where([
	// 									  		['atributosgrupo.idatributo', $a->id],
	// 				                            ['atributosgrupo.idpersona', $idgrupo]
	// 				                        ])
	// 				                      ->first();
	// 				        if($relacion==null){
	// 				        	$df=definicionatributos::find($a->id);
	// 				        	$newrel = new atributosgrupo();
	// 				        	$newrel->idatributo = $a->id;
	// 				        	$newrel->idpersona = $idgrupo;
	// 				        	if($df->estado==1){
	// 				        		$newrel->estado = 1;
	// 				        	}else{
	// 				        		$newrel->estado = 0;
	// 				        	}
	// 				        	$newrel->save();
	// 				        }
	// 					}
	// 				}
	// 			//usuarios
	// 				if($grupo==5){
	// 					foreach ($defattr as &$a) {
	// 						$relacion = DB::table('atributosgrupo')
	// 									  ->where([
	// 									  		['atributosgrupo.idatributo', $a->id],
	// 				                            ['atributosgrupo.idusuario', $idgrupo]
	// 				                        ])
	// 				                      ->first();
	// 				        if($relacion==null){
	// 				        	$df=definicionatributos::find($a->id);
	// 				        	$newrel = new atributosgrupo();
	// 				        	$newrel->idatributo = $a->id;
	// 				        	$newrel->idusuario = $idgrupo;
	// 				        	if($df->estado==1){
	// 				        		$newrel->estado = 1;
	// 				        	}else{
	// 				        		$newrel->estado = 0;
	// 				        	}
	// 				        	$newrel->save();
	// 				        }
	// 					}
	// 				}

	// 			return 200;
	// 		}
	// 		catch(Exception $e){
	// 			return -200;
	// 		}
	// 	}

	// 	public function childView($childs,$idem){
	//         $html = '<ul>';
	//         $cliente = clientes::where("idempresa",$idem)->get();
	//         foreach ($childs as &$arr) {
    //             $atributogrupo = DB::table('atributosgrupo')
	//     							->where([['atributosgrupo.idcliente',$cliente[0]->id],
	//     									 ['atributosgrupo.idatributo',$arr->id]])
	//     							->first();
	//     		if($atributogrupo->estado==0){
    //     			$html .='<li id="t'. $arr->id . '"  class="leaf"><a class="jstree-clicked">' . $arr->definicion ;
	//         		$html .='</a>';
	//                 $html .="</li>";
	//     		}else{
	//     			$html .='<li id="t'. $arr->id . '"  class="leaf"><a>' . $arr->definicion ;
	//         		$html .='</a>';
	//                 $html .="</li>";
	//     		}
	//         }
	//         $html .="</ul></li>";
	//         return $html;
	//     }

	//     public function guardardetattrclientes(Request $request){
	//     	try{
	// 			$empresa = Empresa::find($request->input('idem'));
	// 			self::crerelatributocliente($empresa->id);
	// 			$vaciado = self::vaciaratributoscliente($empresa->id);
	// 			$seleccion = $request->input('seleccion');
	// 			if($seleccion!=""){
	// 				$seleccionados = explode(",", $seleccion);
	// 				$atributoscliente = DB::table('atributosgrupo')
	// 									->join('clientes','clientes.id','atributosgrupo.idcliente')
	// 								    ->where([['clientes.idempresa', $empresa->id],
	// 			                      		   	 ['atributosgrupo.idcliente',"!=",null]])
	// 								    ->select('atributosgrupo.id')
	// 			                        ->get();
	// 			    foreach ($atributoscliente as &$a) {
	// 			    	foreach ($seleccionados as &$s) {
	// 						$rel = DB::table('atributosgrupo')
	// 								    ->where([['atributosgrupo.id', $a->id],
	// 			                      		   	 ['atributosgrupo.idatributo',$s]])
	// 								    ->select('atributosgrupo.id')
	// 			                        ->first();
	// 			            if($rel!=null){
	// 			            	$rel = atributosgrupo::find($rel->id);
	// 			            	$rel->estado = 0;
	// 			        		$rel->save();
	// 			            }
	// 					}
	// 			    }
	// 			}

	// 			return response()->json([
	//                 'mensaje'           => "Guardado exitosamente",
	//                 'titulo'            => "Success",
	//                 'tipoMensaje'       => "success",
	//                 'botonConfirmacion' => "ok"
	//             ]);
	// 		}
	// 		catch(Exception $e){
	// 			return response()->json([
	// 				'mensaje'			=> $e,
	// 				'titulo'			=> "error",
	// 				'tipoMensaje'		=> "error",
	// 				'botonConfirmacion'	=> "ok"
	// 			]);
	// 		}
	//     }

	//     public function vaciaratributoscliente($idempresa){
	// 		try{
	// 			$atributoscliente = DB::table('atributosgrupo')
	// 									->join('clientes','clientes.id','atributosgrupo.idcliente')
	// 								    ->where([['clientes.idempresa', $idempresa],
	// 			                      		   	 ['atributosgrupo.idcliente',"!=",null]])
	// 								    ->select('atributosgrupo.id')
	// 			                        ->get();
	// 			foreach ($atributoscliente as &$a) {
	// 	        	$rel = atributosgrupo::find($a->id);
	// 	        	$rel->estado = 1;
	// 	        	$rel->save();
	// 			}
	// 			return 200;
	// 		}
	// 		catch(Exception $e){
	// 			return -200;
	// 		}
	// 	}

	// 	public function crerelatributocliente($idempresa){
	// 		try{
	// 			$clientes = DB::table('clientes')
	// 						    ->where('clientes.idempresa', $idempresa)
	// 	                        ->get();
	// 			$defattr = DB::table('definicionatributo')
	// 							->where('idempresa',$idempresa)
	// 							->get();
	// 			foreach ($clientes as &$c) {
	// 				foreach ($defattr as &$a) {
	// 					$relacion = DB::table('atributosgrupo')
	// 								  ->where([
	// 								  		['atributosgrupo.idatributo', $a->id],
	// 			                            ['atributosgrupo.idcliente', $c->id]
	// 			                        ])
	// 			                      ->first();
	// 			        if($relacion==null){
	// 			        	$newrel = new atributosgrupo();
	// 			        	$newrel->idatributo = $a->id;
	// 			        	$newrel->idcliente = $c->id;
	// 			        	$newrel->estado = 0;
	// 			        	$newrel->save();
	// 			        }
	// 				}
	// 			}
	// 			return 200;
	// 		}
	// 		catch(Exception $e){
	// 			return -200;
	// 		}
	// 	}

	// 	public function reportedefAttr($idempresa){
	//       try{
	//         $user = \Auth::user()->nombre . " " . \Auth::user()->apellido;
	//         $hoy = Carbon::now('America/La_Paz')->format('d/m/Y');
	//         $atributos = DB::table('definicionatributo')
	// 							 ->join('atributos','atributos.id','definicionatributo.idatributo')
	//                              ->where([['definicionatributo.IdEmpresa',$idempresa],
	//                              	['atributos.estado',0]])
	//                              ->select('definicionatributo.id','definicionatributo.definicion','definicionatributo.estado','atributos.id as idattr','atributos.atributo')
	//                              ->get();
	//         foreach ($atributos as &$a) {
	//           if($a->estado == 1){
	//             $a->estado = "Deshabilitada";
	//           }else{
	//             if($a->estado == 0){
	//               $a->estado = "Habilitada";
	//             }
	//           }
	//         }
	//         $pdf = \PDF::loadView('CRM.reporteatributosdefinicion',compact("atributos","user","hoy"))
	//              ->setPaper('letter');
	//               return $pdf->stream();
	//       }
	//       catch(Exception $e){
	//               dd($e);
	//       }
	//     }

	//     public function downloadExceldefatributos(){
	//       $user = \Auth::user()->nombre . " " . \Auth::user()->apellido;
	//       $hoy = Carbon::now('America/La_Paz')->format('d/m/Y');
	//       $atributos = DB::table('atributos')
	//                           ->get();
	//       foreach ($atributos as &$a) {
	//         if($a->estado == 1){
	//           $a->estado = "Deshabilitada";
	//         }else{
	//           if($a->estado == 0){
	//             $a->estado = "Habilitada";
	//           }
	//         }
	//       }
	//       ob_end_clean();
	//       ob_start();
	//       Excel::create('Atributos', function($excel) use ($atributos,$user,$hoy){
	//          $excel->sheet('Atributos', function($sheet) use ($atributos,$user,$hoy){
	//              $sheet->loadView('CRM.reporteexcelatributosdefinicion',compact("atributos","user","hoy"));
	//            });
	//       })->export('xlsx');
	//     }

	// // persona
	// 	public function crearpersona($nombres,$apellidos,$ci,$nit,$email,$tel,$cel,$dir,$fnc){
	// 		try{
	// 			$persona = new persona();
	// 			$persona->ci=$ci;
	// 			if(!empty($nit)){
	// 				$persona->nit=$nit;
	// 			}
	// 			if(!empty($nombres)){
	// 				$persona->nombres=$nombres;
	// 			}
	// 			if(!empty($apellidos)){
	// 				$persona->apellidos=$apellidos;
	// 			}
	// 			if(!empty($tel)){
	// 				$persona->telefono=$tel;
	// 			}
	// 			if(!empty($cel)){
	// 				$persona->celular=$cel;
	// 			}
	// 			if(!empty($dir)){
	// 				$persona->direccion=$dir;
	// 			}
	// 			if(!empty($email)){
	// 				$persona->email=$email;
	// 			}
	// 			if(!empty($fnc)){
	// 				$persona->fecha_de_nacimiento=$fnc;
	// 			}
	// 			$persona->save();
	// 			return $persona->id;
	// 		}catch(Exception $e){
	// 			return -100;
	// 		}
	// 	}
	// 	public function actualizarpersona($idpersona,$nombres,$apellidos,$ci,$nit,$email,$tel,$cel,$dir,$fnc){
	// 		try{
	// 			$persona = persona::find($idpersona);
	// 			$persona->ci=$ci;
	// 			if(!empty($nit)){
	// 				$persona->nit=$nit;
	// 			}
	// 			if(!empty($nombres)){
	// 				$persona->nombres=$nombres;
	// 			}
	// 			if(!empty($apellidos)){
	// 				$persona->apellidos=$apellidos;
	// 			}
	// 			if(!empty($tel)){
	// 				$persona->telefono=$tel;
	// 			}
	// 			if(!empty($cel)){
	// 				$persona->celular=$cel;
	// 			}
	// 			if(!empty($dir)){
	// 				$persona->direccion=$dir;
	// 			}
	// 			if(!empty($email)){
	// 				$persona->email=$email;
	// 			}
	// 			if(!empty($fnc)){
	// 				$persona->fecha_de_nacimiento=$fnc;
	// 			}
	// 			$persona->save();
	// 			return $persona->id;
	// 		}catch(Exception $e){
	// 			return -100;
	// 		}
	// 	}
	// 	public function comprobardatacrear($ci=0,$nit=0,$email=0){
	// 		try
	// 		{
	// 			$personas = DB::table('persona')
    //                         	->get();
    //             foreach ($personas as &$p) {
    //             	if(!empty($ci)){
	// 					if($p->ci==$ci){
	//             			return "Este CI ya esta registrado";
	//             		}
	// 				}
    //         		if(!empty($nit)){
	//             		if($p->nit==$nit){
	//             			return "Este NIT ya esta registrado";
	//             		}
	//             	}
	//             	if(!empty($email)){
	//             		if($p->email==$email){
	//             			return "Este email ya esta registrado";
	//             		}
	//             	}
    //             }
    //             return 100;
	// 		}catch(Exception $e){
	// 			return -100;
	// 		}
	// 	}
	// 	public function comprobardata($ci=0,$nit=0,$email=0,$idpersona){
	// 		try
	// 		{
	// 			$personas = DB::table('persona')
    //                         	->get();
    //             foreach ($personas as &$p) {
    //             	if($p->id!=$idpersona){
    //             		if(!empty($ci)){
	//                 		if($p->ci==$ci){
	//                 			return "Este CI ya esta registrado";
	//                 		}
	//                 	}
	//                 	if(!empty($nit)){
	//                 		if($p->nit==$nit){
	//                 			return "Este NIT ya esta registrado";
	//                 		}
	//                 	}
	//                 	if(!empty($email)){
	//                 		if($p->email==$email){
	//                 			return "Este email ya esta registrado";
	//                 		}
	//                 	}
    //             	}
    //             }
    //             return 100;
	// 		}catch(Exception $e){
	// 			return -100;
	// 		}
	// 	}
	// // enterprice
	// 	public function crearenterprise($nombre,$nit,$sigla,$correo,$telefono,$direccion,$contacto=0){
	// 		try{
	// 			$enterprice = new enterprise();
	// 			$enterprice->nit=$nit;
	// 			$enterprice->nombre=$nombre;
	// 			$enterprice->sigla=$sigla;
	// 			if(!empty($correo)){
	// 				$enterprice->correo=$correo;
	// 			}
	// 			if(!empty($telefono)){
	// 				$enterprice->telefono=$telefono;
	// 			}
	// 			if(!empty($direccion)){
	// 				$enterprice->direccion=$direccion;
	// 			}
	// 			if(!empty($contacto)){
	// 				if($contacto!=0){
	// 					$enterprice->idcontacto=$contacto;
	// 				}
	// 			}
	// 			$enterprice->save();
	// 			return $enterprice->id;
	// 		}catch(Exception $e){
	// 			return -100;
	// 		}
	// 	}
	// 	public function actualizarenterprice($identerprice,$nombre,$nit,$sigla,$correo,$telefono,$direccion,$contacto=0){
	// 		try{
	// 			$enterprice = enterprise::find($identerprice);
	// 			$enterprice->nit=$nit;
	// 			$enterprice->nombre=$nombre;
	// 			$enterprice->sigla=$sigla;
	// 			if(!empty($correo)){
	// 				$enterprice->correo=$correo;
	// 			}
	// 			if(!empty($telefono)){
	// 				$enterprice->telefono=$telefono;
	// 			}
	// 			if(!empty($direccion)){
	// 				$enterprice->direccion=$direccion;
	// 			}
	// 			if(!empty($contacto)){
	// 				if($contacto!=0){
	// 					$enterprice->idcontacto=$contacto;
	// 				}
	// 			}
	// 			$enterprice->save();
	// 			return $enterprice->id;
	// 		}catch(Exception $e){
	// 			return -100;
	// 		}
	// 	}
	// 	public function comprobardatacrearenterprice($nit=0,$nombre=0,$sigla=0){
	// 		try
	// 		{
	// 			$enterprices = DB::table('enterprise')
    //                         	->get();
    //             foreach ($enterprices as &$e) {
    //         		if($e->nit==$nit){
    //         			return "Este nit ya esta registrado";
    //         		}
    //         		if($e->nombre==$nombre){
    //         			return "Este nombre ya esta registrado";
    //         		}
    //         		if($e->sigla==$sigla){
    //         			return "Esta sigla ya esta registrada";
    //         		}
    //             }
    //             return 100;
	// 		}catch(Exception $e){
	// 			return -100;
	// 		}
	// 	}
	// 	public function comprobardataenterprice($nit=0,$nombre=0,$sigla=0,$identerprice){
	// 		try
	// 		{
	// 			$enterprices = DB::table('enterprise')
    //                         	->get();
    //             foreach ($enterprices as &$e) {
    //             	if($e->id!=$identerprice){
    //             		if($e->nit==$nit){
	//             			return "Este nit ya esta registrado";
	//             		}
	//             		if($e->nombre==$nombre){
	//             			return "Este nombre ya esta registrado";
	//             		}
	//             		if($e->sigla==$sigla){
	//             			return "Esta sigla ya esta registrada";
	//             		}
    //             	}
    //             }
    //             return 100;
	// 		}catch(Exception $e){
	// 			return -100;
	// 		}
	// 	}
	// // sucursal
	// 	public function crearsucursal($alias,$direccion,$telefono,$email,$estado,$empresa,$contacto=0){
	// 		try{
	// 			$sucursal = new sucursal();
	// 			$sucursal->direccion=$direccion;
	// 			$sucursal->alias=$alias;
	// 			$sucursal->estado=$estado;
	// 			$sucursal->idempresa=$empresa;
	// 			if(!empty($telefono)){
	// 				$sucursal->telefono=$telefono;
	// 			}
	// 			if(!empty($email)){
	// 				$sucursal->email=$email;
	// 			}
	// 			if(!empty($contacto)){
	// 				if($contacto!=0){
	// 					$sucursal->idcontacto=$contacto;
	// 				}
	// 			}
	// 			$sucursal->save();
	// 			return $sucursal->id;
	// 		}catch(Exception $e){
	// 			return -100;
	// 		}
	// 	}
	// 	public function actualizarsucursal($idsucursal,$alias,$direccion,$telefono,$email,$estado,$empresa,$contacto=0){
	// 		try{
	// 			$sucursal = sucursal::find($idsucursal);
	// 			$sucursal->direccion=$direccion;
	// 			$sucursal->estado=$estado;
	// 			$sucursal->idempresa=$empresa;
	// 			if(!empty($alias)){
	// 				$sucursal->alias=$alias;
	// 			}
	// 			if(!empty($telefono)){
	// 				$sucursal->telefono=$telefono;
	// 			}
	// 			if(!empty($email)){
	// 				$sucursal->email=$email;
	// 			}
	// 			if(!empty($contacto)){
	// 				if($contacto!=0){
	// 					$sucursal->idcontacto=$contacto;
	// 				}
	// 			}
	// 			$sucursal->save();
	// 			return $sucursal->id;
	// 		}catch(Exception $e){
	// 			return -100;
	// 		}
	// 	}
	// 	public function comprobardatacrearsucursal($alias=0,$direccion=0,$idempresa){
	// 		try
	// 		{
	// 			$sucursales = DB::table('sucursal')
	//                              ->where([['sucursal.idempresa',$idempresa],['sucursal.estado',0]])
	//                              ->get();
    //             foreach ($sucursales as &$s) {
    //         		if($s->alias==$alias){
    //         			return "Este alias ya esta registrado";
    //         		}
    //         		if($s->direccion==$direccion){
    //         			return "Esta direccion ya esta registrado";
    //         		}
    //             }
    //             return 100;
	// 		}catch(Exception $e){
	// 			return -100;
	// 		}
	// 	}
	// 	public function comprobardatasucursal($alias=0,$direccion=0,$idempresa,$idsucursal){
	// 		try
	// 		{
	// 			$sucursales = DB::table('sucursal')
	//                              ->where([['sucursal.idempresa',$idempresa],['sucursal.estado','0']])
	//                              ->get();
    //             foreach ($sucursales as &$s) {
    //             	if($s->id!=$idsucursal){
    //             		if($s->alias==$alias){
	//             			return "Este alias ya esta registrado";
	//             		}
	//             		if($s->direccion==$direccion){
	//             			return "Esta direccion ya esta registrado";
	//             		}
    //             	}
    //             }
    //             return 100;
	// 		}catch(Exception $e){
	// 			return -100;
	// 		}
	// 	}
	// // verificacion
	// 	public function verificacion($vista=0){
	//       try{
	//         $idempresa = \Auth::user()->idempresa;
	//         $TipoUsuario = \Auth::user()->TipoUsuario;
	//         $iduser = \Auth::user()->id;
	//         $hoy = Carbon::now('America/La_Paz');
	//         $res = "none";
	//         if($TipoUsuario==1){
	//           $res = "total";
	//         }else{
	//           $membresia = DB::table('membresia')
	//                       ->where([['membresia.idempresa',$idempresa],['membresia.estado',1]])
	//                       ->first();

	//           $date = DateTime::createFromFormat('y-m-d H:i:s',date('y-m-d H:i:s', strtotime($membresia->fechafin)));
	//           $fechafin=$hoy->diff($date)->format("%Y-%M-%D %H:%I:%S");
	//           if($hoy<$date){
	//             if($vista!=0){
	//               $vistausuario = DB::table('vistausuario')
	//                       ->where([['vistausuario.idusuario',$iduser],['vistausuario.idvista',$vista]])
	//                       ->first();
	//               if($vistausuario->estado==0){
	//               	$res="none1";
	//               }else{
	//           		  if($vistausuario->tipoacceso==1){
	// 	                $res="total";
	// 	              }
	// 	              if($vistausuario->tipoacceso==2){
	// 	                $res="parcial";
	// 	              }
	// 	              if($vistausuario->tipoacceso==3){
	// 	                $res="consulta";
	// 	              }
	//               }
	//             }else{
	//               $res="total";
	//             }
	//           }else{
	//             if($fechafin>'00-00-10 00:00:00'){
	//               $res="none";
	//             }else{
	//             	if($res!="none1"){
	//         			$res="consulta";
	//             	}
	//             }
	//           }
	//         }
	//         //dd($res);
	//         return $res;
	//       }catch(Exception $e){
	//         return "none";
	//       }
	//     }

	//     public function username() {
	//         return 'name';
	//     }
}
