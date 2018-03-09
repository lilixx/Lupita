<?php

namespace Lupita\Http\Controllers;

use Illuminate\Http\Request;
use Lupita\Plazofijo;
use Lupita\Formapagointere;
use Lupita\Frecpagointere;
use Lupita\Socio;
use Lupita\Beneficiario;
use Lupita\Ahorro;
use Lupita\Ahorrodetalle;
use Barryvdh\DomPDF\Facade as PDF;

class PlazofijoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plazofijo = Plazofijo::where('activo', '=', 1)->paginate(10);
        return view('plazofijos.plazofijo',compact('plazofijo'));
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $socio = Socio::where('activo', 1)->get();
        $formapago = Formapagointere::all();
        $frecuenciapago = Frecpagointere::all();
        return view('plazofijos.create',compact('socio', 'formapago', 'frecuenciapago'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      //  dd($request->all());
        //ID del socio
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

        //dd($request->all());
        $hoy = date('Y-m-d'); //fecha de hoy

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
        $interesven = $request->monto * $request->tasainteres / 100; // se calcula el interes de vencimiento

        // si son 6 meses
        if($cantdia > 180 && $cantdia < 186){
          $interes = $interesven / 2;
        } else {
          $interes = $interesven;
        }

        $montoven = $request->monto + $interes; // monto al vencimiento
        $retencion = $interes * 10 /100;
        $totalrec = $montoven - $retencion; //dd($totalrec);

        //agregar al request los datos faltantes
        $request->merge(array('vencimiento' => $fechafinal));
        $request->merge(array('socio_id' => $socio_id));
        $request->merge(array('diaplazo' => $cantdia));
        $request->merge(array('interesven' => $interes));
        $request->merge(array('ir' => $retencion));

        $plazofijo = Plazofijo::create($request->all()); //se crea el plazo fijo

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
