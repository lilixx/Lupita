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
    <div class="alert alert-danger" role="alert">{{ session()->get('errormsj') }}</div>
  @endif

<form class="form-horizontal" role="form" method="POST" action="{{ url('sociosadd') }}" enctype="multipart/form-data">
 {{ csrf_field() }}

 <h1 class="titulo"> Agregar Socio </h1>

 <div class="steps">
  <input id="step_1" type="radio" name="steps" checked="checked"/>
  <label class="step" for="step_1" data-title="Socio"><span>1</span></label>
  <input id="step_2" type="radio" name="steps"/>
  <label class="step" for="step_2" data-title="Trabajo"><span>2</span></label>
  <input id="step_3" type="radio" name="steps"/>
  <label class="step" for="step_3" data-title="Pago"><span>3</span></label>

  @if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


  <div class="content">

      <div class="content_1">

              <div class="col-lg-6">
                <div class="form-group">
                  <label for="titulo" class="col-sm-4 control-label">Nombres</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="nombres"  placeholder="Nombres" value={{old('nombres')}}>
                  </div>
                </div>
              </div>


              <div class="col-lg-6">
                <div class="form-group">
                  <label for="titulo" class="col-sm-4 control-label">Apellidos</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="apellidos"  placeholder="Apellidos" value={{old('apellidos')}}>
                  </div>
                </div>
              </div>


              <div class="col-lg-6">
                <div class="form-group">
                  <label for="titulo" class="col-sm-4 control-label">Fecha de Nacimiento</label>
                    <div class="col-sm-8">
                      <div class="input-group">
                          <input type="text" class="form-control datepicker" name="fecha_nac" value={{old('fecha_nac')}}>
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
                    <input type="text" class="form-control" name="lugar_nac"  placeholder="Lugar de Nacimiento" value={{old('lugar_nac')}}>
                  </div>
                </div>
              </div>

              <div class="col-lg-6">
                <div class="form-group">
                  <label for="titulo" class="col-sm-4 control-label">Nacionalidad</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="nacionalidad"  placeholder="Nacionalidad" value={{old('nacionalidad')}}>
                  </div>
                </div>
              </div>

              <div class="col-lg-6">
                <div class="form-group">
                  <label for="titulo" class="col-sm-4 control-label">Sexo</label>
                  <div class="col-sm-8">
                     <label class="radio-inline"><input type="radio" name="sexo" @if(old('sexo')=="F")
                             checked="checked" @endif value="F">F</label>
                     <label class="radio-inline"><input type="radio" @if(old('sexo')=="M")
                             checked="checked" @endif name="sexo" value="M">M</label>
                  </div>
                </div>
              </div>

              <div class="col-lg-6">
                <div class="form-group">
                  <label for="titulo" class="col-sm-4 control-label">Estado civil</label>
                  <div class="col-sm-8">
                  <select class="form-control" name="estado_civil" value={{old('estado_civil')}}>
                      <option value="0" selected="true" disabled="true">Seleccione un Estado civil</option>
                        <option @if(old('estado_civil') == "soltero") selected='selected' @endif>soltero</option>
                        <option @if(old('estado_civil') == "casado") selected='selected' @endif>casado</option>
                        <option @if(old('estado_civil') == "divorciado") selected='selected' @endif>divorciado</option>
                        <option @if(old('estado_civil') == "viudo") selected='selected' @endif>viudo</option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="col-lg-6">
                <div class="form-group">
                  <label for="titulo" class="col-sm-4 control-label">Conyugue</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="nombre_conyuge"  placeholder="Nombre del Conyugue" value={{old('nombre_conyuge')}}>
                  </div>
                </div>
              </div>

              <div class="col-lg-6">
                <div class="form-group">
                  <label for="titulo" class="col-sm-4 control-label">Número de Hijos</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="num_hijos"  placeholder="Número de Hijos" value={{old('num_hijos')}}>
                  </div>
                </div>
              </div>

              <div class="col-lg-6">
                <div class="form-group">
                  <label for="titulo" class="col-sm-4 control-label">Número de Cédula</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="num_cedula"  placeholder="Número de Cédula" value={{old('num_cedula')}}>
                  </div>
                </div>
              </div>

              <div class="col-lg-6">
                <div class="form-group">
                  <label for="titulo" class="col-sm-4 control-label">Número de Licencia</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="num_licencia"  placeholder="Número de Licencia" value={{old('num_licencia')}}>
                  </div>
                </div>
              </div>

              <div class="col-lg-6">
                <div class="form-group">
                  <label for="titulo" class="col-sm-4 control-label">Número INSS</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="num_inss"  placeholder="Número INSS"  value={{old('num_inss')}}>
                  </div>
                </div>
              </div>

              <div class="col-lg-6">
                <div class="form-group">
                  <label for="titulo" class="col-sm-4 control-label">Dirección Completa</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="direccion_casa"  placeholder="Dirección" value={{old('direccion_casa')}}>
                  </div>
                </div>
              </div>

              <div class="col-lg-6">
                <div class="form-group">
                  <label for="titulo" class="col-sm-4 control-label">Municipio</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="municipio"  placeholder="Municipio" value={{old('municipio')}}>
                  </div>
                </div>
              </div>

              <div class="col-lg-6">
                <div class="form-group">
                  <label for="titulo" class="col-sm-4 control-label">Ciudad</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="ciudad"  placeholder="Ciudad" value={{old('ciudad')}}>
                  </div>
                </div>
              </div>

              <div class="col-lg-6">
                <div class="form-group">
                  <label for="titulo" class="col-sm-4 control-label">Departamento</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="departamento"  placeholder="Departamento" value={{old('departamento')}}>
                  </div>
                </div>
              </div>

              <div class="col-lg-6">
                <div class="form-group">
                  <label for="titulo" class="col-sm-4 control-label">Telefono de la Casa</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="telf_casa"  placeholder="Telefono de la casa" value={{old('telf_casa')}}>
                  </div>
                </div>
              </div>

        </div>

