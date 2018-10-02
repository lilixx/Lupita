<?php

namespace Lupita\Http\Controllers;

use Illuminate\Http\Request;
use Lupita\Socio;
use Lupita\Empresa;
use Lupita\Afiliacioncatalogo;
use Lupita\Afiliacion;
use Lupita\Ahorro;
use Lupita\Prestamo;
use Lupita\Plazofijo;
use ValidateRequests;

class SocioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $socio = Socio::where('activo', 1)->orderBy('apellidos', 'asc')->paginate(10);
      return view('socios.socios',compact('socio'));
    }

    public function search()
    {
       return view('socios.search');
    }

    public function reportes()
    {
       return view('socios.reportes');
    }


    public function consultsocio(Request $request)
    {
       //dd($request->all());
       $sc = $request->nombresocio;
       $id = filter_var($sc, FILTER_SANITIZE_NUMBER_INT); //obtiene el id del socio

       $socio = Socio::find($id);

       //Ahorro
       $ahorro = Ahorro::where('socio_id', '=', $id)->get();

       //Pretamo
       $prestamo = Prestamo::where('socio_id', '=', $id)->where('anticipo', '=', 0)->get();

       //Plazo fijos

       $plazofijo = Plazofijo::where('socio_id', '=', $id)->get();

       //Pretamo
       $anticipo = Prestamo::where('socio_id', '=', $id)->where('anticipo', '=', 1)->get();

       //afiliacion - deuda

       return view('socios.consultsocio',compact('ahorro', 'prestamo', 'plazofijo', 'socio', 'anticipo'));

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

        //dd($request->afiliacioncatologo_id);

        // Validaciones
         $validatedData = $request->validate([
           'nombres' => 'required',
           'apellidos' => 'required',
           'fecha_nac' => 'required',
           'sexo' => 'required',
           'nacionalidad' => 'required',
           'estado_civil' => 'required',
           'num_cedula' => 'required',
           'ciudad' => 'required',
           'departamento' => 'required',
           'empresa_id' => 'required',
           'pagoplanilla' => 'required',
           'afiliacioncatologo_id' => 'required_if:pagoplanilla,==,1'

         ],

         [
           'nombres.required' => 'El campo nombres es requerido',
           'apellidos.required' => 'El campo apellidos es requerido',
           'fecha_nac.required' => 'El campo fecha de nacimiento es requerido',
           'sexo.required' => 'El campo sexo es requerido',
           'nacionalidad.required' => 'El campo nacionalidad es requerido',
           'estado_civil.required' => 'El campo estado civil es requerido',
           'num_cedula.required' => 'El campo número de cédula es requerido',
           'ciudad.required' => 'El campo ciudad es requerido',
           'departamento.required' => 'El campo departamento es requerido',
           'empresa_id.required' => 'El campo empresa es requerido',
           'pagoplanilla.required' => 'El campo tipo de pago es requerido',
           'afiliacioncatologo_id.required_if' => 'Debe seleccionar la cantidad de deducciones'

         ]

        );

      //  si es femenino
        $estadociv = $request->estado_civil;
        if($request->sexo == "F"){
           $estadociv = substr_replace($estadociv, "a", -1);
           $request->merge(array('estado_civil' => $estadociv));
        }

        //dd($request->afiliacioncatologo_id);

        //---------- Guardar al Socio -------------
        $socio = Socio::create($request->all());


    //----------  Guarda la afiliacion -------------

        $afiliacion = new Afiliacion();
        $afiliacion->pagoplanilla = $request->pagoplanilla;
        if($request->pagoplanilla == 0){
          $afiliacion->pagado = 1;
        } else {
          $afiliacion->afiliacioncatalogo_id = $request->afiliacioncatologo_id;
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
      // Validaciones
       $validatedData = $request->validate([
         'nombres' => 'required',
         'apellidos' => 'required',
         'fecha_nac' => 'required',
         'sexo' => 'required',
         'nacionalidad' => 'required',
         'estado_civil' => 'required',
         'num_cedula' => 'required',
         'ciudad' => 'required',
         'departamento' => 'required',
         'empresa_id' => 'required',
       ],

       [
         'nombres.required' => 'El campo nombres es requerido',
         'apellidos.required' => 'El campo apellidos es requerido',
         'fecha_nac.required' => 'El campo fecha de nacimiento es requerido',
         'sexo.required' => 'El campo sexo es requerido',
         'nacionalidad.required' => 'El campo nacionalidad es requerido',
         'estado_civil.required' => 'El campo estado civil es requerido',
         'num_cedula.required' => 'El campo número de cédula es requerido',
         'ciudad.required' => 'El campo ciudad es requerido',
         'departamento.required' => 'El campo departamento es requerido',
         'empresa_id.required' => 'El campo empresa es requerido',

       ]

      );

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
