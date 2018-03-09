<?php

namespace Lupita\Http\Controllers;

use Illuminate\Http\Request;
use Lupita\Cooperativa;

class CooperativaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $consejo = Cooperativa::where('activo', 1)->get();
        return view('mconsejos.mconsejos',compact('consejo'));
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
        $consejo = Cooperativa::find($id);
        return view('mconsejos.edit')
        ->with(['edit' => true, 'consejo' => $consejo]);
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
        //dd($request->all());
        $consejo = Cooperativa::find($id);

        $cargo = $consejo->cargo;

        if($consejo->sexo != $request->sexo && ($consejo->cargo == "PRESIDENTA" || $consejo->cargo == "VICEPRESIDENTA")){
          $cargo = substr_replace($cargo, "E", -1);
        }elseif($consejo->sexo != $request->sexo && ($consejo->cargo == "PRESIDENTE" || $consejo->cargo == "VICEPRESIDENTE")){
          $cargo = substr_replace($cargo, "A", -1);
        } elseif($consejo->sexo != $request->sexo && $consejo->cargo == "SECRETARIA"){
          $cargo = substr_replace($cargo, "0", -1);
        } elseif($consejo->sexo != $request->sexo && $consejo->cargo == "SECRETARIO"){
          $cargo = substr_replace($cargo, "A", -1);
        } elseif($consejo->sexo != $request->sexo && $consejo->cargo == "TESORERA"){
          $cargo = substr_replace($cargo, "0", -1);
        } elseif($consejo->sexo != $request->sexo && $consejo->cargo == "TESORERO"){
          $cargo = substr_replace($cargo, "A", -1);
        }elseif($consejo->sexo != $request->sexo && $consejo->cargo == "COORDINADORA") {
          $cargo = substr_replace($cargo, "", -1);
        }elseif($consejo->sexo != $request->sexo && $consejo->cargo == "COORDINADOR") {
          $cargo = $consejo->cargo . "A";
        }elseif($consejo->sexo != $request->sexo && $consejo->cargo == "Directora") {
          $cargo = substr_replace($cargo, "", -1);
        }elseif($consejo->sexo != $request->sexo && $consejo->cargo == "Director") {
          $cargo = $consejo->cargo . "a";
        }

        $consejo->cargo = $cargo;
        $consejo->nombre = $request->nombre;
        $consejo->sexo = $request->sexo;


        if($consejo->save()){
           return redirect('mconsejo')->with('msj', 'Datos guardados');
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
