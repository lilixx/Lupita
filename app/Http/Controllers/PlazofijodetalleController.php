<?php

namespace Lupita\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Lupita\Plazofijo;
use Lupita\Plazofijodetalle;
use Lupita\Ahorrodetalle;

class PlazofijodetalleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index2()
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


    //Cron Plazo fijo  cron plazofijo mensual
    //cronplazofijomen

    public function index()    //cron plazo fijo mensual
    {
       $now = \Carbon\Carbon::now();
       $date = $now->format('Y-m');
       $datetoday = $now->format('Y-m-d'); //dd($datetoday);
       $plazof = Plazofijo::where('activo', 1)->get()->where('frecpagointere_id', 1)->where('vencimiento', '>', $datetoday); //busca los plazo fijos activos
       //dd($plazof);
       foreach($plazof as $pl){
         if($date == $pl->created_at->format('Y-m')){ //si fueron creados en el mes corriente
           $diah = $now->format('d'); // se obtiene el dia de hoy
           $diapl = $pl->created_at->format('d'); // se obtiene el dia en que fue creado el plazo
           $cantd = $diah - $diapl; // cantidad de dias entre ambas fechas
           if($pl->diaplazo < 200) { // plazo fijo de 6 meses
             $intd = ($pl->intereses / 6) / 30; // se obtiene el interes de cada dia
           } else { // es un plazo fijo anual
             $intd = ($pl->intereses / 12) / 30; // se obtiene el interes de cada dia
           }
           $intotal = number_format($intd * $cantd, 2); // interes desde que se creo hasta la fecha final del mes
           $numero = 1;
         } else { // no es el primer pago de intereses
           $ultimopago = Plazofijodetalle::where('plazofijo_id', $pl->id)->orderBy('id', 'desc')->first(); // obtener el ultimo pago del plazo fijo
           if($pl->diaplazo < 200) { // plazo fijo de 6 meses
             $intotal = number_format($pl->intereses / 6, 2);
           }else{ //plazofijo anual
             $intotal = number_format($pl->intereses / 12, 2);
           }
           $numero = $ultimopago->numero + 1;
         }
         if($pl->formapagointere_id == 1){ // si es acreditada a la cuenta de ahorro
           $pagado = 1;
         } else {
           $pagado = 0;
         }

         $ir = number_format($intotal * 10 /100, 3); //se calcula el IR
         $total = number_format($intotal - $ir, 2);

         $interes[] =  [ // se guardan en un array
           'plazofijo_id' => $pl->id,
           'numero' => $numero,
           'intereses' => $intotal,
           'ir' => $ir,
           'total' => $total,
           'pagado' => $pagado,
           'created_at' => $now,
           'updated_at' => $now,
         ];
         if($pl->formapagointere_id == 1){ // si es acreditada a la cuenta de ahorro
           $hoy = date('Y-m-d'); //fecha de hoy
           $cuentaid = $pl->socio->ahorro->id; // id de la cuenta de ahorro
           $lastmovah = Ahorrodetalle::where('ahorro_id', '=', $cuentaid)->orderBy('id', 'desc')->first();//ultimo mov de la cuenta
           $saldo = $lastmovah->saldofinal + $total;
           $cuentah[] =  [ // se guardan en un array
             'ahorro_id' => $cuentaid,
             'concepto_id' => 6,
             'debitos' => 0,
             'creditos' => $total,
             'saldofinal' => $saldo,
             'fecha' => $hoy,
             'created_at' => $now,
             'updated_at' => $now,
           ];
         }
       }  //dd($interes);
       Plazofijodetalle::insert($interes);

       if(!empty($cuentah)){ // si hubieron plazo fijos que deben acreditarse a la cuenta
         Ahorrodetalle::insert($cuentah);
       }

    }

    //Cron Plazo fijo  cron plazofijo mensual
    //cronplazofijomenvecimiento

    public function cronplazofijomenvecimiento()    //cron plazo fijo mensual vencimiento
    {
       $now = \Carbon\Carbon::now();
       $date = $now->format('Y-m');
       $datetoday = $now->format('Y-m-d'); //dd($datetoday);

       $plazof = Plazofijo::where('activo', 1)->get()->where('frecpagointere_id', 1)
       ->where('vencimiento', '=', $datetoday); //busca los plazo fijos activos, con cargo mensuales y que se vencen el dia de hoy
       //dd($plazof);
       $datetoday = date_create($datetoday);
       if(!empty($plazof)){
         foreach($plazof as $pl){

             $ultimopago = Plazofijodetalle::where('plazofijo_id', $pl->id)->orderBy('id', 'desc')->first();
             $numero = $ultimopago->numero + 1;
             $datelastpay = $ultimopago->created_at->format('Y-m-d');
             $datelastpay = date_create($datelastpay);
             $interval = date_diff($datetoday, $datelastpay);// cantidad de dias entre ambas fechas

             $cantdia = $interval->format('%a');

             $tasaint = $pl->tasainteres /100; //tasa de interes

             $tasaintper =  number_format((1 + $tasaint) ** (360/360)-1, 2); //se calcula la tasa de interes periodica anual
             $intereses = number_format(($tasaintper / 365) * $pl->monto * $cantdia, 2); //se calcula el interes diario y luego el interes

             $retencion = number_format($intereses * 10 /100, 2);

             $total = $intereses - $retencion;

             if($pl->formapagointere_id == 1){ // si es acreditada a la cuenta de ahorro
               $pagado = 1;
             } else {
               $pagado = 0;
             }

             $interes[] =  [ // se guardan en un array
               'plazofijo_id' => $pl->id,
               'numero' => $numero,
               'intereses' => $intereses,
               'ir' => $retencion,
               'total' => $total,
               'pagado' => $pagado,
               'created_at' => $now,
               'updated_at' => $now,
             ];

           if($pl->formapagointere_id == 1){ // si es acreditada a la cuenta de ahorro
             $hoy = date('Y-m-d'); //fecha de hoy
             $cuentaid = $pl->socio->ahorro->id; // id de la cuenta de ahorro
             $lastmovah = Ahorrodetalle::where('ahorro_id', '=', $cuentaid)->orderBy('id', 'desc')->first();//ultimo mov de la cuenta
             $saldo = $lastmovah->saldofinal + $total;
             $cuentah[] =  [ // se guardan en un array
               'ahorro_id' => $cuentaid,
               'concepto_id' => 6,
               'debitos' => 0,
               'creditos' => $total,
               'saldofinal' => $saldo,
               'fecha' => $hoy,
               'created_at' => $now,
               'updated_at' => $now,
             ];
           }
           if($pl->formapagointere_id == 1 ){ // si es el ultimo pago y es acreditado a cuenta de ahorro
             $pl->activo=0; // Pasa a inactivo el certificado a plazo fijo
             $pl->update();
           }
         }
         //dd($plazof);
         Plazofijodetalle::insert($interes);

         if(!empty($cuentah)){ // si hubieron plazo fijos que deben acreditarse a la cuenta
           Ahorrodetalle::insert($cuentah);
         }

      }
    }

    //Cron Pago de Plazo fijos
