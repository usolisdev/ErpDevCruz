<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empresa;
use App\Gestion;
use App\Periodo;
use App\Reporte;
use DB;
use DateTime;
use Carbon\Carbon;
use \Milon\Barcode\DNS2D;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class GestionController extends Controller
{
	public function listadegestiones(Request $request){
		try{
			$gestiones = DB::table('gestion')
                             ->where('gestion.IdEmpresa',$request->input('IdEmpresa'))
                             ->orderby('gestion.FechaInicio','DESC')
                             ->get();

            return response()->json([
					'mensaje'			=> "Listado de Gestiones Exitoso",
					'titulo'			=> "Success",
					'tipoMensaje'		=> "success",
					'botonConfirmacion'	=> "ok",
					'Gestiones'          => $gestiones

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

	public function TraerGestion(Request $request){
		try{
            $gestion=DB::table('gestion')
                        ->where('gestion.id',$request->input('IdGestion'))
                        ->first();

			return response()->json([
				'mensaje'			=> "Traer Gestion Exitoso",
				'titulo'			=> "Success",
				'tipoMensaje'		=> "success",
				'botonConfirmacion'	=> "ok",
				'Gestion'           => $gestion
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

    public function lgestion($idempresa1){
    	try{
    		$idempresa=$idempresa1;
    		$empresa=Empresa::find($idempresa);
    		$EmpresaNombre = $empresa->Nombre;
    		$EmpresaSigla = $empresa->Sigla;
    		$gestiones = DB::table('gestion')
                             ->where('gestion.IdEmpresa',$idempresa1)
                             ->orderby('gestion.FechaInicio','DESC')
                             ->get();

			$idusuario = \Auth::user()->id;
			$reporte = DB::table('reporte')
			                    ->where('reporte.Tipo','gestion')
			                    ->first();
			$reporte = Reporte::find($reporte->id);
			$reporte->Reporte_id = $idempresa;
			$reporte->IdUsuario = $idusuario; 
			$reporte->save();
			$access = self::verificacion(2);
			if($access=="none"){
				\Auth::logout();
				$errors = [$this->username() => trans('auth.none')];
				return redirect('/login')
			            // ->withInput($request->only($this->username(), 'remember'))
			            ->withErrors($errors);
			}
             return view('Gestiones.gestiones',compact('gestiones','idempresa','EmpresaNombre','EmpresaSigla','access'));
    	}
    	catch(Exception $e){
           return $e;
    	}
    }

    public function GuardarGestion(Request $request){
		try{
			$idusuario = \Auth::user()->id;
			$feci=$request->input('txtfecin');
            $fecf=$request->input('txtfecfin');
			$gestiones =  DB::table('gestion')
                            ->where('gestion.IdEmpresa', $request->input('idem'))
                            ->get();
            if($fecf<=$feci){
        		return response()->json([
					'mensaje'			=> "la fecha de fin no puede ser menor que la inicio",
					'titulo'			=> "Error",
					'tipoMensaje'		=> "error",
					'botonConfirmacion'	=> "ok"
				]);
        	}
        	foreach ($gestiones as &$g) {
            	if($g->Nombre==$request->input('NombreGestion')){
            		return response()->json([
						'mensaje'			=> "Ya existe una Gestion con este nombre",
						'titulo'			=> "Error",
						'tipoMensaje'		=> "error",
						'botonConfirmacion'	=> "ok"
					]);
            	}
            }

        	foreach ($gestiones as &$g) {
    			$fei1=$g->FechaInicio;
            	$fef1=$g->FechaFin;
            	if($feci>=$fei1){
            		if($feci<=$fef1){
	            		return response()->json([
							'mensaje'			=> "Solapamiento de fechas detectado",
							'titulo'			=> "Error",
							'tipoMensaje'		=> "error",
							'botonConfirmacion'	=> "ok"
						]);
	            	}
            	}
            }

        	foreach ($gestiones as &$g) {
    			$fei1=$g->FechaInicio;
            	$fef1=$g->FechaFin;
            	if($fecf>=$fei1){
            		if($fecf<=$fef1){
	            		return response()->json([
							'mensaje'			=> "Solapamiento de fechas detectado",
							'titulo'			=> "Error",
							'tipoMensaje'		=> "error",
							'botonConfirmacion'	=> "ok"
						]);
	            	}
            	}
            }
            $cantGes=0;
            foreach ($gestiones as &$g) {
    			if($g->Estado==1){
    				$cantGes = $cantGes + 1;
    			}
            }
            if($cantGes>=2){
            	return response()->json([
					'mensaje'			=> "Ya hay 2 Gestiones Abiertas",
					'titulo'			=> "Error",
					'tipoMensaje'		=> "error",
					'botonConfirmacion'	=> "ok"
				]);
            }

            
			$gestion = new Gestion;
			$gestion->Nombre		= $request->input('NombreGestion');
			$gestion->FechaInicio	= $request->input('txtfecin');
			$gestion->FechaFin	    = $request->input('txtfecfin');
			$gestion->Estado	    = 1;
			$gestion->IdUsuario	    = $idusuario;
			$gestion->IdEmpresa		= $request->input('idem');

			$guardado = $gestion->save();

			if($guardado){
				return response()->json([
					'mensaje'			=> "Gestion Creada Correctamente",
					'titulo'			=> "Success",
					'tipoMensaje'		=> "success",
					'botonConfirmacion'	=> "ok",
					'Gestion'           => $gestion
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

	public function EditarGestion(Request $request){
		try{
			$idusuario = \Auth::user()->id;
			$feci=$request->input('txtfecin');
            $fecf=$request->input('txtfecfin');
            $gestac=Gestion::find($request->input('IdGestion'));
            $gestiones =  DB::table('gestion')
                            ->where('gestion.IdEmpresa', $request->input('idem'))
                            ->get();
            if($gestac->Estado==0){
            	return response()->json([
					'mensaje'			=> "La Gestion No puede ser Editada, Ya que Esta Cerrada",
					'titulo'			=> "Error",
					'tipoMensaje'		=> "error",
					'botonConfirmacion'	=> "ok"
				]);
            }
            if($fecf<=$feci){
        		return response()->json([
					'mensaje'			=> "la fecha de fin no puede ser menor que la inicio",
					'titulo'			=> "Error",
					'tipoMensaje'		=> "error",
					'botonConfirmacion'	=> "ok"
				]);
        	}
        	foreach ($gestiones as &$g) {
            	if($g->id!=$gestac->id){
	            	if($g->Nombre==$gestac->Nombre){
	            		return response()->json([
							'mensaje'			=> "Ya existe una Gestion con este nombre",
							'titulo'			=> "Error",
							'tipoMensaje'		=> "error",
							'botonConfirmacion'	=> "ok"
						]);
	            	}
	            }
            }
            if($feci!=$gestac->FechaInicio){
            	foreach ($gestiones as &$g) {
            		if($g->id!=$gestac->id){
            			$fei1=$g->FechaInicio;
		            	$fef1=$g->FechaFin;
		            	if($feci>=$fei1){
		            		if($feci<=$fef1){
			            		return response()->json([
									'mensaje'			=> "Solapamiento de fechas detectado",
									'titulo'			=> "Error",
									'tipoMensaje'		=> "error",
									'botonConfirmacion'	=> "ok"
								]);
			            	}
		            	}
            		}
	            }
            }
            if($fecf!=$gestac->FechaFin){
            	foreach ($gestiones as &$g) {
            		if($g->id!=$gestac->id){
            			$fei1=$g->FechaInicio;
		            	$fef1=$g->FechaFin;
		            	if($fecf>=$fei1){
		            		if($fecf<=$fef1){
			            		return response()->json([
									'mensaje'			=> "Solapamiento de fechas detectado",
									'titulo'			=> "Error",
									'tipoMensaje'		=> "error",
									'botonConfirmacion'	=> "ok"
								]);
			            	}
		            	}
            		}
	            }
            }

			$gestac->Nombre		    = $request->input('NombreGestion');
			$gestac->FechaInicio	= $request->input('txtfecin');
			$gestac->FechaFin	    = $request->input('txtfecfin');
			$gestac->IdUsuario	    = $idusuario;
			$gestac->IdEmpresa		= $request->input('idem');

			$guardado = $gestac->save();

			if($guardado){
				return response()->json([
					'mensaje'			=> "Gestion Actualizada Correctamente",
					'titulo'			=> "Success",
					'tipoMensaje'		=> "success",
					'botonConfirmacion'	=> "ok",
					'Gestion'           => $gestac
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

	public function EliminarGestion(Request $request){
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
