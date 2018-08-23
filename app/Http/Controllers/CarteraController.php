<?php

namespace Lupita\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Lupita\Deudaempresa;
use Lupita\Cartera;

class CarteraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){

    }
    public function croncartera()//
    {
      $today = Carbon::now()->format('Y-m-d').'%'; 
      $now = \Carbon\Carbon::now();

      //Deuda empresa de hoy
      $deudaemp = Deudaempresa::where('created_at', 'like', $today)->orderBy('empresa_id', 'asc')->get();
      //dd($deudaemp);
      $idempresa = 0;
      $afiliacion = 0; $prestamo = 0; $interes = 0; $ahorro = 0; $total = 0; $principal = 0;

      $last = $deudaemp->last(); $lastid = $last->id; //obtengo el id del ultimo elemento del array

      foreach($deudaemp as $dp){

        if($idempresa == 0 || $idempresa == $dp->empresa_id){ // verifica que el id de la empresa es igual al anterior
          if($dp->afiliaciondetalle_id != null){ //si es afiliacion
            $afiliacion = $afiliacion + $dp->afiliaciondetalle->afiliacion->afiliacioncatalogo->valor;
          }else if($dp->prestamodetalle_id != null){ //si es prestamo
            $principal = $prestamo + $dp->prestamodetalle->abonoprincipal + $principal;
            $interes = $interes + $dp->prestamodetalle->intereses;
          }else if($dp->ahorrodetalle_id != null){ // si es ahorro
            $ahorro = $ahorro + $dp->ahorrodetalle->creditos;
          }
          if($idempresa == 0){
            $idempresa = $dp->empresa_id;
          }

        }if($idempresa != $dp->empresa_id || $lastid == $dp->id ){ // son diferentes o es el ultimo

          if($lastid == $dp->id && $afiliacion == 0 && $principal == 0 && $ahorro == 0){ // es el ultimo y solo fue un id empresa
            if($dp->afiliaciondetalle_id != null){
              $afiliacion = $dp->afiliaciondetalle->afiliacion->afiliacioncatalogo->valor;
            }else if($dp->prestamodetalle_id != null){
              $principal = $prestamo + $dp->prestamodetalle->abonoprincipal;
              $interes = $dp->prestamodetalle->intereses;
            }else if($dp->ahorrodetalle_id != null){
              $ahorro = $dp->ahorrodetalle->creditos;
            }
            $idempresa = $dp->empresa_id;
          }

          // pasa a cartera  el id empresa anterior con todos los datos recopilados
          $total = $ahorro + $afiliacion + $principal + $interes;
          $cartera[] =  [ // coloca en un arreglo la deuda de la empresa
            'ahorro' => $ahorro,
            'empresa_id' => $idempresa,
            'afiliacion' => $afiliacion,
            'principal' => $principal,
            'intereses' => $interes,
            'total' => $total,
            'created_at' => $now,
            'updated_at' => $now,
          ];

          if($lastid != $dp->id) { // si no es el ultimo elemento del arreglo
            $afiliacion = 0; $prestamo = 0; $interes = 0; $ahorro = 0; $principal = 0; // inicaliza las variables

            if($dp->afiliaciondetalle_id != null){
              $afiliacion = $afiliacion + $dp->afiliaciondetalle->afiliacion->afiliacioncatalogo->valor;
            }else if($dp->prestamodetalle_id != null){
              $principal = $prestamo + $dp->prestamodetalle->abonoprincipal;
              $interes = $interes + $dp->prestamodetalle->intereses;
            }else if($dp->ahorrodetalle_id != null){
              $ahorro = $ahorro + $dp->ahorrodetalle->creditos;
            }
         }
       }
        $idempresa = $dp->empresa_id;//captura el id de la empresa
      }
      Cartera::insert($cartera); //Guarda la cartera (Resumen de la deuda de la empresa)
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
