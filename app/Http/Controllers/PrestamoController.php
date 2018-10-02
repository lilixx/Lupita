<?php

namespace Lupita\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Lupita\Prestamo;
use Lupita\Prestamodetalle;
use Lupita\Fiador;
use Lupita\Socio;
use Lupita\Empresa;
use Lupita\Tasacambio;
use Lupita\Comision;
use Lupita\Cooperativa;
use Lupita\Prestamopausa;
use Lupita\Cajachica;
use DB;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;

class PrestamoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

       $prestamo = Prestamo::where('activo', 1)->where('anticipo', 0)->paginate(10);

       //DB::table('prestamos')->where('activo', 0)->update(['activo'=>1, 'pagado'=>0]);

      return view('prestamos.prestamo',compact('prestamo'));

    }

    public function anticipoindex()
    {

       $anticipo = Prestamo::where('activo', 1)->where('anticipo', 1)->paginate(10);

       //DB::table('prestamos')->where('activo', 0)->update(['activo'=>1, 'pagado'=>0]);

      return view('prestamos.anticipo',compact('anticipo'));

    }

    //Cartera por empresa
    public function carteraemp()
    {
      $empresa = Empresa::get();
      return view('prestamos.carteraemp',compact('empresa'));
    }

    public function carteraempcon(Request $request)
    {
       $id = $request->empresa;
       $empresa = Empresa::find($id);

       $hoy = date('Y-m-d');
       $hoy = Carbon::parse($hoy);

       $prestamo = DB::table('prestamos')
      ->where('prestamos.activo', '=', 1)
      ->join('socios', 'socios.id', '=', 'prestamos.socio_id')
      ->join('empresas', 'empresas.id', '=', 'socios.empresa_id')
      ->where('empresas.id', '=', $id)
      ->select('prestamos.monto', 'prestamos.id','prestamos.vencimiento',
       'empresas.nombre', 'socios.nombres', 'socios.apellidos')->get();

       $c = 1;
       foreach($prestamo as $pr){
         $vencimiento = $pr->vencimiento;
         $vencimiento = Carbon::parse($vencimiento);
         $venc = $hoy->diff($vencimiento);
         $venc = $venc->format('%a');

         $cartera[] =  [ //cartera
           'numero' => $c,
           'nombre' => $pr->nombres,
           'apellido' => $pr->apellidos,
           'empresa' => $pr->nombre,
           'monto' => $pr->monto,
           'referencia' => $pr->id,
           'vencimiento' => $pr->vencimiento,
           'diasvencimiento' => $venc,
         ];
          $c= $c+1;
       }

       //dd($cartera);

       $pdf = PDF::loadView('repcartera', ['cartera' => $cartera]);
       return $pdf->stream('repcartera.pdf',array('Attachment'=>0));
    }

    public function pausa($id)
    {
        //dd($id);
        $prestamo = Prestamo::find($id);
        return view('prestamos.pausa')
        ->with(['edit' => true, 'prestamo' => $prestamo]);
    }

    public function pausar(Request $request, $id)
    {
        //dd($request->cobrointere);
        // Prestamo pausa
        $prestamop = new Prestamopausa();
        $prestamop->prestamo_id = $id;
        $prestamop->cobrointere = $request->cobrointere;
        $prestamop->save();

        //actualiza el prestamo a pausa
        $prestamo = Prestamo::find($id);
        $prestamo->pausa=1; // Pasa a pausado la cuenta de ahorro
        $prestamo->update();
        return redirect('prestamos')->with('msj', 'Datos actualizados');
    }

    public function continuar(Request $request, $id)
    {
        $prestamo = Prestamo::find($id);
        $prestamo->pausa=0; // Quita la pausa
        $ultimapausa = Prestamopausa::where('prestamo_id', $id)->orderBy('id', 'desc')->first();//busca la ultima pausa que se hizo
        $ultimapausa->activo=0;
        $ultimapausa->update();
        $prestamo->update();
        return redirect('prestamos')->with('msj', 'Datos actualizados');
    }

    // Reporte de Cartera //
    public function repcartera()
    {
        $hoy = date('Y-m-d');
        $hoy = Carbon::parse($hoy);

        $prestamo = Prestamo::where('activo', 1)->with('socio')->get()->sortBy(function($prestamo, $key)
        {
          return $prestamo->socio->empresa_id;
        });

        $c = 1;
        foreach($prestamo as $pr){
          $vencimiento = $pr->vencimiento;
          $vencimiento = Carbon::parse($vencimiento);
          $venc = $hoy->diff($vencimiento);
          $venc = $venc->format('%a');

          $cartera[] =  [ //cartera
            'numero' => $c,
            'nombre' => $pr->socio->nombres,
            'apellido' => $pr->socio->apellidos,
            'empresa' => $pr->socio->empresa->nombre,
            'monto' => $pr->monto,
            'referencia' => $pr->id,
            'vencimiento' => $pr->vencimiento,
            'diasvencimiento' => $venc,
          ];
           $c= $c+1;
        }

        $pdf = PDF::loadView('repcartera', ['cartera' => $cartera]);
        return $pdf->stream('repcartera.pdf',array('Attachment'=>0));

        //return view('prestamos.repcartera',compact('cartera'));
    }

    /*Prestamo anticipos*/
    //cronanticipo
    public function cronanticipo()    //
    {
        $now = \Carbon\Carbon::now();
        $prestamo = Prestamo::where('activo', 1)->where('anticipo', 1)->get(); //Busca los anticipos

        $cont = 0; $cuotafinal = 0; $pagos = [];
        foreach($prestamo as $pr){

         $id = $pr->id; // id del prestamo

          $ultimopago = Prestamodetalle::where('prestamo_id', $id)->orderBy('id', 'desc')->first(); // obtener el ultimo pago del prestamo

          if($pr->comision_id != null){
           $porcom = ($pr->comision->valor)/100; //porcentaje de comision
           $comision = $pr->monto * $porcom; //comision
         } else{
           $comision = 0;
         }

         //dd($ultimopago);

          if(empty($ultimopago)){ //si aun no se han hecho pagos al prestamo
            $hoy = date('Y-m-d'); //dd($pr->fechainicio);
            if($hoy >= $pr->fechainicio){ //si hoy es la fecha de inicio
              $saldo = $pr->monto + $comision;
              $numcuota = 1;
              if($numcuota == $pr->cantcuotas){ //si ya llego a su ultima cuota
                  $principal = $pr->monto;
                  $cuotafinal = 1;
                  $saldoactual = 0;
               } else {
                 $principal = $pr->cuota;
                 //$cuotafinal = 0;
                 $saldoactual = $saldo - $principal;
               }
             $cont = 1;
           }
          } else { // ya se han realizado pagos
              $cont = $cont+1;
              $numcuota = $ultimopago->numcuota+1;
              if($numcuota == $pr->cantcuotas){ //si ya llego a su ultima cuota
                  $principal = $ultimopago->saldo;
                  $cuotafinal = 1;
               } else{
                 $principal = $pr->cuota;
                // $cuotafinal = 0;
               }
              $saldo = $ultimopago->saldo - $principal;
              $saldoactual = $ultimopago->saldo - $principal;
        }

        /*Si esta en pausa */
        if($pr->pausa == 1){
          $prpausa = Prestamopausa::where('prestamo_id', $id)->where('activo', 1)->orderBy('id', 'desc')->first();//busca el prestamo pausa
          if($prpausa->cobrointere == 0)
          {
            $interes = 0;
            $saldoactual = $ultimopago->saldo;
            $numcuota = 0;
           }
           else{
            if(empty($ultimopago)){// si no hay ultimo pago
              $saldoactual = $pr->monto;
              $numcuota = 0;
            } else{
              $saldoactual = $ultimopago->saldo + $interes;
              $numcuota = 0;
            }
          }
          $principal = 0;
        }
        if($cont != 0){
          $pagos[] =  [
              'prestamo_id' => $pr->id,
              'numcuota' => $numcuota,
              //'saldo' => $saldo,
              'abonoprincipal' => $principal,
              'saldo' => $saldoactual,
              'created_at' => $now,
              'updated_at' => $now,
            ];
        }

        if($cuotafinal == 1){
           $prestamoupdate = Prestamo::find($id);
           $prestamoupdate->pagado=1; // Pasa a pagado el prestamo
           $prestamoupdate->activo=0; // pasa a inactivo el prestamo
           $prestamoupdate->update();
         }
       }
    //    dd($pagos);
        if(!empty($pagos)){
        //  dd($pagos);
          Prestamodetalle::insert($pagos);
        }
    }



    /*Prestamo quincenales*/
    //cronprestamoq
    public function cronprestamoq()    //
    {
        $now = \Carbon\Carbon::now();
        $prestamo = Prestamo::where('activo', 1)->where('mensual', 0)->get(); //Busca los prestamos que estan activos y su pago es quincenal
        //dd($prestamo);
        $tasac = Tasacambio::where('activo', 1)->value('id');
        $cont = 0;
        foreach($prestamo as $pr){
          $id = $pr->id; // id del prestamo


          $ultimopago = Prestamodetalle::where('prestamo_id', $id)->orderBy('id', 'desc')->first(); // obtener el ultimo pago del prestamo


          if($pr->comision_id != null){
           $porcom = ($pr->comision->valor)/100; //porcentaje de comision
           $comision = $pr->monto * $porcom; //comision
         } else{
           $comision = 0;
         }

          if(empty($ultimopago)){ //si aun no se han hecho pagos al prestamo
            $hoy = date('Y-m-d'); //dd($pr->fechainicio);
          //  if($hoy >= $pr->fechainicio){ //si hoy es la fecha de inicio
              $saldo = $pr->monto + $comision;
              $interes = number_format($interes = $saldo * 0.01, 2);
              $numcuota = 1; $cont= $cont+1;
              if($numcuota == $pr->cantcuotas){ //si ya llego a su ultima cuota
                  $principal = $pr->monto;
                  $cuotafinal = 1;
                  $saldoactual = 0;
               } else{
                 $principal = $pr->cuota - $interes;
                 $cuotafinal = 0;
                 $saldoactual = $saldo - $principal;
               }

          /*  } else{ // no es hoy la fecha de inicio
               $cont = 0;
            } */
          } else { // ya se han realizado pagos
              $cont = $cont+1;
              $numcuota = $ultimopago->numcuota+1;
              $interes = number_format($interes = $ultimopago->saldo * 0.01, 2);
              if($numcuota == $pr->cantcuotas){ //si ya llego a su ultima cuota
                  $principal = $ultimopago->saldo;
                  $cuotafinal = 1;
               } else{
                 $principal = $pr->cuota - $interes;
                 $cuotafinal = 0;
               }
              $saldo = $ultimopago->saldo - $principal;
              $saldoactual = $ultimopago->saldo - $principal;
        }

        /*Si esta en pausa */
        if($pr->pausa == 1){
          $prpausa = Prestamopausa::where('prestamo_id', $id)->where('activo', 1)->orderBy('id', 'desc')->first();//busca el prestamo pausa
          if($prpausa->cobrointere == 0)
          {
            $interes = 0;
            if(empty($ultimopago)){// si no hay ultimo pago
              $saldoactual = $pr->monto;
              $numcuota = 0;
            } else {
            $saldoactual = $ultimopago->saldo;
            $numcuota = 0;
           }

          } else{
            if(empty($ultimopago)){// si no hay ultimo pago
              $saldoactual = $pr->monto + $interes;
              $numcuota = 0;
            } else{
              $saldoactual = $ultimopago->saldo + $interes;
              $numcuota = 0;
            }
          }
          $principal = 0;
        }

         if($cont != 0){

          $pagos[] =  [
            'prestamo_id' => $pr->id,
            'tasacambio_id' => $tasac,
            'numcuota' => $numcuota,
            'abonoprincipal' => $principal,
            'intereses' => $interes,
            'saldo' => $saldoactual,
            'created_at' => $now,
            'updated_at' => $now,
          ];

         }

         if($cuotafinal == 1){
           $prestamoupdate = Prestamo::find($id);
           $prestamoupdate->pagado=1; // Pasa a pagado el prestamo
           $prestamoupdate->activo=0; // pasa a inactivo el prestamo
           $prestamoupdate->update();
         }

       } //dd($pagos);

        if(!empty($pagos)){
          //dd($pagos);
          Prestamodetalle::insert($pagos);
        }
    }

    /*Prestamo que se cobran mensualmente*/
    //cronprestamom
    public function cronprestamom() //
    {    //dd(date('d'));
        $now = \Carbon\Carbon::now();
        if(date('d') == 15){ // si es el dia 15
          $prestamo = Prestamo::where('activo', 1)->where('mensual', 1)->where('pmensual', 15)->get(); //Busca los prestamos que estan activos y su pago es quincenal
        } else{ //Busca los prestamos que estan activos y su pago es ultimo dia del mes
           $prestamo = Prestamo::where('activo', 1)->where('mensual', 1)->where('pmensual', 30)->get();
        }

        $tasac = Tasacambio::where('activo', 1)->value('id');
        $cont = 0;
        foreach($prestamo as $pr){
          $id = $pr->id; // id del prestamo
          $ultimopago = Prestamodetalle::where('prestamo_id', $id)->orderBy('id', 'desc')->first(); // obtener el ultimo pago del prestamo
          if($pr->comision_id != null){
           $porcom = ($pr->comision->valor)/100; //porcentaje de comision
           $comision = $pr->monto * $porcom; //comision
          } else {
           $comision = 0;
          }

          if(empty($ultimopago)){ //si aun no se han hecho pagos al prestamo
            $hoy = date('Y-m-d'); //dd($pr->fechainicio);
        //    if($hoy >= $pr->fechainicio){ //si hoy es la fecha de inicio
              //dd($pr->fechainicio);
              $saldo = $pr->monto + $comision; //saldo anterior
              $interes = number_format($interes = $saldo * 0.02, 2);
              //$principal = number_format($principal = $pr->cuota - $interes, 2);
              $principal = $pr->cuota - $interes;
              $saldoactual = $saldo - $principal;
              //dd($principal);
              $numcuota = 1; $cont= $cont+1;
              $cuotafinal = 0;
      /*      } else { // hoy no es la fecha de inicio
              $cont = 0;
            }*/
          } else {
              $cont = $cont+1;
              $numcuota = $ultimopago->numcuota+1;
              $interes = number_format($interes = $ultimopago->saldo * 0.02, 2);
              if($numcuota == $pr->cantcuotas){ //si ya llego a su ultima cuota
                  $principal = $ultimopago->saldo;
                  $cuotafinal = 1;
               } else{
                 $principal = $pr->cuota - $interes;
                 $cuotafinal = 0;
               }
              $saldo = $ultimopago->saldo - $principal;
              $saldoactual = $ultimopago->saldo - $principal;
          }

          /*Si esta en pausa */
          if($pr->pausa == 1){
            $prpausa = Prestamopausa::where('prestamo_id', $id)->where('activo', 1)->orderBy('id', 'desc')->first();//busca el prestamo pausa
            if($prpausa->cobrointere == 0)
            {
              $interes = 0;
              if(empty($ultimopago)){// si no hay ultimo pago
                $saldo = $pr->monto;
                $numcuota = 0;
              } else {
              $saldo = $ultimopago->saldo;
              $numcuota = $ultimopago->cuota;
             }

            } else{
              if(empty($ultimopago)){// si no hay ultimo pago
                $saldo = $pr->monto + $interes;
                $numcuota = 0;
              } else{
                $saldo = $ultimopago->saldo + $interes;
                $numcuota = $ultimopago->cuota;
              }
            }
            $principal = 0;
          }

          if($cont != 0){
          $pagos[] =  [
            'prestamo_id' => $pr->id,
            'tasacambio_id' => $tasac,
            'numcuota' => $numcuota,
            'abonoprincipal' => $principal,
            'intereses' => $interes,
            'saldo' => $saldoactual,
            'created_at' => $now,
            'updated_at' => $now,
          ];

          if($cuotafinal == 1){
            $prestamoupdate = Prestamo::find($id);
            $prestamoupdate->pagado=1; // Pasa a pagado el prestamo
            $prestamoupdate->activo=0; // pasa a inactivo el prestamo
            $prestamoupdate->update();
          }

         }

       } //dd($pagos);

       //dd($pagos);

        if(!empty($pagos)){
          Prestamodetalle::insert($pagos);
        }

    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $monto = Input::has('monto') ? Input::get('monto') : null;
        $plazo = Input::has('plazo') ? Input::get('plazo') : null;
        $corte = Input::has('corte') ? Input::get('corte') : null;
        $comisioon = Input::has('coomision') ? Input::get('coomision') : null;

        // Validacion de plazo
        if($plazo > 12){
          return back()->with('errormsj', 'Los datos no se guardaron');
        }


        $unoaseis = Comision::where('nombre', '1 a 6')->where('activo', 1)->value('id');
        $unoaseis = Comision::find($unoaseis);
        //dd($unoaseis->id);

        $sieteaocho = Comision::where('nombre', '7 a 8')->where('activo', 1)->value('id');
        $sieteaocho = Comision::find($sieteaocho);

        $nueveadoce = Comision::where('nombre', '9 a 12')->where('activo', 1)->value('id');
        $nueveadoce = Comision::find($nueveadoce);

        $comisionid = 0;
        $unoaseisv = $unoaseis->valor / 100;
        $sieteaochov = $sieteaocho->valor / 100;
        $nueveadocev = $nueveadoce->valor / 100;


        if($plazo != null)  {
          if($comisioon == 1) { // si se aplicara comision
              if($plazo <= 6){
                 $comision = $monto * $unoaseisv;
                 $comisionid = $unoaseis->id;
              } elseif($plazo >= 7 && $plazo <= 8){
                 $comision = $monto * $sieteaochov;
                 $comisionid = $sieteaocho->id;
              } elseif($plazo >= 9 && $plazo <= 12){
                 $comision = $monto * $nueveadocev;
                 $comisionid = $nueveadoce->id;
              }
          } else{ // no hay comision
            $comision = 0;
            $comisionid = null;
          }

              if($corte == 0){ // si el corte es quincenal

              $cquincenal = $plazo *2;
              $saldo = $comision + $monto;
              $cuota1 = $saldo * 0.01;
              $cuota2 = $cuota1 / (1-pow(1.01, -$cquincenal));
              $cuota2 = round($cuota2, 2);
            //  dd($cuota2);

           } elseif($corte == 1){ //si el corte es mensual

               $saldo = $comision + $monto;

               $cquincenal = $plazo;

               $cuota1 = $saldo * 0.02;
               $cuota2 = $cuota1 / (1-pow(1.02, -$cquincenal));
               $cuota2 = round($cuota2, 2);

            }
        } else {
           $cuota2 = 0; $cquincenal = 0; $comision = 0;
        } //dd($cuota2);


        $socio = Socio::where('activo', 1)->get();
        return view('prestamos.create',compact('socio', 'cuota2', 'cquincenal', 'comision', 'comisionid'));
    }

    public function createanticipo()
    {

        $monto = Input::has('monto') ? Input::get('monto') : null;
        $plazo = Input::has('plazo') ? Input::get('plazo') : null;

        // Validacion de plazo
        if($plazo > 4){
          return back()->with('errormsj', 'Error el plazo debe ser menor o igual a 4');
        }

        $cajachica = Cajachica::where('activo', 1)->orderBy('id', 'desc')->first();
        $saldo = $cajachica->total;

        if($monto > $saldo){ // comprueba que hay saldo suficiente
          return back()->with('errormsj', 'Saldo insuficiente');
        }


        $unaquincena = Comision::where('nombre', '1 quincena')->where('activo', 1)->value('id');
        $unaquincena = Comision::find($unaquincena);

        $dosquincena = Comision::where('nombre', '2 quincena')->where('activo', 1)->value('id');
        $dosquincena = Comision::find($dosquincena);

        $tresquincena = Comision::where('nombre', '3 quincena')->where('activo', 1)->value('id');
        $tresquincena = Comision::find($tresquincena);

        $cuatroquincena = Comision::where('nombre', '4 quincena')->where('activo', 1)->value('id');
        $cuatroquincena = Comision::find($cuatroquincena);

        $comisionid = 0;
        $unaquincena = $unaquincena->valor / 100;
        $dosquincena = $dosquincena->valor / 100;
        $tresquincena = $tresquincena->valor / 100;
        $cuatroquincena = $cuatroquincena->valor / 100;

       if($plazo == null){
         $cuota2 = 0; $cquincenal = 0; $comision = 0;
       } else{

           if($plazo == 1){
             $comision = $monto * $unaquincena;
             $cquincenal = 1;
             $comisionid = 4;
           }elseif($plazo == 2){
             $comision = $monto * $dosquincena;
             $cquincenal = 2;
             $comisionid = 5;
           }elseif($plazo == 3){
             $comision = $monto * $tresquincena;
             $cquincenal = 3;
             $comisionid = 6;
           }elseif($plazo == 4){
             $comision = $monto * $cuatroquincena;
             $cquincenal = 4;
             $comisionid = 7;
           }

           $cuota2 = ($comision + $monto) / $cquincenal;
       }

        $socio = Socio::where('activo', 1)->get();
        return view('prestamos.createanticipo',compact('socio', 'cuota2', 'cquincenal', 'comision', 'comisionid'));
    }

    public function storeanticipo(Request $request)
    {
       $cajachica = Cajachica::where('activo', 1)->orderBy('id', 'desc')->first();
       $saldo = $cajachica->total;

       if($request->monto > $saldo){ // comprueba que hay saldo suficiente
         return back()->with('errormsj', 'Saldo insuficiente');
       }

       $sc = $request->nombresocio;
       $socio_id = filter_var($sc, FILTER_SANITIZE_NUMBER_INT); //obtiene el id del socio

       //Calcula fecha de Inicio
           $dia = date('d');
           $mes = date('m');
           $año = date('Y');
           $fechainicio = 0;

           if($dia >= 10 && $dia < 25){ // dia mayor o igual a 10 y menor a 25
             $dia = 30; // el primer dia sera 30
           } elseif($dia < 10){ // dia menor a 10
             $dia = 15; // el primer dia sera 15
           } elseif($dia>=25 && $mes < 12){ //dia mayor a 25 y mes menor a 12
             $dia = 15; $mes = $mes + 1;
           } elseif($dia >=25 && $mes == 12){ // dia mayor a 25 y mes igual a 12
             $dia = 15; $mes = 1; $año = $año + 1;
           }
           if($mes == 2 && $dia == 30){ //si es febrero
             $dia = 28;
           }
           $fechainicio = $año . "-" . $mes . "-" . $dia;
    //  dd();
       $anticipo = 1;
       $request->merge(array('socio_id' => $socio_id));
       $request->merge(array('fechainicio' => $fechainicio));
       $request->merge(array('anticipo' => $anticipo));

      // dd($request->all());

       if($prestamo = Prestamo::create($request->all())){
          $cajachica2 = new Cajachica();
          $cajachica2->egreso = $request->monto;
          $cajachica2->total = $saldo - $request->monto;
          $prestamo->prestamocajachicas()->save($cajachica2);
          //$cajachica2->save(); // guarda el egreso en caja chica

          return redirect('anticipo')->with('msj', 'Datos guardados');
       } else {
          return back()->with('errormsj', 'Los datos no se guardaron');
       }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  //dd($request->all());

        /* Validaciones */

        // Validaciones
         $validatedData = $request->validate([
           'monto' => 'required',
           'plazo' => 'required',
           'corte' => 'required',
           'nombresocio' => 'required',
         ],

         [
           'monto.required' => 'El campo monto es requerido',
           'plazo.required' => 'El campo plazo es requerido',
           'corte.required' => 'El campo corte es requerido',
           'nombresocio.required' => 'El campo socio es requerido',
         ]

        );

        $sc = $request->nombresocio;
        $socio_id = filter_var($sc, FILTER_SANITIZE_NUMBER_INT); //obtiene el id del socio

      //  dd($request->nombresocio);

        if(!empty($request->fiador_id)){   // si se selecciono a alguien para ser fiador

            $fiador_id = Fiador::where('socio_id', $request->fiador_id)->value('id'); // busca la existencia del fiador
            //dd($fiador_id);

             if($fiador_id == null) { // si el fiador no existe lo guarda

                //---------- Guardar al Fiador -------------
                  $fiador = new Fiador();
                  $fiador->socio_id = $request->fiador_id;
                  $fiador->save();
            }
       } else {
          $fiador_id = 2; // no hay fiador en este prestamo
       }

        //Calcula fecha de Inicio
            $dia = date('d');
            $mes = date('m');
            $año = date('Y');
            $fechainicio = 0;
          //  $fecha = date('dmy');
         if($request->corte == 0){ // si es quincenal
            if($dia >= 10 && $dia < 25){ // dia mayor o igual a 10 y menor a 25
              $dia = 30; // el primer dia sera 30
            } elseif($dia < 10){ // dia menor a 10
              $dia = 15; // el primer dia sera 15
            } elseif($dia>=25 && $mes < 12){ //dia mayor a 25 y mes menor a 12
              $dia = 15; $mes = $mes + 1;
            } elseif($dia >=25 && $mes == 12){ // dia mayor a 25 y mes igual a 12
              $dia = 15; $mes = 1; $año = $año + 1;
            }
            if($mes == 2 && $dia == 30){ //si es febrero
              $dia = 28;
            }
            $fechainicio = $año . "-" . $mes . "-" . $dia;
         } else { // es mensual
              if($request->pmensual == 15){ //el corte es los 15
                 if($dia < 10){ // dia menor a 10 se cobra el 15
                  $fechainicio = $año . "-" . $mes . "-" . 15;
                }elseif($dia >= 10 && $mes <= 11) { //dia mayor o igual a 10 y mes menor o igual a 11
                  $mes = $mes + 1;
                  $fechainicio = $año . "-" . $mes . "-" . 15;
                } else{
                  $mes = 01; $año = $año + 1; //sera para el prox año
                  $fechainicio = $año . "-" . $mes . "-" . 15;
                }
             } elseif($request->pmensual == 30) { //el corte es los 30
                 if($dia < 25){ // dia menor a 25
                   if($mes != 2){
                     $fechainicio = $año . "-" . $mes . "-" . 30;
                   } else { // es febrero
                     $fechainicio = $año . "-" . $mes . "-" . 28;
                   }
                }elseif($dia >= 25 && $mes <= 11) { // dia mayor o igual a 25 y mes menor o igual a 11
                  $mes = $mes + 1;
                  if($mes != 2){
                    $fechainicio = $año . "-" . $mes . "-" . 30;
                  } else { // es febrero
                    $fechainicio = $año . "-" . $mes . "-" . 28;
                  }
                } else{ // sera el prox año
                  $mes = 01; $año = $año + 1;
                  $fechainicio = $año . "-" . $mes . "-" . 30;
                }
              }
        }

        //dd($fechainicio);
        $cantcuota = $request->cantcuotas;
        $corte = $request->corte; // si sera quincenal o mensual
        if($corte == 0){ // no es mensual
          $i = 2;
          $fecha = $fechainicio;
          while($i <= $cantcuota) {
            $fecha = strtotime('+15 day', strtotime($fecha));
            $fecha = (date('Y-m-d', $fecha));
            $i++;
          }
        } else { // es mensual
          $cc = $cantcuota-1;
          $fecha = strtotime('+'.$cc.'month', strtotime($fechainicio));
          $fecha = (date('Y-m-d', $fecha));
        }

        $vencimiento =  $fecha;
        //dd($vencimiento);

        // pasa los dias a 15 o 30
        $vencimiento = explode('-', $vencimiento);

        if($vencimiento[2] > 15 && $vencimiento[1] != 02){
          $vencimiento[2] = '30'; //
        }elseif($vencimiento[2] > 15 && $vencimiento[1] == 02){
          $vencimiento[2] = '28';
        }else{
          $vencimiento[2] = '15';
        }

        //dd($vencimiento);

        $vencimiento = implode('-', $vencimiento); // agrega el dia indicado 15 o 30

        //dd($vencimiento);

        //----------  Guarda el prestamo -------------
        $prestamo = new Prestamo();
        $prestamo->socio_id = $socio_id;
        $prestamo->monto = $request->monto;
        $prestamo->plazo = $request->plazo;
        $prestamo->cuota = $request->cuota;
        $prestamo->num_cheque = $request->num_cheque;
        $prestamo->cantcuotas = $request->cantcuotas;
        $prestamo->comision_id = $request->comision_id;
        $prestamo->mensual = $request->corte;
        $prestamo->vencimiento = $vencimiento;
        $prestamo->pmensual = $request->pmensual;
        $prestamo->fechainicio = $fechainicio;
        $prestamo->parentescof = $request->parentescof;

        $saldo = $request->monto + $request->comision;
        $interes = 0; $i=1; $suminteres = 0;

        if($request->corte == 0){ //si es quincenal
          $tasa = 0.01;
        } else {
          $tasa = 0.02;
        }
          while ($saldo >= 0 && $i <= $prestamo->cantcuotas) {
              number_format($interes = $saldo * $tasa, 2);
              number_format($principal = $prestamo->cuota - $interes, 2);
              number_format($saldo = $saldo - $principal, 2);
              $i = $i+1;
              $suminteres = $interes+$suminteres;
          }

        $suminteres = number_format($suminteres, 2);

        $prestamo->intereses = $suminteres; //dd($fiador_id);

        if($fiador_id == null) { // el fiador no existia
          $fiador->prestamos()->save($prestamo); // aca guarda el prestamo
        } elseif($fiador_id == 2){ //si no hay fiador
           $prestamo->save(); //guarda el prestamo
        } else { // si el fiador ya existia
          $prestamo->fiador_id = $fiador_id;
          $prestamo->save(); //guarda el prestamo
        }

        return redirect('prestamos')->with('msj', 'Datos guardados');
     }

        /* Plan de Pagos */

        public function planpago(Request $request, $id)
        {
            $prestamo = Prestamo::find($id);

            $abono= 0; $principal = 0; $i = 1;

            $date = $prestamo->fechainicio;

            $dia = date("d", strtotime($date));
            $mes = date("n");
            $año = date("Y", strtotime($date));//dd($año);

            if($prestamo->comision != null){
              $porcom = ($prestamo->comision->valor)/100; //porcentaje de comision
              $comision = $prestamo->monto * $porcom;
            } else{
              $porcom = 0;
              $comision = 0;
            }

            $saldo = $prestamo->monto + $comision;
            $interes = $prestamo->interes;

          //  dd($request->all());
            if($prestamo->mensual == 0){ //corte quincenal

            $pdf = PDF::loadView('planquincenal', ['prestamo' => $prestamo, 'request' => $request, 'saldo' => $saldo, 'interes' => $interes,
             'abono' => $abono, 'principal' => $principal, 'i' => $i, 'dia' => $dia, 'mes' => $mes, 'año' => $año]);
            return $pdf->stream('planquincenal.pdf',array('Attachment'=>0));

          } else {

            $dia = $prestamo->pmensual;
            $pdf = PDF::loadView('planmensual', ['prestamo' => $prestamo, 'request' => $request, 'saldo' => $saldo, 'interes' => $interes,
             'abono' => $abono, 'principal' => $principal, 'i' => $i, 'dia' => $dia, 'mes' => $mes, 'año' => $año]);
            return $pdf->stream('planmensual.pdf',array('Attachment'=>0));

          }

      }

    /* Resume*/

    public function resume(Request $request, $id)
    {
        $prestamo = Prestamo::find($id);

        $prestamo->resumen=1; //pasa a que ya se genero el resumen

        $prestamo->update($request->all());

        $unoaseis = Comision::where('nombre', '1 a 6')->where('activo', 1)->value('id');

        if($prestamo->plazo <= 6){
           $comision = $prestamo->monto * 0.11;
        } elseif($prestamo->plazo >= 7 && $prestamo->plazo <= 8){
           $comision = $prestamo->monto * 0.15;
        } elseif($prestamo->plazo >= 9 && $prestamo->plazo <= 12){
           $comision = $prestamo->monto * 0.18;
        }

        $ptotal = $comision + $prestamo->monto;

        $saldo = $comision + $prestamo->monto;

        $deudad = 0; $deudac = 0; $cuotac = 0;

        $tasac = Tasacambio::where('activo', 1)->value('valor');

        //dd($tasac);

      $pdf = PDF::loadView('resume', ['prestamo' => $prestamo, 'comision' => $comision,
         'ptotal' => $ptotal, 'deudad' => $deudad,
         'deudac' => $deudac, 'tasac' => $tasac, 'cuotac' => $cuotac]);
        return $pdf->stream('resumepdf.pdf',array('Attachment'=>0));


    }

    /* Resume*/

    public function contractof(Request $request, $id)
    {
      $prestamo = Prestamo::find($id);
      $tasac = Tasacambio::where('activo', 1)->value('valor');
      $prestamocom = ($prestamo->comision->valor)/100;
      $prestamocom = $prestamocom * $prestamo->monto;
      $cantdol = $prestamo->monto + $prestamocom + $prestamo->intereses;
      $cantdol = str_replace('.0', '', $cantdol);

     /*Junta Directiva*/

     $presidente = Cooperativa::where('id', 1)->value('nombre');
     $cpresidente = Cooperativa::where('id', 1)->value('cargo');
     $vicepresidente = Cooperativa::where('id', 2)->value('nombre');
     $cvicepresidente = Cooperativa::where('id', 2)->value('cargo');
     $secretario = Cooperativa::where('id', 3)->value('nombre');
     $csecretario = Cooperativa::where('id', 3)->value('cargo');
     $tesorero = Cooperativa::where('id', 4)->value('nombre');
     $ctesorero = Cooperativa::where('id', 4)->value('cargo');
     $vocal1 = Cooperativa::where('id', 5)->value('nombre');
     $cvocal1 = Cooperativa::where('id', 5)->value('cargo');
     $coordinador = Cooperativa::where('id', 6)->value('nombre');
     $ccoordinador = Cooperativa::where('id', 6)->value('cargo');
     $vocal2 = Cooperativa::where('id', 7)->value('nombre');
     $cvocal2 = Cooperativa::where('id', 7)->value('cargo');
     $secretario2 = Cooperativa::where('id', 8)->value('nombre');
     $csecretario2 = Cooperativa::where('id', 8)->value('cargo');
     $registro = Cooperativa::where('id', 9)->value('cargo');
     $cregistro = Cooperativa::where('id', 9)->value('cargo');

      //para pasar de numeros a letras
      $f = new \NumberFormatter('es-ES', \NumberFormatter::SPELLOUT);

      $cantn= $prestamo->cantcuotas;
      $cantl = $f->format($cantn);

      /*cuotas*/
      $cuotan = $prestamo->cuota;
      $cuotal = $f->format($cuotan);
      //si no es un numero entero - dolares
      if(!is_int($cuotan)){
       $decc = explode(".", $cuotan);
       $num1c = $f->format($decc[0]);
       $num2c = $f->format($decc[1]);

       $num1c = str_replace('uno', 'un', $num1c);

       $num2c = str_replace('uno', 'un', $num2c);

       $num1c .= " dólares de los Estados Unidos de América con ";

       $num2c .= " centavos";

       $numletrasc = $num1c . $num2c;

    } else { //numero entero - dolares
       $numletrasc = $f->format($cuotan);
       $numletrasc = str_replace('uno', 'un', $numletrasc);
       $numletrasc .= " dólares de los Estados Unidos de América ";
    }

      $num = $cantdol * $tasac; //dd($numero);
      $numero = number_format($num, 2);
      $number = number_format($num, 2, '.', '');

      //si no es un numero entero - Cordobas
      if(!is_int($numero)){
       $dec = explode(".", $number);
       $num1 = $f->format($dec[0]); //dd($num1);
       $num2 = $f->format($dec[1]);

       $num1 = str_replace('uno', 'un', $num1);

       $num2 = str_replace('uno', 'un', $num2);

       $num1 .= " córdobas con ";

       $num2 .= " centavos";

       $numletras = $num1 . $num2;

    } else { //numero entero - Cordobas
       $numletras = $f->format($numero);
       $numletras = str_replace('uno', 'un', $numletras);
       $numletras .= " córdobas ";
    }
    //dd($cantdol);

    //si no es un numero entero - Dolares
        if(!is_int($cantdol)){
         $decd = explode(".", $cantdol); //dd($decd);
         $num1d = $f->format($decd[0]);
         $num2d = $f->format($decd[1]);

         $num1d = str_replace('uno', 'un', $num1d);

         $num2d = str_replace('uno', 'un', $num2d);

         $num1d .= " dólares de los Estados Unidos de América con ";

         $num2d .= " centavos";

         $numletrasd = $num1d . $num2d;

      } else { //numero entero - Dolares
         $numletrasd = $f->format($cantdol);
         $numletrasd = str_replace('uno', 'un', $numletrasd);
         $numletrasd .= " dólares de los Estados Unidos de América ";
      }

        $numdolletras = $f->format($numero);

     //Dia Inicio y Fin del prestamo

      $finicio = $prestamo->fechainicio;

      setlocale(LC_ALL,"es_ES");

      $finiciol = strftime("%d de %B del %Y", strtotime($finicio));

      $dia = date("d", strtotime($finicio));
      $mes = date("m", strtotime($finicio));
      $año = date("Y", strtotime($finicio));

      if($prestamo->mensual == 0){ //si es quincenal

        $cantp = $prestamo->plazo * 2;
        $n = 2;

        while ($n <= $cantp) {
            if($dia == 30 && $mes<=12){
              $mes = $mes + 1;
              if($mes > 12){
                $mes = 1;
                $año = $año +1;
              }
            }
            if($dia == 15){
              $dia = 30;
            } else{
              $dia = 15;
            }
            $n = $n+1;
        }

      } else{
         $cantp = $prestamo->plazo;
         $m = 2;
         $dia = $prestamo->pmensual;
         while ($m <= $cantp) {
            $mes = $mes + 1;
            if($mes > 12){
              $mes = 1;
              $año = $año +1;
            }
            $m = $m+1;
         }
      }

      $diama = $año ."-". $mes ."-". $dia; //dd($diama);

      $ffinl = strftime("%d de %B del %Y", strtotime($diama)); //dd($ffinl);

      //fecha del dia de hoy

      $dtoday = strftime("a los %d días del mes de %B del año %Y"); //dd($dtoday);

        if($prestamo->fiador_id != NULL) {

            $pdf = PDF::loadView('contractoq', ['prestamo' => $prestamo, 'numero' => $numero,
            'numletras' => $numletras, 'tasac' => $tasac, 'numdolletras' => $numdolletras, 'dtoday' => $dtoday,
            'numletrasd' => $numletrasd,  'cantdol' => $cantdol, 'cantl' => $cantl, 'cantn' => $cantn,
            'cuotan' => $cuotan, 'numletrasc' => $numletrasc, 'ffinl' => $ffinl, 'finiciol' => $finiciol,
            'presidente' => $presidente, 'vicepresidente' => $vicepresidente, 'secretario' => $secretario,
            'tesorero' => $tesorero, 'vocal1' => $vocal1, 'coordinador' => $coordinador, 'vocal2' => $vocal2,
            'cpresidente' => $cpresidente, 'cvicepresidente' => $cvicepresidente, 'csecretario' => $csecretario,
            'ctesorero' => $ctesorero, 'cvocal1' => $cvocal1, 'ccoordinador' => $ccoordinador, 'cvocal2' => $cvocal2,
            'secretario2' => $secretario2, 'csecretario2' => $csecretario2, 'registro' => $registro, 'cregistro' => $cregistro]);
            return $pdf->stream('contractoq.pdf',array('Attachment'=>0));

        } else{

          $pdf = PDF::loadView('contractom', ['prestamo' => $prestamo, 'numero' => $numero,
          'numletras' => $numletras, 'tasac' => $tasac, 'numdolletras' => $numdolletras, 'dtoday' => $dtoday,
          'numletrasd' => $numletrasd,  'cantdol' => $cantdol, 'cantl' => $cantl, 'cantn' => $cantn,
          'cuotan' => $cuotan, 'numletrasc' => $numletrasc, 'ffinl' => $ffinl, 'finiciol' => $finiciol,
          'presidente' => $presidente, 'vicepresidente' => $vicepresidente, 'secretario' => $secretario,
          'tesorero' => $tesorero, 'vocal1' => $vocal1, 'coordinador' => $coordinador, 'vocal2' => $vocal2,
          'cpresidente' => $cpresidente, 'cvicepresidente' => $cvicepresidente, 'csecretario' => $csecretario,
          'ctesorero' => $ctesorero, 'cvocal1' => $cvocal1, 'ccoordinador' => $ccoordinador, 'cvocal2' => $cvocal2,
          'secretario2' => $secretario2, 'csecretario2' => $csecretario2, 'registro' => $registro, 'cregistro' => $cregistro]);
          return $pdf->stream('contractom.pdf',array('Attachment'=>0));

        }
    }

    /** Mostrar Movimientos */

    public function movimiento(Request $request, $id)
    {
        $mov = Prestamodetalle::where('prestamo_id', $id)->get(); //dd($mov);
        $prestamo = Prestamo::find($id);
        return view('prestamos.movimiento',compact('mov', 'prestamo'));

    }

    /**Reporte de prestamo */

    public function repprestamo(Request $request, $id)
    {
        $mov = Prestamodetalle::where('prestamo_id', $id)->orderBy('id', 'desc')->limit(20)->get(); //dd($mov);
        $mov = $mov->sortBy('id');//los ordena ascendentemente
        $prestamo = Prestamo::find($id);

        $pdf = PDF::loadView('repprestamo', ['mov' => $mov, 'prestamo' => $prestamo]);
        return $pdf->stream('repprestamo.pdf',array('Attachment'=>0));

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
