@extends('layouts.app')

@section('content')

  @if(session()->has('msj'))
    <div class="alert alert-info" role="alert">{{ session('msj') }}</div>
  @endif
  @if(session()->has('errormsj'))
    <div class="alert alert-danger" role="alert">Error al guardar los datos</div>
  @endif

<form class="form-horizontal" role="form" method="POST" action="{{ url('afiliacioncatadd') }}" enctype="multipart/form-data">
 {{ csrf_field() }}

<h1 class="titulo pais"> Agregar La Deducción </h1>

  <div class="form-group">
    <label for="titulo" class="col-sm-2 control-label">Cantidad</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="cantidad"  placeholder="Ingrese la cantidad">
    </div>
  </div>

  <div class="form-group">
    <label for="titulo" class="col-sm-2 control-label">Valor</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="valor"  placeholder="Ingrese el valor">
    </div>
  </div>

  <div class="col-sm-12" style="float:right;">
    <button type="submit" class="btn btn-success" style="float:right; margin-bottom:1em;">
     <span class="glyphicon glyphicon-star" aria-hidden="true"></span>  Crear</button>
  </div>

</form>

@endsection
