<?php

namespace Lupita\Http\Controllers;

use Illuminate\Http\Request;
use Lupita\Socio;
use Lupita\Empresa;
use Lupita\Afiliacioncatalogo;
use Lupita\Afiliacion;

class SocioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $socio = Socio::where('activo', 1)->get();
      return view('socios.socios',compact('socio'));
    }

    //autocomplete
    public function socioautocomplete(Request $request)
    {
        $data = Socio::select("id", "nombres as name", "apellidos")->where("nombres","LIKE","%{$request->input('term')}%")->get();
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $empresa = Empresa::all();
       $afcat = Afiliacioncatalogo::all();
       return view('socios.create',compact('empresa', 'afcat'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   //dd($request->all());

        if($request->pagoplanilla == 1 && (empty($request->empresa_id))){ //si selecciono pago de planilla y no selecciono la empresa
          return back()->with('errormsj', 'Los datos no se guardaron');
        }

      //  si es femenino
        $estadociv = $request->estado_civil;
        if($request->sexo == "F"){
           $estadociv = substr_replace($estadociv, "a", -1);
           $request->merge(array('estado_civil' => $estadociv));
        }

        //---------- Guardar al Socio -------------
        $socio = Socio::create($request->all());


    //----------  Guarda la afiliacion -------------

        $afiliacion = new Afiliacion();
        $afiliacion->pagoplanilla = $request->pagoplanilla;
        if($request->pagoplanilla == 0){
          $afiliacion->pagado = 1;
        } else {
          $afiliacion->afiliacioncatalogo_id = $request->afiliacioncatalogo_id;
        }
        $socio->afiliacions()->save($afiliacion);

        return redirect('socios')->with('msj', 'Datos guardados');

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
        $socio = Socio::find($id);
        $empresa = Empresa::all();
        $afcat = Afiliacioncatalogo::all();
        return view('socios.edit')
        ->with(['edit' => true, 'empresa' => $empresa, 'afcat' => $afcat, 'socio' => $socio]);
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
        $estadoc = $request->estado_civil;
        if($request->sexo == "F"){
           $estadociv = substr_replace($estadoc, "a", -1);// dd($estadociv);
           $request->merge(array('estado_civil' => $estadociv));
        }

        $socio = Socio::find($id); //dd($request->all());

        if($socio->update($request->all())){
           return redirect()->to("socios")->with('msj', 'Datos guardados');
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