//cronplazofijopay
    public function cronplazofijopay()
    {
      $now = \Carbon\Carbon::now();
      $datetoday = $now->format('Y-m-d'); //dd($datetoday);
      $plazof = Plazofijo::where('activo', 1)->get()->where('frecpagointere_id', '<>', 1)->where('vencimiento', '>=', $datetoday); //busca los plazo fijos activos
      //dd($plazof);
      foreach($plazof as $pf){
        $ultimopago = Plazofijodetalle::where('plazofijo_id', $pf->id)->orderBy('id', 'desc')->first();
        $ultimo = 0;
        // si es trimestral
         if($pf->frecpagointere_id == 2){

            if(empty($ultimopago)){ // si no se han hecho pagos
              $numero = 1;
              $diapl = $pf->created_at->format('Y-m-d'); // dia que se creo el plazo fijo
              $nextpay = $pf->created_at->addMonth(3)->format('Y-m-d'); // se calcula el siguiente dia de pago
            } else { // ya se han realizado pagos
               $numero = $ultimopago->numero + 1;
               // se calcula cuando sera el siguiente pago
               if($ultimopago->numero == 1){
                 $nextpay = $pf->created_at->addMonth(6)->format('Y-m-d');
               } else if ($ultimopago->numero == 2){
                 $nextpay = $pf->created_at->addMonth(9)->format('Y-m-d');
               } else if($ultimopago->numero == 3){
                 $nextpay = $pf->created_at->addMonth(12)->format('Y-m-d');
               }
            }
            if(($numero == 4 || ($pf->diaplazo < 200 && $pf == 2)) && $nextpay == $datetoday){
              $ultimo = 1;
            }
            $intotal = number_format($pf->intereses / 4, 2);

          }

          // si es semestral
          if($pf->frecpagointere_id == 3){
             if(empty($ultimopago)){ // si no se han hecho pagos
               $numero = 1;
               $diapl = $pf->created_at->format('Y-m-d'); // dia que se creo el plazo fijo
               $nextpay = $pf->created_at->addMonth(6)->format('Y-m-d'); // se calcula el siguiente dia de pago
               $ultimo = 0;
             } else { // ya se han realizado pagos
                $numero = $ultimopago->numero + 1;
                // se calcula cuando sera el siguiente pago
                  $nextpay = $pf->created_at->addMonth(12)->format('Y-m-d');
                }
             $intotal = number_format($pf->intereses / 2, 2);
             if(($numero == 2 || $pf->diaplazo < 200) && $nextpay == $datetoday){
               $ultimo = 1;
             }
          }

          // si es anual
          if($pf->frecpagointere_id == 4){
                 $numero = 1;
                 $nextpay = $pf->created_at->addMonth(12)->format('Y-m-d');
                 $intotal = $pf->intereses;
            if($nextpay == $datetoday){
                 $ultimo = 1;
            }
          }

          if($nextpay == $datetoday){ // si hoy es el dia de pago
            $ir = number_format($intotal * 10 /100, 3);
            $total = $intotal - $ir;
            if($pf->formapagointere_id == 1){ // si es acreditada a la cuenta de ahorro
              $pagado = 1;
            } else {
              $pagado = 0;
            }
            $interes[] =  [ // se guardan en un array
              'plazofijo_id' => $pf->id,
              'numero' => $numero,
              'intereses' => $intotal,
              'ir' => $ir,
              'total' => $total,
              'pagado' => $pagado,
              'created_at' => $now,
              'updated_at' => $now,
            ];
            if($pf->formapagointere_id == 1){ // si es acreditada a la cuenta de ahorro
              $hoy = date('Y-m-d'); //fecha de hoy
              $cuentaid = $pf->socio->ahorro->id; // id de la cuenta de ahorro
              $lastmovah = Ahorrodetalle::where('ahorro_id', '=', $cuentaid)->orderBy('id', 'desc')->first();//ultimo mov de la cuenta
              $saldo = $lastmovah->saldofinal + $total;
              $cuentah[] =  [ // se guardan en un array
                'ahorro_id' => $cuentaid,
                'concepto_id' => 6,
                'debitos' => 0,
                'creditos' => $total,
                'saldofinal' => $saldo,
                'fecha' => $hoy,
                'created_at' => $now,
                'updated_at' => $now,
              ];
            }
          }
          if($ultimo == 1 && $pf->formapagointere_id == 1 ){ // si es el ultimo pago y es acreditado a cuenta de ahorro
            $pf->activo=0; // Pasa a inactivo el certificado a plazo fijo
            $pf->update();
          }
        }

        //  dd($interes);
          Plazofijodetalle::insert($interes);

          if(!empty($cuentah)){ // si hubieron plazo fijos que deben acreditarse a la cuenta
            Ahorrodetalle::insert($cuentah);
          }
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
