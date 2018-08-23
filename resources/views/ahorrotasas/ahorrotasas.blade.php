
@extends('layouts.app')

@section('content')

  @if(isset($edit))
    @include('modificar')
  @else

  @if(session()->has('msj'))
    <div class="alert alert-info" role="alert">{{ session('msj') }}</div>
  @endif
  @if(session()->has('errormsj'))
    <div class="alert alert-danger" role="alert">Error al guardar los datos</div>
  @endif

   <h1 class="titulo cargo"> Tasa - Ahorro </h1>

   <a href="ahorrotasas/create" class="btn btn-info">
     <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Agregar</a> 



@include('ahorrotasas.tbl')

@endif

@endsection
