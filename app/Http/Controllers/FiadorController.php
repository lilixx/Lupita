<?php

namespace Lupita\Http\Controllers;

use Illuminate\Http\Request;
use Lupita\Afiliacion;
use Lupita\Afiliaciondetalle;
use Lupita\Prestamo;
use Lupita\Prestamodetalle;
use Lupita\Ahorrodetalle;
use Lupita\Tasacambio;
use Lupita\Ahorro;
use DB;
use Carbon\Carbon;

class FiadorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $ahorro = Ahorro::where('activo', '=', 1)->where('dia15', '!=', 0)
      ->where('dia15', '!=', null)->where('pausada', '=', 0)->get(); //busca los ahorros activos, no pausados con deposito dia 15
      $hoy = date('Y-m-d'); //fecha de hoy
      $now = \Carbon\Carbon::now();

      foreach($ahorro as $ah){
        $id = $ah->id;
        $lastmov = Ahorrodetalle::where('ahorro_id', '=', $id)->orderBy('id', 'desc')->first();
        $saldofinal = $ah->dia15 + $lastmov->saldofinal;

        $ahorrodet[] =  [ //IR
          'ahorro_id' => $ah->id,
          'concepto_id' => 1,
          'rock_ck' => 'Planilla',
          'creditos' => $ah->dia15,
          'saldofinal' => $saldofinal,
          'fecha' => $hoy,
          'created_at' => $now,
          'updated_at' => $now,
        ];
      } dd($ahorrodet);
       //Ahorrodetalle::insert($ahorrodet); // guarda en ahorro detalle

    }

    public function crondepositopq()
    {
      $ahorro = Ahorro::where('activo', '=', 1)->where('dia15', '!=', 0)
      ->where('dia15', '!=', null)->where('pausada', '=', 1)->get();
      dd($ahorro);
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
