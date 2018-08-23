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


<h1 class="titulo pais"> Finalización de CP antes del vencimiento </h1>


<form class="form-horizontal" role="form" method="POST" action="{{ route('plazofijo.update', $plazof->id ) }}" enctype="multipart/form-data">
  <input name="_method" type="hidden" value="PUT">
  {{ csrf_field() }}


  <div class="col-lg-6">
    <div class="form-group">
      <label for="titulo" class="col-sm-4 control-label">Monto</label>
      <div class="col-sm-8">
        <input type="text" class="form-control" name="monto" value="{{$plazof->monto}}" readonly>
      </div>
    </div>
  </div>

  <div class="col-lg-6">
    <div class="form-group">
      <label for="titulo" class="col-sm-4 control-label">Cant. de dias</label>
      <div class="col-sm-8">
        <input type="text" class="form-control" name="cantcuotas" value="{{$cantdia}}" readonly>
      </div>
    </div>
  </div>

  <div class="col-lg-6">
    <div class="form-group">
      <label for="titulo" class="col-sm-4 control-label">Total de Intereses</label>
      <div class="col-sm-8">
        <input type="text" class="form-control" name="intereses" value="{{$intereses}}" readonly>
      </div>
    </div>
  </div>

  <div class="col-lg-6">
    <div class="form-group">
      <label for="titulo" class="col-sm-4 control-label">Retención</label>
      <div class="col-sm-8">
        <input type="text" class="form-control" name="ir" value="{{$retencion}}" readonly>
      </div>
    </div>
  </div>

  <div class="col-lg-6">
    <div class="form-group">
      <label for="titulo" class="col-sm-4 control-label">Total</label>
      <div class="col-sm-8">
        <input type="text" class="form-control" name="total" value="{{$total}}" readonly>
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

  <input type="hidden" name="numero" value="{{$numero}}">

   <div class="col-sm-4" style="float:right;">
     <button class="btn btn-edit" style="float:right; margin-bottom:1em; margin-top:2em;">
      <span class="glyphicon glyphicon-send" aria-hidden="true"></span> Finalizar</button>
   </div>

</form>


@endsection
