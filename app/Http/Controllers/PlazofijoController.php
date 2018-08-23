<?php

namespace Lupita\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Lupita\Plazofijo;
use Lupita\Plazofijodetalle;
use Lupita\Formapagointere;
use Lupita\Frecpagointere;
use Lupita\Socio;
use Lupita\Beneficiario;
use Lupita\Ahorro;
use Lupita\Ahorrodetalle;
use Lupita\Plazofijotasa;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;

class PlazofijoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pfmensual = Plazofijo::where('activo', '=', 1)->where('frecpagointere_id', '=', 1)->paginate(10);
        $pftrimestral = Plazofijo::where('activo', '=', 1)->where('frecpagointere_id', '=', 2)->paginate(10);
        $pfsemestral = Plazofijo::where('activo', '=', 1)->where('frecpagointere_id', '=', 3)->paginate(10);
        $pfanual = Plazofijo::where('activo', '=', 1)->where('frecpagointere_id', '=', 4)->paginate(10);
        return view('plazofijos.plazofijo',compact('pfmensual', 'pftrimestral', 'pfsemestral', 'pfanual'));
    }

    public function inactivo()
    {
        $plazof= Plazofijo::where('activo', 0)->get(); // obtiene todos los plazos fijos inactivos
        return view('plazofijos.inactivo',compact('plazof'));
    }

    public function certificadopdf(Request $request, $id)
    {
          $plazo = Plazofijo::find($id);
          $montven = 0;
          $totalrec = 0;

          $pdf = PDF::loadView('certificado', ['plazo' => $plazo, 'montven' => $montven, 'totalrec' => $totalrec]);
          $pdf->setPaper('letter', 'landscape');
          return $pdf->stream('certificado.pdf',array('Attachment'=>0));

    }

    /**Reporte de plazo fijo */

    public function repplazofijo(Request $request, $id)
    {
        $mov = Plazofijodetalle::where('plazofijo_id', $id)->orderBy('id', 'desc')->limit(20)->get(); //dd($mov);
        $mov = $mov->sortBy('id');//los ordena ascendentemente
        $plazofijo = Plazofijo::find($id);

        $pdf = PDF::loadView('repplazofijo', ['mov' => $mov, 'plazofijo' => $plazofijo]);
        return $pdf->stream('repplazofijo.pdf',array('Attachment'=>0));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $socio = Socio::where('activo', 1)->get();
        $tasa = Plazofijotasa::where('activo', 1)->get();
        $formapago = Formapagointere::all();
        $frecuenciapago = Frecpagointere::all();
        return view('plazofijos.create',compact('socio', 'formapago', 'frecuenciapago', 'tasa'));
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
      // Validaciones
       $validatedData = $request->validate([
           'nombresocio' => 'required',
           'numdoc' => 'required',
           'vencimiento' => 'required',
           'monto' => 'required|numeric|min:1000',
           'debitoch' => 'required',
           'frecpagointere_id' => 'required',
           'formapagointere_id' => 'required',
           'plazofijotasa_id' => 'required',

         ],

       [
         'nombresocio.required' => 'El campo nombres del socio es requerido',
         'numdoc.required' => 'El número del documento es requerido',
         'vencimiento.required' => 'El campo vencimiento es requerido',
         'monto.required' => 'El campo monto es requerido',
         'monto.min' => 'El monto debe ser igual o mayor a 1000',
         'monto.numeric' => 'el monto debe ser numerico',
         'debitoch.required' => 'El campo debito a la cuenta de ahorro es requerido',
         'frecpagointere_id.required' => 'El campo frecuencia de pago de interes es requerido',
         'formapagointere_id.required' => 'La forma de pago de interes es requerido',
         'plazofijotasa_id.required' => 'La tasa de interes es requerida',
       ]

      );

        $sc = $request->nombresocio;
        $socio_id = filter_var($sc, FILTER_SANITIZE_NUMBER_INT); //obtiene el id del socio

       //Verifica que hay cuenta de ahorro y si tiene fondos suficientes
        if($request->debitoch == 1){ //si el monto saldra de la cuenta de ahorro
           $ahorro =  Ahorro::where('socio_id', $socio_id)->count(); //busca si hay ahorros asociados al socio
           if(!empty($ahorro)){ // si hay ahorros
              $idahorro = Ahorro::where('socio_id', $socio_id)->value('id'); // obtiene el id del ahorro
              $ahorrodetalle =  Ahorrodetalle::where('ahorro_id', $idahorro)->count();
              if(empty($ahorrodetalle)){  // si no hay ahorros detalle
                return back()->with('errormsj', 'Los datos no se guardaron');
              } else { // hay ahorro-detalles
                $ultimosaldo = Ahorrodetalle::where('ahorro_id', $idahorro)->orderBy('id', 'desc')->first();//busca el ultimo saldo
                if($ultimosaldo->saldofinal <= $request->monto){ //si el saldo es menor al monto
                  return back()->with('errormsj', 'Los datos no se guardaron');
                }
              }
           } else{ //no hay ahorros
             return back()->with('errormsj', 'Los datos no se guardaron');
           }
        }

        //forma de pago a cuenta de ahorro y no tiene cuenta
        if($request->formapagointere_id == 1){
          $ahorro =  Ahorro::where('socio_id', $socio_id)->count();
          if(empty($ahorro)){ // si no hay ahorros
            return back()->with('errormsj', 'Los datos no se guardaron');
          }
        }

        $hoy = date('Y-m-d'); //fecha de hoy
        $lastday = date('Y-m-t', strtotime($hoy)); // ultimo dia del mes

        if($hoy == $lastday){ // si hoy es el ultimo dia del mes
          $hoy = strtotime('+1 day', strtotime($hoy)); // se suma 1 dia
          $hoy = date('Y-m-d', $hoy);
        }

        //change created_at
        $create = Carbon::parse($hoy);
        $create = $create->format('Y-m-d H:i:s');

        //  dd($create);


        $vencimiento = $request->vencimiento;

        //se calcula la fecha final
        if($vencimiento == 'semestral'){ //si el vencimiento es de 6 meses
          $fechafinal = date('Y-m-d', strtotime($hoy. ' + 183 days')); //se suman 183 dias
        } elseif($vencimiento == 'anual'){ // si el vencimiento es de un año
          $fechafinal = date('Y-m-d', strtotime($hoy. ' + 365 days')); // se suman 365 dias
        }

        if(date('N', strtotime($fechafinal)) == 6){ // si la fecha de vencimiento es sabado se suman 2 dias
          $fechafinal = date('Y-m-d', strtotime($fechafinal. ' + 2 days'));
        } elseif (date('N', strtotime($fechafinal)) > 6){ // si la fecha de vencimiento es domingo se suma un dia
          $fechafinal = date('Y-m-d', strtotime($fechafinal. ' + 1 days'));
        }

        $fechafinal = date_create($fechafinal); // se pasa a formato date

        $hoy = date_create($hoy);
        $interval = date_diff($hoy, $fechafinal);
        $cantdia = $interval->format('%a'); // se obtiene la cantidad de dias

        //$interesven = $request->monto * $request->tasainteres / 100; // se calcula el interes de vencimiento

        /* nuevo codigo de cal interes */

         if($request->frecpagointere_id == 1){ //si es mensual
            $diacp = 30;
            $frec = 12;
         } else if($request->frecpagointere_id == 2){ // si es trimestral
            $diacp = 90;
            $frec = 4;
         } else if($request->frecpagointere_id == 3){ // si es semestral
            $diacp = 180;
            $frec = 2;
         } else if($request->frecpagointere_id == 4){ // si es anual
            $diacp = 360;
            $frec = 1;
         }

         $idtasa = $request->plazofijotasa_id;
         $tasainteres = Plazofijotasa::find($idtasa)->value('valor');

         $tasaint = $tasainteres /100;
         dd($tasaint);

         $tasaintper =  (1 + $tasaint) ** ($diacp/360)-1; //se calcula la tasa de interes periodica
         $tasanominal = $tasaintper * $frec;  //se calcula la tasa nominal
         $interesven = number_format($request->monto * $tasa / $diacp * $diacp, 2);  //se calcula el interesven
         dd($interesven);
        /* fin del nuevo cod. */

        // si son 6 meses
        if($cantdia > 180 && $cantdia < 186){
          $interes = $interesven / 2;
        } else {
          $interes = $interesven;
        }

        $montoven = $request->monto + $interes; // monto al vencimiento
        $retencion = number_format($interes * 10 /100, 2);
        $totalrec = $montoven - $retencion; //dd($totalrec);

        $plazofijo = new Plazofijo();
        $plazofijo->created_at = $create;
        $plazofijo->vencimiento = $fechafinal;
        $plazofijo->socio_id = $socio_id;
        $plazofijo->diaplazo = $cantdia;
        $plazofijo->intereses = $interes;
        $plazofijo->ir = $retencion;
        $plazofijo->numdoc = $request->numdoc;
        $plazofijo->monto = $request->monto;
        $plazofijo->debitoch = $request->debitoch;
        $plazofijo->plazofijotasa_id = $request->plazofijotasa_id ;
      //  $plazofijo->rock_ck = $request->rock_ck;
        $plazofijo->frecpagointere_id = $request->frecpagointere_id;
        $plazofijo->formapagointere_id = $request->formapagointere_id;

        dd($plazofijo);

        $plazofijo->save();

      //  date_create($hoy);

        //dd($request->all());

        //$plazofijo = Plazofijo::create($request->all()); //se crea el plazo fijo

        //si el monto sale de la cuenta de ahorro
        if($request->debitoch == 1){
          $ahorrodet = new Ahorrodetalle();
          $ahorrodet->ahorro_id = $idahorro;
          $ahorrodet->concepto_id = 5;
          $ahorrodet->rock_ck = 'Nota de Debito ' . $request->rock_ck;
          $ahorrodet->debitos = $request->monto;
          $ahorrodet->saldofinal = $ultimosaldo->saldofinal - $request->monto;
          $ahorrodet->fecha = $hoy;
          $ahorrodet->save(); //se guarda el movimiento en la cuenta de ahorro
        }


        foreach($request->nombreben as $key2=> $m) //recorre todos los beneficiarios
        {
           if($request->nombreben[$key2] != null){ // si no estan en null guarda los beneficiarios

               $beneficiario = new Beneficiario();
               $beneficiario->nombres = $request->nombreben[$key2];
               $beneficiario->apellidos = $request->apellidoben[$key2];
               $beneficiario->num_cedula = $request->cedulaben[$key2];
               $beneficiario->parentesco = $request->parentescoben[$key2];
               $beneficiario->telefono = $request->telefonoben[$key2];
               $porcentaje = $request->porcentajema[$key2];

               $plazofijo->beneficiarios()->save($beneficiario, ['porcentaje' => $porcentaje]);

            } elseif($request->beneficiario[$key2] != null && $request->nombreben[$key2] == null){

              $ben = $request->beneficiario[$key2];
              $beneficiario_id = filter_var($ben, FILTER_SANITIZE_NUMBER_INT); //obtiene el id del beneficiario
              //$plazofijo->beneficiarios()->save($beneficiario_id);

              $containers2[] =  [
                           'beneficiario_id'=>$beneficiario_id,
                           'plazofijo_id'=>$plazofijo->id,
                           'porcentaje'=>$request->porcentajeaut[$key2],
              ];

            }
        }

        if(!empty($containers2)){
          $plazofijo->beneficiarios()->attach($containers2);
        }

        if($plazofijo->save()){
           return redirect('plazofijo')->with('msj', 'Datos guardados');
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

    /** Terminar Certificado de plazo fijo antes del vencimiento **/

    public function finalizebefore($id){
      $nominal = Input::has('nominal') ? Input::get('nominal') : null;
      $interes = 0;

      $plazof = Plazofijo::find($id);
      $hoy = date('Y-m-d'); //fecha de hoy
      $hoy = date_create($hoy);

      $ultimopago = Plazofijodetalle::where('plazofijo_id', $id)->orderBy('id', 'desc')->first();

      if(empty($ultimopago)){ // si no se han realizado pagos
        $inicio = $plazof->created_at->format('Y-m-d');
        $inicio = date_create($inicio);
        $numero = 1;
      } else { // ya se han realizado pagos
        $inicio = $ultimopago->created_at->format('Y-m-d');
        //dd($hoy);
        $inicio = date_create($inicio);
        $numero = $ultimopago->numero + 1;
      }

      $interval = date_diff($hoy, $inicio);
      $cantdia = $interval->format('%a');

      $tasaint = $plazof->plazofijotasa->valor /100; //tasa de interes
      $tasaintper =  number_format((1 + $tasaint) ** (360/360)-1, 2); //se calcula la tasa de interes periodica anual
      $intereses = number_format(($tasaintper / 365) * $plazof->monto * $cantdia, 2); //se calcula el interes diario y luego el interes

      $retencion = number_format($intereses * 10 /100, 2);

      $total = $intereses - $retencion;

      if($plazof->activo == 1){
        return view('plazofijos.finalizebefore',compact('nominal', 'plazof', 'cantdia', 'intereses', 'retencion', 'numero', 'total'));
      } else {
         abort(404);
      }
    }

    /* Funcion para indicar que se emitio un cheque, marcar como pagado */
    public function payck($id) {
        $plazofijodet = Plazofijodetalle::find($id);
        return view('plazofijos.payck',compact('plazofijodet'));

    }

    public function savepayck(Request $request, $id){
      $request->merge(array('pagado' => 1));
      $plazofijodet = Plazofijodetalle::find($id);
      $now = \Carbon\Carbon::now();
      $datetoday = $now->format('Y-m-d');

      if($plazofijodet->update($request->all())){
         if($plazofijodet->plazofijo->vencimiento <= $datetoday) { // si el vencimiento es menor o igual al dia de hoy
           $plazofijo = Plazofijo::find($plazofijodet->plazofijo_id);
           $idpl = $plazofijo->id; // id del plazo fijo
           $plazofdet = Plazofijodetalle::where('pagado', 0)->get()->where('plazofijo_id', $idpl); // se buscan los plazofijo detalle que no han sido pagados
           if(count($plazofdet) == 0){  // si ya todos estan pagados
             $plazofijo->activo=0; // Pasa a inactivo el certificado a plazo fijo
             $plazofijo->update();
           }
         }
         return redirect()->to("plazofijo")->with('msj', 'Datos guardados');
      } else {
         return back()->with('errormsj', 'Los datos no se guardaron');
      }

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
      //  $plazofijodetalle = new Plazofijodetalle();
        $request->merge(array('plazofijo_id' => $id));
        $request->merge(array('pagado' => 1));
        $plazofijodetalle = Plazofijodetalle::create($request->all()); // guarda el plazo fijo detalle

        $hoy = date('Y-m-d'); //fecha de hoy
        $hoy = date_create($hoy);
        //dd($hoy);
        $plazofijo = Plazofijo::find($id);

        //pagos realizados anteriormente
        $pagos = Plazofijodetalle::where('plazofijo_id', $id)->orderBy('id', 'desc')->get();
        $interes = 0;
        $ir = 0;

        if(count($pagos) == 0){ // no hubieron pagos
          $plazofijo->intereses = $request->interes;
          $plazofijo->ir = $request->ir;
          $plazofijo->diaplazo = $request->cantcuotas;

        } else { //hubieron pagos
            foreach($pagos as $pg){
              $interes = $pg->intereses + $interes;
              $ir = $pg->ir + $ir;
           }
           $plazofijo->intereses = $interes;
           $plazofijo->ir = $ir;

           $inicio = $plazofijo->created_at->format('Y-m-d');
           $inicio = date_create($inicio);
           $interval = date_diff($hoy, $inicio);
           $cantdia = $interval->format('%a');
           $plazofijo->diaplazo = $cantdia;
        }

        $plazofijo->pagadoantes = 1;//se marca como pagado antes de la fecha de vencimiento
        $plazofijo->activo = 0;
        $plazofijo->update(); // se actualiza con los valores que se han modificado

        return redirect()->to("plazofijo")->with('msj', 'Datos actualizados');
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
