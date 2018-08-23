<?php

namespace Lupita\Http\Controllers;

use Illuminate\Http\Request;
use Lupita\Afiliaciondetalle;
use Lupita\Deudaempresa;
use Lupita\Prestamodetalle;
use Lupita\Ahorrodetalle;
use Lupita\Afiliacion;
use Lupita\Tasacambio;
use Lupita\Empresa;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Lupita\Prestamopausa;
use DB;

class DeudaempresaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index0()
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

    public function cronafdeudaemp(){ //cronafdeudaemp
      $today = Carbon::now()->format('Y-m-d').'%';
      $now = \Carbon\Carbon::now();
      $dia = date("t"); // se obtiene el corriente dia
      //dd($dia);

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

      if($dia == 31 || $dia == 29){
        $today2 = explode('-', $today);
        if($dia == 31){
          $today2[2] = '30%';
        }elseif($dia == 29){ // febrero año bisiesto
          $today2[2] = '28%';
        }
        $today2 = implode('-', $today2);
      }

      $prestamodetalle = Prestamodetalle::where('created_at', 'like', $today2)->get(); //obtiene los pagos de prestamo que se hicieron hoy
      //dd($prestamodetalle);
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

    public function proyplanilla(Request $request, $id){

      //Busca las afiliaciones de la empresa que aun no han sido pagadas
    /*  $afiliacion = Afiliacion::where('pagado', 0)->with(['socio' => function($query) use ($id)
      {
         $query->where('empresa_id', $id);
      }])->get(); */
      $today = Carbon::now()->format('Y-m-d'); // fecha de hoy
      $dia = date("d"); // se obtiene el corriente dia
      $lastday = date('t',strtotime('today'));
    //  dd($dia);

      // la fecha de la proyeccion
      $today = explode('-', $today);
      if($dia < 15){
        $today[2] = '15';
      }else { // febrero año bisiesto
        $today[2] = $lastday;
      }
      $today = implode('-', $today);

      $tasac = Tasacambio::where('activo', 1)->value('valor'); // tasa de cambio
      $empresa = Empresa::find($id);

      $deudaemp = DB::table('socios')
      ->where('socios.empresa_id', '=', $id)
      ->leftjoin('afiliacions', function ($join) {
         $join->on('afiliacions.socio_id', '=', 'socios.id')
         ->where('afiliacions.pagado', '=', 0);
      })
     ->join('afiliacioncatalogos', 'afiliacioncatalogos.id', '=', 'afiliacions.afiliacioncatalogo_id', 'left outer')
     ->leftjoin('ahorros', function ($join) {
         $join->on('ahorros.socio_id', '=', 'socios.id')
         ->where('ahorros.pausada', '=', 0)
         ->where('ahorros.activo', '=', 1);
      })
      ->leftjoin('prestamos', function ($join) {
          $join->on('prestamos.socio_id', '=', 'socios.id')
          ->where('prestamos.pagado', '=', 0);
      })
      ->select('socios.id', 'socios.nombres', 'socios.apellidos',
       'afiliacioncatalogos.valor as afiliacion', 'ahorros.dolar', 'ahorros.dia15', 'ahorros.dia30',
       'prestamos.cuota', 'prestamos.mensual', 'prestamos.pmensual', 'prestamos.id as pid',
       'prestamos.monto', 'prestamos.cantcuotas', 'prestamos.comision_id', 'prestamos.pausa')
      ->orderBy('socios.id', 'asc')
      ->get();
      //dd($deudaemp);
      $totalah = 0;  $totalaf = 0; $totalpr = 0; $totalt = 0; $cont = 0; $cons = 0;
      $totalin = 0; $totalcu = 0; $totalinc = 0; $totalprincipalc = 0;
      $totalcuotac = 0; $totalaf = 0; $totalsaldoprincipal = 0;


      foreach($deudaemp as $de){
        $cons = $cons + 1;
        // cuenta de ahorro
        if(!empty($de->dia15 || $de->dia30)){
          if($de->dolar == 0){ // es en cordobas
            $dia15 = number_format($de->dia15/$tasac, 2);
            $dia30 =  number_format($de->dia30/$tasac, 2);
          }else{
            $dia15 = $de->dia15;
            $dia30 = $de->dia30;
          }
          if($dia < 15){
            $ahorro = $dia15;
          }else{
            $ahorro = $dia30;
          }
        }else{
           $ahorro = 0;// no hay cuenta de ahorro
        }

        //prestamo
        //dd($de->pid);
        $ultimopago = Prestamodetalle::where('prestamo_id', $de->pid)->orderBy('id', 'desc')->first();

        if(empty($ultimopago)){ //si aun no se han hecho pagos al prestamo y no esta pausado
            if($de->comision_id != null){ // si hay comision
              $comision = Comision::where('id', $de->comision_id);
              $porcom = ($comision->valor)/100; //porcentaje de comision
              $comision = $de->monto * $porcom; //comision
            } else{
              $comision = 0;
            }
            $saldo = $de->monto + $comision; //aca se sumaba la comision
            $interes = number_format($interes = $saldo * 0.01, 2);
            $principal = $de->cuota - $interes;
            $saldoactual = $saldo - $principal;
            $numcuota = 1; $cont= $cont+1;
            $cuotafinal = 0;
        } else { // ya se han realizado pagos y no esta en pausa
            $cont = $cont+1;
            $numcuota = $ultimopago->numcuota+1;
            $interes = number_format($interes = $ultimopago->saldo * 0.01, 2);
            if($numcuota == $de->cantcuotas){ //si ya llego a su ultima cuota
                $principal = $ultimopago->saldo;
                $cuotafinal = 1;
             } else{
               $principal = $de->cuota - $interes;
               $cuotafinal = 0;
             }
            $saldo = $ultimopago->saldo;
            $saldoactual = $ultimopago->saldo - $principal;
       }

       if($de->pausa == 1) { // esta en pausa
         $prpausa = Prestamopausa::where('prestamo_id', $de->pid)->where('activo', 1)->orderBy('id', 'desc')->first();//busca el prestamo pausa
         if($prpausa->cobrointere == 0)
         {
           $interes = 0;
           $cuota = 0;
           if(empty($ultimopago)){// si no hay ultimo pago
             $saldo = $pr->monto;
             $numcuota = 0;
           } else {
           $saldo = $ultimopago->saldo;
           $numcuota = $ultimopago->numcuota;
          }

        } else{ // se cobra el interes
           $cuota = $interes;
           if(empty($ultimopago)){// si no hay ultimo pago
             $saldo = $pr->monto + $interes;
             $numcuota = 0;
           } else{
             $saldo = $ultimopago->saldo + $interes;
             $numcuota = $ultimopago->numcuota;
           }
         }
         $principal = 0;
       }

        if($de->mensual == 1 && $de->pausa == 0){ //mensual
          if(($dia < 15 && $de->pmensual == 15) || ($dia >= 15 && $de->pmensual == 30)){  // se cobran los 15
            $cuota = $de->cuota;
          }else{ // se cobran los 30
            $cuota = 0;
          }
        } elseif($de->mensual == 0 && $de->pausa == 0){ // quincenal o es 30
          $cuota = $de->cuota;
        }

        $saldoprincipal = $saldo - $principal;

        $interesc = $interes * $tasac;
        $principalc = $principal * $tasac;
        $cuotac = $cuota * $tasac;

        $total = $cuotac + $de->afiliacion + $ahorro;

        if($de->cuota != null){
          $cuotap = $de->cantcuotas - $numcuota;
        } else{
          $cuotap = 0;
        }


        $deuda[] =  [
          'num' => $cons,
          'nombres' => $de->nombres,
          'apellidos' => $de->apellidos,
          'ahorro' => $ahorro,
          'interes' => $interes,
          'principal' => $principal,
          'cuota' => $cuota,
          'cantcuotas' => $de->cantcuotas,
          'numcuota' => $numcuota,
          'cuotap' => $cuotap,
          'interesc' => $interesc,
          'principalc' => $principalc,
          'cuotac' => $cuotac,
          'afiliacion' => $de->afiliacion,
          'saldoprincipal' => $saldoprincipal,
          'total' => $total,
        ];
        $totalah = $totalah + $ahorro;
        $totalin = $totalin + $interes;
        $totalpr = $totalpr + $principal;
        $totalcu = $totalcu + $cuota;
        $totalinc = $totalinc + $interesc;
        $totalprincipalc = $totalprincipalc + $principalc;
        $totalcuotac = $totalcuotac + $cuotac;
        $totalaf = $totalaf + $de->afiliacion;
        $totalsaldoprincipal = $totalsaldoprincipal + $saldoprincipal;
        $totalt = $total + $totalt;
      }

      $pdf = PDF::loadView('proyecciondetalle', ['deuda' => $deuda, 'empresa' => $empresa, 'today' => $today,
      'totalah' => $totalah, 'totalaf' => $totalaf, 'totalpr' => $totalpr, 'totalt' => $totalt, 'tasac' => $tasac,
      'totalin' => $totalin, 'totalcu' => $totalcu, 'totalprincipalc' => $totalprincipalc, 'totalinc' => $totalinc,
      'totalcuotac' => $totalcuotac, 'totalt' => $totalt, 'totalsaldoprincipal' => $totalsaldoprincipal ]);
      $pdf->setPaper('A4', 'landscape');
      return $pdf->stream('proyecciondetalle.pdf',array('Attachment'=>0));


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
