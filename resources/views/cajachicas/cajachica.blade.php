
@extends('layouts.app')

@section('content')

  @if(isset($edit))
    @include('modificar')
  @else

  @if(session()->has('msj'))
    <div class="alert alert-info" role="alert">{{ session('msj') }}</div>
  @endif
  @if(session()->has('errormsj'))
    <div class="alert alert-danger" role="alert">Error, no tiene saldo suficiente</div>
  @endif

  @if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

   <h1 class="titulo pais"> Caja Chica </h1>

  <a href="cajachica/create" class="btn btn-info">
    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Agregar</a>

@include('cajachicas.tbl')

@endif

@endsection
