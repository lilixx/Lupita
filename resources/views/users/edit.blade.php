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

 <h1 class="titulo cliente"> Editar Usuario </h1>

   <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
       <label for="name" class="col-md-4 control-label">Nombre de usuario</label>

       <div class="col-md-6">
           <input id="name" type="text" class="form-control" name="name" value="{{ $user->name }}" required autofocus readonly>

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
            <option value="{{ $rl->id }}" @foreach($user->roles as $userl)
              @if($rl->id==$userl->id)
                      selected='selected' @endif
            @endforeach> {{ $rl->nombre }}   </option>
          @endforeach
         </select>
      </div>
     </div>


   <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
       <label for="email" class="col-md-4 control-label">E-Mail </label>

       <div class="col-md-6">
           <input id="email" type="email" class="form-control" name="email" value="{{ $user->email }}" required>

           @if ($errors->has('email'))
               <span class="help-block">
                   <strong>{{ $errors->first('email') }}</strong>
               </span>
           @endif
       </div>
   </div>


  <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
      <label for="password" class="col-md-4 control-label">Nueva Contraseña</label>

      <div class="col-md-6">
          <input id="password" type="password" class="form-control" name="password">

          @if ($errors->has('password'))
              <span class="help-block">
                  <strong>{{ $errors->first('password') }}</strong>
              </span>
          @endif
      </div>
  </div>

  <div class="form-group">
      <label for="password-confirm" class="col-md-4 control-label">Confirmar Contraseña</label>

      <div class="col-md-6">
          <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
      </div>
  </div>


  <div class="col-sm-4" style="float:right;">
    <button type="submit" class="btn btn-edit" style="float:right; margin-bottom:1em;">
     <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>  Modificar</button>
  </div>

<div class="col-lg-12">
  <hr>
</div>





@endsection
