<?php

namespace Lupita\Http\Controllers;

use Illuminate\Http\Request;
use Lupita\Ahorrodetalle;
use Lupita\Ahorro;

class AhorrodetalleController extends Controller
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $ultimosaldo = Ahorrodetalle::where('ahorro_id', $request->ahorro_id)->orderBy('id', 'desc')->first(); // busca el ultimo saldo

        $ahorrodetalle = new Ahorrodetalle();
        $valor = $request->valor;
        if($request->concepto_id == 1){ // es deposito
            $request->merge(array('creditos' => $valor));
            $request->merge(array('rock_ck' => 'ROC N. ' . $request->rock_ck));
            $ahorro = Ahorro::where('id', '=', $request->ahorro_id)->value('depositoinicial');
            if(empty($ultimosaldo)){ // si aun no hay movimientos
                $saldofinal = $valor;
            }else{ // ya existian movimientos
                $saldofinal = $valor + $ultimosaldo->saldofinal;
            }
       } else { // es Retiro
         $request->merge(array('debitos' => $valor));
         $request->merge(array('rock_ck' => 'CK ' . $request->rock_ck));
         $saldofinal = $ultimosaldo->saldofinal - $valor;
         $request->merge(array('debitos' => $valor)); // debito obtiene el valor de debitos
      }

       $fecha = date('Y-m-d'); //fecha del dia
       $request->merge(array('fecha' => $fecha)); // agrega al request la fecha
       $request->merge(array('saldofinal' => $saldofinal)); // agrega al request el saldo final
       
       if($saldofinal >= 0){ // si el saldofinal es mayor o igual que cero
         $ahorrodetalle = Ahorrodetalle::create($request->all());
         $ahorrodetalle->save(); //el movimiento se guarda
         return redirect('ahorros')->with('msj', 'Datos guardados');
       } else {
           return back()->with('errormsj', 'Los datos no se guardaron');
       }
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
