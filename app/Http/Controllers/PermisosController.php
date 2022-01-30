<?php

namespace App\Http\Controllers;

use Excel;
use DateTime;
use App\vista;
use App\modulo;
use App\Empresa;
use App\Reporte;
use App\Usuario;
use App\membresia;
use Carbon\Carbon;
use App\vistausuario;
use App\moduloempresa;
use \Milon\Barcode\DNS2D;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Contracts\Encryption\DecryptException;
use Throwable;

class PermisosController extends Controller
{
	// modulos
		public function listarmodulos($idempresa){
			try{
				$empresa = Empresa::find($idempresa);
	        	$EmpresaSigla = $empresa->Sigla;
	        	$EmpresaNombre = $empresa->Nombre;
	        	$idusuario = \Auth::user()->id;
	        	$access = self::verificacion(2);
				if($access=="none"){
					\Auth::logout();
					$errors = [$this->username() => trans('auth.none')];
					return redirect('/login')
				            // ->withInput($request->only($this->username(), 'remember'))
				            ->withErrors($errors);
				}
				if($access=="none1"){
					$sinacceso = 'No tiene Permiso para acceder a esta funcion';
					return redirect()->back()->with(compact('sinacceso'));
				}
	            return view('Permisos.modulos',compact('idempresa','EmpresaSigla','idusuario','EmpresaNombre','access'));
			}catch(Exception $e){
				return response()->json([
					'mensaje'			=> $e,
					'titulo'			=> "error",
					'tipoMensaje'		=> "error",
					'botonConfirmacion'	=> "ok"
				]);
			}
		}

