<?php

namespace Lupita\Http\Controllers;

use Illuminate\Http\Request;
use Lupita\Afiliacion;
use Lupita\Afiliaciondetalle;
use Lupita\Tasacambio;
use Carbon\Carbon;

class AfiliacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create2()
    {


    }

    public function cronafiliacion()//cronafiliacion
    {
          $now = \Carbon\Carbon::now();
          $afiliacion = Afiliacion::where('pagado', 0)->get();//busca las que no han sido pagadas

          if(!$afiliacion->isEmpty()){ // si hay afiliaciones que no han sido pagadas
            //dd($afiliacion);
              foreach($afiliacion as $af){
                $afid = $af->id;
                $ultimoafd = Afiliaciondetalle::where('afiliacion_id', $afid)->orderBy('id', 'desc')->first(); // obtener el ultimo afiliaciondetalle
                if(empty($ultimoafd)){ //si no hay afiliacion detalle
                  $data[] =  [
                    'afiliacion_id' => $afid,
                    'num_deduccion' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                  ];
                } else { //ya hay afiliaciondetalle
                  // dd($af->afiliacioncatalogo->cantidad);
                   if($af->afiliacioncatalogo->cantidad >= $ultimoafd->num_deduccion){ //si es menor o igual a la cantidad de afiliacioncatalogo
                      $data[] =  [
                        'afiliacion_id' => $afid,
                        'num_deduccion' => $ultimoafd->num_deduccion + 1,
                        'created_at' => $now,
                        'updated_at' => $now,
                      ];
                    }

                    $num = $ultimoafd->num_deduccion + 1; // saber el num de deduccion
                    if($af->afiliacioncatalogo->cantidad == $num){ // si son iguales
                      $id = $afid;
                      $afiliacion = Afiliacion::find($id);
                      $afiliacion->pagado=1; // afiliacion pasa a pagada
                      $afiliacion->update();
                    }
                }

              }

              //dd($data);

             Afiliaciondetalle::insert($data); // guarda las afiliaciones detalle

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
