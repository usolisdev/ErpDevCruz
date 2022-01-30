<?php

namespace App\Http\Controllers;

use Excel;
use App\vista;
use Throwable;
use App\Cuentas;
use App\Empresa;
use App\Gestion;
use App\Periodo;
use App\persona;
use App\Reporte;
use App\Usuario;
use Carbon\Carbon;
use App\TipoUsuario;
use App\tipodeacceso;
use App\vistausuario;
use App\EmpresaMoneda;
use \Milon\Barcode\DNS2D;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Contracts\Encryption\DecryptException;

class UsuariosController extends Controller
{
	//usuarios
		public function lusuarios($idempresa=0){
			try{
				if(Auth::user()->TipoUsuario==1){
					$empresas = DB::table('empresa')
	                      ->where('empresa.estado','0')
	                      ->get();
					$idusuario = Auth::user()->id;

					$tipous = DB::table('tipousuario')->get();
					$tipoac = DB::table('tipodeacceso')->get();
					if($idempresa != 0){
						$empresa = Empresa::find($idempresa);
						$sucursales = DB::table('sucursal')
					                      ->where([['sucursal.estado','0'],['sucursal.idempresa',$idempresa]])
					                      ->get();
		        		$EmpresaSigla = $empresa->Sigla;
		        		$idusuario = Auth::user()->id;
		        		return view('auth.usuarios', compact('empresas','tipous','tipoac','idempresa','idusuario','EmpresaSigla','sucursales'));
					}else{
						return view('auth.usuarios', compact('empresas','tipous','tipoac','idempresa'));
					}
				}else{
					$sinacceso = 'No tiene Permiso para acceder a esta funcion';
					return redirect()->back()->with(compact('sinacceso'));
				}

			}
			catch(Throwable $e){

			}
		}

