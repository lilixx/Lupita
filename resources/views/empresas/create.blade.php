
@extends('layouts.app')

@section('content')

  @if(session()->has('msj'))
    <div class="alert alert-info" role="alert">{{ session('msj') }}</div>
  @endif
  @if(session()->has('errormsj'))
    <div class="alert alert-danger" role="alert">Error al guardar los datos</div>
  @endif

<form class="form-horizontal" role="form" method="POST" action="{{ url('empresaadd') }}" enctype="multipart/form-data">
 {{ csrf_field() }}

<h1 class="titulo pais"> Agregar Empresa </h1>

  <div class="form-group">
    <label for="titulo" class="col-sm-2 control-label">Nombre</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="nombre"  placeholder="nombre" required>
    </div>
  </div>

  <div class="form-group">
    <label for="titulo" class="col-sm-2 control-label">Dirección</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="direccion"  placeholder="Dirección">
    </div>
  </div>

  <div class="form-group">
    <label for="titulo" class="col-sm-2 control-label">Teléfono</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="direccion"  placeholder="Dirección">
    </div>
  </div>

  <div class="col-sm-12" style="float:right;">
    <button type="submit" class="btn btn-success" style="float:right; margin-bottom:1em;">
     <span class="glyphicon glyphicon-star" aria-hidden="true"></span>  Crear</button>
  </div>

</form>

@endsection
