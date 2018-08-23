@extends('layouts.app')

@section('content')

  @if(session()->has('msj'))
    <div class="alert alert-info" role="alert">{{ session('msj') }}</div>
  @endif
  @if(session()->has('errormsj'))
    <div class="alert alert-danger" role="alert">Error al guardar los datos</div>
  @endif

  <form class="form-horizontal" role="form" method="POST" action="{{ route('prestamos.pausar', $prestamo->id ) }}" enctype="multipart/form-data">
  <input name="_method" type="hidden" value="PUT">
   {{ csrf_field() }}


<h1 class="titulo cargo"> Poner en Pausa el Prestamo </h1>

<div class="col-lg-6">
  <div class="form-group">
    <label for="titulo" class="col-sm-4 control-label">Se aplicara intereses</label>
    <div class="col-sm-8">
       <label class="radio-inline"><input type="radio" name="cobrointere" @if(old('cobrointere')=="Si")
               checked="checked" @endif value="1">Si</label>
       <label class="radio-inline"><input type="radio" @if(old('cobrointere')=="No")
               checked="checked" @endif name="cobrointere" value="0">No</label>
    </div>
  </div>
</div>




  <div class="col-sm-4" style="float:right;">
    <button type="submit" class="btn btn-edit" style="float:right; margin-bottom:1em;">
     <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>  Pausar</button>
  </div>

</form>

@endsection