	    public function listarusuarios(Request $request){
			try{
				$empresas = DB::table('empresa')
	                      ->where('empresa.estado','0')
	                      ->get();
				$idusuario = Auth::user()->id;

				$tipous = DB::table('tipousuario')->get();
				$idem = $request->input('idem');
				if($idem!=0){
					$usuarios = DB::table('users')
							->where([['users.estado','!=','0'],['users.idempresa',$idem]])
	                      	->get();
				}else{
					$usuarios = DB::table('users')
							->where('users.estado','!=','0')
	                      	->get();
				}
	            return response()->json([
						'mensaje'			=> "Listado de Usuarios Exitoso",
						'titulo'			=> "Success",
						'tipoMensaje'		=> "success",
						'botonConfirmacion'	=> "ok",
						'Usuarios'          => $usuarios,
						'empresas'          => $empresas,
						'TipoUsuario'       => $tipous
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

		public function profile($idempresa,$IdUsuario){
			try{
				$empresas = DB::table('empresa')
	                      ->where('empresa.estado','0')
	                      ->get();
				$idusuario = Auth::user()->id;
				if(Auth::user()->TipoUsuario==1 || $idusuario==$IdUsuario ){
					$tipous = DB::table('tipousuario')->get();
					$tipoac = DB::table('tipodeacceso')->get();
					$usuario = usuario::find($IdUsuario);

                    $personaData = DB::table('users')
		            			->join('persona','persona.id','users.idpersona')
		                        ->where('users.id',$IdUsuario)
		                        ->first();

					if($idempresa != 0){
						$empresa = Empresa::find($idempresa);
						$sucursales = DB::table('sucursal')
					                      ->where([['sucursal.estado','0'],['sucursal.idempresa',$idempresa]])
					                      ->get();
		        		$EmpresaSigla = $empresa->Sigla;
		        		$idusuario = Auth::user()->id;
		        		return view('auth.usuario_profile', compact('empresas','tipous','tipoac', 'usuario','IdUsuario','idempresa','EmpresaSigla','sucursales','personaData'));
					}else{
						return view('auth.usuario_profile', compact('empresas','tipous','tipoac', 'usuario','IdUsuario','idempresa','personaData'));
					}
				}else{
					return Redirect::back();
				}
			}
			catch(Throwable $e){

			}
		}

		public function TraerUsuario(Request $request){
			try{
				$idusuario = Auth::user()->id;

				$empresas = DB::table('empresa')
	                      ->where('empresa.estado','0')
	                      ->get();

	            $usuario=DB::table('users')
	                        ->where('users.id',$request->input('idusuario'))
	                        ->first();

	            $persona=DB::table('persona')
	                        ->where('persona.id',$usuario->idpersona)
	                        ->first();

	            // $modulos = DB::table('modulo')
		        //     			->join('moduloempresa','moduloempresa.idmodulo','modulo.id')
		        //                 ->where('moduloempresa.idempresa',$usuario->idempresa)
		        //                 ->get();

	            // //permisos
			    //     	$view = self::guardarvistausuario($usuario->id);
			    //     	$modulo1='<ul>';
			    //     	$modulo2='<ul>';
			    //     	$modulo3='<ul>';
			    //     	$modulo4='<ul>';
			    //     	$modulo5='<ul>';
			    //     	$modulo6='<ul>';
			    //     	$modulo7='<ul>';
			    //     	$modulo8='<ul>';
			    //     	$modulo9='<ul>';
			    //     	$vistas1 =  DB::table('vistausuario')
			    //     				  ->join('vista', 'vista.id','vistausuario.idvista')
				//                       ->where([['vista.idmodulo', 8],['vistausuario.idusuario', $usuario->id],['vista.idvistapadre', null]])
				//                       ->select('vistausuario.id','vista.id as idvista','vista.vista','vistausuario.estado','vistausuario.tipoacceso')
				//                       ->get();
				//         $vistas2 =  DB::table('vistausuario')
			    //     				  ->join('vista', 'vista.id','vistausuario.idvista')
				//                       ->where([['vista.idmodulo', 1],['vistausuario.idusuario', $usuario->id],['vista.idvistapadre', null]])
				//                       ->select('vistausuario.id','vista.id as idvista','vista.vista','vistausuario.estado','vistausuario.tipoacceso')
				//                       ->get();
				//         $vistas3 =  DB::table('vistausuario')
			    //     				  ->join('vista', 'vista.id','vistausuario.idvista')
				//                       ->where([['vista.idmodulo', 2],['vistausuario.idusuario', $usuario->id],['vista.idvistapadre', null]])
				//                       ->select('vistausuario.id','vista.id as idvista','vista.vista','vistausuario.estado','vistausuario.tipoacceso')
				//                       ->get();
				//         $vistas4 =  DB::table('vistausuario')
			    //     				  ->join('vista', 'vista.id','vistausuario.idvista')
				//                       ->where([['vista.idmodulo', 3],['vistausuario.idusuario', $usuario->id],['vista.idvistapadre', null]])
				//                       ->select('vistausuario.id','vista.id as idvista','vista.vista','vistausuario.estado','vistausuario.tipoacceso')
				//                       ->get();
				//         $vistas5 =  DB::table('vistausuario')
			    //     				  ->join('vista', 'vista.id','vistausuario.idvista')
				//                       ->where([['vista.idmodulo', 4],['vistausuario.idusuario', $usuario->id],['vista.idvistapadre', null]])
				//                       ->select('vistausuario.id','vista.id as idvista','vista.vista','vistausuario.estado','vistausuario.tipoacceso')
				//                       ->get();
				//         $vistas6 =  DB::table('vistausuario')
			    //     				  ->join('vista', 'vista.id','vistausuario.idvista')
				//                       ->where([['vista.idmodulo', 5],['vistausuario.idusuario', $usuario->id],['vista.idvistapadre', null]])
				//                       ->select('vistausuario.id','vista.id as idvista','vista.vista','vistausuario.estado','vistausuario.tipoacceso')
				//                       ->get();
				//         $vistas7 =  DB::table('vistausuario')
			    //     				  ->join('vista', 'vista.id','vistausuario.idvista')
				//                       ->where([['vista.idmodulo', 6],['vistausuario.idusuario', $usuario->id],['vista.idvistapadre', null]])
				//                       ->select('vistausuario.id','vista.id as idvista','vista.vista','vistausuario.estado','vistausuario.tipoacceso')
				//                       ->get();
				//         $vistas8 =  DB::table('vistausuario')
			    //     				  ->join('vista', 'vista.id','vistausuario.idvista')
				//                       ->where([['vista.idmodulo', 7],['vistausuario.idusuario', $usuario->id],['vista.idvistapadre', null]])
				//                       ->select('vistausuario.id','vista.id as idvista','vista.vista','vistausuario.estado','vistausuario.tipoacceso')
				//                       ->get();
				//         $vistas9 =  DB::table('vistausuario')
			    //     				  ->join('vista', 'vista.id','vistausuario.idvista')
				//                       ->where([['vista.idmodulo', 9],['vistausuario.idusuario', $usuario->id],['vista.idvistapadre', null]])
				//                       ->select('vistausuario.id','vista.id as idvista','vista.vista','vistausuario.estado','vistausuario.tipoacceso')
				//                       ->get();
			    //         foreach ($vistas1 as $v) {
			    //         	if($v->estado==1){
			    //         		$modulo1 .='<li id="t'.$v->id . '"  class="leaf"><a class="jstree-clicked">' . $v->vista . '<span>';
			    //         		if($v->tipoacceso==1){
			    //         			$modulo1 .= '<i class="fa fa-star optionac checked font-green-sharp" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
			    //         		}else{
			    //         			$modulo1 .= '<i class="fa fa-star optionac" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
			    //         		}
			    //         		if($v->tipoacceso==2){
			    //         			$modulo1 .= '<i class="fa fa-star-half-full optionac checked font-green-sharp" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
			    //         		}else{
			    //         			$modulo1 .= '<i class="fa fa-star-half-full optionac" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
			    //         		}
			    //         		if($v->tipoacceso==3){
			    //         			$modulo1 .= '<i class="fa fa-eye optionac checked font-green-sharp" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
			    //         		}else{
			    //         			$modulo1 .= '<i class="fa fa-eye optionac" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
			    //         		}
			    //         		$modulo1 .='</span></a>';
			    //         	}else{
			    //         		$modulo1 .='<li id="t'.$v->id . '"  class="leaf"><a>' . $v->vista . '<span>';
			    //         		if($v->tipoacceso==1){
			    //         			$modulo1 .= '<i class="fa fa-star optionac checked font-green-sharp" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
			    //         		}else{
			    //         			$modulo1 .= '<i class="fa fa-star optionac" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
			    //         		}
			    //         		if($v->tipoacceso==2){
			    //         			$modulo1 .= '<i class="fa fa-star-half-full optionac checked font-green-sharp" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
			    //         		}else{
			    //         			$modulo1 .= '<i class="fa fa-star-half-full optionac" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
			    //         		}
			    //         		if($v->tipoacceso==3){
			    //         			$modulo1 .= '<i class="fa fa-eye optionac checked font-green-sharp" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
			    //         		}else{
			    //         			$modulo1 .= '<i class="fa fa-eye optionac" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
			    //         		}
			    //         		$modulo1 .='</span></a>';
			    //         	}
			    //         	$childs = DB::table('vistausuario')
				//     				  ->join('vista', 'vista.id','vistausuario.idvista')
				//                       ->where([['vista.idvistapadre',$v->idvista],['vistausuario.idusuario', $usuario->id]])
				//                       ->select('vistausuario.id','vista.id as idvista','vista.vista','vistausuario.estado','vistausuario.tipoacceso','vista.idvistapadre','vistausuario.idusuario')
				//                       ->get();
			    //             if(count($childs)> 0) {
			    //                 $modulo1 .=$this->childView($childs);
			    //             }
			    //         }
			    //         $modulo1 .='</ul>';

			    //         foreach ($vistas2 as $v) {
			    //         	if($v->estado==1){
			    //         		$modulo2 .='<li id="t'.$v->id . '"  class="leaf"><a class="jstree-clicked">' . $v->vista . '<span>';
			    //         		if($v->tipoacceso==1){
			    //         			$modulo2 .= '<i class="fa fa-star optionac checked font-green-sharp" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
			    //         		}else{
			    //         			$modulo2 .= '<i class="fa fa-star optionac" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
			    //         		}
			    //         		if($v->tipoacceso==2){
			    //         			$modulo2 .= '<i class="fa fa-star-half-full optionac checked font-green-sharp" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
			    //         		}else{
			    //         			$modulo2 .= '<i class="fa fa-star-half-full optionac" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
			    //         		}
			    //         		if($v->tipoacceso==3){
			    //         			$modulo2 .= '<i class="fa fa-eye optionac checked font-green-sharp" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
			    //         		}else{
			    //         			$modulo2 .= '<i class="fa fa-eye optionac" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
			    //         		}
			    //         		$modulo2 .='</span></a>';
			    //         	}else{
			    //         		$modulo2 .='<li id="t'.$v->id . '"  class="leaf"><a>' . $v->vista . '<span>';
			    //         		if($v->tipoacceso==1){
			    //         			$modulo2 .= '<i class="fa fa-star optionac checked font-green-sharp" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
			    //         		}else{
			    //         			$modulo2 .= '<i class="fa fa-star optionac" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
			    //         		}
			    //         		if($v->tipoacceso==2){
			    //         			$modulo2 .= '<i class="fa fa-star-half-full optionac checked font-green-sharp" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
			    //         		}else{
			    //         			$modulo2 .= '<i class="fa fa-star-half-full optionac" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
			    //         		}
			    //         		if($v->tipoacceso==3){
			    //         			$modulo2 .= '<i class="fa fa-eye optionac checked font-green-sharp" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
			    //         		}else{
			    //         			$modulo2 .= '<i class="fa fa-eye optionac" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
			    //         		}
			    //         		$modulo2 .='</span></a>';
			    //         	}
			    //         	$childs = DB::table('vistausuario')
				//     				  ->join('vista', 'vista.id','vistausuario.idvista')
				//                       ->where([['vista.idvistapadre',$v->idvista],['vistausuario.idusuario', $usuario->id]])
				//                       ->select('vistausuario.id','vista.id as idvista','vista.vista','vistausuario.estado','vistausuario.tipoacceso','vista.idvistapadre','vistausuario.idusuario')
				//                       ->get();
			    //             if(count($childs)> 0) {
			    //                 $modulo2 .= $this->childView($childs);
			    //             }
			    //         }
			    //         $modulo2 .='</ul>';

			    //         foreach ($vistas3 as $v) {
			    //         	if($v->estado==1){
			    //         		$modulo3 .='<li id="t'.$v->id . '"  class="leaf"><a class="jstree-clicked">' . $v->vista . '<span>';
			    //         		if($v->tipoacceso==1){
			    //         			$modulo3 .= '<i class="fa fa-star optionac checked font-green-sharp" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
			    //         		}else{
			    //         			$modulo3 .= '<i class="fa fa-star optionac" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
			    //         		}
			    //         		if($v->tipoacceso==2){
			    //         			$modulo3 .= '<i class="fa fa-star-half-full optionac checked font-green-sharp" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
			    //         		}else{
			    //         			$modulo3 .= '<i class="fa fa-star-half-full optionac" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
			    //         		}
			    //         		if($v->tipoacceso==3){
			    //         			$modulo3 .= '<i class="fa fa-eye optionac checked font-green-sharp" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
			    //         		}else{
			    //         			$modulo3 .= '<i class="fa fa-eye optionac" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
			    //         		}
			    //         		$modulo3 .='</span></a>';
			    //         	}else{
			    //         		$modulo3 .='<li id="t'.$v->id . '"  class="leaf"><a>' . $v->vista . '<span>';
			    //         		if($v->tipoacceso==1){
			    //         			$modulo3 .= '<i class="fa fa-star optionac checked font-green-sharp" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
			    //         		}else{
			    //         			$modulo3 .= '<i class="fa fa-star optionac" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
			    //         		}
			    //         		if($v->tipoacceso==2){
			    //         			$modulo3 .= '<i class="fa fa-star-half-full optionac checked font-green-sharp" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
			    //         		}else{
			    //         			$modulo3 .= '<i class="fa fa-star-half-full optionac" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
			    //         		}
			    //         		if($v->tipoacceso==3){
			    //         			$modulo3 .= '<i class="fa fa-eye optionac checked font-green-sharp" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
			    //         		}else{
			    //         			$modulo3 .= '<i class="fa fa-eye optionac" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
			    //         		}
			    //         		$modulo3 .='</span></a>';
			    //         	}
			    //         	$childs = DB::table('vistausuario')
				//     				  ->join('vista', 'vista.id','vistausuario.idvista')
				//                       ->where([['vista.idvistapadre',$v->idvista],['vistausuario.idusuario', $usuario->id]])
				//                       ->select('vistausuario.id','vista.id as idvista','vista.vista','vistausuario.estado','vistausuario.tipoacceso','vista.idvistapadre','vistausuario.idusuario')
				//                       ->get();
			    //             if(count($childs)> 0) {
			    //                 $modulo3 .=$this->childView($childs);
			    //             }
			    //         }
			    //         $modulo3 .='</ul>';

			    //         foreach ($vistas4 as $v) {
			    //         	if($v->estado==1){
			    //         		$modulo4 .='<li id="t'.$v->id . '"  class="leaf"><a class="jstree-clicked">' . $v->vista . '<span>';
			    //         		if($v->tipoacceso==1){
			    //         			$modulo4 .= '<i class="fa fa-star optionac checked font-green-sharp" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
			    //         		}else{
			    //         			$modulo4 .= '<i class="fa fa-star optionac" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
			    //         		}
			    //         		if($v->tipoacceso==2){
			    //         			$modulo4 .= '<i class="fa fa-star-half-full optionac checked font-green-sharp" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
			    //         		}else{
			    //         			$modulo4 .= '<i class="fa fa-star-half-full optionac" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
			    //         		}
			    //         		if($v->tipoacceso==3){
			    //         			$modulo4 .= '<i class="fa fa-eye optionac checked font-green-sharp" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
			    //         		}else{
			    //         			$modulo4 .= '<i class="fa fa-eye optionac" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
			    //         		}
			    //         		$modulo4 .='</span></a>';
			    //         	}else{
			    //         		$modulo4 .='<li id="t'.$v->id . '"  class="leaf"><a>' . $v->vista . '<span>';
			    //         		if($v->tipoacceso==1){
			    //         			$modulo4 .= '<i class="fa fa-star optionac checked font-green-sharp" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
			    //         		}else{
			    //         			$modulo4 .= '<i class="fa fa-star optionac" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
			    //         		}
			    //         		if($v->tipoacceso==2){
			    //         			$modulo4 .= '<i class="fa fa-star-half-full optionac checked font-green-sharp" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
			    //         		}else{
			    //         			$modulo4 .= '<i class="fa fa-star-half-full optionac" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
			    //         		}
			    //         		if($v->tipoacceso==3){
			    //         			$modulo4 .= '<i class="fa fa-eye optionac checked font-green-sharp" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
			    //         		}else{
			    //         			$modulo4 .= '<i class="fa fa-eye optionac" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
			    //         		}
			    //         		$modulo4 .='</span></a>';
			    //         	}
			    //         	$childs = DB::table('vistausuario')
				//     				  ->join('vista', 'vista.id','vistausuario.idvista')
				//                       ->where([['vista.idvistapadre',$v->idvista],['vistausuario.idusuario', $usuario->id]])
				//                       ->select('vistausuario.id','vista.id as idvista','vista.vista','vistausuario.estado','vistausuario.tipoacceso','vista.idvistapadre','vistausuario.idusuario')
				//                       ->get();
			    //             if(count($childs)> 0) {
			    //                 $modulo4 .=$this->childView($childs);
			    //             }
			    //         }
			    //         $modulo4 .='</ul>';

			    //         foreach ($vistas5 as $v) {
			    //         	if($v->estado==1){
			    //         		$modulo5 .='<li id="t'.$v->id . '"  class="leaf"><a class="jstree-clicked">' . $v->vista . '<span>';
			    //         		if($v->tipoacceso==1){
			    //         			$modulo5 .= '<i class="fa fa-star optionac checked font-green-sharp" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
			    //         		}else{
			    //         			$modulo5 .= '<i class="fa fa-star optionac" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
			    //         		}
			    //         		if($v->tipoacceso==2){
			    //         			$modulo5 .= '<i class="fa fa-star-half-full optionac checked font-green-sharp" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
			    //         		}else{
			    //         			$modulo5 .= '<i class="fa fa-star-half-full optionac" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
			    //         		}
			    //         		if($v->tipoacceso==3){
			    //         			$modulo5 .= '<i class="fa fa-eye optionac checked font-green-sharp" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
			    //         		}else{
			    //         			$modulo5 .= '<i class="fa fa-eye optionac" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
			    //         		}
			    //         		$modulo5 .='</span></a>';
			    //         	}else{
			    //         		$modulo5 .='<li id="t'.$v->id . '"  class="leaf"><a>' . $v->vista . '<span>';
			    //         		if($v->tipoacceso==1){
			    //         			$modulo5 .= '<i class="fa fa-star optionac checked font-green-sharp" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
			    //         		}else{
			    //         			$modulo5 .= '<i class="fa fa-star optionac" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
			    //         		}
			    //         		if($v->tipoacceso==2){
			    //         			$modulo5 .= '<i class="fa fa-star-half-full optionac checked font-green-sharp" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
			    //         		}else{
			    //         			$modulo5 .= '<i class="fa fa-star-half-full optionac" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
			    //         		}
			    //         		if($v->tipoacceso==3){
			    //         			$modulo5 .= '<i class="fa fa-eye optionac checked font-green-sharp" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
			    //         		}else{
			    //         			$modulo5 .= '<i class="fa fa-eye optionac" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
			    //         		}
			    //         		$modulo5 .='</span></a>';
			    //         	}
			    //         	$childs = DB::table('vistausuario')
				//     				  ->join('vista', 'vista.id','vistausuario.idvista')
				//                       ->where([['vista.idvistapadre',$v->idvista],['vistausuario.idusuario', $usuario->id]])
				//                       ->select('vistausuario.id','vista.id as idvista','vista.vista','vistausuario.estado','vistausuario.tipoacceso','vista.idvistapadre','vistausuario.idusuario')
				//                       ->get();
			    //             if(count($childs)> 0) {
			    //                 $modulo5 .=$this->childView($childs);
			    //             }
			    //         }
			    //         $modulo5 .='</ul>';

			    //         foreach ($vistas6 as $v) {
			    //         	if($v->estado==1){
			    //         		$modulo6 .='<li id="t'.$v->id . '"  class="leaf"><a class="jstree-clicked">' . $v->vista . '<span>';
			    //         		if($v->tipoacceso==1){
			    //         			$modulo6 .= '<i class="fa fa-star optionac checked font-green-sharp" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
			    //         		}else{
			    //         			$modulo6 .= '<i class="fa fa-star optionac" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
			    //         		}
			    //         		if($v->tipoacceso==2){
			    //         			$modulo6 .= '<i class="fa fa-star-half-full optionac checked font-green-sharp" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
			    //         		}else{
			    //         			$modulo6 .= '<i class="fa fa-star-half-full optionac" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
			    //         		}
			    //         		if($v->tipoacceso==3){
			    //         			$modulo6 .= '<i class="fa fa-eye optionac checked font-green-sharp" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
			    //         		}else{
			    //         			$modulo6 .= '<i class="fa fa-eye optionac" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
			    //         		}
			    //         		$modulo6 .='</span></a>';
			    //         	}else{
			    //         		$modulo6 .='<li id="t'.$v->id . '"  class="leaf"><a>' . $v->vista . '<span>';
			    //         		if($v->tipoacceso==1){
			    //         			$modulo6 .= '<i class="fa fa-star optionac checked font-green-sharp" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
			    //         		}else{
			    //         			$modulo6 .= '<i class="fa fa-star optionac" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
			    //         		}
			    //         		if($v->tipoacceso==2){
			    //         			$modulo6 .= '<i class="fa fa-star-half-full optionac checked font-green-sharp" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
			    //         		}else{
			    //         			$modulo6 .= '<i class="fa fa-star-half-full optionac" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
			    //         		}
			    //         		if($v->tipoacceso==3){
			    //         			$modulo6 .= '<i class="fa fa-eye optionac checked font-green-sharp" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
			    //         		}else{
			    //         			$modulo6 .= '<i class="fa fa-eye optionac" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
			    //         		}
			    //         		$modulo6 .='</span></a>';
			    //         	}
			    //         	$childs = DB::table('vistausuario')
				//     				  ->join('vista', 'vista.id','vistausuario.idvista')
				//                       ->where([['vista.idvistapadre',$v->idvista],['vistausuario.idusuario', $usuario->id]])
				//                       ->select('vistausuario.id','vista.id as idvista','vista.vista','vistausuario.estado','vistausuario.tipoacceso','vista.idvistapadre','vistausuario.idusuario')
				//                       ->get();
			    //             if(count($childs)> 0) {
			    //                 $modulo6 .=$this->childView($childs);
			    //             }
			    //         }
			    //         $modulo6 .='</ul>';

			    //         foreach ($vistas7 as $v) {
			    //         	if($v->estado==1){
			    //         		$modulo7 .='<li id="t'.$v->id . '"  class="leaf"><a class="jstree-clicked">' . $v->vista . '<span>';
			    //         		if($v->tipoacceso==1){
			    //         			$modulo7 .= '<i class="fa fa-star optionac checked font-green-sharp" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
			    //         		}else{
			    //         			$modulo7 .= '<i class="fa fa-star optionac" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
			    //         		}
			    //         		if($v->tipoacceso==2){
			    //         			$modulo7 .= '<i class="fa fa-star-half-full optionac checked font-green-sharp" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
			    //         		}else{
			    //         			$modulo7 .= '<i class="fa fa-star-half-full optionac" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
			    //         		}
			    //         		if($v->tipoacceso==3){
			    //         			$modulo7 .= '<i class="fa fa-eye optionac checked font-green-sharp" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
			    //         		}else{
			    //         			$modulo7 .= '<i class="fa fa-eye optionac" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
			    //         		}
			    //         		$modulo7 .='</span></a>';
			    //         	}else{
			    //         		$modulo7 .='<li id="t'.$v->id . '"  class="leaf"><a>' . $v->vista . '<span>';
			    //         		if($v->tipoacceso==1){
			    //         			$modulo7 .= '<i class="fa fa-star optionac checked font-green-sharp" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
			    //         		}else{
			    //         			$modulo7 .= '<i class="fa fa-star optionac" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
			    //         		}
			    //         		if($v->tipoacceso==2){
			    //         			$modulo7 .= '<i class="fa fa-star-half-full optionac checked font-green-sharp" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
			    //         		}else{
			    //         			$modulo7 .= '<i class="fa fa-star-half-full optionac" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
			    //         		}
			    //         		if($v->tipoacceso==3){
			    //         			$modulo7 .= '<i class="fa fa-eye optionac checked font-green-sharp" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
			    //         		}else{
			    //         			$modulo7 .= '<i class="fa fa-eye optionac" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
			    //         		}
			    //         		$modulo7 .='</span></a>';
			    //         	}
			    //         	$childs = DB::table('vistausuario')
				//     				  ->join('vista', 'vista.id','vistausuario.idvista')
				//                       ->where([['vista.idvistapadre',$v->idvista],['vistausuario.idusuario', $usuario->id]])
				//                       ->select('vistausuario.id','vista.id as idvista','vista.vista','vistausuario.estado','vistausuario.tipoacceso','vista.idvistapadre','vistausuario.idusuario')
				//                       ->get();
			    //             if(count($childs)> 0) {
			    //                 $modulo7 .=$this->childView($childs);
			    //             }
			    //         }
			    //         $modulo7 .='</ul>';

			    //         foreach ($vistas8 as $v) {
			    //         	if($v->estado==1){
			    //         		$modulo8 .='<li id="t'.$v->id . '"  class="leaf"><a class="jstree-clicked">' . $v->vista . '<span>';
			    //         		if($v->tipoacceso==1){
			    //         			$modulo8 .= '<i class="fa fa-star optionac checked font-green-sharp" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
			    //         		}else{
			    //         			$modulo8 .= '<i class="fa fa-star optionac" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
			    //         		}
			    //         		if($v->tipoacceso==2){
			    //         			$modulo8 .= '<i class="fa fa-star-half-full optionac checked font-green-sharp" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
			    //         		}else{
			    //         			$modulo8 .= '<i class="fa fa-star-half-full optionac" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
			    //         		}
			    //         		if($v->tipoacceso==3){
			    //         			$modulo8 .= '<i class="fa fa-eye optionac checked font-green-sharp" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
			    //         		}else{
			    //         			$modulo8 .= '<i class="fa fa-eye optionac" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
			    //         		}
			    //         		$modulo8 .='</span></a>';
			    //         	}else{
			    //         		$modulo8 .='<li id="t'.$v->id . '"  class="leaf"><a>' . $v->vista . '<span>';
			    //         		if($v->tipoacceso==1){
			    //         			$modulo8 .= '<i class="fa fa-star optionac checked font-green-sharp" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
			    //         		}else{
			    //         			$modulo8 .= '<i class="fa fa-star optionac" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
			    //         		}
			    //         		if($v->tipoacceso==2){
			    //         			$modulo8 .= '<i class="fa fa-star-half-full optionac checked font-green-sharp" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
			    //         		}else{
			    //         			$modulo8 .= '<i class="fa fa-star-half-full optionac" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
			    //         		}
			    //         		if($v->tipoacceso==3){
			    //         			$modulo8 .= '<i class="fa fa-eye optionac checked font-green-sharp" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
			    //         		}else{
			    //         			$modulo8 .= '<i class="fa fa-eye optionac" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
			    //         		}
			    //         		$modulo8 .='</span></a>';
			    //         	}
			    //         	$childs = DB::table('vistausuario')
				//     				  ->join('vista', 'vista.id','vistausuario.idvista')
				//                       ->where([['vista.idvistapadre',$v->idvista],['vistausuario.idusuario', $usuario->id]])
				//                       ->select('vistausuario.id','vista.id as idvista','vista.vista','vistausuario.estado','vistausuario.tipoacceso','vista.idvistapadre','vistausuario.idusuario')
				//                       ->get();
			    //             if(count($childs)> 0) {
			    //                 $modulo8 .=$this->childView($childs);
			    //             }
			    //         }
			    //         $modulo8 .='</ul>';

			    //         foreach ($vistas9 as $v) {
			    //         	if($v->estado==1){
			    //         		$modulo9 .='<li id="t'.$v->id . '"  class="leaf"><a class="jstree-clicked">' . $v->vista . '<span>';
			    //         		if($v->tipoacceso==1){
			    //         			$modulo9 .= '<i class="fa fa-star optionac checked font-green-sharp" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
			    //         		}else{
			    //         			$modulo9 .= '<i class="fa fa-star optionac" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
			    //         		}
			    //         		if($v->tipoacceso==2){
			    //         			$modulo9 .= '<i class="fa fa-star-half-full optionac checked font-green-sharp" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
			    //         		}else{
			    //         			$modulo9 .= '<i class="fa fa-star-half-full optionac" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
			    //         		}
			    //         		if($v->tipoacceso==3){
			    //         			$modulo9 .= '<i class="fa fa-eye optionac checked font-green-sharp" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
			    //         		}else{
			    //         			$modulo9 .= '<i class="fa fa-eye optionac" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
			    //         		}
			    //         		$modulo9 .='</span></a>';
			    //         	}else{
			    //         		$modulo9 .='<li id="t'.$v->id . '"  class="leaf"><a>' . $v->vista . '<span>';
			    //         		if($v->tipoacceso==1){
			    //         			$modulo9 .= '<i class="fa fa-star optionac checked font-green-sharp" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
			    //         		}else{
			    //         			$modulo9 .= '<i class="fa fa-star optionac" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
			    //         		}
			    //         		if($v->tipoacceso==2){
			    //         			$modulo9 .= '<i class="fa fa-star-half-full optionac checked font-green-sharp" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
			    //         		}else{
			    //         			$modulo9 .= '<i class="fa fa-star-half-full optionac" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
			    //         		}
			    //         		if($v->tipoacceso==3){
			    //         			$modulo9 .= '<i class="fa fa-eye optionac checked font-green-sharp" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
			    //         		}else{
			    //         			$modulo9 .= '<i class="fa fa-eye optionac" data-value="3" data-toggle="tooltip" title="Solo Consulta" ></i>';
			    //         		}
			    //         		$modulo9 .='</span></a>';
			    //         	}
			    //         	$childs = DB::table('vistausuario')
				//     				  ->join('vista', 'vista.id','vistausuario.idvista')
				//                       ->where([['vista.idvistapadre',$v->idvista],['vistausuario.idusuario', $usuario->id]])
				//                       ->select('vistausuario.id','vista.id as idvista','vista.vista','vistausuario.estado','vistausuario.tipoacceso','vista.idvistapadre','vistausuario.idusuario')
				//                       ->get();
			    //             if(count($childs)> 0) {
			    //                 $modulo9 .=$this->childView($childs);
			    //             }
			    //         }
			    //         $modulo9 .='</ul>';
	            // foreach ($modulos as &$m) {

	        	// 	if($m->estado==0){
	        	// 		if($m->idmodulo==1){
	        	// 			$modulo2 = "";
	        	// 		}
	        	// 		if($m->idmodulo==2){
	        	// 			$modulo3 = "";
	        	// 		}
	        	// 		if($m->idmodulo==3){
	        	// 			$modulo4 = "";
	        	// 		}
	        	// 		if($m->idmodulo==4){
	        	// 			$modulo5 = "";
	        	// 		}
	        	// 		if($m->idmodulo==5){
	        	// 			$modulo6 = "";
	        	// 		}
	        	// 		if($m->idmodulo==6){
	        	// 			$modulo7 = "";
	        	// 		}
	        	// 		if($m->idmodulo==7){
	        	// 			$modulo8 = "";
	        	// 		}
	        	// 		if($m->idmodulo==8){
	        	// 			$modulo1 = "";
	        	// 		}
	        	// 		if($m->idmodulo==9){
	        	// 			$modulo9 = "";
	        	// 		}
	        	// 	}
	        	// }

				return response()->json([
					'mensaje'			=> "Usuario Encontrado Exitosamente",
					'titulo'			=> "Success",
					'tipoMensaje'		=> "success",
					'botonConfirmacion'	=> "ok",
					'Usuario'           => $usuario,
					'Persona'           => $persona,
					'Empresas'          => $empresas
	                // 'Modulo1'           => $modulo1,
	                // 'Modulo2'           => $modulo2,
	                // 'Modulo3'           => $modulo3,
	                // 'Modulo4'           => $modulo4,
	                // 'Modulo5'           => $modulo5,
	                // 'Modulo6'           => $modulo6,
	                // 'Modulo7'           => $modulo7,
	                // 'Modulo8'           => $modulo8,
	                // 'Modulo9'           => $modulo9
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

	    public function GuardarUsuario(Request $request){
			try{
				$idusuario = Auth::user()->id;
				$user=$request->input('Nombre');
				$ci=$request->input('ci');
	            $nit=$request->input('nit');
	            $nombres=$request->input('Name');
	            $apellidos=$request->input('Apellido');
	            $email=$request->input('Correo');
	            $celular=$request->input('celular');
	            $telefono=$request->input('Telefono');
	            $direccion=$request->input('direccion');
	            $fecnac=$request->input('fecnac');
	            $cargo=$request->input('Cargo');
	            $password=$request->input('Password');
	            $tipo=$request->input('TipoUsuario');
	            $empresa=$request->input('Empresa');
	            $sucursal=$request->input('Sucursal');

				$Nombre = DB::table('users')
	                            ->where(strtolower('users.name'),strtolower($request->input('Nombre')))
	                            ->first();
	            $correo = DB::table('users')
	                            ->where(strtolower('users.email'),strtolower($request->input('Correo')))
	                            ->first();
	            if($Nombre!=null){
	            	return response()->json([
						'mensaje'			=> "Ya existe un Usuario con este nombre",
						'titulo'			=> "Error",
						'tipoMensaje'		=> "error",
						'botonConfirmacion'	=> "ok"
					]);
	            }
	            if($correo!=null){
	            	return response()->json([
						'mensaje'			=> "Ya existe un Usuario con este Correo",
						'titulo'			=> "Error",
						'tipoMensaje'		=> "error",
						'botonConfirmacion'	=> "ok"
					]);
	            }
	            //persona
	                $persona=null;
	                if(!empty($ci)){
	                	$persona = DB::table('persona')
				            ->where('persona.ci',$ci)
				            ->first();
	                }else{
	                	$persona = DB::table('persona')
				            ->where('persona.nit',$nit)
				            ->first();
	                }
				    if($persona==null){
				    	$compci=self::comprobardatacrear($ci,$nit,$email);
						if($compci!=100){
							return response()->json([
								'mensaje'			=> $compci,
								'titulo'			=> "Error",
								'tipoMensaje'		=> "error",
								'botonConfirmacion'	=> "ok"
							]);
						}else{
							$persona = self::crearpersona($nombres,$apellidos,$ci,$nit,$email,$telefono,$celular,$direccion,$fecnac);
						}
				    }else{

				    	$compci=self::comprobardata($ci,$nit,$email,$persona->id);
						if($compci!=100){
							return response()->json([
								'mensaje'			=> $compci,
								'titulo'			=> "Error",
								'tipoMensaje'		=> "error",
								'botonConfirmacion'	=> "ok"
							]);
						}else{
							$persona = self::actualizarpersona($persona->id,$nombres,$apellidos,$ci,$nit,$email,$telefono,$celular,$direccion,$fecnac);
						}
				    }
				//usuario
					$usuario = new Usuario;
					$usuario->name		    = $user;
					$usuario->nombre		= $nombres;
					$usuario->apellido		= $apellidos;
					$usuario->telefono		= $telefono;
					$usuario->cargo		    = $cargo;
					$usuario->email		    = $email;
					$usuario->password	    = Hash::make($password);
					$usuario->TipoUsuario	= $tipo;
					$usuario->estado	    = 0;
					$usuario->reset	        = 0;
					$usuario->idpersona     = $persona;
					if($empresa!=0){
						$usuario->idempresa	    = $empresa;
					}
					if($sucursal!=0){
						$usuario->idsucursal	= $sucursal;
					}
					$guardado = $usuario->save();
				$empresas = DB::table('empresa')
	                      ->where('empresa.estado','0')
	                      ->get();

				$tipous = DB::table('tipousuario')->get();
				$tipoac = DB::table('tipodeacceso')->get();

				if($guardado){
					// 'rols'              => $rols,
					return response()->json([
						'mensaje'			=> "Usuario Guardado Exitosamente",
						'titulo'			=> "Success",
						'tipoMensaje'		=> "success",
						'botonConfirmacion'	=> "ok",
						'Usuario'           => $usuario,
						'empresas'          => $empresas,
						'TipoUsuario'       => $tipous,
						'tipoacceso'        => $tipoac
					]);
				}

			}
			catch(Throwable $e){
				//dd($e);
				return response()->json([
					'mensaje'			=> $e,
					'titulo'			=> "Error",
					'tipoMensaje'		=> "error",
					'botonConfirmacion'	=> "ok"
				]);
			}
		}

        public function ActualizarDatosCuenta(Request $request){
			try{
                $nombre = DB::table('users')
	                            ->where(strtolower('users.name'),strtolower($request->input('NameUsuario')))
                                ->where('users.id','!=',$request->input('IdUsuario'))
	                            ->first();

                if ($nombre!=null)
                {
                    return response()->json([
                        'mensaje'			=> "Ya existe un usuario con este nombre",
                        'titulo'			=> "Error",
                        'tipoMensaje'		=> "error",
                        'botonConfirmacion'	=> "ok"
                    ]);
                }

                $Usuario = Usuario::where('users.id', $request->input('IdUsuario'))->first();
                $Usuario->name = $request->input('NameUsuario');
                $Usuario->cargo = $request->input('Cargo');
                $Usuario->idempresa = $request->input('Empresa');
                $Usuario->idsucursal = $request->input('Sucursal');
                $Usuario->save();

                return response()->json([
                    'mensaje'			=> "Datos de Cuenta Actualizado Exitosamente",
                    'titulo'			=> "Success",
                    'tipoMensaje'		=> "success",
                    'botonConfirmacion'	=> "ok",
                    'Usuario'           => $Usuario
                ]);

			}
			catch(Throwable $e){
				//dd($e);
				return response()->json([
					'mensaje'			=> $e,
					'titulo'			=> "Error",
					'tipoMensaje'		=> "error",
					'botonConfirmacion'	=> "ok"
				]);
			}
		}

        public function ActualizarDatosPersonales(Request $request){
			try{

                $Usuario = Usuario::where('users.id', $request->input('IdUsuario'))->first();
                $Persona = persona::find($Usuario->idpersona);

                $Persona->nombres = $request->input('Nombre');
                $Persona->apellidos = $request->input('Apellido');
                $Persona->fecha_de_nacimiento = $request->input('FechaNaci');
                $Persona->ci = $request->input('Ci');
                $Persona->nit = $request->input('Nit');
                $Persona->telefono = $request->input('Telefono');
                $Persona->celular = $request->input('Celular');
                $Persona->email = $request->input('Correo');
                $Persona->direccion = $request->input('Direccion');
                $Persona->save();

                return response()->json([
                    'mensaje'			=> "Datos Personales Actualizado Exitosamente",
                    'titulo'			=> "Success",
                    'tipoMensaje'		=> "success",
                    'botonConfirmacion'	=> "ok",
                    'Persona'           => $Persona
                ]);

			}
			catch(Throwable $e){
				//dd($e);
				return response()->json([
					'mensaje'			=> $e,
					'titulo'			=> "Error",
					'tipoMensaje'		=> "error",
					'botonConfirmacion'	=> "ok"
				]);
			}
		}

        public function ActualizarInicioSesionCorreo(Request $request){
			try{

                $usuario = DB::table('users')
                            ->where('users.id',$request->input('IdUsuario'))
                            ->first();

                if(Hash::check($request->input('Contra'), $usuario->password)){

                    $usuarioac = Usuario::where('users.id', $usuario->id)->first();

                    $usuarioac->email = $request->input('Correo');
                    $usuarioac->save();

                    return response()->json([
                        'mensaje'			=> "Correo Actualizado Exitosamente",
                        'titulo'			=> "Success",
                        'tipoMensaje'		=> "success",
                        'botonConfirmacion'	=> "ok",
                        'Usuario'           => $usuarioac
                    ]);

                }
                else{
                    return response()->json([
                        'mensaje'			=> "Contraseña Incorrecta",
                        'titulo'			=> "Error",
                        'tipoMensaje'		=> "error",
                        'botonConfirmacion'	=> "ok"
                    ]);
                }
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

        public function ActualizarInicioSesionContra(Request $request){
			try{

                $usuario = DB::table('users')
                            ->where('users.id',$request->input('IdUsuario'))
                            ->first();

                if(Hash::check($request->input('ActualContra'), $usuario->password)){

                    $usuarioac = Usuario::where('users.id', $usuario->id)->first();

                    //$usuarioac->email = $request->input('Correo');
                    $usuarioac->password = Hash::make($request->input('NuevaContra'));
                    $usuarioac->save();

                    return response()->json([
                        'mensaje'			=> "Contraseña Actualizada Exitosamente",
                        'titulo'			=> "Success",
                        'tipoMensaje'		=> "success",
                        'botonConfirmacion'	=> "ok",
                        'Usuario'           => $usuarioac
                    ]);

                }
                else{
                    return response()->json([
                        'mensaje'			=> "Contraseña Actual Incorrecta",
                        'titulo'			=> "Error",
                        'tipoMensaje'		=> "error",
                        'botonConfirmacion'	=> "ok"
                    ]);
                }
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

	// 	public function EditarUsuario(Request $request){
	// 		try{
	// 			$iduser=$request->input('idusuario');
	// 			$user=$request->input('usuario');
	// 			$ci=$request->input('ci');
	//             $nit=$request->input('nit');
	//             $nombres=$request->input('Nombre');
	//             $apellidos=$request->input('Apellido');
	//             $email=$request->input('Correoper');
	//             $celular=$request->input('celular');
	//             $telefono=$request->input('Telefono');
	//             $direccion=$request->input('direccion');
	//             $fecnac=$request->input('fecnac');
	//             $cargo=$request->input('Cargo');
	//             $password=$request->input('Password');
	//             $tipo=$request->input('TipoUsuario');
	//             $empresa=$request->input('Empresa');
	//             $sucursal=$request->input('Sucursal');


	// 			$empresas = DB::table('empresa')
	//                       ->where('empresa.estado','0')
	//                       ->get();
	//             $usuario=DB::table('users')
	//                         ->where('users.id',$request->input('idusuario'))
	//                         ->first();
	//             if(strtolower($usuario->name)==strtolower($request->input('usuario'))){
	//             }else{
	//             	$nombre = DB::table('users')
	//                             ->where(strtolower('users.name'),strtolower($request->input('usuario')))
	//                             ->first();
	//                 if($nombre!=null){
	//             	return response()->json([
	// 					'mensaje'			=> "Ya existe un usuario con este nombre",
	// 					'titulo'			=> "Error",
	// 					'tipoMensaje'		=> "error",
	// 					'botonConfirmacion'	=> "ok"
	// 				]);
	//             }
	//             }
	//             if(strtolower($usuario->email)==strtolower($request->input('Correo'))){
	//         	}
	//             else{
	//             	$nit = DB::table('users')
	//                             ->where(strtolower('users.email'),strtolower($request->input('Correo')))
	//                             ->first();
	//                 if($nit!=null){
	//             	return response()->json([
	// 					'mensaje'			=> "Ya existe un usuario con este correo",
	// 					'titulo'			=> "Error",
	// 					'tipoMensaje'		=> "error",
	// 					'botonConfirmacion'	=> "ok"
	// 				]);
	//             }
	//             }
	//             $usuarioac=Usuario::where('users.id', $iduser)
	// 								->first();
	//             //Persona
	//                 $persona=null;
    // 	    		$persona = persona::find($usuarioac->idpersona);
    // 	    		$compci=self::comprobardata($ci,$nit,$email,$persona->id);
    // 	    		if($compci!=100){
    // 	    			return response()->json([
	// 						'mensaje'			=> $compci,
	// 						'titulo'			=> "error",
	// 						'tipoMensaje'		=> "error",
	// 						'botonConfirmacion'	=> "ok"
	// 					]);
    // 	    		}else{
    // 	    			$persona = self::actualizarpersona($persona->id,$nombres,$apellidos,$ci,$nit,$email,$telefono,$celular,$direccion,$fecnac);
    // 	    		}
	// 	    	//Usuario
	// 				$usuarioac->name		    = $request->input('usuario');
	// 				$usuarioac->nombre			= $request->input('Nombre');
	// 				$usuarioac->apellido		= $request->input('Apellido');
	// 				$usuarioac->telefono		= $request->input('Telefono');
	// 				$usuarioac->cargo		    = $request->input('Cargo');
	// 				$usuarioac->email		    = $request->input('Correo');
	// 				if($request->input('Empresa')!=0){
	// 					$usuarioac->idempresa	= $request->input('Empresa');
	// 				}else{
	// 					$usuarioac->idempresa   = NULL;
	// 				}

	// 				if($request->input('Sucursal')!=0){
	// 					$usuarioac->idsucursal	 = $request->input('Sucursal');
	// 				}else{
	// 					$usuarioac->idsucursal   = NULL;
	// 				}

	// 				$guardado = $usuarioac->save();

	// 			$persona=DB::table('persona')
	//                         ->where('persona.id',$usuarioac->idpersona)
	//                         ->first();

	// 			if($guardado){
	// 				return response()->json([
	// 					'mensaje'			=> "Usuario Actualizado Exitosamente",
	// 					'titulo'			=> "Success",
	// 					'tipoMensaje'		=> "success",
	// 					'botonConfirmacion'	=> "ok",
	// 					'Usuario'           => $usuarioac,
	// 					'Persona'           => $persona,
	// 					'Empresas'          => $empresas
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

	// 	public function EditarContrasenia(Request $request){
	// 		try{
	// 			$empresas = DB::table('empresa')
	//                       ->where('empresa.estado','0')
	//                       ->get();
	//             $usuario=DB::table('users')
	//                         ->where('users.id',$request->input('idusuario'))
	//                         ->first();
	//             if(\Hash::check($request->input('password'), $usuario->password)){
	//             	$usuarioac=Usuario::where('users.id', $request->input('idusuario'))
	// 							->first();
	// 				$usuarioac->password	= \Hash::make($request->input('newpassword'));

	// 				$guardado = $usuarioac->save();

	// 				if($guardado){
	// 					return response()->json([
	// 						'mensaje'			=> "Usuario Actualizado Exitosamente",
	// 						'titulo'			=> "Success",
	// 						'tipoMensaje'		=> "success",
	// 						'botonConfirmacion'	=> "ok",
	// 						'Usuario'           => $usuarioac,
	// 						'Empresas'          => $empresas
	// 					]);
	// 				}
	//             }else{
	//             	return response()->json([
	// 				'mensaje'			=> "Contraseña equivocada",
	// 				'titulo'			=> "error",
	// 				'tipoMensaje'		=> "error",
	// 				'botonConfirmacion'	=> "ok"
	// 			]);
	//             }
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

		public function EliminarUsuario(Request $request){
			try{

                $SectoresSelect = $request->input(('IdRowSelected'));

                foreach ($SectoresSelect as $l) {

                    $usuario=usuario::find($l);

                    $usuario->estado=0;
                    $usuario->save();
                }

                $Mensaje = "Usuarios eliminadas Exitosamente";

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
					'mensaje'			=> "Error a intentar eliminar el usuario",
					'titulo'			=> "error",
					'tipoMensaje'		=> "error",
					'botonConfirmacion'	=> "ok"
				]);
			}
		}

	// 	public function reporteUsers($idempresa=0){
	// 		try{
	// 			$user = \Auth::user()->nombre . " " . \Auth::user()->apellido;
	// 			$hoy = Carbon::now('America/La_Paz')->format('d/m/Y');
	// 			$usuarios = DB::table('users')
	//                       ->where('users.estado','1')
	//                       ->get();
	// 			if($idempresa!=0){
	// 				$usuarios = DB::table('users')
	//                       ->where([["estado",1],["idempresa",$idempresa]])
	//                       ->get();
	// 			}

	//             foreach ($usuarios as &$us) {
	// 				if($us->TipoUsuario==1){
	// 					$us->TipoUsuario = "Administrador";
	// 				}
	// 				if($us->TipoUsuario==2){
	// 					$us->TipoUsuario = "Usuario";
	// 				}
	// 			}
	// 			$pdf = \PDF::loadView('auth.reporteusuarios',compact("usuarios","user","hoy"))
	// 		       ->setPaper('letter');
	// 		       //impresora magnetica fina "papel estrecho"
    //         	return $pdf->stream();
	// 		}
	// 		catch(Exception $e){
	//             dd($e);
	// 		}
	// 	}

	// 	public function downloadExcelusuarios($idempresa=0){
	// 		$usuarios = Usuario::select("name","nombre","apellido","telefono","email","TipoUsuario as tipous")
	//         					->where("estado",1)
	//         					->get();
	// 		if($idempresa!=0){
	// 			$usuarios = Usuario::select("name","nombre","apellido","telefono","email","TipoUsuario as tipous")
	//         					->where([["estado",1],["idempresa",$idempresa]])
	//         					->get();
	// 		}

	// 		foreach ($usuarios as &$us) {
	// 			if($us->tipous==1){
	// 				$us->tipous = "Administrador";
	// 			}
	// 			if($us->tipous==2){
	// 				$us->tipous = "Usuario";
	// 			}
	// 		}
	//         return Excel::create('Usuarios', function($excel) use ($usuarios) {
	//             $excel->sheet('Usuarios', function($sheet) use ($usuarios)
	//             {
	//                 $sheet->fromArray($usuarios);
	//             });
	//         })->download('xlsx');
	//     }

	// 	public function childView($childs){
	//         $html = '<ul>';
	//         foreach ($childs as $arr) {
	//         	$childs2 = DB::table('vistausuario')
	//     				  ->join('vista', 'vista.id','vistausuario.idvista')
	//                       ->where([['vista.idvistapadre',$arr->idvista],['vistausuario.idusuario', $arr->idusuario]])
	//                       ->select('vistausuario.id','vista.id as idvista','vista.vista','vistausuario.estado','vistausuario.tipoacceso','vista.idvistapadre','vistausuario.idusuario')
	//                       ->get();
	//             if(count($childs2)){
	//             	if($arr->estado==1){
	// 	        		$html .='<li id="t'.$arr->id . '"  class="leaf"><a class="jstree-clicked">' . $arr->vista . '<span>';
	// 	        		if($arr->tipoacceso==1){
	//             			$html .= '<i class="fa fa-star optionac checked font-green-sharp" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
	//             		}else{
	//             			$html .= '<i class="fa fa-star optionac" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
	//             		}
	//             		if($arr->tipoacceso==2){
	//             			$html .= '<i class="fa fa-star-half-full optionac checked font-green-sharp" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
	//             		}else{
	//             			$html .= '<i class="fa fa-star-half-full optionac" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
	//             		}
	//             		if($arr->tipoacceso==3){
	//             			$html .= '<i class="fa fa-eye optionac checked font-green-sharp" data-value="1" data-toggle="tooltip" title="Solo Consulta" ></i>';
	//             		}else{
	//             			$html .= '<i class="fa fa-eye optionac" data-value="1" data-toggle="tooltip" title="Solo Consulta" ></i>';
	//             		}
	//             		$html .='</span></a>';
	// 	        	}else{
	// 	        		$html .='<li id="t'.$arr->id . '"  class="leaf"><a>' . $arr->vista . '<span>';
	// 	        		if($arr->tipoacceso==1){
	//             			$html .= '<i class="fa fa-star optionac checked font-green-sharp" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
	//             		}else{
	//             			$html .= '<i class="fa fa-star optionac" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
	//             		}
	//             		if($arr->tipoacceso==2){
	//             			$html .= '<i class="fa fa-star-half-full optionac checked font-green-sharp" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
	//             		}else{
	//             			$html .= '<i class="fa fa-star-half-full optionac" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
	//             		}
	//             		if($arr->tipoacceso==3){
	//             			$html .= '<i class="fa fa-eye optionac checked font-green-sharp" data-value="1" data-toggle="tooltip" title="Solo Consulta" ></i>';
	//             		}else{
	//             			$html .= '<i class="fa fa-eye optionac" data-value="1" data-toggle="tooltip" title="Solo Consulta" ></i>';
	//             		}
	//             		$html .='</span></a>';
	// 	        	}
	//                 $html.= $this->childView($childs2);
	//             }else{
	//                 if($arr->estado==1){
	// 	        		$html .='<li id="t'.$arr->id . '"  class="leaf"><a class="jstree-clicked">' . $arr->vista . '<span>';
	// 	        		if($arr->tipoacceso==1){
	//             			$html .= '<i class="fa fa-star optionac checked font-green-sharp" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
	//             		}else{
	//             			$html .= '<i class="fa fa-star optionac" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
	//             		}
	//             		if($arr->tipoacceso==2){
	//             			$html .= '<i class="fa fa-star-half-full optionac checked font-green-sharp" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
	//             		}else{
	//             			$html .= '<i class="fa fa-star-half-full optionac" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
	//             		}
	//             		if($arr->tipoacceso==3){
	//             			$html .= '<i class="fa fa-eye optionac checked font-green-sharp" data-value="1" data-toggle="tooltip" title="Solo Consulta" ></i>';
	//             		}else{
	//             			$html .= '<i class="fa fa-eye optionac" data-value="1" data-toggle="tooltip" title="Solo Consulta" ></i>';
	//             		}
	//             		$html .='</span></a>';
	// 	        	}else{
	// 	        		$html .='<li id="t'.$arr->id . '"  class="leaf"><a>' . $arr->vista . '<span>';
	// 	        		if($arr->tipoacceso==1){
	//             			$html .= '<i class="fa fa-star optionac checked font-green-sharp" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
	//             		}else{
	//             			$html .= '<i class="fa fa-star optionac" data-value="1" data-toggle="tooltip" title="Acceso Total" ></i>';
	//             		}
	//             		if($arr->tipoacceso==2){
	//             			$html .= '<i class="fa fa-star-half-full optionac checked font-green-sharp" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
	//             		}else{
	//             			$html .= '<i class="fa fa-star-half-full optionac" data-value="2" data-toggle="tooltip" title="Acceso Parcial"></i>';
	//             		}
	//             		if($arr->tipoacceso==3){
	//             			$html .= '<i class="fa fa-eye optionac checked font-green-sharp" data-value="1" data-toggle="tooltip" title="Solo Consulta" ></i>';
	//             		}else{
	//             			$html .= '<i class="fa fa-eye optionac" data-value="1" data-toggle="tooltip" title="Solo Consulta" ></i>';
	//             		}
	//             		$html .='</span></a>';
	// 	        	}
	//                 $html .="</li>";
	//             }
	//         }
	//         $html .="</ul>";
	//         return $html;
	//     }

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

	// 	public function vaciarvistarusuario($idusuario){
	// 		try{
	// 			$Usuario = Usuario::find($idusuario);
	// 			$vistas = DB::table('vista')->get();
	// 			foreach ($vistas as &$v) {
	// 				$relacion = DB::table('vistausuario')
	// 							  ->where([
	// 							  		['vistausuario.idvista', $v->id],
	// 		                            ['vistausuario.idusuario', $Usuario->id]
	// 		                        ])
	// 		                      ->first();
	// 	        	$newrel = vistausuario::find($relacion->id);
	// 	        	$newrel->estado = 0;
	// 	   			$newrel->tipoacceso = 3;
	// 	        	$newrel->save();
	// 			}
	// 			return 200;
	// 		}
	// 		catch(Exception $e){
	// 			return -200;
	// 		}
	// 	}

	// 	public function actualizarpermisos(Request $request){
	// 		try{
	// 			$usuario = Usuario::find($request->input('idusuario'));
	// 			$tipo = $request->input('tipousuario');
	// 			if(!empty($tipo)){
	// 				$usuario->TipoUsuario = $tipo;
	// 			}
	// 			$usuario->save();
	// 			$vaciado = self::vaciarvistarusuario($usuario->id);
	// 			$seleccion = $request->input('seleccion');
	// 			if($seleccion!=""){
	// 				$seleccionados = explode(",", $seleccion);
	// 				foreach ($seleccionados as &$s) {
	// 					$pak = explode("/", $s);
	// 					$relacion = vistausuario::where('vistausuario.id',$pak[0])->first();
	// 					$relacion->estado = 1;
	// 					$relacion->tipoacceso = $pak[1];
	// 					$relacion->save();
	// 				}
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
	// 	}
	// //Personas
	// 	public function Traerpersona(Request $request){
	// 		try{
	// 			$ci = $request->input('ci');
	// 			$nit = $request->input('nit');
	// 			$email = $request->input('email');
	// 			$persona;
	// 			if(!empty($ci)){
	// 				$persona=DB::table('persona')
	//                         ->where('persona.ci',$ci)
	//                         ->first();
	// 			}
	// 			if(!empty($nit)){
	// 				$persona=DB::table('persona')
	//                         ->where('persona.nit',$nit)
	//                         ->first();
	// 			}
	// 			if(!empty($email)){
	// 				$persona=DB::table('persona')
	//                         ->where('persona.email',$email)
	//                         ->first();
	// 			}


	// 			return response()->json([
	// 				'mensaje'			=> "Traer Persona Exitoso",
	// 				'titulo'			=> "Success",
	// 				'tipoMensaje'		=> "success",
	// 				'botonConfirmacion'	=> "ok",
	// 				'Persona'           => $persona
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
			}catch(Throwable $e){
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
			}catch(Throwable $e){
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
			}catch(Throwable $e){
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
			}catch(Throwable $e){
				return -100;
			}
		}
}
