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


<h1 class="titulo pais"> Pago por cheque </h1>


<form class="form-horizontal" role="form" method="POST" action="{{  route('plazofijo.savepayck', $plazofijodet->id ) }}" enctype="multipart/form-data">
  <input name="_method" type="hidden" value="PUT">
  {{ csrf_field() }}

  <div class="col-lg-6">
    <div class="form-group">
      <label for="titulo" class="col-sm-4 control-label">Fecha en que se realizo el cargo</label>
      <div class="col-sm-8">
        <input type="text" class="form-control" name="fecha" value="{{$plazofijodet->created_at->toDateString()}}" readonly>
      </div>
    </div>
  </div>


  <div class="col-lg-6">
    <div class="form-group">
      <label for="titulo" class="col-sm-4 control-label">ROC/CK</label>
      <div class="col-sm-8">
          <input type="text" class="form-control" name="rock_ck"  placeholder="Ingrese el ROC/CK">
      </div>
    </div>
  </div>


   <div class="col-sm-4" style="float:right;">
     <button class="btn btn-edit" style="float:right; margin-bottom:1em; margin-top:2em;">
      <span class="glyphicon glyphicon-send" aria-hidden="true"></span> Finalizar</button>
   </div>

</form>


@endsection
