@extends('layouts.app')

@section('content')

  @if(session()->has('msj'))
    <div class="alert alert-info" role="alert">{{ session('msj') }}</div>
  @endif
  @if(session()->has('errormsj'))
    <div class="alert alert-danger" role="alert">Error al guardar los datos</div>
  @endif

<form class="form-horizontal" role="form" method="POST" action="{{ route('descuentos.update', $descuento->id ) }}" enctype="multipart/form-data">
<input name="_method" type="hidden" value="PUT">
 {{ csrf_field() }}

<h1 class="titulo cargo"> Modificar Descuento </h1>

<div class="form-group">
  <label for="precio" class="col-sm-2 control-label">Valor</label>
  <div class="col-sm-10">
    <div class="input-group">
      <span class="input-group-addon" id="basic-addon1">%</span>
      <input type="text" class="form-control" name="porcentaje" value="{{ $descuento->porcentaje }}">
    </div>
  </div>
</div>


  <div class="col-sm-4" style="float:right;">
    <button type="submit" class="btn btn-edit" style="float:right; margin-bottom:1em;">
     <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>  Modificar</button>
  </div>

</form>

@endsection