		public function traermodulos(Request $request){
			try{
				$empresa = Empresa::find($request->input('IdEmpresa'));
	        	$idusuario = \Auth::user()->id;
	        	$molde = self::guardarmodulos($empresa->id);
	        	$modulos =  DB::table('moduloempresa')
	        				  ->join('modulo', 'modulo.id','moduloempresa.idmodulo')
		                      ->where('moduloempresa.idempresa', $empresa->id)
		                      ->select('moduloempresa.id','modulo.modulo','moduloempresa.estado')
		                      ->get();
	            $tree='<ul>';
	            foreach ($modulos as $m) {
	            	if($m->estado==1){
	            		$tree .='<li id="'.$m->id . '"  class="leaf"><a class="jstree-clicked">' . $m->modulo . '</a>';
	            	}else{
	            		$tree .='<li id="'.$m->id . '"  class="leaf"><a>' . $m->modulo . '</a>';
	            	}
	            }
	            $tree .='</ul>';
	            return response()->json([
	                'mensaje'           => "Listado de Modulos Exitoso",
	                'titulo'            => "Success",
	                'tipoMensaje'       => "success",
	                'botonConfirmacion' => "ok",
	                "Modulos"           => $tree
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

		public function guardarmodulos($idempresa){
			try{
				$empresa = Empresa::find($idempresa);
				$modulos = DB::table('modulo')->get();
				foreach ($modulos as &$m) {
					$relacion = DB::table('moduloempresa')
								  ->where([
								  		['moduloempresa.idmodulo', $m->id],
			                            ['moduloempresa.idempresa', $empresa->id]
			                        ])
			                      ->first();
			        if($relacion==null){
			        	$newrel = new moduloempresa();
			        	$newrel->idempresa = $empresa->id;
			        	$newrel->idmodulo = $m->id;
			        	$newrel->estado = 0;
			        	$newrel->save();
			        }
				}
				return 200;
			}
			catch(Exception $e){
				return -200;
			}
		}

		public function vaciarmodulos($idempresa){
			try{
				$empresa = Empresa::find($idempresa);
				$modulos = DB::table('modulo')->get();
				foreach ($modulos as &$m) {
					$relacion = DB::table('moduloempresa')
								  ->where([
								  		['moduloempresa.idmodulo', $m->id],
			                            ['moduloempresa.idempresa', $empresa->id]
			                        ])
			                      ->first();
		        	$newrel = moduloempresa::find($relacion->id);
		        	$newrel->estado = 0;
		        	$newrel->save();
				}
				return 200;
			}
			catch(Exception $e){
				return -200;
			}
		}

		public function actualizarmodulos(Request $request){
			try{
				$empresa = Empresa::find($request->input('IdEmpresa'));
				$modulos = DB::table('modulo')->get();
				$vaciado = self::vaciarmodulos($empresa->id);
				$seleccionados = explode(",", $request->input('seleccion'));
				foreach ($seleccionados as &$s) {
					$relacion = moduloempresa::where('moduloempresa.id',$s)->first();
					$relacion->estado = 1;
					$relacion->save();
				}
				return response()->json([
	                'mensaje'           => "Guardado exitosamente",
	                'titulo'            => "Success",
	                'tipoMensaje'       => "success",
	                'botonConfirmacion' => "ok"
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
	// roles
		public function listarpermisos($idempresa=0){
			try{
				$empresas = DB::table('empresa')
	                      ->where('empresa.estado','0')
	                      ->get();
				$idusuario = Auth::user()->id;

				$tipous = DB::table('tipousuario')->get();
				$tipoac = DB::table('tipodeacceso')->get();
				$usuarios = DB::table('users')
							->where('users.estado','!=','0')
	                      	->get();
	            if($idempresa!=0){
	            	$empresa = Empresa::find($idempresa);
	        		$EmpresaSigla = $empresa->Sigla;
	        		$EmpresaNombre = $empresa->Nombre;
	        		$usuarios = DB::table('users')
							->where([['users.estado','!=','0'],['users.idempresa',$empresa->id]])
	                      	->get();
	        		$idusuario = Auth::user()->id;
	        		$access = self::verificacion(5);
					if($access=="none"){
						Auth::logout();
						$errors = [$this->username() => trans('auth.none')];
						return redirect('/login')
					            // ->withInput($request->only($this->username(), 'remember'))
					            ->withErrors($errors);
					}
					if($access=="none1"){
						$sinacceso = 'No tiene Permiso para acceder a esta funcion';
						return redirect()->back()->with(compact('sinacceso'));
					}
	            	return view('Permisos.roles',compact('idempresa','EmpresaSigla','idusuario','empresas','tipous','tipoac','idempresa','usuarios','EmpresaNombre','access'));
	            }else{
	            	$access="total";
	            	return view('Permisos.roles',compact('idempresa','usuarios','empresas','access'));
	            }
			}catch(Throwable $e){
				return response()->json([
					'mensaje'			=> $e,
					'titulo'			=> "error",
					'tipoMensaje'		=> "error",
					'botonConfirmacion'	=> "ok"
				]);
			}
		}

		public function traerpermisos(Request $request){
			try{
				$idusuario = Auth::user()->id;
	            $usuario=DB::table('users')
	                        ->where('users.id',$request->input('idusuario'))
	                        ->first();
	            $modulos = DB::table('modulo')
	            			->join('moduloempresa','moduloempresa.idmodulo','modulo.id')
	                        ->where('moduloempresa.idempresa',$usuario->idempresa)
	                        ->get();
	            //permisos
		        	$view = self::guardarvistausuario($usuario->id);
		        	$modulo1='<ul>';
		        	$modulo2='<ul>';
		        	$modulo3='<ul>';
		        	$modulo4='<ul>';
		        	$modulo5='<ul>';
		        	$modulo6='<ul>';
		        	$modulo7='<ul>';
		        	$modulo8='<ul>';
		        	$modulo9='<ul>';
		        	$vistas1 =  DB::table('vistausuario')
		        				  ->join('vista', 'vista.id','vistausuario.idvista')
			                      ->where([['vista.idmodulo', 8],['vistausuario.idusuario', $usuario->id],['vista.idvistapadre', null]])
			                      ->select('vistausuario.id','vista.id as idvista','vista.vista','vistausuario.estado','vistausuario.tipoacceso')
			                      ->get();
			        $vistas2 =  DB::table('vistausuario')
		        				  ->join('vista', 'vista.id','vistausuario.idvista')
			                      ->where([['vista.idmodulo', 1],['vistausuario.idusuario', $usuario->id],['vista.idvistapadre', null]])
			                      ->select('vistausuario.id','vista.id as idvista','vista.vista','vistausuario.estado','vistausuario.tipoacceso')
			                      ->get();
			        $vistas3 =  DB::table('vistausuario')
		        				  ->join('vista', 'vista.id','vistausuario.idvista')
			                      ->where([['vista.idmodulo', 2],['vistausuario.idusuario', $usuario->id],['vista.idvistapadre', null]])
			                      ->select('vistausuario.id','vista.id as idvista','vista.vista','vistausuario.estado','vistausuario.tipoacceso')
			                      ->get();
			        $vistas4 =  DB::table('vistausuario')
		        				  ->join('vista', 'vista.id','vistausuario.idvista')
			                      ->where([['vista.idmodulo', 3],['vistausuario.idusuario', $usuario->id],['vista.idvistapadre', null]])
			                      ->select('vistausuario.id','vista.id as idvista','vista.vista','vistausuario.estado','vistausuario.tipoacceso')
			                      ->get();
			        $vistas5 =  DB::table('vistausuario')
		        				  ->join('vista', 'vista.id','vistausuario.idvista')
			                      ->where([['vista.idmodulo', 4],['vistausuario.idusuario', $usuario->id],['vista.idvistapadre', null]])
			                      ->select('vistausuario.id','vista.id as idvista','vista.vista','vistausuario.estado','vistausuario.tipoacceso')
			                      ->get();
			        $vistas6 =  DB::table('vistausuario')
		        				  ->join('vista', 'vista.id','vistausuario.idvista')
			                      ->where([['vista.idmodulo', 5],['vistausuario.idusuario', $usuario->id],['vista.idvistapadre', null]])
			                      ->select('vistausuario.id','vista.id as idvista','vista.vista','vistausuario.estado','vistausuario.tipoacceso')
			                      ->get();
			        $vistas7 =  DB::table('vistausuario')
		        				  ->join('vista', 'vista.id','vistausuario.idvista')
			                      ->where([['vista.idmodulo', 6],['vistausuario.idusuario', $usuario->id],['vista.idvistapadre', null]])
			                      ->select('vistausuario.id','vista.id as idvista','vista.vista','vistausuario.estado','vistausuario.tipoacceso')
			                      ->get();
			        $vistas8 =  DB::table('vistausuario')
		        				  ->join('vista', 'vista.id','vistausuario.idvista')
			                      ->where([['vista.idmodulo', 7],['vistausuario.idusuario', $usuario->id],['vista.idvistapadre', null]])
			                      ->select('vistausuario.id','vista.id as idvista','vista.vista','vistausuario.estado','vistausuario.tipoacceso')
			                      ->get();
			        $vistas9 =  DB::table('vistausuario')
		        				  ->join('vista', 'vista.id','vistausuario.idvista')
			                      ->where([['vista.idmodulo', 9],['vistausuario.idusuario', $usuario->id],['vista.idvistapadre', null]])
			                      ->select('vistausuario.id','vista.id as idvista','vista.vista','vistausuario.estado','vistausuario.tipoacceso')
			                      ->get();
		            foreach ($vistas1 as $v) {
		            	if($v->estado==1){
		            		$modulo1 .='<li id="t'.$v->id . '"  class="leaf"><a class="jstree-clicked">' . $v->vista . '<span>';
		            		if($v->tipoacceso==1){
		            			$modulo1 .= '<i class="fa fa-star optionac checked font-green-sharp" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
		            		}else{
		            			$modulo1 .= '<i class="fa fa-star optionac" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
		            		}
		            		if($v->tipoacceso==2){
		            			$modulo1 .= '<i class="fa fa-star-half-full optionac checked font-green-sharp" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
		            		}else{
		            			$modulo1 .= '<i class="fa fa-star-half-full optionac" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
		            		}
		            		if($v->tipoacceso==3){
		            			$modulo1 .= '<i class="fa fa-eye optionac checked font-green-sharp" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
		            		}else{
		            			$modulo1 .= '<i class="fa fa-eye optionac" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
		            		}
		            		$modulo1 .='</span></a>';
		            	}else{
		            		$modulo1 .='<li id="t'.$v->id . '"  class="leaf"><a>' . $v->vista . '<span>';
		            		if($v->tipoacceso==1){
		            			$modulo1 .= '<i class="fa fa-star optionac checked font-green-sharp" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
		            		}else{
		            			$modulo1 .= '<i class="fa fa-star optionac" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
		            		}
		            		if($v->tipoacceso==2){
		            			$modulo1 .= '<i class="fa fa-star-half-full optionac checked font-green-sharp" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
		            		}else{
		            			$modulo1 .= '<i class="fa fa-star-half-full optionac" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
		            		}
		            		if($v->tipoacceso==3){
		            			$modulo1 .= '<i class="fa fa-eye optionac checked font-green-sharp" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
		            		}else{
		            			$modulo1 .= '<i class="fa fa-eye optionac" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
		            		}
		            		$modulo1 .='</span></a>';
		            	}
		            	$childs = DB::table('vistausuario')
			    				  ->join('vista', 'vista.id','vistausuario.idvista')
			                      ->where([['vista.idvistapadre',$v->idvista],['vistausuario.idusuario', $usuario->id]])
			                      ->select('vistausuario.id','vista.id as idvista','vista.vista','vistausuario.estado','vistausuario.tipoacceso','vista.idvistapadre','vistausuario.idusuario')
			                      ->get();
		                if(count($childs)> 0) {
		                    $modulo1 .=$this->childView($childs);
		                }
		            }
		            $modulo1 .='</ul>';

		            foreach ($vistas2 as $v) {
		            	if($v->estado==1){
		            		$modulo2 .='<li id="t'.$v->id . '"  class="leaf"><a class="jstree-clicked">' . $v->vista . '<span>';
		            		if($v->tipoacceso==1){
		            			$modulo2 .= '<i class="fa fa-star optionac checked font-green-sharp" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
		            		}else{
		            			$modulo2 .= '<i class="fa fa-star optionac" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
		            		}
		            		if($v->tipoacceso==2){
		            			$modulo2 .= '<i class="fa fa-star-half-full optionac checked font-green-sharp" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
		            		}else{
		            			$modulo2 .= '<i class="fa fa-star-half-full optionac" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
		            		}
		            		if($v->tipoacceso==3){
		            			$modulo2 .= '<i class="fa fa-eye optionac checked font-green-sharp" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
		            		}else{
		            			$modulo2 .= '<i class="fa fa-eye optionac" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
		            		}
		            		$modulo2 .='</span></a>';
		            	}else{
		            		$modulo2 .='<li id="t'.$v->id . '"  class="leaf"><a>' . $v->vista . '<span>';
		            		if($v->tipoacceso==1){
		            			$modulo2 .= '<i class="fa fa-star optionac checked font-green-sharp" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
		            		}else{
		            			$modulo2 .= '<i class="fa fa-star optionac" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
		            		}
		            		if($v->tipoacceso==2){
		            			$modulo2 .= '<i class="fa fa-star-half-full optionac checked font-green-sharp" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
		            		}else{
		            			$modulo2 .= '<i class="fa fa-star-half-full optionac" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
		            		}
		            		if($v->tipoacceso==3){
		            			$modulo2 .= '<i class="fa fa-eye optionac checked font-green-sharp" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
		            		}else{
		            			$modulo2 .= '<i class="fa fa-eye optionac" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
		            		}
		            		$modulo2 .='</span></a>';
		            	}
		            	$childs = DB::table('vistausuario')
			    				  ->join('vista', 'vista.id','vistausuario.idvista')
			                      ->where([['vista.idvistapadre',$v->idvista],['vistausuario.idusuario', $usuario->id]])
			                      ->select('vistausuario.id','vista.id as idvista','vista.vista','vistausuario.estado','vistausuario.tipoacceso','vista.idvistapadre','vistausuario.idusuario')
			                      ->get();
		                if(count($childs)> 0) {
		                    $modulo2 .= $this->childView($childs);
		                }
		            }
		            $modulo2 .='</ul>';

		            foreach ($vistas3 as $v) {
		            	if($v->estado==1){
		            		$modulo3 .='<li id="t'.$v->id . '"  class="leaf"><a class="jstree-clicked">' . $v->vista . '<span>';
		            		if($v->tipoacceso==1){
		            			$modulo3 .= '<i class="fa fa-star optionac checked font-green-sharp" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
		            		}else{
		            			$modulo3 .= '<i class="fa fa-star optionac" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
		            		}
		            		if($v->tipoacceso==2){
		            			$modulo3 .= '<i class="fa fa-star-half-full optionac checked font-green-sharp" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
		            		}else{
		            			$modulo3 .= '<i class="fa fa-star-half-full optionac" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
		            		}
		            		if($v->tipoacceso==3){
		            			$modulo3 .= '<i class="fa fa-eye optionac checked font-green-sharp" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
		            		}else{
		            			$modulo3 .= '<i class="fa fa-eye optionac" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
		            		}
		            		$modulo3 .='</span></a>';
		            	}else{
		            		$modulo3 .='<li id="t'.$v->id . '"  class="leaf"><a>' . $v->vista . '<span>';
		            		if($v->tipoacceso==1){
		            			$modulo3 .= '<i class="fa fa-star optionac checked font-green-sharp" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
		            		}else{
		            			$modulo3 .= '<i class="fa fa-star optionac" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
		            		}
		            		if($v->tipoacceso==2){
		            			$modulo3 .= '<i class="fa fa-star-half-full optionac checked font-green-sharp" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
		            		}else{
		            			$modulo3 .= '<i class="fa fa-star-half-full optionac" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
		            		}
		            		if($v->tipoacceso==3){
		            			$modulo3 .= '<i class="fa fa-eye optionac checked font-green-sharp" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
		            		}else{
		            			$modulo3 .= '<i class="fa fa-eye optionac" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
		            		}
		            		$modulo3 .='</span></a>';
		            	}
		            	$childs = DB::table('vistausuario')
			    				  ->join('vista', 'vista.id','vistausuario.idvista')
			                      ->where([['vista.idvistapadre',$v->idvista],['vistausuario.idusuario', $usuario->id]])
			                      ->select('vistausuario.id','vista.id as idvista','vista.vista','vistausuario.estado','vistausuario.tipoacceso','vista.idvistapadre','vistausuario.idusuario')
			                      ->get();
		                if(count($childs)> 0) {
		                    $modulo3 .=$this->childView($childs);
		                }
		            }
		            $modulo3 .='</ul>';

		            foreach ($vistas4 as $v) {
		            	if($v->estado==1){
		            		$modulo4 .='<li id="t'.$v->id . '"  class="leaf"><a class="jstree-clicked">' . $v->vista . '<span>';
		            		if($v->tipoacceso==1){
		            			$modulo4 .= '<i class="fa fa-star optionac checked font-green-sharp" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
		            		}else{
		            			$modulo4 .= '<i class="fa fa-star optionac" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
		            		}
		            		if($v->tipoacceso==2){
		            			$modulo4 .= '<i class="fa fa-star-half-full optionac checked font-green-sharp" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
		            		}else{
		            			$modulo4 .= '<i class="fa fa-star-half-full optionac" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
		            		}
		            		if($v->tipoacceso==3){
		            			$modulo4 .= '<i class="fa fa-eye optionac checked font-green-sharp" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
		            		}else{
		            			$modulo4 .= '<i class="fa fa-eye optionac" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
		            		}
		            		$modulo4 .='</span></a>';
		            	}else{
		            		$modulo4 .='<li id="t'.$v->id . '"  class="leaf"><a>' . $v->vista . '<span>';
		            		if($v->tipoacceso==1){
		            			$modulo4 .= '<i class="fa fa-star optionac checked font-green-sharp" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
		            		}else{
		            			$modulo4 .= '<i class="fa fa-star optionac" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
		            		}
		            		if($v->tipoacceso==2){
		            			$modulo4 .= '<i class="fa fa-star-half-full optionac checked font-green-sharp" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
		            		}else{
		            			$modulo4 .= '<i class="fa fa-star-half-full optionac" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
		            		}
		            		if($v->tipoacceso==3){
		            			$modulo4 .= '<i class="fa fa-eye optionac checked font-green-sharp" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
		            		}else{
		            			$modulo4 .= '<i class="fa fa-eye optionac" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
		            		}
		            		$modulo4 .='</span></a>';
		            	}
		            	$childs = DB::table('vistausuario')
			    				  ->join('vista', 'vista.id','vistausuario.idvista')
			                      ->where([['vista.idvistapadre',$v->idvista],['vistausuario.idusuario', $usuario->id]])
			                      ->select('vistausuario.id','vista.id as idvista','vista.vista','vistausuario.estado','vistausuario.tipoacceso','vista.idvistapadre','vistausuario.idusuario')
			                      ->get();
		                if(count($childs)> 0) {
		                    $modulo4 .=$this->childView($childs);
		                }
		            }
		            $modulo4 .='</ul>';

		            foreach ($vistas5 as $v) {
		            	if($v->estado==1){
		            		$modulo5 .='<li id="t'.$v->id . '"  class="leaf"><a class="jstree-clicked">' . $v->vista . '<span>';
		            		if($v->tipoacceso==1){
		            			$modulo5 .= '<i class="fa fa-star optionac checked font-green-sharp" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
		            		}else{
		            			$modulo5 .= '<i class="fa fa-star optionac" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
		            		}
		            		if($v->tipoacceso==2){
		            			$modulo5 .= '<i class="fa fa-star-half-full optionac checked font-green-sharp" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
		            		}else{
		            			$modulo5 .= '<i class="fa fa-star-half-full optionac" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
		            		}
		            		if($v->tipoacceso==3){
		            			$modulo5 .= '<i class="fa fa-eye optionac checked font-green-sharp" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
		            		}else{
		            			$modulo5 .= '<i class="fa fa-eye optionac" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
		            		}
		            		$modulo5 .='</span></a>';
		            	}else{
		            		$modulo5 .='<li id="t'.$v->id . '"  class="leaf"><a>' . $v->vista . '<span>';
		            		if($v->tipoacceso==1){
		            			$modulo5 .= '<i class="fa fa-star optionac checked font-green-sharp" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
		            		}else{
		            			$modulo5 .= '<i class="fa fa-star optionac" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
		            		}
		            		if($v->tipoacceso==2){
		            			$modulo5 .= '<i class="fa fa-star-half-full optionac checked font-green-sharp" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
		            		}else{
		            			$modulo5 .= '<i class="fa fa-star-half-full optionac" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
		            		}
		            		if($v->tipoacceso==3){
		            			$modulo5 .= '<i class="fa fa-eye optionac checked font-green-sharp" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
		            		}else{
		            			$modulo5 .= '<i class="fa fa-eye optionac" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
		            		}
		            		$modulo5 .='</span></a>';
		            	}
		            	$childs = DB::table('vistausuario')
			    				  ->join('vista', 'vista.id','vistausuario.idvista')
			                      ->where([['vista.idvistapadre',$v->idvista],['vistausuario.idusuario', $usuario->id]])
			                      ->select('vistausuario.id','vista.id as idvista','vista.vista','vistausuario.estado','vistausuario.tipoacceso','vista.idvistapadre','vistausuario.idusuario')
			                      ->get();
		                if(count($childs)> 0) {
		                    $modulo5 .=$this->childView($childs);
		                }
		            }
		            $modulo5 .='</ul>';

		            foreach ($vistas6 as $v) {
		            	if($v->estado==1){
		            		$modulo6 .='<li id="t'.$v->id . '"  class="leaf"><a class="jstree-clicked">' . $v->vista . '<span>';
		            		if($v->tipoacceso==1){
		            			$modulo6 .= '<i class="fa fa-star optionac checked font-green-sharp" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
		            		}else{
		            			$modulo6 .= '<i class="fa fa-star optionac" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
		            		}
		            		if($v->tipoacceso==2){
		            			$modulo6 .= '<i class="fa fa-star-half-full optionac checked font-green-sharp" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
		            		}else{
		            			$modulo6 .= '<i class="fa fa-star-half-full optionac" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
		            		}
		            		if($v->tipoacceso==3){
		            			$modulo6 .= '<i class="fa fa-eye optionac checked font-green-sharp" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
		            		}else{
		            			$modulo6 .= '<i class="fa fa-eye optionac" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
		            		}
		            		$modulo6 .='</span></a>';
		            	}else{
		            		$modulo6 .='<li id="t'.$v->id . '"  class="leaf"><a>' . $v->vista . '<span>';
		            		if($v->tipoacceso==1){
		            			$modulo6 .= '<i class="fa fa-star optionac checked font-green-sharp" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
		            		}else{
		            			$modulo6 .= '<i class="fa fa-star optionac" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
		            		}
		            		if($v->tipoacceso==2){
		            			$modulo6 .= '<i class="fa fa-star-half-full optionac checked font-green-sharp" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
		            		}else{
		            			$modulo6 .= '<i class="fa fa-star-half-full optionac" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
		            		}
		            		if($v->tipoacceso==3){
		            			$modulo6 .= '<i class="fa fa-eye optionac checked font-green-sharp" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
		            		}else{
		            			$modulo6 .= '<i class="fa fa-eye optionac" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
		            		}
		            		$modulo6 .='</span></a>';
		            	}
		            	$childs = DB::table('vistausuario')
			    				  ->join('vista', 'vista.id','vistausuario.idvista')
			                      ->where([['vista.idvistapadre',$v->idvista],['vistausuario.idusuario', $usuario->id]])
			                      ->select('vistausuario.id','vista.id as idvista','vista.vista','vistausuario.estado','vistausuario.tipoacceso','vista.idvistapadre','vistausuario.idusuario')
			                      ->get();
		                if(count($childs)> 0) {
		                    $modulo6 .=$this->childView($childs);
		                }
		            }
		            $modulo6 .='</ul>';

		            foreach ($vistas7 as $v) {
		            	if($v->estado==1){
		            		$modulo7 .='<li id="t'.$v->id . '"  class="leaf"><a class="jstree-clicked">' . $v->vista . '<span>';
		            		if($v->tipoacceso==1){
		            			$modulo7 .= '<i class="fa fa-star optionac checked font-green-sharp" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
		            		}else{
		            			$modulo7 .= '<i class="fa fa-star optionac" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
		            		}
		            		if($v->tipoacceso==2){
		            			$modulo7 .= '<i class="fa fa-star-half-full optionac checked font-green-sharp" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
		            		}else{
		            			$modulo7 .= '<i class="fa fa-star-half-full optionac" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
		            		}
		            		if($v->tipoacceso==3){
		            			$modulo7 .= '<i class="fa fa-eye optionac checked font-green-sharp" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
		            		}else{
		            			$modulo7 .= '<i class="fa fa-eye optionac" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
		            		}
		            		$modulo7 .='</span></a>';
		            	}else{
		            		$modulo7 .='<li id="t'.$v->id . '"  class="leaf"><a>' . $v->vista . '<span>';
		            		if($v->tipoacceso==1){
		            			$modulo7 .= '<i class="fa fa-star optionac checked font-green-sharp" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
		            		}else{
		            			$modulo7 .= '<i class="fa fa-star optionac" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
		            		}
		            		if($v->tipoacceso==2){
		            			$modulo7 .= '<i class="fa fa-star-half-full optionac checked font-green-sharp" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
		            		}else{
		            			$modulo7 .= '<i class="fa fa-star-half-full optionac" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
		            		}
		            		if($v->tipoacceso==3){
		            			$modulo7 .= '<i class="fa fa-eye optionac checked font-green-sharp" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
		            		}else{
		            			$modulo7 .= '<i class="fa fa-eye optionac" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
		            		}
		            		$modulo7 .='</span></a>';
		            	}
		            	$childs = DB::table('vistausuario')
			    				  ->join('vista', 'vista.id','vistausuario.idvista')
			                      ->where([['vista.idvistapadre',$v->idvista],['vistausuario.idusuario', $usuario->id]])
			                      ->select('vistausuario.id','vista.id as idvista','vista.vista','vistausuario.estado','vistausuario.tipoacceso','vista.idvistapadre','vistausuario.idusuario')
			                      ->get();
		                if(count($childs)> 0) {
		                    $modulo7 .=$this->childView($childs);
		                }
		            }
		            $modulo7 .='</ul>';

		            foreach ($vistas8 as $v) {
		            	if($v->estado==1){
		            		$modulo8 .='<li id="t'.$v->id . '"  class="leaf"><a class="jstree-clicked">' . $v->vista . '<span>';
		            		if($v->tipoacceso==1){
		            			$modulo8 .= '<i class="fa fa-star optionac checked font-green-sharp" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
		            		}else{
		            			$modulo8 .= '<i class="fa fa-star optionac" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
		            		}
		            		if($v->tipoacceso==2){
		            			$modulo8 .= '<i class="fa fa-star-half-full optionac checked font-green-sharp" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
		            		}else{
		            			$modulo8 .= '<i class="fa fa-star-half-full optionac" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
		            		}
		            		if($v->tipoacceso==3){
		            			$modulo8 .= '<i class="fa fa-eye optionac checked font-green-sharp" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
		            		}else{
		            			$modulo8 .= '<i class="fa fa-eye optionac" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
		            		}
		            		$modulo8 .='</span></a>';
		            	}else{
		            		$modulo8 .='<li id="t'.$v->id . '"  class="leaf"><a>' . $v->vista . '<span>';
		            		if($v->tipoacceso==1){
		            			$modulo8 .= '<i class="fa fa-star optionac checked font-green-sharp" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
		            		}else{
		            			$modulo8 .= '<i class="fa fa-star optionac" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
		            		}
		            		if($v->tipoacceso==2){
		            			$modulo8 .= '<i class="fa fa-star-half-full optionac checked font-green-sharp" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
		            		}else{
		            			$modulo8 .= '<i class="fa fa-star-half-full optionac" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
		            		}
		            		if($v->tipoacceso==3){
		            			$modulo8 .= '<i class="fa fa-eye optionac checked font-green-sharp" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
		            		}else{
		            			$modulo8 .= '<i class="fa fa-eye optionac" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
		            		}
		            		$modulo8 .='</span></a>';
		            	}
		            	$childs = DB::table('vistausuario')
			    				  ->join('vista', 'vista.id','vistausuario.idvista')
			                      ->where([['vista.idvistapadre',$v->idvista],['vistausuario.idusuario', $usuario->id]])
			                      ->select('vistausuario.id','vista.id as idvista','vista.vista','vistausuario.estado','vistausuario.tipoacceso','vista.idvistapadre','vistausuario.idusuario')
			                      ->get();
		                if(count($childs)> 0) {
		                    $modulo8 .=$this->childView($childs);
		                }
		            }
		            $modulo8 .='</ul>';

		            foreach ($vistas9 as $v) {
		            	if($v->estado==1){
		            		$modulo9 .='<li id="t'.$v->id . '"  class="leaf"><a class="jstree-clicked">' . $v->vista . '<span>';
		            		if($v->tipoacceso==1){
		            			$modulo9 .= '<i class="fa fa-star optionac checked font-green-sharp" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
		            		}else{
		            			$modulo9 .= '<i class="fa fa-star optionac" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
		            		}
		            		if($v->tipoacceso==2){
		            			$modulo9 .= '<i class="fa fa-star-half-full optionac checked font-green-sharp" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
		            		}else{
		            			$modulo9 .= '<i class="fa fa-star-half-full optionac" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
		            		}
		            		if($v->tipoacceso==3){
		            			$modulo9 .= '<i class="fa fa-eye optionac checked font-green-sharp" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
		            		}else{
		            			$modulo9 .= '<i class="fa fa-eye optionac" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
		            		}
		            		$modulo9 .='</span></a>';
		            	}else{
		            		$modulo9 .='<li id="t'.$v->id . '"  class="leaf"><a>' . $v->vista . '<span>';
		            		if($v->tipoacceso==1){
		            			$modulo9 .= '<i class="fa fa-star optionac checked font-green-sharp" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
		            		}else{
		            			$modulo9 .= '<i class="fa fa-star optionac" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
		            		}
		            		if($v->tipoacceso==2){
		            			$modulo9 .= '<i class="fa fa-star-half-full optionac checked font-green-sharp" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
		            		}else{
		            			$modulo9 .= '<i class="fa fa-star-half-full optionac" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
		            		}
		            		if($v->tipoacceso==3){
		            			$modulo9 .= '<i class="fa fa-eye optionac checked font-green-sharp" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
		            		}else{
		            			$modulo9 .= '<i class="fa fa-eye optionac" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
		            		}
		            		$modulo9 .='</span></a>';
		            	}
		            	$childs = DB::table('vistausuario')
			    				  ->join('vista', 'vista.id','vistausuario.idvista')
			                      ->where([['vista.idvistapadre',$v->idvista],['vistausuario.idusuario', $usuario->id]])
			                      ->select('vistausuario.id','vista.id as idvista','vista.vista','vistausuario.estado','vistausuario.tipoacceso','vista.idvistapadre','vistausuario.idusuario')
			                      ->get();
		                if(count($childs)> 0) {
		                    $modulo9 .=$this->childView($childs);
		                }
		            }
		            $modulo9 .='</ul>';
	            foreach ($modulos as &$m) {

	        		if($m->estado==0){
	        			if($m->idmodulo==1){
	        				$modulo2 = "";
	        			}
	        			if($m->idmodulo==2){
	        				$modulo3 = "";
	        			}
	        			if($m->idmodulo==3){
	        				$modulo4 = "";
	        			}
	        			if($m->idmodulo==4){
	        				$modulo5 = "";
	        			}
	        			if($m->idmodulo==5){
	        				$modulo6 = "";
	        			}
	        			if($m->idmodulo==6){
	        				$modulo7 = "";
	        			}
	        			if($m->idmodulo==7){
	        				$modulo8 = "";
	        			}
	        			if($m->idmodulo==8){
	        				$modulo1 = "";
	        			}
	        			if($m->idmodulo==9){
	        				$modulo9 = "";
	        			}
	        		}
	        	}
				return response()->json([
					'mensaje'			=> "Usuario Encontrado Exitosamente",
					'titulo'			=> "Success",
					'tipoMensaje'		=> "success",
					'botonConfirmacion'	=> "ok",
					'Usuario'           => $usuario,
	                'Modulo1'           => $modulo1,
	                'Modulo2'           => $modulo2,
	                'Modulo3'           => $modulo3,
	                'Modulo4'           => $modulo4,
	                'Modulo5'           => $modulo5,
	                'Modulo6'           => $modulo6,
	                'Modulo7'           => $modulo7,
	                'Modulo8'           => $modulo8,
	                'Modulo9'           => $modulo9
				]);
			}catch(Throwable $e){

			}
		}

		public function childView($childs){
	        $html = '<ul>';
	        foreach ($childs as $arr) {
	        	$childs2 = DB::table('vistausuario')
	    				  ->join('vista', 'vista.id','vistausuario.idvista')
	                      ->where([['vista.idvistapadre',$arr->idvista],['vistausuario.idusuario', $arr->idusuario]])
	                      ->select('vistausuario.id','vista.id as idvista','vista.vista','vistausuario.estado','vistausuario.tipoacceso','vista.idvistapadre','vistausuario.idusuario')
	                      ->get();
	            if(count($childs2)){
	            	if($arr->estado==1){
		        		$html .='<li id="t'.$arr->id . '"  class="leaf"><a class="jstree-clicked">' . $arr->vista . '<span>';
		        		if($arr->tipoacceso==1){
	            			$html .= '<i class="fa fa-star optionac checked font-green-sharp" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
	            		}else{
	            			$html .= '<i class="fa fa-star optionac" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
	            		}
	            		if($arr->tipoacceso==2){
	            			$html .= '<i class="fa fa-star-half-full optionac checked font-green-sharp" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
	            		}else{
	            			$html .= '<i class="fa fa-star-half-full optionac" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
	            		}
	            		if($arr->tipoacceso==3){
	            			$html .= '<i class="fa fa-eye optionac checked font-green-sharp" data-value="1" data-toggle="tooltip" title="Solo Consulta" ></i>';
	            		}else{
	            			$html .= '<i class="fa fa-eye optionac" data-value="1" data-toggle="tooltip" title="Solo Consulta" ></i>';
	            		}
	            		$html .='</span></a>';
		        	}else{
		        		$html .='<li id="t'.$arr->id . '"  class="leaf"><a>' . $arr->vista . '<span>';
		        		if($arr->tipoacceso==1){
	            			$html .= '<i class="fa fa-star optionac checked font-green-sharp" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
	            		}else{
	            			$html .= '<i class="fa fa-star optionac" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
	            		}
	            		if($arr->tipoacceso==2){
	            			$html .= '<i class="fa fa-star-half-full optionac checked font-green-sharp" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
	            		}else{
	            			$html .= '<i class="fa fa-star-half-full optionac" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
	            		}
	            		if($arr->tipoacceso==3){
	            			$html .= '<i class="fa fa-eye optionac checked font-green-sharp" data-value="1" data-toggle="tooltip" title="Solo Consulta" ></i>';
	            		}else{
	            			$html .= '<i class="fa fa-eye optionac" data-value="1" data-toggle="tooltip" title="Solo Consulta" ></i>';
	            		}
	            		$html .='</span></a>';
		        	}
	                $html.= $this->childView($childs2);
	            }else{
	                if($arr->estado==1){
		        		$html .='<li id="t'.$arr->id . '"  class="leaf"><a class="jstree-clicked">' . $arr->vista . '<span>';
		        		if($arr->tipoacceso==1){
	            			$html .= '<i class="fa fa-star optionac checked font-green-sharp" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
	            		}else{
	            			$html .= '<i class="fa fa-star optionac" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
	            		}
	            		if($arr->tipoacceso==2){
	            			$html .= '<i class="fa fa-star-half-full optionac checked font-green-sharp" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
	            		}else{
	            			$html .= '<i class="fa fa-star-half-full optionac" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
	            		}
	            		if($arr->tipoacceso==3){
	            			$html .= '<i class="fa fa-eye optionac checked font-green-sharp" data-value="1" data-toggle="tooltip" title="Solo Consulta" ></i>';
	            		}else{
	            			$html .= '<i class="fa fa-eye optionac" data-value="1" data-toggle="tooltip" title="Solo Consulta" ></i>';
	            		}
	            		$html .='</span></a>';
		        	}else{
		        		$html .='<li id="t'.$arr->id . '"  class="leaf"><a>' . $arr->vista . '<span>';
		        		if($arr->tipoacceso==1){
	            			$html .= '<i class="fa fa-star optionac checked font-green-sharp" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
	            		}else{
	            			$html .= '<i class="fa fa-star optionac" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
	            		}
	            		if($arr->tipoacceso==2){
	            			$html .= '<i class="fa fa-star-half-full optionac checked font-green-sharp" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
	            		}else{
	            			$html .= '<i class="fa fa-star-half-full optionac" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
	            		}
	            		if($arr->tipoacceso==3){
	            			$html .= '<i class="fa fa-eye optionac checked font-green-sharp" data-value="1" data-toggle="tooltip" title="Solo Consulta" ></i>';
	            		}else{
	            			$html .= '<i class="fa fa-eye optionac" data-value="1" data-toggle="tooltip" title="Solo Consulta" ></i>';
	            		}
	            		$html .='</span></a>';
		        	}
	                $html .="</li>";
	            }
	        }
	        $html .="</ul>";
	        return $html;
	    }

		public function guardarvistausuario($idusuario){
			try{
				$Usuario = Usuario::find($idusuario);
				$vistas = DB::table('vista')->get();
				foreach ($vistas as &$v) {
					$relacion = DB::table('vistausuario')
								  ->where([
								  		['vistausuario.idvista', $v->id],
			                            ['vistausuario.idusuario', $Usuario->id]
			                        ])
			                      ->first();
			        if($relacion==null){
			        	$newrel = new vistausuario();
			        	$newrel->idusuario = $Usuario->id;
			        	$newrel->idvista = $v->id;
			        	$newrel->tipoacceso = 3;
			        	$newrel->estado = 0;
			        	$newrel->save();
			        }
				}
				return 200;
			}
			catch(Throwable $e){
				return -200;
			}
		}

		public function vaciarvistarusuario($idusuario){
			try{
				$Usuario = Usuario::find($idusuario);
				$vistas = DB::table('vista')->get();
				foreach ($vistas as &$v) {
					$relacion = DB::table('vistausuario')
								  ->where([
								  		['vistausuario.idvista', $v->id],
			                            ['vistausuario.idusuario', $Usuario->id]
			                        ])
			                      ->first();
		        	$newrel = vistausuario::find($relacion->id);
		        	$newrel->estado = 0;
		   			$newrel->tipoacceso = 3;
		        	$newrel->save();
				}
				return 200;
			}
			catch(Throwable $e){
				return -200;
			}
		}

		public function actualizarpermisos(Request $request){
			try{
				$usuario = Usuario::find($request->input('idusuario'));
				$vaciado = self::vaciarvistarusuario($usuario->id);
				$seleccion = $request->input('seleccion');
				if($seleccion!=""){
					$seleccionados = explode(",", $seleccion);
					foreach ($seleccionados as &$s) {
						$pak = explode("/", $s);
						$relacion = vistausuario::where('vistausuario.id',$pak[0])->first();
						$relacion->estado = 1;
						$relacion->tipoacceso = $pak[1];
						$relacion->save();
					}
				}

				return response()->json([
	                'mensaje'           => "Guardado exitosamente",
	                'titulo'            => "Success",
	                'tipoMensaje'       => "success",
	                'botonConfirmacion' => "ok"
	            ]);
			}
			catch(Throwable $e){
				return response()->json([
					'mensaje'			=> $e,
					'titulo'			=> "Error",
					'tipoMensaje'		=> "error",
					'botonConfirmacion'	=> "ok"
				]);
			}
		}
	// membresias
		public function lmembresias($idempresa=0){
			try{
				if(Auth::user()->TipoUsuario==1){
					if($idempresa!=0){
						$empresa = Empresa::find($idempresa);
			        	$EmpresaSigla = $empresa->Sigla;
			        	$idusuario = Auth::user()->id;
			        	$empresas = DB::table('empresa')
		                      ->where('empresa.estado','0')
		                      ->get();
			            return view('Permisos.membresia',compact('idempresa','EmpresaSigla','idusuario','empresas'));
					}else{
			        	$idusuario = Auth::user()->id;
			        	$empresas = DB::table('empresa')
		                      ->where('empresa.estado','0')
		                      ->get();
			            return view('Permisos.membresia',compact('idempresa','idusuario','empresas'));
					}
				}else{
					$sinacceso = 'No tiene Permiso para acceder a esta funcion';
					return redirect()->back()->with(compact('sinacceso'));
				}

			}catch(Throwable $e){
				return response()->json([
					'mensaje'			=> $e,
					'titulo'			=> "error",
					'tipoMensaje'		=> "error",
					'botonConfirmacion'	=> "ok"
				]);
			}
		}

		public function traermembresias(Request $request){
			try{
				$idusuario = Auth::user()->id;
				$empresas = DB::table('empresa')
	                      ->where('empresa.estado','0')
	                      ->get();
	            $idem = $request->input('idempresa');
	            if($idem!=0){
	            	$membresias = DB::table('membresia')
	                      ->where([['membresia.idempresa',$idem]])
	                      ->get();
	            }else{
	            	$membresias = DB::table('membresia')
	                      ->get();
	            }

				return response()->json([
					'mensaje'			=> "Membresias Encontradas Exitosamente",
					'titulo'			=> "Success",
					'tipoMensaje'		=> "success",
					'botonConfirmacion'	=> "ok",
	                'Empresas'          => $empresas,
	                'Membresias'        => $membresias
				]);
			}
			catch(Throwable $e){
				return response()->json([
					'mensaje'			=> $e,
					'titulo'			=> "error",
					'tipoMensaje'		=> "error",
					'botonConfirmacion'	=> "ok"
				]);
			}
		}

		public function traermembresia(Request $request){
			try{
				$empresas = DB::table('empresa')
	                      ->where('empresa.estado','0')
	                      ->get();
				$membresia = DB::table('membresia')
	                      ->where('membresia.id',$request->input('idmembresia'))
	                      ->first();
	            if($membresia->estado==1){
	            	return response()->json([
						'mensaje'			=> "ok",
						'titulo'			=> "Success",
						'tipoMensaje'		=> "success",
						'botonConfirmacion'	=> "ok",
						'Empresas'          => $empresas,
						'Membresia'         => $membresia
					]);
	            }else{
	            	return response()->json([
						'mensaje'			=> "No se puede editar esta Membresia por que ha sido cancelada",
						'titulo'			=> "error",
						'tipoMensaje'		=> "error",
						'botonConfirmacion'	=> "ok"
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

		public function crearmembresia(Request $request){
			try{
                $hoy = Carbon::now('America/La_Paz');

				$empresas = DB::table('empresa')
	                      ->where('empresa.estado','0')
	                      ->get();
	            $membresias = DB::table('membresia')
	                      ->where([['membresia.estado','1'],['membresia.idempresa',$request->input('Empresa')]])
	                      ->get();
	            $feci=$request->input('Fei');
	            //$fecf=$request->input('Fef');
	            if($feci < $hoy){
	        		return response()->json([
						'mensaje'			=> "La fecha de inicio debe ser mayor a la fecha actual",
						'titulo'			=> "Error",
						'tipoMensaje'		=> "error",
						'botonConfirmacion'	=> "ok"
					]);
	        	}
                if ($request->input('IdMembresia') != "" || $request->input('IdMembresia') != null) {

                    $empresas = DB::table('empresa')
	                      ->where('empresa.estado','0')
	                      ->get();

                    $membresia = membresia::find($request->input('IdMembresia'));
                    $membresia->idempresa=$request->input('Empresa');
                    $membresia->fechainicio=$request->input('Fei');
                    $membresia->fechafin=$request->input('Fef');
                    $guardar = $membresia->save();
                    if($guardar){
                        return response()->json([
                            'mensaje'			=> "Membresia actualizada exitosamente",
                            'titulo'			=> "Success",
                            'tipoMensaje'		=> "success",
                            'botonConfirmacion'	=> "ok",
                            'Empresas'          => $empresas,
                            'Membresia'         => $membresia
                        ]);
                    }else{
                        return response()->json([
                            'mensaje'			=> "Error al tratar de actualizar la membresia",
                            'titulo'			=> "Error",
                            'tipoMensaje'		=> "error",
                            'botonConfirmacion'	=> "ok"
                        ]);
                    }
                }
                else {

                    if(count($membresias)>0){
                        return response()->json([
                            'mensaje'			=> "ya existe una membresia habilitada para esta empresa.",
                            'titulo'			=> "Error",
                            'tipoMensaje'		=> "error",
                            'botonConfirmacion'	=> "ok"
                        ]);
                    }else{
                        $membresia = new membresia();
                        $membresia->idempresa=$request->input('Empresa');
                        $membresia->fechainicio=$request->input('Fei');
                        $membresia->fechafin=$request->input('Fef');
                        $membresia->estado=1;
                        $guardar = $membresia->save();
                        if($guardar){
                            return response()->json([
                                'mensaje'			=> "Membresia creada exitosamente",
                                'titulo'			=> "Success",
                                'tipoMensaje'		=> "success",
                                'botonConfirmacion'	=> "ok",
                                'Empresas'          => $empresas,
                                'Membresia'         => $membresia
                            ]);
                        }else{
                            return response()->json([
                                'mensaje'			=> "Error al tratar de crear la membresia",
                                'titulo'			=> "Error",
                                'tipoMensaje'		=> "error",
                                'botonConfirmacion'	=> "ok"
                            ]);
                        }
                    }
                }
			}
			catch(Throwable $e){
				return response()->json([
					'mensaje'			=> $e,
					'titulo'			=> "Error",
					'tipoMensaje'		=> "error",
					'botonConfirmacion'	=> "ok"
				]);
			}
		}

		public function cancelarmembresia(Request $request){
			try{

				$empresas = DB::table('empresa')
	                      ->where('empresa.estado','0')
	                      ->get();
				$membresia = DB::table('membresia')
	                      ->where('membresia.id',$request->input('idmembresia'))
	                      ->first();
	            if($membresia->estado==1){
	            	$membresia = membresia::find($membresia->id);
	            	$membresia->estado=0;
	            	$membresia->save();
	            	return response()->json([
						'mensaje'			=> "Membresia cancelada exitosamente",
						'titulo'			=> "Success",
						'tipoMensaje'		=> "success",
						'botonConfirmacion'	=> "ok",
						'Empresas'          => $empresas,
						'Membresia'         => $membresia
					]);
	            }else{
	            	return response()->json([
						'mensaje'			=> "Esta Membresia ya se encuentra cancelada",
						'titulo'			=> "Error",
						'tipoMensaje'		=> "error",
						'botonConfirmacion'	=> "ok"
					]);
	            }
			}
			catch(Throwable $e){
				return response()->json([
					'mensaje'			=> $e,
					'titulo'			=> "Error",
					'tipoMensaje'		=> "error",
					'botonConfirmacion'	=> "ok"
				]);
			}
		}

		// public function actualizarmembresia(Request $request){
		// 	try{
		// 		$empresas = DB::table('empresa')
	    //                   ->where('empresa.estado','0')
	    //                   ->get();
	    //         $feci=$request->input('Fei');
	    //         $fecf=$request->input('Fef');
	    //         if($fecf<=$feci){
	    //     		return response()->json([
		// 				'mensaje'			=> "la fecha de fin no puede ser menor que la inicio",
		// 				'titulo'			=> "Error",
		// 				'tipoMensaje'		=> "error",
		// 				'botonConfirmacion'	=> "ok"
		// 			]);
	    //     	}

	    //     	$membresia = membresia::find($request->input('idmem'));
	    //     	$membresia->idempresa=$request->input('Empresa');
	    //     	$membresia->fechainicio=$request->input('Fei');
	    //     	$membresia->fechafin=$request->input('Fef');
	    //     	$guardar = $membresia->save();
		// 		if($guardar){
		// 			return response()->json([
		// 				'mensaje'			=> "Membresia actualizada exitosamente",
		// 				'titulo'			=> "Success",
		// 				'tipoMensaje'		=> "success",
		// 				'botonConfirmacion'	=> "ok",
		// 				'Empresas'          => $empresas,
		// 				'Membresia'         => $membresia
		// 			]);
	    //         }else{
	    //         	return response()->json([
		// 				'mensaje'			=> "Error al tratar de actualizar la membresia",
		// 				'titulo'			=> "error",
		// 				'tipoMensaje'		=> "error",
		// 				'botonConfirmacion'	=> "ok"
		// 			]);
	    //         }
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

		public function reporteMemb($idempresa=0){
			try{
				$user = \Auth::user()->nombre . " " . \Auth::user()->apellido;
				$hoy = Carbon::now('America/La_Paz')->format('d/m/Y');
				$membresias = DB::table('membresia')
								->orderByRaw('estado DESC')
	                      		->get();
				if($idempresa!=0){
					$membresias = DB::table('membresia')
				                      ->where("idempresa",$idempresa)
				                      ->orderByRaw('estado DESC')
				                      ->get();
				}
	            foreach ($membresias as &$memb) {
	            	$emp = Empresa::find($memb->idempresa);
	            	$memb->idempresa=$emp->Nombre;
					if($memb->estado == 1){
						$memb->estado = "Habilitada";
					}else{
						if($memb->estado == 0){
							$memb->estado = "Deshabilitada";
						}
					}
				}
				$pdf = \PDF::loadView('Permisos.reportememb',compact("membresias","user","hoy"))
			       ->setPaper('letter');
			       //impresora magnetica fina "papel estrecho"
            	return $pdf->stream();
			}
			catch(Exception $e){
	            dd($e);
			}
		}

		public function downloadExcelmemb($idempresa=0){
			$membresias = membresia::select("idempresa","estado","fechainicio","fechafin")
								->orderByRaw('estado DESC')
	        					->get();
			if($idempresa!=0){
				$membresias = membresia::select("idempresa","estado","fechainicio","fechafin")
	        					->where("idempresa",$idempresa)
	        					->orderByRaw('estado DESC')
	        					->get();
			}

			foreach ($membresias as &$memb) {
            	$emp = Empresa::find($memb->idempresa);
            	$memb->idempresa=$emp->Nombre;
				if($memb->estado == 1){
					$memb->estado = "Habilitada";
				}else{
					if($memb->estado == 0){
						$memb->estado = "Deshabilitada";
					}
				}
			}
	        return Excel::create('Membresias', function($excel) use ($membresias) {
	            $excel->sheet('Membresias', function($sheet) use ($membresias)
	            {
	                $sheet->fromArray($membresias);
	            });
	        })->download('xlsx');
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
