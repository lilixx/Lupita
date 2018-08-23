<!-- Jquery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">

<!-- Datepicker Files -->
<link rel="stylesheet" href="{{asset('datepicker/css/bootstrap-datepicker3.css')}}">
<link rel="stylesheet" href="{{asset('datepicker/css/bootstrap-datepicker.standalone.css')}}">

<!-- Languaje -->
<script src="{{asset('datepicker/locales/bootstrap-datepicker.es.min.js')}}"></script>

@extends('layouts.app')

@section('content')

  @if(session()->has('msj'))
    <div class="alert alert-info" role="alert">{{ session('msj') }}</div>
  @endif
  @if(session()->has('errormsj'))
    <div class="alert alert-danger" role="alert">Error al guardar los datos</div>
  @endif

  <form class="form-horizontal" role="form" method="POST" action="{{ route('socios.update', $socio->id ) }}" enctype="multipart/form-data">
  <input name="_method" type="hidden" value="PUT">
   {{ csrf_field() }}


 <h1 class="titulo"> Editar Socio </h1>

 <div class="steps">
  <input id="step_1" type="radio" name="steps" checked="checked"/>
  <label class="step" for="step_1" data-title="Socio"><span>1</span></label>
  <input id="step_2" type="radio" name="steps"/>
  <label class="step" for="step_2" data-title="Trabajo"><span>2</span></label>



  <div class="content">

      <div class="content_1">

              <div class="col-lg-6">
                <div class="form-group">
                  <label for="titulo" class="col-sm-4 control-label">Nombres (requerido)</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="nombres" value="{{$socio->nombres}}">
                  </div>
                </div>
              </div>

              <div class="col-lg-6">
                <div class="form-group">
                  <label for="titulo" class="col-sm-4 control-label">Apellidos (requerido)</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="apellidos"  value="{{$socio->apellidos}}">
                  </div>
                </div>
              </div>

              <div class="col-lg-6">
                <div class="form-group">
                  <label for="titulo" class="col-sm-4 control-label">Fecha de Nacimiento (requerido)</label>
                    <div class="col-sm-8">
                      <div class="input-group">
                          <input type="text" class="form-control datepicker" name="fecha_nac" value="{{$socio->fecha_nac}}">
                          <div class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                          </div>
                      </div>
                    </div>
                </div>
              </div>

              <div class="col-lg-6">
                <div class="form-group">
                  <label for="titulo" class="col-sm-4 control-label">Lugar de Nacimiento</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="lugar_nac"  value="{{$socio->lugar_nac}}">
                  </div>
                </div>
              </div>

              <div class="col-lg-6">
                <div class="form-group">
                  <label for="titulo" class="col-sm-4 control-label">Nacionalidad (requerido)</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="nacionalidad"  value="{{$socio->nacionalidad}}">
                  </div>
                </div>
              </div>


              <div class="col-lg-6">
                <div class="form-group">
                  <label for="titulo" class="col-sm-4 control-label">Sexo (requerido)</label>
                  <div class="col-sm-8">
                     <label class="radio-inline"><input type="radio" name="sexo" value="F" @if($socio->sexo=="F")
                             checked="checked" @endif>F</label>
                     <label class="radio-inline"><input type="radio" name="sexo" value="M" @if($socio->sexo=="M")
                             checked="checked" @endif>M</label>
                  </div>
                </div>
              </div>

              <div class="col-lg-6">
                <div class="form-group">
                  <label for="titulo" class="col-sm-4 control-label">Estado civil (requerido)</label>
                  <div class="col-sm-8">
                    <select class="form-control" name="estado_civil">
                        <option @if($socio->estado_civil=="soltero" || $socio->estado_civil=="soltera")
                                selected='selected' @endif>soltero</option>
                        <option @if($socio->estado_civil=="casado" || $socio->estado_civil=="casada")
                                selected='selected' @endif>casado</option>
                        <option @if($socio->estado_civil=="divorciado" || $socio->estado_civil=="divorciada")
                                selected='selected' @endif>divorciado</option>
                        <option @if($socio->estado_civil=="viudo" || $socio->estado_civil=="viuda")
                                selected='selected' @endif>viudo</option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="col-lg-6">
                <div class="form-group">
                  <label for="titulo" class="col-sm-4 control-label">Conyugue</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="nombre_conyuge"  value="{{$socio->nombre_conyuge}}">
                  </div>
                </div>
              </div>

              <div class="col-lg-6">
                <div class="form-group">
                  <label for="titulo" class="col-sm-4 control-label">Número de Hijos</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="num_hijos" value="{{$socio->num_hijos}}">
                  </div>
                </div>
              </div>

              <div class="col-lg-6">
                <div class="form-group">
                  <label for="titulo" class="col-sm-4 control-label">Número de Cédula (requerido)</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="num_cedula" value="{{$socio->num_cedula}}">
                  </div>
                </div>
              </div>

              <div class="col-lg-6">
                <div class="form-group">
                  <label for="titulo" class="col-sm-4 control-label">Número de Licencia</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="num_licencia" value="{{$socio->num_licencia}}">
                  </div>
                </div>
              </div>

              <div class="col-lg-6">
                <div class="form-group">
                  <label for="titulo" class="col-sm-4 control-label">Número INSS</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="num_inss"  value="{{$socio->num_inss}}">
                  </div>
                </div>
              </div>

              <div class="col-lg-6">
                <div class="form-group">
                  <label for="titulo" class="col-sm-4 control-label">Dirección Completa</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="direccion_casa"  value="{{$socio->direccion_casa}}">
                  </div>
                </div>
              </div>

              <div class="col-lg-6">
                <div class="form-group">
                  <label for="titulo" class="col-sm-4 control-label">Municipio</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="municipio" value="{{$socio->municipio}}">
                  </div>
                </div>
              </div>

              <div class="col-lg-6">
                <div class="form-group">
                  <label for="titulo" class="col-sm-4 control-label">Ciudad (requerido)</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="ciudad" value="{{$socio->ciudad}}">
                  </div>
                </div>
              </div>

              <div class="col-lg-6">
                <div class="form-group">
                  <label for="titulo" class="col-sm-4 control-label">Departamento (requerido)</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="departamento" value="{{$socio->departamento}}">
                  </div>
                </div>
              </div>

              <div class="col-lg-6">
                <div class="form-group">
                  <label for="titulo" class="col-sm-4 control-label">Telefono de la Casa</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="telf_casa" value="{{$socio->telf_casa}}">
                  </div>
                </div>
              </div>

        </div>

