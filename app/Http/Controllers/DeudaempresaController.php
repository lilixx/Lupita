<?php

namespace Lupita\Http\Controllers;

use Illuminate\Http\Request;
use Lupita\Afiliaciondetalle;
use Lupita\Deudaempresa;
use Lupita\Prestamodetalle;
use Lupita\Ahorrodetalle;
use Carbon\Carbon;

class DeudaempresaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

    public function cronafdeudaemp(){ //
      $today = Carbon::now()->format('Y-m-d').'%';
      $now = \Carbon\Carbon::now();

      //Deuda afiliaciones
      $afiliaciondetalle = Afiliaciondetalle::where('created_at', 'like', $today)->get(); //obtiene las cuotas de afiliaciones que se pagaron hoy
      foreach($afiliaciondetalle as $ad){
        $id = $ad->id;
        $empresaid =  $ad->afiliacion->socio->empresa->id;
          $deudaemp[] =  [
            'empresa_id' => $empresaid,
            'afiliaciondetalle_id' => $id,
            'prestamodetalle_id' => null,
            'ahorrodetalle_id' => null,
            'created_at' => $now,
            'updated_at' => $now,
          ];
      }
      //Deudaempresa::insert($deudaemp); // guarda en deudaempresas las cuotas de afiliaciones que se realizaron hoy

      //Deuda prestamo
      $prestamodetalle = Prestamodetalle::where('created_at', 'like', $today)->get(); //obtiene los pagos de prestamo que se hicieron hoy
      foreach($prestamodetalle as $pd){
        $idp = $pd->id;
        $empresaid =  $pd->prestamo->socio->empresa->id;
          $deudaemp[] =  [
            'empresa_id' => $empresaid,
            'afiliaciondetalle_id' => null,
            'prestamodetalle_id' => $idp,
            'ahorrodetalle_id' => null,
            'created_at' => $now,
            'updated_at' => $now,
          ];
      }

      //Deuda ahorro
      $ahorrodetalle = Ahorrodetalle::where('created_at', 'like', $today)->where('rock_ck', '=', 'planilla')->get(); //obtiene las cuotas de ahorro que se realizaron hoy
      foreach($ahorrodetalle as $ad){
        $ida = $ad->id;
        $empresaid =  $ad->ahorro->socio->empresa->id;
          $deudaemp[] =  [
            'empresa_id' => $empresaid,
            'afiliaciondetalle_id' => null,
            'prestamodetalle_id' => null,
            'ahorrodetalle_id' => $ida,
            'created_at' => $now,
            'updated_at' => $now,
          ];
      } //dd($deudaemp);

      Deudaempresa::insert($deudaemp); // guarda las deudaempresas de ahorro, prestamo y afiliacion

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
