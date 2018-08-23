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


<h1 class="titulo cargo"> Ahorro - Tasa editar </h1>

  <div class="col-lg-6">
    <div class="form-group">
      <label for="precio" class="col-sm-2 control-label">Valor</label>
      <div class="col-sm-10">
        <div class="input-group">
          <span class="input-group-addon" id="basic-addon1">%</span>
          <input type="text" class="form-control" name="valor" placeholder="Valor"/>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-6">
    <div class="form-group">
      <label for="titulo" class="col-sm-4 control-label">Especial</label>
      <div class="col-sm-8">
         <label class="radio-inline"><input type="radio" name="especial" @if(old('especial')=="Si")
                 checked="checked" @endif value="1">Si</label>
         <label class="radio-inline"><input type="radio" @if(old('especial')=="No")
                 checked="checked" @endif name="especial" value="0">No</label>
      </div>
    </div>
  </div>


</form>

@endsection
