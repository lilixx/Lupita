@extends('layouts.app')

@section('content')


  <form class="form-horizontal" role="form" method="POST" action="{{ url('/pagoadd') }}" enctype="multipart/form-data">
   {{ csrf_field() }}

<h1 class="titulo cargo"> Realizar Pago </h1>



<div class="col-lg-6">
  <div class="form-group">
    <label for="titulo" class="col-sm-4 control-label">Ingrese el Abono</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" name="abono"  placeholder="Ingrese el abono" required>
    </div>
  </div>
</div>

<div class="col-lg-6">
  <div class="form-group">
    <label for="titulo" class="col-sm-4 control-label">Ingrese el número del recibo</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" name="recibo"  placeholder="Ingrese el número del recibo" required>
    </div>
  </div>
</div>

  <input type="hidden" name="id" value="{{$id}}">

  <div class="col-sm-12" style="float:right;">
    <button type="submit" class="btn btn-success" style="float:right; margin-bottom:1em;">
     <span class="glyphicon glyphicon-star" aria-hidden="true"></span>  Agregar</button>
  </div>

</form>

@endsection
