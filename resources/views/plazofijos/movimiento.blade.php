@extends('layouts.app')

@section('content')

  @if(session()->has('msj'))
    <div class="alert alert-info" role="alert">{{ session('msj') }}</div>
  @endif
  @if(session()->has('errormsj'))
    <div class="alert alert-danger" role="alert">Error, no posee suficiente saldo para realizar el movimiento</div>
  @endif

  <form class="form-horizontal" role="form" method="POST" action="{{ url('movimientoadd') }}" enctype="multipart/form-data">
   {{ csrf_field() }}

<h1 class="titulo cargo"> Agregar  Movimiento </h1>

<div class="col-lg-12">
  <div class="form-group">
    <label for="precio" class="col-sm-2 control-label">Tipo de Movimiento</label>
    <div class="col-sm-10">
      <select name="concepto_id" class="form-control" name="concepto_id">
         <option value="0" selected="true" disabled="true">Seleccione el tipo de movimiento</option>
           <option value="1">Deposito</option>
           <option value="2">Retiro</option>
       </select>
    </div>
  </div>
</div>

<input type="hidden" name="ahorro_id" value="{{$ahorroid}}">

<div class="col-lg-6">
  <div class="form-group">
    <label for="titulo" class="col-sm-4 control-label">Ingrese el ROC/CK</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" name="rock_ck"  placeholder="Ingrese el ROC/CK">
    </div>
  </div>
</div>

<div class="col-lg-6">
  <div class="form-group">
    <label for="precio" class="col-sm-2 control-label">Cantidad</label>
    <div class="col-sm-10">
      <div class="input-group">
        <span class="input-group-addon" id="basic-addon1">$</span>
        <input type="text" class="form-control" name="valor" placeholder="Ingrese la cantidad"/>
      </div>
    </div>
  </div>
</div>

  <div class="col-sm-12" style="float:right;">
    <button type="submit" class="btn btn-success" style="float:right; margin-bottom:1em;">
     <span class="glyphicon glyphicon-star" aria-hidden="true"></span>  Agregar</button>
  </div>

</form>

@endsection
