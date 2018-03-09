@extends('layouts.app')

@section('content')

  @if(session()->has('msj'))
    <div class="alert alert-info" role="alert">{{ session('msj') }}</div>
  @endif
  @if(session()->has('errormsj'))
    <div class="alert alert-danger" role="alert">Error al guardar los datos</div>
  @endif

<form class="form-horizontal" role="form" method="POST" action="{{ route('mconsejo.update', $consejo->id ) }}" enctype="multipart/form-data">
<input name="_method" type="hidden" value="PUT">
 {{ csrf_field() }}

<h1 class="titulo cargo"> Modificar Miembro de la Junta Directiva  </h1>


  <div class="form-group">
    <label for="titulo" class="col-sm-2 control-label">Cargo</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" name="cargo" value="{{$consejo->cargo}}" readonly>
    </div>
  </div>


<div class="form-group">
  <label for="precio" class="col-sm-2 control-label">Nombre</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" name="nombre"  value="{{ $consejo->nombre }}">
    </div>
</div>

<div class="col-lg-6">
  <div class="form-group">
    <label for="titulo" class="col-sm-4 control-label">Sexo</label>
    <div class="col-sm-8">
       <label class="radio-inline"><input type="radio" name="sexo" value="F" @if($consejo->sexo=="F")
               checked="checked" @endif>F</label>
       <label class="radio-inline"><input type="radio" name="sexo" value="M" @if($consejo->sexo=="M")
               checked="checked" @endif>M</label>
    </div>
  </div>
</div>


  <div class="col-sm-4" style="float:right;">
    <button type="submit" class="btn btn-edit" style="float:right; margin-bottom:1em;">
     <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>  Modificar</button>
  </div>

</form>

@endsection
