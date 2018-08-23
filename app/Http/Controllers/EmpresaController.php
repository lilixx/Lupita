<?php

namespace Lupita\Http\Controllers;

use Illuminate\Http\Request;
use Lupita\Empresa;
use Lupita\Cartera;
use Lupita\Carteradetalle;
use Lupita\Deudaempresa;
use ValidateRequests;
use Lupita\Tasacambio;
use Barryvdh\DomPDF\Facade as PDF;
use DB;

class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $empresa = Empresa::all();
      return view('empresas.empresa',compact('empresa'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('empresas.create');
    }

    public function deuda(Request $request, $id)
    {
       $empresa = Empresa::find($id);
       $deuda = Cartera::where('empresa_id', $id)->where('pagado', 0)->get();
       return view('empresas.deuda',compact('deuda', 'empresa'));
    }

    public function deudadetalle(Request $request, $id) //
    {
       $cartera = Cartera::find($id);
       $tasac = Tasacambio::where('activo', 1)->value('valor'); // tasa de cambio
       $datecart = $cartera->created_at->format('Y-m-d').'%';
       $idemp = $cartera->empresa_id;

       //$deudaemp = Deudaempresa::where('created_at', 'like', $datecart)->where('empresa_id',  '=', $idemp)->get();

       $deudaemp = DB::table('deudaempresas')
       ->where('deudaempresas.created_at', 'like', $datecart)
       ->where('deudaempresas.empresa_id', '=', $idemp)
       ->join('afiliaciondetalles', 'afiliaciondetalles.id', '=', 'deudaempresas.afiliaciondetalle_id', 'left outer')
       ->join('afiliacions', 'afiliacions.id', '=', 'afiliaciondetalles.afiliacion_id', 'left outer')
       ->join('afiliacioncatalogos', 'afiliacioncatalogos.id', '=', 'afiliacions.afiliacioncatalogo_id', 'left outer')
       ->join('prestamodetalles', 'prestamodetalles.id', '=', 'deudaempresas.prestamodetalle_id', 'left outer')
       ->join('prestamos', 'prestamos.id', '=', 'prestamodetalles.prestamo_id', 'left outer')
       ->join('ahorrodetalles', 'ahorrodetalles.id', '=', 'deudaempresas.ahorrodetalle_id', 'left outer')
       ->join('ahorros', 'ahorros.id', '=', 'ahorrodetalles.ahorro_id', 'left outer')
       ->join('socios', function ($join) {
          $join->on('socios.id', '=', 'afiliacions.socio_id')
          ->orOn('socios.id', '=', 'prestamos.socio_id')
          ->orOn('socios.id', '=', 'ahorros.socio_id');
       })
       ->select('socios.id', 'socios.nombres', 'socios.apellidos', 'prestamodetalles.intereses', 'prestamos.cuota',
       'prestamodetalles.abonoprincipal', 'prestamodetalles.saldo', 'afiliacioncatalogos.valor',
       'prestamos.cantcuotas', 'prestamodetalles.numcuota',
        'ahorrodetalles.creditos as credito')
       ->orderBy('socios.id', 'asc')
       ->get();

       $numitem = count($deudaemp); // obtiene el num de item del array

       $totalah = 0;  $totalaf = 0; $totalpr = 0; $totalt = 0; $cont = 0; $cons = 0;
       $totalin = 0; $totalcu = 0; $totalinc = 0; $totalprincipalc = 0;
       $totalcuotac = 0; $totalaf = 0; $totalsaldoprincipal = 0;

       $cods = 0; $cont = 0;
       foreach($deudaemp as $de){

         if($de->id != $cods){
           $ahorro = 0; $afiliacion = 0;
           $principal = 0; $intereses = 0; $prinint = 0; $cuotapag = 0;
           $cuotacant = 0; $cuotapen = 0; $total = 0; $totaldol = 0;
           $nombres = $de->nombres;
           $apellidos = $de->apellidos;
           $ahorro = $de->credito;
           $afiliacion = $de->valor;
           $principal = $de->abonoprincipal;
           $intereses = $de->intereses;
           $prinint = $de->cuota;
           $total = $ahorro + $afiliacion + $prinint;
         } else{
           $ahorro = $ahorro + $de->credito;
           $afiliacion = $afiliacion + $de->valor;
           $principal = $principal + $de->abonoprincipal;
           $intereses = $intereses + $de->intereses;
           $prinint = $prinint + $de->cuota;
           $total = $total + $de->credito + $de->valor + $de->cuota;
         }


         $cont = $cont + 1;
         $principalc = $principal * $tasac;
         $interesc = number_format($intereses * $tasac, 2);

         $saldoprincipal = $de->saldo;
         $cuotapag = $de->numcuota;
         $cuotacant = $de->cantcuotas;
         $cuotapen = $de->cantcuotas - $de->numcuota;
         $totaldol = $principal + $intereses;
         $cuotac = $totaldol * $tasac;
         $totald = $cuotac + $afiliacion + $ahorro;


         if(($cont > 0 && $cods != $de->id) ||$numitem == $cont){ // si es el ultimo item
           $deuda[] =  [
             'num'=> $cont,
             'nombres' => $nombres,
             'apellidos' => $apellidos,
             'ahorro' => $ahorro,
             'afiliacion' => $afiliacion,
             'principal' => $principal,
             'principalc' => $principalc,
             'saldoprincipal' => $saldoprincipal,
             'cuota' => $totaldol,
             'cuotapen' => $cuotapen,
             'cuotacant' => $cuotacant,
             'cuotapag' => $cuotapag,
             'cuotac' => $cuotac,
             'interes' => $intereses,
             'interesc' => $interesc,
             'prinint' => $prinint,
             'total' => $totald,
           ];
         }

          $cods = $de->id; // cods obtiene el id del actual item

         $totalah = $totalah + $ahorro;
         $totalin = $totalin + $intereses;
         $totalpr = $totalpr + $principal;
         $totalcu = $totalcu + $de->cuota;
         $totalinc = $totalinc + $interesc;
         $totalprincipalc = $totalprincipalc + $principalc;
         $totalcuotac = $totalcuotac + $cuotac;
         $totalaf = $totalaf + $afiliacion;
         $totalsaldoprincipal = $totalsaldoprincipal + $saldoprincipal;
         $totalt = $totald + $totalt;
       }

      // dd($deuda);

       //$idsoc = 0; $ah = 0; $af= 0; $pr=0; $int = 0; $prin = 0;

       $pdf = PDF::loadView('deudadetalle', ['deuda' => $deuda, 'cartera' => $cartera,
       'totalah' => $totalah, 'totalaf' => $totalaf, 'totalpr' => $totalpr, 'totalt' => $totalt, 'tasac' => $tasac,
       'totalin' => $totalin, 'totalcu' => $totalcu, 'totalprincipalc' => $totalprincipalc, 'totalinc' => $totalinc,
       'totalcuotac' => $totalcuotac, 'totalt' => $totalt, 'totalsaldoprincipal' => $totalsaldoprincipal ]);
       $pdf->setPaper('A4', 'landscape');
       return $pdf->stream('deudaemp.pdf',array('Attachment'=>0));

       //return view('empresas.deudadetalle',compact('deudaemp', 'cartera'));
       //dd($deudaemp);
    }

    public function pago(Request $request, $id)
    {
      //$empresa = Empresa::find($id);
      $carteras = Cartera::where('empresa_id', '=', $id)->where('activo', '=', 1)->count(); // cuenta si hay carteras de la empresa en estado activo
      if($carteras > 0){
        return view('empresas.pago', compact('id'));
      }else{
        abort(404);
      }

    }

    public function movimiento(Request $request, $id)
    {
      $empresa = Empresa::find($id);
      $carteras = Cartera::where('empresa_id', $id)->orderBy('id', 'desc')->limit(10)->get();

      return view('empresas.movimientos', compact('empresa', 'carteras'));

    }

    public function pagoadd(Request $request)
    {
       //dd($request->all());
       $id = $request->id;
       $deuda = Cartera::where('empresa_id', $id)->where('pagado', 0)->get();

       //dd($deuda);
       $deudant = 0; $sobrante = 0;
       $now = \Carbon\Carbon::now();

        foreach($deuda as $de){
          $idcartera = $de->id;
          $ultimopago = Carteradetalle::where('cartera_id', $idcartera)->orderBy('id', 'desc')->first(); // obtiene el ultimo pago
          if(empty($ultimopago)){ //si aun no se han hecho pagos
            $sobrante = $request->abono - $de->total - $deudant;
            $deudant = $de->total;
          } else { // ya se han hecho pagos
            $sobrante = $request->abono - $ultimopago->saldo - $deudant;
            $deudant = $ultimopago->saldo;
          }

          if($sobrante > 0){ // sobra dinero, se cancela la deuda de esa cartera
            $pagos[] =  [
              'cartera_id' => $de->id,
              'abono' => $deudant,
              'saldo' => 0,
              'recibo' => $request->recibo,
              'created_at' => $now,
              'updated_at' => $now,
            ];

            $de->pagado=1; // Pasa a pagado el prestamo
            $de->activo=0; // pasa a inactivo el prestamo
            $de->update();

          } else { // aun queda debiendo de ese pago
            $abono = $deudant + $sobrante;
            $saldo = $deudant - $abono;
            $pagos[] =  [
              'cartera_id' => $de->id,
              'abono' => $abono,
              'saldo' => $saldo,
              'recibo' => $request->recibo,
              'created_at' => $now,
              'updated_at' => $now,
            ];
            break;
          }

        }
       Carteradetalle::insert($pagos);
       return redirect('empresas')->with('msj', 'Datos guardados');

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $empresa = Empresa::create($request->all());

        if($empresa->save()){
           return redirect('empresas')->with('msj', 'Datos guardados');
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
      $empresa = Empresa::find($id);
      return view('empresas.edit')
      ->with(['edit' => true, 'empresa' => $empresa]);
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
        $empresa = Empresa::find($id);
        $empresa->nombre = $request->nombre;

        if($empresa->save()){
           return redirect('empresas')->with('msj', 'Datos guardados');
        } else {
           return back()->with('errormsj', 'Los datos no se guardaron');
        }
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
