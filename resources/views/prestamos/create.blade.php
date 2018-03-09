<?php
 use Illuminate\Support\Facades\Input; ?>
@extends('layouts.app')

@section('content')

  @if(session()->has('msj'))
    <div class="alert alert-info" role="alert">{{ session('msj') }}</div>
  @endif
  @if(session()->has('errormsj'))
    <div class="alert alert-danger" role="alert">Error al guardar los datos</div>
  @endif


<form class="form-horizontal" action="{{URL::current()}}">
<h1 class="titulo pais"> Agregar Prestamo </h1>


  <div class="col-lg-6">
     <div class="form-group">
       <label for="titulo" class="col-sm-4 control-label">Monto</label>
       <div class="col-sm-8">
         <input type="text" class="form-control" name="monto" value="{{Input::get('monto')}}">
       </div>
     </div>
 </div>

 <div class="col-lg-6">
   <div class="form-group">
     <label for="titulo" class="col-sm-4 control-label">Plazo(meses)</label>
     <div class="col-sm-8">
       <input type="text" class="form-control" name="plazo" value="{{Input::get('plazo')}}">
     </div>
   </div>
 </div>

 <div class="col-lg-6">
    <div class="form-group">
      <label for="titulo" class="col-sm-4 control-label">Corte</label>
      <div class="col-sm-8">
        <select name="corte" class="form-control" name="corte">
           <option value="0" selected="true" disabled="true">Seleccione el corte</option>
             <option value="0" @if(Input::get('corte') == 0)
                     selected='selected' @endif>Quincenal</option>
             <option value="1" @if(Input::get('corte') == 1)
                     selected='selected' @endif>Mensual</option>
         </select>
       </div>
    </div>
</div>


  <div class="col-sm-4" style="float:right;">
    <button type="submit" class="btn btn-success" style="float:right; margin-bottom:1em;">
     <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Consultar</button>
  </div>

  <div class="col-lg-12">
     <hr>
 </div>

</form>

<form class="form-horizontal" role="form" method="POST" action="{{ url('prestamosadd') }}" enctype="multipart/form-data">

  {{ csrf_field() }}

  <div class="col-lg-6">
    <div class="form-group">
      <label for="titulo" class="col-sm-4 control-label">Socio</label>
          <div class="col-sm-8">
              <select name="socio_id" class="form-control" name="socio_id">
                 <option value="0" selected="true" disabled="true">Seleccione al Socio</option>
                 @foreach ($socio as $sc)
                   <option value="{{$sc->id}}">{{$sc->nombres}} {{$sc->apellidos}}</option>
                 @endforeach
               </select>
            </div>
          </div>
       </div>


       <div class="col-lg-6">
         <div class="form-group">
           <label for="titulo" class="col-sm-4 control-label">Fiador</label>
               <div class="col-sm-8">
                   <select name="fiador_id" class="form-control" name="fiador_id">
                      <option value="0" selected="true" disabled="true">Seleccione al Fiador</option>
                      @foreach ($socio as $sc)
                        <option value="{{$sc->id}}">{{$sc->nombres}} {{$sc->apellidos}}</option>
                      @endforeach
                    </select>
                 </div>
               </div>
            </div>


          <div class="col-lg-6">
               <div class="form-group">
                 <label for="titulo" class="col-sm-4 control-label">Relación</label>
                 <div class="col-sm-8">
                   <input type="text" class="form-control" name="parentescof" placeholder="Relacion o parentesco del fiador">
                 </div>
               </div>
           </div>


  <div class="col-lg-6">
    <div class="form-group">
      <label for="titulo" class="col-sm-4 control-label">Comisión</label>
      <div class="col-sm-8">
        <input type="text" class="form-control" name="comision" value="{{$comision}}" readonly>
      </div>
    </div>
  </div>

  <input type="hidden" name="monto" value="{{Input::get('monto')}}">

  <input type="hidden" name="plazo" value="{{Input::get('plazo')}}">

  <input type="hidden" name="corte" value="{{Input::get('corte')}}">

  <input type="hidden" name="comision_id" value="{{$comisionid}}">


  <div class="col-lg-6">
    <div class="form-group">
      <label for="titulo" class="col-sm-4 control-label">Cant. cuotas</label>
      <div class="col-sm-8">
        <input type="text" class="form-control" name="cantcuotas" value="{{$cquincenal}}" readonly>
      </div>
    </div>
  </div>

  <div class="col-lg-6">
    <div class="form-group">
      <label for="titulo" class="col-sm-4 control-label">Cuota</label>
      <div class="col-sm-8">
        <input type="text" class="form-control" name="cuota" value="{{$cuota2}}" readonly>
      </div>
    </div>
  </div>

  @if(Input::get('corte') == 1)

  <div class="col-lg-6">
    <div class="form-group">
      <label for="titulo" class="col-sm-4 control-label">Pago Mensual</label>
      <div class="col-sm-8">
        <select name="pmensual" class="form-control" name="pmensual">
           <option value="0" selected="true" disabled="true">Seleccione el dia de corte</option>
             <option value="15">15</option>
             <option value="30">30</option>
         </select>
      </div>
    </div>
  </div>

@endif


  <div class="col-lg-6">
    <div class="form-group">
      <label for="titulo" class="col-sm-4 control-label">Num. de Cheque</label>
      <div class="col-sm-8">
        <input type="text" class="form-control" name="num_cheque"  placeholder="Ingrese el número del cheque">
      </div>
    </div>
  </div>


   <div class="col-sm-4" style="float:right;">
     <button class="btn btn-edit" style="float:right; margin-bottom:1em; margin-top:2em;">
      <span class="glyphicon glyphicon-send" aria-hidden="true"></span> Crear</button>
   </div>

</form>


@endsection