<div class="content_2">

      <div class="col-lg-6">
        <div class="form-group">
          <label for="titulo" class="col-sm-4 control-label">Trabajo</label>
          <div class="col-sm-8">
            <select  class="form-control input-sm" name="empresa_id">
             <option value="0" selected="true" disabled="true">Seleccione una Empresa</option>
               @foreach ($empresa as $em)
                 <option value="{{$em->id}}">{{$em->nombre}}</option>
               @endforeach
              </select>
          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="form-group">
          <label for="titulo" class="col-sm-4 control-label">Telefono</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" name="telf_trabajo"  placeholder="Telefono" value={{old('telf_trabajo')}}>
          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="form-group">
          <label for="titulo" class="col-sm-4 control-label">Cargo que ocupa</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" name="cargo"  placeholder="Cargo" value={{old('cargo')}}>
          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="form-group">
          <label for="titulo" class="col-sm-4 control-label">Sueldo que devenga</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" name="sueldo"  placeholder="Sueldo" value={{old('sueldo')}}>
          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="form-group">
          <label for="titulo" class="col-sm-4 control-label">Otros ingresos</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" name="otrosingresos"  placeholder="Otros ingresos" value={{old('otrosingresos')}}>
          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="form-group">
          <label for="titulo" class="col-sm-4 control-label">Origen de estos</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" name="origenoting"  placeholder="Orrigen de los ingresos" value={{old('origenoting')}}>
          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="form-group">
          <label for="titulo" class="col-sm-4 control-label">Tiempo de laborar ahí</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" name="antiguedad"  placeholder="Antiguedad" value={{old('antiguedad')}}>
            </div>
          </div>
        </div>

</div>

<div class="content_3">

    <div class="col-lg-6">
      <div class="form-group">
        <label for="titulo" class="col-sm-3 control-label">Tipo de Pago</label>
        <div class="col-sm-8">
          <select  class="form-control input-sm" name="pagoplanilla">
            <option value="3" selected="true" disabled="true">Seleccione el tipo de pago</option>
              <option @if(old('pagoplanilla') == "1") selected='selected' @endif value="1">Planilla</option>
              <option @if(old('pagoplanilla') == "0") selected='selected' @endif value="0">Efectivo</option>
          </select>
        </div>
      </div>
    </div>



    <div class="col-lg-6">
      <div class="form-group">
        <label for="titulo" class="col-sm-4 control-label">Cantidad de Deducciones</label>
        <div class="col-sm-8">
          <select  class="form-control input-sm" name="afiliacioncatologo_id">
           <option value="0" selected="true" disabled="true">Seleccione una cantidad</option>
            @foreach ($afcat as $ac)
             <option value="{{$ac->id}}">{{$ac->cantidad}}(C${{$ac->valor}})</option>
            @endforeach
            </select>
        </div>
      </div>
    </div>

      <div class="col-lg-12">
        <div class="form-group">
          <label for="titulo" class="col-sm-4 control-label">Comentarios</label>
          <div class="col-sm-8">
            <textarea class="form-control" rows="3" name="comentario"  placeholder="Comentarios" value={{old('comentario')}}></textarea>
          </div>
        </div>
      </div>

      <div class="col-sm-4" style="float:right;">
        <button type="submit" class="btn btn-success" style="float:right; margin-bottom:1em;">
         <span class="glyphicon glyphicon-star" aria-hidden="true"></span>  Agregar</button>
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
