@extends('layouts.app')

@section('content')

 <form class="form-horizontal" role="form" method="POST" action="{{ route('carteraempcon') }}" enctype="multipart/form-data">
 <input name="_method" type="hidden" value="PUT">
    {{ csrf_field() }}

<h1 class="titulo cargo"> Cartera por Empresa </h1>

<div class="col-lg-12">
  <div class="form-group">
    <label for="precio" class="col-sm-2 control-label">Seleccione la Empresa</label>
    <div class="col-sm-10">
      <select  class="form-control input-sm" name="empresa">
         <option value="0" selected="true" disabled="true">Seleccione una Empresa</option>
           @foreach ($empresa as $em)
             <option value="{{$em->id}}">{{$em->nombre}}</option>
           @endforeach
      </select>
    </div>
  </div>
</div>



<div class="col-sm-12" style="float:right;">
    <button type="submit" class="btn btn-success" style="float:right; margin-bottom:1em;">
     <span class="glyphicon glyphicon-star" aria-hidden="true"></span>  Enviar</button>
</div>

</form>

@endsection