<div class="content_2">

      <div class="col-lg-6">
        <div class="form-group">
          <label for="titulo" class="col-sm-4 control-label">Trabajo (requerido)</label>
          <div class="col-sm-8">
            <select  class="form-control input-sm" name="empresa_id">
             <option value="0" selected="true" disabled="true">Seleccione una Empresa</option>
               @foreach ($empresa as $em)
                <option value="{{ $em->id }}"  @if($em->id==$socio->empresa_id)
                        selected='selected' @endif> {{ $em->nombre }}   </option>
               @endforeach
            </select>
          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="form-group">
          <label for="titulo" class="col-sm-4 control-label">Telefono</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" name="telf_trabajo"  value="{{$socio->telf_trabajo}}">
          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="form-group">
          <label for="titulo" class="col-sm-4 control-label">Cargo que ocupa</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" name="cargo"  value="{{$socio->cargo}}">
          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="form-group">
          <label for="titulo" class="col-sm-4 control-label">Sueldo que devenga</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" name="sueldo" value="{{$socio->sueldo}}">
          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="form-group">
          <label for="titulo" class="col-sm-4 control-label">Otros ingresos</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" name="otrosingresos"  value="{{$socio->otrosingresos}}">
          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="form-group">
          <label for="titulo" class="col-sm-4 control-label">Origen de estos</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" name="origenoting"  value="{{$socio->origenoting}}">
          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="form-group">
          <label for="titulo" class="col-sm-4 control-label">Tiempo de laborar ahí</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" name="antiguedad"  value="{{$socio->antiguedad}}">
            </div>
          </div>
        </div>

        <div class="col-sm-4" style="float:right;">
          <button type="submit" class="btn btn-success" style="float:right; margin-bottom:1em;">
           <span class="glyphicon glyphicon-star" aria-hidden="true"></span>  Editar</button>
        </div>

</div>





</div> <!-- End content -->

</form>

<script>
    $('.datepicker').datepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,
        language: "es",
        maxDate: '-18y',
        autoclose: true
    });

</script>





@endsection
