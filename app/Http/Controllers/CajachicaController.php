<?php

namespace Lupita\Http\Controllers;

use Illuminate\Http\Request;
use Lupita\Cajachica;
use ValidateRequests;

class CajachicaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cajachica = Cajachica::orderBy('id', 'desc')->take(15)->get();
        return view('cajachicas.cajachica',compact('cajachica'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->user()->authorizeRoles(['Supervisor', 'Root']);
        return view('cajachicas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $request->user()->authorizeRoles(['Supervisor', 'Root']);
      $validatedData = $request->validate([
        'egreso' => 'required_without:ingreso',
        'ingreso' => 'required_without:egreso',
      ],

      [
        'egreso.required_without' => 'El campo egreso es requerido cuando el campo ingreso no esta presente',
        'ingreso.required_without' => 'El campo ingreso es requerido cuando el campo egreso no esta presente',
      ]

     );

        $cajachica = Cajachica::where('activo', 1)->orderBy('id', 'desc')->first();
        $valoranterior = $cajachica->total;


       if ($request->egreso != null && $request->ingreso != null){
        return back()->with('errormsj', 'Solo se puede ingresar un valor');
      }
       elseif(!empty($valoranterior) && ($request->ingreso != null)){
        $total = $valoranterior + $request->ingreso;
      } elseif(!empty($valoranterior) && ($request->egreso != null)){
        $total = $valoranterior - $request->egreso;
      } elseif(empty($valoranterior) && ($request->ingreso != null)){
        $total = $request->ingreso;
      } elseif ((empty($valoranterior) && ($request->egreso != null)) || $valoranterior < $request->egreso) {
        return back()->with('errormsj', 'No tiene saldo suficiente');
      }

        $request->merge(array('total' => $total));

        if($cajachica = Cajachica::create($request->all())){
           return redirect('cajachica')->with('msj', 'Datos guardados');
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
