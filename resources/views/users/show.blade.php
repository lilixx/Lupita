@extends('layouts.app')

@section('content')

  @if(session()->has('msj'))
    <div class="alert alert-info" role="alert">{{ session('msj') }}</div>
  @endif
  @if(session()->has('errormsj'))
    <div class="alert alert-danger" role="alert">Error al guardar los datos</div>
  @endif

<form class="form-horizontal" role="form" method="POST" action="{{ route('users.update', $user->id ) }}" enctype="multipart/form-data">
<input name="_method" type="hidden" value="PUT">
 {{ csrf_field() }}

 <h1 class="titulo cliente"> Mi perfil </h1>

<div class="col-lg-4">
  <div class="form-group">
    <label for="titulo" class="col-sm-4 control-label">Email</label>
    <div class="col-sm-8">
    <p style="padding-top: 7px;">{{ $user->email }}</p>
    </div>
  </div>
</div>


<div class="col-lg-10">
<a style="float:right;" href="<?php echo  url('/');?>/users/{{ $user->id }}/editprofile" class="btn btn-success">
<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Modificar</a>
</div>

<div class="col-lg-12">
  <hr>
</div>





@endsection
