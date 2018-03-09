<?php

namespace Lupita\Http\Controllers;

use Illuminate\Http\Request;
use Lupita\Socio;
use Lupita\Ahorro;
use Lupita\Ahorrodetalle;
use Lupita\Beneficiario;
use Lupita\Tasacambio;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade as PDF;

class AhorroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      /*  $ahorro = Ahorro::where('activo', '=', 1)->paginate(10);
        return view('ahorros.ahorro',compact('ahorro'));*/
        $lastdaym = date("Y-m-d", strtotime("last day of this month") ) ; //obtengo el ultimo dia del mes
        $lastmonth = date("Y-m-t", strtotime("last day of previous month"));
      //  $firstdaym = date("Y-m-d", strtotime("first day of this month") ) ;//obtengo el primer dia del mes

        //$ahorrodetalle = Ahorrodetalle::where('fecha', '>=', $lastmonth)
      //  ->where('fecha', '<=', $lastdaym)->get();

        $ahorro = Ahorro::where('activo', '=', 1)->get(); //dd($ahorro);

        return view('ahorros.ahorros',compact('ahorro'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function create()
    {
        $socio = Socio::where('activo', 1)->get();
        return view('ahorros.create',compact('socio'));
    }

    public function repch($id)
    {
        $ahorro = Ahorro::find($id);
        $ahorrodet = Ahorrodetalle::where('ahorro_id', '=', $id)->orderBy('id', 'desc')->limit(20)->get(); //obtiene los 20 ultimos ahorro detalles
        $ahorrodet = $ahorrodet->sortBy('id');//los ordena ascendentemente
        $pdf = PDF::loadView('repch', ['ahorrodet' => $ahorrodet, 'ahorro' => $ahorro]);
        return $pdf->stream('repch.pdf',array('Attachment'=>0));
    }

    public function cronahorrom() //
    {
      $hoy = date('Y-m-d'); //fecha de hoy
      $ahorro = Ahorro::where('activo', '=', 1)->where('dia30', '!=', 0)
      ->where('dia30', '!=', null)->where('fechainicio', '<=', $hoy)->get(); //busca los ahorros activos, dia30 diferente a 0 y que ya hayan iniciado o inicien hoy
       //dd($ahorro);
      $tasac = Tasacambio::where('activo', 1)->value('valor'); // tasa de cambio
      $now = \Carbon\Carbon::now();
      //dd($tasac);

      $lastmonth = date("Y-m-t", strtotime("last day of previous month")); //obtengo el mes anterior
      $lastdaym = date("Y-m-d", strtotime("last day of this month") ) ; //obtengo el ultimo dia del mes
      $firstdaym = date("Y-m-d", strtotime("first day of this month") ) ;//obtengo el primer dia del mes
      //dd($ahorro);
      foreach($ahorro as $ah){ //recorre todos los ahorros
          $id = $ah->id;
          $ultimomov = Ahorrodetalle::where('ahorro_id', '=', $id)->where('fecha', '=', $lastmonth)->orderBy('id', 'desc')->first(); //ultimo datos del mes anterior

          $movmesactual = Ahorrodetalle::where('ahorro_id', '=', $id)->where('fecha', '>=', $firstdaym)->where('fecha', '<=', $lastdaym)->get(); //mov del mes actualizados
          $lastmovmesactual = Ahorrodetalle::where('ahorro_id', '=', $id)->where('fecha', '>=', $firstdaym)->where('fecha', '<=', $lastdaym)->orderBy('id', 'desc')->first();//ultimo mov del mes actual
          $cantmovactual = Ahorrodetalle::where('ahorro_id', '=', $id)->where('fecha', '>=', $firstdaym)->where('fecha', '<=', $lastdaym)->count();//cant de mov del mes
          $cont = 1; $promedio = 0; $interes = 0; $final = 0; $retencion = 0; $lastmov = 0; $deposito = 0;

          foreach($movmesactual as $mov){ //recorre todos los movimientos del mes

             $fecha = $mov->fecha; //fecha del movimiento
             $fecha = Carbon::parse($fecha);

              if(empty($ultimomov)){    //cuenta nueva, no hay mov en el mes anterior
                if($cont == 1 && $cantmovactual > 1){ // hay mas de un mov en el mes
                  $saldofinalant = $mov->saldofinal;
                  $fechant = $mov->fecha;
                  $fechant = Carbon::parse($fechant); $cal = 0;
                } elseif($cont ==1 && $cantmovactual ==1){ // solo un mov en la cuenta nueva
                  $cal = 0;
                }
              } elseif($cont == 1 && !empty($ultimomov) && $cantmovactual >= 1){  //cuenta vieja y hay mas de un mov en el mes
                  $fechant = $ultimomov->fecha; //fecha del ultimo mov del mes anterior
                  $fechant = Carbon::parse($fechant);
                  $interval = $fecha->diff($fechant);
                  $cantd = $interval->format('%a');//dd($cantd);
                  $saldofinalant = $ultimomov->saldofinal;
                  $cal = $saldofinalant * 0.05/365*$cantd; //dd($cal);
                  $saldofinalant = $mov->saldofinal; //dd($cal);
                  $fechant = $mov->fecha;
                  $fechant = Carbon::parse($fechant);
              }

              if($cont >= 2){
                $interval = $fecha->diff($fechant);
                $cantd = $interval->format('%a');
                $cal = $saldofinalant * 0.05/365*$cantd;
                $fechant = $mov->fecha; //se guarda la fecha actual como fecha anterior
                $fechant = Carbon::parse($fechant);
                $saldofinalant = $mov->saldofinal; //se guarda el saldo como saldo anterior
              } elseif($cantmovactual == 1){ //solo hubo un movimiento
                $fechant =$mov->fecha;
                $fechant = Carbon::parse($fechant);
                $saldofinalant = $mov->saldofinal; //dd($saldofinalant);
              }
              if($cont == $cantmovactual){ //ultimo movimiento del mes
                $fechah =  Carbon::parse($hoy); //fecha de hoy
                $interval = $fechah->diff($fechant);
                $cantd = $interval->format('%a');
                $final = $saldofinalant * 0.05/365*$cantd; //dd($cal);
              }
              $interes = $cal + $interes;
              $cont = $cont + 1;


          } //dd($lastmovmesactual->saldofinal);

          $ultimomovah = Ahorrodetalle::where('ahorro_id', '=', $id)->orderBy('id', 'desc')->first(); // busca el ultimo movimiento
          //dd($ultimomovah);
          if(!empty($ultimomovah)){ // si existen movimientos en la cuenta
              if(!empty($movmesactual)) { // si hubieron movimientos en el mes
                $lastmov = $lastmovmesactual->saldofinal; //dd($lastmov);
                $interes = $interes + $final;
                $interes = number_format($interes, 2);
                $retencion = number_format($interes * 0.1, 2);
              }elseif(empty($movmesactual)) { //no hay mov en el mes actual
                   $lastmov = $ultimomovah->saldofinal;
                   if($ultimomovah->saldofinal > 0){ //comprueba que el saldo final no sea 0 para darle interes
                      $fechant = $ultimomovah->fecha;
                      $fechah =  Carbon::parse($hoy); //fecha de hoy
                      $fechant = Carbon::parse($fechant);
                      $interval = $fechah->diff($fechant);
                      $cantd = $interval->format('%a');
                      $interes = $ultimomovah->saldofinal * 0.05/365*$cantd;
                      $interes = number_format($interes, 2);
                      $retencion = number_format($interes * 0.1, 2);
                    }
              }
           }

           if($ah->pausada == 0){ // si no esta pausada
             $deposito = $ah->dia30;
             if($ah->dolar == 0){ //si el ahorro es en cordoba
               $deposito = number_format($deposito / $tasac, 2);
             }
           }  //dd($lastmov);

            $saldep= $lastmov + $deposito ; //saldo final del deposito
            $saldint = $saldep + $interes; // saldo final de interes
            $saldret = $saldint - $retencion; // saldo final de retencion

            $ahorrodet[] =  [ //deposito
              'ahorro_id' => $ah->id,
              'concepto_id' => 1,
              'rock_ck' => 'Planilla',
              'debitos' => 0,
              'creditos' => $deposito,
              'saldofinal' => $saldep,
              'fecha' => $hoy,
              'created_at' => $now,
              'updated_at' => $now,
            ];

            $ahorrodet[] =  [ //interes
              'ahorro_id' => $ah->id,
              'concepto_id' => 3,
              'rock_ck' => '',
              'debitos' => 0,
              'creditos' => $interes,
              'saldofinal' => $saldint,
              'fecha' => $hoy,
              'created_at' => $now,
              'updated_at' => $now,
            ];

            $ahorrodet[] =  [ //IR
              'ahorro_id' => $ah->id,
              'concepto_id' => 4,
              'rock_ck' => '',
              'debitos' => $retencion,
              'creditos' => 0,
              'saldofinal' => $saldret,
              'fecha' => $hoy,
              'created_at' => $now,
              'updated_at' => $now,
            ];


      } //dd($ahorrodet);

       Ahorrodetalle::insert($ahorrodet); // guarda en ahorro detalle

    }

    public function cronahorroq()
    {
      $hoy = date('Y-m-d'); //fecha de hoy
      $now = \Carbon\Carbon::now();
      $credito = 0;

      $ahorro = Ahorro::where('activo', '=', 1)->where('dia15', '!=', 0)
      ->where('dia15', '!=', null)->where('fechainicio', '<=', $hoy)->get(); //busca los ahorros activos, no pausados con deposito dia 15

      foreach($ahorro as $ah){
        $id = $ah->id;
        $lastmov = Ahorrodetalle::where('ahorro_id', '=', $id)->orderBy('id', 'desc')->first();//busca los movimientos
        if($ah->pausada == 0){
          $credito = $ah->dia15;
        }

        if(empty($lastmov)){//es una cuenta nueva
           $saldofinal = $credito;
        } else {
           $saldofinal = $credito + $lastmov->saldofinal;
        }

        $ahorrodet[] =  [ //IR
          'ahorro_id' => $ah->id,
          'concepto_id' => 1,
          'rock_ck' => 'Planilla',
          'creditos' => $credito,
          'saldofinal' => $saldofinal,
          'fecha' => $hoy,
          'created_at' => $now,
          'updated_at' => $now,
        ];
      }
       Ahorrodetalle::insert($ahorrodet); // guarda en ahorro detalle
    }

    public function movimiento($id)
    {
      //$socio = Socio::where('activo', 1)->get();
      //dd($socio);
      $ahorroid = $id; //dd($ahorroid);
      return view('ahorros.movimiento', compact('ahorroid'));
    }

    public function pausar(Request $request, $id)
    {
        $ahorro = Ahorro::find($id);
        $ahorro->pausada=1; // Pasa a pausado el ahorro
        $ahorro->update();
        return redirect('ahorros')->with('msj', 'Datos actualizados');
    }

    public function continuar(Request $request, $id)
    {
        $ahorro = Ahorro::find($id);
        $ahorro->pausada=0; // Quita la pausa
        $ahorro->update();
        return redirect('ahorros')->with('msj', 'Datos actualizados');
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());

        $sc = $request->nombresocio;
        $socio_id = filter_var($sc, FILTER_SANITIZE_NUMBER_INT); //obtiene el id del socio

        $ahorro = new Ahorro();
        $ahorro->socio_id = $socio_id;
        $ahorro->dolar = $request->dolar;
        $ahorro->fechainicio = $request->fechainicio;
        $ahorro->dia15 = $request->dia15;
        $ahorro->dia30 = $request->dia30;
        $ahorro->depositoinicial = $request->depositoinicial;
        $ahorro->dolar = $request->dolar;
        $ahorro->comentario = $request->comentario;

        if ($request->nombreben == null) { // el beneficiario ya existia
          $ben = $request->beneficiario;
          $beneficiario_id = filter_var($ben, FILTER_SANITIZE_NUMBER_INT); //obtiene el id del beneficiario

          $ahorro->beneficiario_id = $beneficiario_id;
          $ahorro->save(); //Guarda el ahorro

        } else { //el beneficiario no existia
            $beneficiario = new Beneficiario();
            $beneficiario->nombres = $request->nombreben;
            $beneficiario->apellidos = $request->apellidoben;
            $beneficiario->num_cedula = $request->cedulaben;
            $beneficiario->save(); //Guarda al beneficiario

            $beneficiario->ahorros()->save($ahorro); //guarda el ahorro

        }

        if($request->depositoinicial != null){
          $hoy = date('Y-m-d'); //fecha de hoy
          $ahorrodet = new Ahorrodetalle();
          $ahorrodet->ahorro_id = $ahorro->id;
          $ahorrodet->concepto_id = 1;
          $ahorrodet->rock_ck = 'ROC N. ' . $request->rock_ck;
          $ahorrodet->creditos = $request->depositoinicial;
          $ahorrodet->saldofinal = $request->depositoinicial;
          $ahorrodet->fecha = $hoy;
          $ahorrodet->save();
        }

        return redirect('ahorros')->with('msj', 'Datos guardados');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ahorro = Ahorro::find($id);
        return view('ahorros.show')
        ->with(['ahorro' => $ahorro]);
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
