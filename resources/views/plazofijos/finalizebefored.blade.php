
<?php
 use Illuminate\Support\Facades\Input; ?>

@extends('layouts.app')

@section('content')

<form class="form-horizontal" action="{{URL::current()}}">

   <h1 class="titulo cargo"> Finalización de CP antes del vencimiento  </h1>

   <div class="col-lg-6">
      <div class="form-group">
        <label for="titulo" class="col-sm-4 control-label">Seleccione una Opción</label>
        <div class="col-sm-8">
          <select name="fopcion" class="form-control" name="fopcion">
             <option value="0" selected="true" disabled="true">Seleccione una Opción</option>
               <option value="0" @if(Input::get('fopcion') == 0)
                       selected='selected' @endif>Cuenta Especial y CK</option>
               <option value="1" @if(Input::get('fopcion') == 1)
                       selected='selected' @endif>Retirar todo</option>
           </select>
         </div>
      </div>
  </div>

   <div class="col-sm-4" style="float:right;">
     <button type="submit" class="btn btn-edit" style="float:right; margin-bottom:1em;">
      <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>  Enviar</button>
   </div>

   <input type="hidden" name="id" value="{{$id}}">


</form>

@endsection
