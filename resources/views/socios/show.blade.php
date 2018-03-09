@extends('layouts.app')

@section('content')

  @if(session()->has('msj'))
    <div class="alert alert-info" role="alert">{{ session('msj') }}</div>
  @endif
  @if(session()->has('errormsj'))
    <div class="alert alert-danger" role="alert">Error al guardar los datos</div>
  @endif


  <h1 class="titulo huesped"> Huésped: {{ $huespede->nombres }} {{ $huespede->apellidos }} </h1>



<div class="col-lg-4">
  <div class="form-group">
    <label for="titulo" class="col-sm-4 control-label">Fecha de Nac.</label>
      <div class="col-sm-8">
           <p style="padding-top: 7px;">{{ $huespede->fecha_nac }}</p>
      </div>
    </div>
</div>

<div class="col-lg-4">
  <div class="form-group">
    <label for="titulo" class="col-sm-4 control-label">Sexo</label>
    <div class="col-sm-8">
      <p style="padding-top: 7px;">{{ $huespede->sexo }}</p>
    </div>
  </div>
</div>

<div class="col-lg-4">
  <div class="form-group">
    <label for="titulo" class="col-sm-4 control-label">Estado civil</label>
    <div class="col-sm-8">
      <p style="padding-top: 7px;">{{ $huespede->estado_civil }}</p>
    </div>
  </div>
</div>

<div class="col-lg-4">
  <div class="form-group">
    <label for="titulo" class="col-sm-4 control-label">Nacionalidad</label>
    <div class="col-sm-8">
     <p style="padding-top: 7px;">
        @foreach ($pais as $pa)
            {{ $pa->nombre }}
        @endforeach
     </p>
    </div>
  </div>
</div>

<div class="col-lg-4">
  <div class="form-group">
    <label for="titulo" class="col-sm-4 control-label">Profesión u oficio</label>
    <div class="col-sm-8">
      <p style="padding-top: 7px;">{{ $huespede->profesion }}</p>
    </div>
  </div>
</div>

<div class="col-lg-6">
  <div class="form-group">
    <label for="titulo" class="col-sm-2 control-label">Dirección</label>
    <div class="col-sm-8">
      <p style="padding-top: 7px;">{{ $huespede->direccion }}</p>
    </div>
  </div>
</div>


<div class="col-lg-6">
  <div class="form-group">
    <label for="titulo" class="col-sm-4 control-label">Comentarios</label>
    <div class="col-sm-8">
    <p style="padding-top: 7px;">{{$huespede->comentario}}</p>
    </div>
  </div>
</div>

<div class="col-lg-10">
<a style="float:right;" href="<?php echo  url('/');?>/huespedes/{{ $huespede->id }}/edit" class="btn btn-success">
<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Modificar</a>
</div>

<div class="col-lg-12">
  <hr>
</div>

<div class="col-lg-6">
<table class="table table-striped">
    <thead>
        <tr>
          <th>Identificación</th>
          <th><a href="<?php echo  url('/');?>/dochuespedes/{{ $huespede->id }}/create" class="btn btn-info" title="Agregar">
              <span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>
          </th>
        </tr>
        <tr>
            <th>Tipo</th>
            <th>Num. documento</th>
            <th>Acciones</th>
        </tr>
    </thead>

    <tbody>
       @foreach ($doc as $td)
       <tr>
          <td> <span>{{ $td->nombre }}</span> </td>
          <td> <span>{{ $td->valordocumento }}</span> </td>
          <td>
             <a href="<?php echo  url('/');?>/dochuespedes/{{ $td->id }}/edit" class="btn btn-primary" title="Modificar">
              <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
             </a>

              <a href="#" class="btn btn-danger" title="Dar de baja">
                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
              </a>
          </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>

<!-- /////////////////////////////// Medio de Comunicacion //////////////////////////////////// -->

<div class="col-lg-6">
<table class="table table-striped">
    <thead>
        <tr>
          <th>Medio de Comunicación</th>
          <th><a href="<?php echo  url('/');?>/mediocomunicaciones/{{ $huespede->id }}/create" class="btn btn-info" title="Agregar">
              <span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>
          </th>
        </tr>
        <tr>
            <th>Tipo</th>
            <th>Medio</th>
            <th>Acciones</th>
        </tr>
    </thead>

    <tbody>
       @foreach ($medio as $td)
       <tr>
          <td> <span>{{ $td->nombre }}</span> </td>
          <td> <span>{{ $td->valormediocomunicacion }}</span> </td>
          <td>
             <a href="<?php echo  url('/');?>/mediocomunicaciones/{{ $td->id }}/edit" class="btn btn-primary" title="Modificar">
              <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
             </a>

              <a href="#" class="btn btn-danger" title="Dar de baja">
                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
              </a>
          </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>


@endsection
