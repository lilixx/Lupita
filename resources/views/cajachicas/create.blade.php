@extends('layouts.app')

@section('content')

  @if(session()->has('msj'))
    <div class="alert alert-info" role="alert">{{ session('msj') }}</div>
  @endif
  @if(session()->has('errormsj'))
    <div class="alert alert-danger" role="alert">{{ session()->get('errormsj') }}</div>
  @endif



<form class="form-horizontal" role="form" method="POST" action="{{ url('cajachicaadd') }}" enctype="multipart/form-data">
 {{ csrf_field() }}

 @if (count($errors) > 0)
   <div class="alert alert-danger">
       <ul>
           @foreach ($errors->all() as $error)
               <li>{{ $error }}</li>
           @endforeach
       </ul>
   </div>
@endif

<h1 class="titulo pais"> Agregar Ingreso o Egreso </h1>

  <div class="form-group">
    <label for="titulo" class="col-sm-2 control-label">Ingreso</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="ingreso"  placeholder="Ingreso">
    </div>
  </div>

  <div class="form-group">
    <label for="titulo" class="col-sm-2 control-label">Egreso</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="egreso"  placeholder="Egreso">
    </div>
  </div>

  <div class="form-group">
    <label for="titulo" class="col-sm-2 control-label">Recibo o Núm. de Cheque</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="num_doc"  placeholder="Recibo o Núm. de Cheque" required>
    </div>
  </div>


  <div class="col-sm-12" style="float:right;">
    <button type="submit" class="btn btn-success" style="float:right; margin-bottom:1em;">
     <span class="glyphicon glyphicon-star" aria-hidden="true"></span>  Crear</button>
  </div>

</form>

@endsection
