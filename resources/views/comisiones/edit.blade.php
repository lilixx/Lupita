@extends('layouts.app')

@section('content')

  @if(session()->has('msj'))
    <div class="alert alert-info" role="alert">{{ session('msj') }}</div>
  @endif
  @if(session()->has('errormsj'))
    <div class="alert alert-danger" role="alert">Error al guardar los datos</div>
  @endif

<form class="form-horizontal" role="form" method="POST" action="{{ url('comisionadd') }}" enctype="multipart/form-data">
   {{ csrf_field() }}


<h1 class="titulo cargo"> Cambiar Porcentaje de Comisión </h1>

  <div class="form-group">
    <label for="titulo" class="col-sm-2 control-label">Nombre</label>
    <div class="col-sm-10">
      <input type="text" id="disabledInput" class="form-control" name="nombre" value="{{ $comision->nombre }}" readonly>
    </div>
  </div>

  <div class="form-group">
    <label for="precio" class="col-sm-2 control-label">Valor</label>
    <div class="col-sm-10">
      <div class="input-group">
        <span class="input-group-addon" id="basic-addon1">%</span>
        <input type="text" class="form-control" name="valor">
      </div>
    </div>
  </div>

  <input type="hidden" name="comisionanterior" value="{{$comision->id}}">

  <div class="col-sm-4" style="float:right;">
    <button type="submit" class="btn btn-edit" style="float:right; margin-bottom:1em;">
     <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>  Cambiar</button>
  </div>

</form>

@endsection
