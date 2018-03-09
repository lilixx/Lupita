<?php

namespace Lupita\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Lupita\Prestamo;
use Lupita\Prestamodetalle;
use Lupita\Fiador;
use Lupita\Socio;
use Lupita\Tasacambio;
use Lupita\Comision;
use Lupita\Cooperativa;
use DB;
use Barryvdh\DomPDF\Facade as PDF;

class PrestamoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prestamo = Prestamo::where('activo', 1)->get();
        return view('prestamos.prestamo',compact('prestamo'));
    }

    /*Prestamo quincenales*/

    public function cronprestamoq()    //cronprestamoq
    {
        $now = \Carbon\Carbon::now();
        $prestamo = Prestamo::where('activo', 1)->where('mensual', 0)->get(); //Busca los prestamos que estan activos y su pago es quincenal
        $tasac = Tasacambio::where('activo', 1)->value('id');
        $cont = 0;
        foreach($prestamo as $pr){
          $id = $pr->id; // id del prestamo
          $ultimopago = Prestamodetalle::where('prestamo_id', $id)->orderBy('id', 'desc')->first(); // obtener el ultimo pago del prestamo
          $porcom = ($pr->comision->valor)/100; //porcentaje de comision

          if(empty($ultimopago)){ //si aun no se han hecho pagos al prestamo
            $hoy = date('Y-m-d'); //dd($pr->fechainicio);
            if($hoy == $pr->fechainicio){ //si hoy es la fecha de inicio
              //dd($pr->fechainicio);
              $comision = $pr->monto * $porcom; //comision
              $saldo = $pr->monto + $comision;
              $interes = number_format($interes = $saldo * 0.01, 2);
              $principal = number_format($principal = $pr->cuota - $interes, 2);
              $saldoactual = number_format($saldoactual = $saldo - $principal, 2);
              $numcuota = 1; $cont= $cont+1;
              $cuotafinal = 0;
            }
          } else {
              $cont = $cont+1;
              $numcuota = $ultimopago->numcuota+1;
              $comision = $pr->monto * $porcom; //comision
              $interes = number_format($interes = $ultimopago->saldo * 0.01, 2);
              if($numcuota == $pr->cantcuotas){ //si ya llego a su ultima cuota
                  $principal = $ultimopago->saldo;
                  $cuotafinal = 1;
               } else{
                 $principal = number_format($principal = $pr->cuota - $interes, 2);
                 $cuotafinal = 0;
               }
              $saldo = $ultimopago->saldo - $principal;
              $saldoactual = number_format($saldoactual = $ultimopago->saldo - $principal, 2);
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

       }

        if($cont != 0){
          Prestamodetalle::insert($pagos);
        }
    }

    /*Prestamo que se cobran mensualmente*/
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
          $porcom = ($pr->comision->valor)/100; //porcentaje de comision

          if(empty($ultimopago)){ //si aun no se han hecho pagos al prestamo
            $hoy = date('Y-m-d'); //dd($pr->fechainicio);
            if($hoy == $pr->fechainicio){ //si hoy es la fecha de inicio
              //dd($pr->fechainicio);
              $comision = $pr->monto * $porcom; //comision
              $saldo = $pr->monto + $comision;
              $interes = number_format($interes = $saldo * 0.02, 2);
              $principal = number_format($principal = $pr->cuota - $interes, 2);
              $saldoactual = number_format($saldoactual = $saldo - $principal, 2);
              $numcuota = 1; $cont= $cont+1;
              $cuotafinal = 0;
            }
          } else {
              $cont = $cont+1;
              $numcuota = $ultimopago->numcuota+1;
              $comision = $pr->monto * $porcom; //comision
              $interes = number_format($interes = $ultimopago->saldo * 0.02, 2);
              if($numcuota == $pr->cantcuotas){ //si ya llego a su ultima cuota
                  $principal = $ultimopago->saldo;
                  $cuotafinal = 1;
               } else{
                 $principal = number_format($principal = $pr->cuota - $interes, 2);
                 $cuotafinal = 0;
               }
              $saldo = $ultimopago->saldo - $principal;
              $saldoactual = number_format($saldoactual = $ultimopago->saldo - $principal, 2);
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

        if($cont != 0){
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  //dd($request->all());
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
         if($request->corte == 0){
            if($dia > 10 && $dia <= 25){
              $dia = 30;
            } elseif($dia <= 10){
              $dia = 15;
            } elseif($dia>25 && $mes < 12){
              $dia = 15; $mes = $mes + 1;
            } elseif($dia >25 && $mes == 12){
              $dia = 15; $mes = 1; $año = $año + 1;
            }
            if($mes == 2 && $dia == 30){ //si es febrero
              $dia = 28;
            }
            $fechainicio = $año . "-" . $mes . "-" . $dia;
         } else {
              if($request->pmensual == 15){ //dd($request->pmensual);
                 if($dia <= 10){
                  $fechainicio = $año . "-" . $mes . "-" . 15;
                }elseif($dia > 10 && $mes <= 11) {
                  $mes = $mes + 1;
                  $fechainicio = $año . "-" . $mes . "-" . 15;
                } else{
                  $mes = 01; $año = $año + 1;
                  $fechainicio = $año . "-" . $mes . "-" . 15;
                }
             } elseif($request->pmensual == 30) {
                 if($dia <= 25){
                   if($mes != 2){
                     $fechainicio = $año . "-" . $mes . "-" . 30;
                   } else {
                     $fechainicio = $año . "-" . $mes . "-" . 28;
                   }
                }elseif($dia > 25 && $mes <= 11) {
                  $mes = $mes + 1;
                  if($mes != 2){
                    $fechainicio = $año . "-" . $mes . "-" . 30;
                  } else {
                    $fechainicio = $año . "-" . $mes . "-" . 28;
                  }
                } else{
                  $mes = 01; $año = $año + 1;
                  $fechainicio = $año . "-" . $mes . "-" . 30;
                }
              }
        }

        //  dd($fechainicio);

        //----------  Guarda el prestamo -------------
        $prestamo = new Prestamo();
        $prestamo->socio_id = $request->socio_id;
        $prestamo->monto = $request->monto;
        $prestamo->plazo = $request->plazo;
        $prestamo->cuota = $request->cuota;
        $prestamo->num_cheque = $request->num_cheque;
        $prestamo->cantcuotas = $request->cantcuotas;
        $prestamo->comision_id = $request->comision_id;
        $prestamo->mensual = $request->corte;
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
            $mes = date("m", strtotime($date));
            $año = date("Y", strtotime($date));//dd($año);


            $porcom = ($prestamo->comision->valor)/100; //porcentaje de comision

            $comision = $prestamo->monto * $porcom;

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
