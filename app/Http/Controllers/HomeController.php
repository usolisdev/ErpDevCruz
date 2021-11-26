<?php

namespace App\Http\Controllers;

use DateTime;
use Throwable;
use App\Reporte;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $empresas = DB::table('empresa')
        //             ->where('empresa.estado','0')
        //             ->get();
        // $idusuario = Auth::user()->id;
        // $reporte = DB::table('reporte')
        //                 ->where('reporte.Tipo','empresa')
        //                 ->first();
        // $reporte = Reporte::find($reporte->id);
        // $reporte->IdUsuario = $idusuario;
        // $reporte->save();
        // $monedas = DB::table('moneda')->get();
        // $access = self::verificacion();
        // if($access=="none"){
        // Auth::logout();
        // $errors = [$this->username() => trans('auth.none')];
        // return redirect('/login')
        //             // ->withInput($request->only($this->username(), 'remember'))
        //             ->withErrors($errors);
        // }

        // if(Auth::user()->TipoUsuario==1){
        // return view('Empresas.empresas',compact('empresas','monedas'));
        // }else{

        // return redirect()->route('gotomenu', ['idempresa' => Auth::user()->idempresa]);
        // }
        return view('Empresas.empresas');
    }

    //utilitarios
    public function verificacion($vista=0){
        try{
          $idempresa = Auth::user()->idempresa;
          $TipoUsuario = Auth::user()->TipoUsuario;
          $iduser = Auth::user()->id;
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
        }catch(Throwable $e){
          return "none";
        }
    }
}
