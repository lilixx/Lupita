@extends('layouts.app')

@section('content')

  @if(session()->has('msj'))
    <div class="alert alert-info" role="alert">{{ session('msj') }}</div>
  @endif
  @if(session()->has('errormsj'))
    <div class="alert alert-danger" role="alert">Error al guardar los datos</div>
  @endif

  <form class="form-horizontal" role="form" method="POST" action="{{ url('useradd') }}" enctype="multipart/form-data">
   {{ csrf_field() }}

 <h1 class="titulo usuario"> Agregar Usuario</h1>

   <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
       <label for="name" class="col-md-4 control-label">Nombre de usuario</label>

       <div class="col-md-6">
           <input id="name" type="text" class="form-control" name="name" required autofocus>

           @if ($errors->has('name'))
               <span class="help-block">
                   <strong>{{ $errors->first('name') }}</strong>
               </span>
           @endif
       </div>
   </div>

   <div class="form-group">
     <label for="name" class="col-md-4 control-label">Rol</label>
     <div class="col-md-6">
        <select  class="form-control input-sm" name="rol_id" required>
          @foreach ($rol as $rl)
            <option value="{{$rl->id}}">{{$rl->nombre}}</option>
          @endforeach
         </select>
      </div>
     </div>


   <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
       <label for="email" class="col-md-4 control-label">E-Mail </label>

       <div class="col-md-6">
           <input id="email" type="email" class="form-control" name="email" required>

           @if ($errors->has('email'))
               <span class="help-block">
                   <strong>{{ $errors->first('email') }}</strong>
               </span>
           @endif
       </div>
   </div>


   <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
       <label for="password" class="col-md-4 control-label">Password</label>

       <div class="col-md-6">
           <input id="password" type="password" class="form-control" name="password" required>

           @if ($errors->has('password'))
               <span class="help-block">
                   <strong>{{ $errors->first('password') }}</strong>
               </span>
           @endif
       </div>
   </div>

   <div class="form-group">
       <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

       <div class="col-md-6">
           <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
       </div>
   </div>


  <div class="col-sm-4" style="float:right;">
    <button type="submit" class="btn btn-success" style="float:right; margin-bottom:1em;">
     <span class="glyphicon glyphicon-star" aria-hidden="true"></span>  Agregar</button>
  </div>

<div class="col-lg-12">
  <hr>
</div>





@endsection
