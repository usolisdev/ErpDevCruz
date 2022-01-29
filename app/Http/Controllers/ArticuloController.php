<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empresa;
use App\Gestion;
use App\Periodo;
use App\Reporte;
use App\Articulo;
use App\Categoria;
use App\Lote;
use App\Nota;
use DB;
use Carbon\Carbon;
use \Milon\Barcode\DNS2D;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class ArticuloController extends Controller
{
	public function larticulos($idempresa1){
    	try{
    		$idempresa=$idempresa1;
    		$empresa=Empresa::find($idempresa);
    		$EmpresaNombre = $empresa->Nombre;
    		$EmpresaSigla = $empresa->Sigla;
    		$articulos = DB::table('articulo')
    						->join('categoria', 'categoria.id','articulo.IdCategoria')
							->where('articulo.IdEmpresa',$idempresa1)
							->select('articulo.id', 'articulo.codigo','articulo.nombre','articulo.descripcion','articulo.cantidad','articulo.precioventa','articulo.preciointermedio', 'articulo.preciomayorista','articulo.demanda','articulo.tiempoespera','articulo.costoorden','costoinventario','articulo.puntonuevopedido', 'categoria.id as idcat', 'articulo.idcuenta', 'categoria.nombre as nombrecat','articulo.CodigoBuscar')
							->get();
            $categorias = DB::table('categoria')
							->where('categoria.IdEmpresa',$idempresa1)
							->get();
			$idusuario = \Auth::user()->id;
			
            return view('Articulos.articulos',compact('articulos','idempresa','EmpresaNombre','EmpresaSigla','categorias'));
    	}
    	catch(Exception $e){
           return $e;
    	}
    }
    public function guardarArticulo(Request $request){
    	try{
    		$idusuario = \Auth::user()->id;
    		$nombre = $request->input("Nombre");
    		$descripcion = $request->input("txtdes");
    		$precio = $request->input("txtprice");
            $preciointer = $request->input("txtpriceinter");
            $preciomay = $request->input("txtpricemay");
            $codebus = $request->input("txtcodebus");
    		// $demanda = $request->input("txtdem");
    		// $tiempoes = $request->input("txtfecha");
    		// $puntopedido = $request->input("txtpoint");
    		// $costoorden = $request->input("txtcosto");
    		$idcat = $request->input("idcat");
    		$idem = $request->input("idem");
            $hoy = Carbon::now('America/La_Paz');

            $Nserie=000;
            $articulos=DB::table('articulo')
                                ->leftjoin('categoria', 'categoria.id', 'articulo.IdCategoria')
                                ->where('articulo.IdCategoria',$idcat)
                                ->get();
            $Nserie = $Nserie + count($articulos) + 1;
            if($Nserie<10){
                $Nserie = '00' . $Nserie;
            }
            if($Nserie>10){
                $Nserie = '0' . $Nserie;
            }
            if($Nserie>99){
                $Nserie = '' . $Nserie;
            }
    		$articulo = new Articulo();
            $articulo->codigo= (Categoria::find($idcat)->codigo/1000) . ' ' . $Nserie;
    		$articulo->nombre=$nombre;
			$articulo->descripcion=$descripcion;
			$articulo->cantidad=0;
			$articulo->precioventa=$precio;
            $articulo->preciointermedio=$preciointer;
            $articulo->preciomayorista=$preciomay;
			$articulo->demanda=0;
			$articulo->tiempoespera=$hoy;
			$articulo->costoorden=0;
			$articulo->costoinventario=0;
			$articulo->puntonuevopedido=0;
            if($codebus==null || $codebus=='' || $codebus==' '){
                $articulo->CodigoBuscar= (Categoria::find($idcat)->codigo/1000) . ' ' . $Nserie;
            }else{
                $articulo->CodigoBuscar= $codebus;
            }
            
			$articulo->IdEmpresa=$idem;
			$articulo->IdUsuario=$idusuario;
			$articulo->IdCategoria=$idcat;
			$guardar = $articulo->save();
			if($guardar){
				return response()->json([
	                'mensaje'           => "Se guardo satisfactoriamente el Articulo",
	                'titulo'            => "Success",
	                'tipoMensaje'       => "success",
	                'botonConfirmacion' => "ok"
	            ]);
			}else{
				return response()->json([
	                'mensaje'           => "Error al intentar guardar el Articulo",
	                'titulo'            => "Error",
	                'tipoMensaje'       => "error",
	                'botonConfirmacion' => "ok"
	            ]);
			}
    	}
    	catch(Exception $e){
    		return response()->json([
                'mensaje'           => $e,
                'titulo'            => "Error",
                'tipoMensaje'       => "error",
                'botonConfirmacion' => "ok"
            ]);
    	}
    }
    public function editarArticulo(Request $request){
    	try{
    		$idusuario = \Auth::user()->id;
    		$Idart = $request->input("Idart");
    		$nombre = $request->input("Nombre");
    		$descripcion = $request->input("txtdes");
    		$precio = $request->input("txtprice");
            $preciointer = $request->input("txtpriceinter");
            $preciomay = $request->input("txtpricemay");
    		// $demanda = $request->input("txtdem");
    		// $tiempoes = $request->input("txtfecha");
    		// $puntopedido = $request->input("txtpoint");
    		// $costoorden = $request->input("txtcosto");
    		$idcat = $request->input("idcat");
            $hoy = Carbon::now('America/La_Paz');

    		$articulo = Articulo::find($Idart);
    		$articulo->nombre=$nombre;
			$articulo->descripcion=$descripcion;
			$articulo->precioventa=$precio;
            $articulo->preciointermedio=$preciointer;
            $articulo->preciomayorista=$preciomay;
			$articulo->demanda=0;
			$articulo->tiempoespera=$hoy;
			$articulo->costoorden=0;
			$articulo->puntonuevopedido=0;
			$articulo->IdCategoria=$idcat;
			$guardar = $articulo->save();
			if($guardar){
				return response()->json([
	                'mensaje'           => "Se edito satisfactoriamente el Articulo",
	                'titulo'            => "Success",
	                'tipoMensaje'       => "success",
	                'botonConfirmacion' => "ok"
	            ]);
			}else{
				return response()->json([
	                'mensaje'           => "Error al intentar editar el Articulo",
	                'titulo'            => "Error",
	                'tipoMensaje'       => "error",
	                'botonConfirmacion' => "ok"
	            ]);
			}
    	}
    	catch(Exception $e){
    		return response()->json([
                'mensaje'           => $e,
                'titulo'            => "Error",
                'tipoMensaje'       => "error",
                'botonConfirmacion' => "ok"
            ]);
    	}
    }
    public function eliminarArticulo(Request $request){
    	$id = $request->input('IdArticulo');
        try {
            $Lotes = Lote::where([
                ['IdArticulo', $id]
            ])->get();
            if(count($Lotes)>0){
                return response()->json([
                    'mensaje'           => "Tiene Lotes Relacionados",
                    'titulo'            => "Error",
                    'tipoMensaje'       => "error",
                    'botonConfirmacion' => "ok"
                ]);
            }else{
                DB::table('articulo')
                    ->where('articulo.id', $id)
                    ->delete();
                return response()->json([
                    'mensaje'           => "Articulo Eliminado Exitosamente",
                    'titulo'            => "Success",
                    'tipoMensaje'       => "success",
                    'botonConfirmacion' => "ok"
                ]);
            }
        } catch (QueryException $e) {
            return response()->json([
                'mensaje'           => "Error al tratar de eliminar este Articulo",
                'titulo'            => "Error",
                'tipoMensaje'       => "error",
                'botonConfirmacion' => "ok"
            ]);
        }
    }
    public function datosarticulo(Request $request){
    	try{
    		$Categorys = Categoria::where([
	            ['IdCategoriaPadre', null],
	            ['IdEmpresa', $idempresa ]
	        ])->get();
    	}
    	catch(Exception $e){
    		return response()->json([
                'mensaje'           => $e,
                'titulo'            => "Error",
                'tipoMensaje'       => "error",
                'botonConfirmacion' => "ok"
            ]);
    	}
    }
    public function listarlotes($idart, $idempresa1){
    	try{
    		$idempresa=$idempresa1;
    		$empresa=Empresa::find($idempresa);
    		
    		$EmpresaNombre = $empresa->Nombre;
    		$EmpresaSigla = $empresa->Sigla;
    		$art = Articulo::find($idart);
    		$articulo = $art->nombre;
            $Lotes = DB::table('lote')
                            ->join('nota', 'nota.id','lote.IdNota')
                            ->where('lote.IdArticulo',$idart)
                            ->select('lote.id','lote.Nrolote','lote.FechaIngreso','lote.FechaVencimiento','lote.Cantidad','lote.PrecioCompra','lote.Stock','nota.id as idnota', 'nota.Nronota as nnota')
                            ->get();
            
			$idusuario = \Auth::user()->id;
			
            return view('Lotes.lotes',compact('Lotes','idempresa','EmpresaNombre','EmpresaSigla','articulo'));
    	}
    	catch(Exception $e){
           return $e;
    	}
    }
}
