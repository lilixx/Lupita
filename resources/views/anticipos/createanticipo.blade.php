<script
  src="https://code.jquery.com/jquery-2.0.2.min.js"
  integrity="sha256-TZWGoHXwgqBP1AF4SZxHIBKzUdtMGk0hCQegiR99itk="
  crossorigin="anonymous"></script>

<script src="https://code.jquery.com/ui/1.10.3/jquery-ui.min.js"></script>

<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />

<?php
 use Illuminate\Support\Facades\Input; ?>
@extends('layouts.app')

@section('content')

  @if(session()->has('msj'))
    <div class="alert alert-info" role="alert">{{ session('msj') }}</div>
  @endif
  @if(session()->has('errormsj'))
    <div class="alert alert-danger" role="alert">Error el plazo debe ser menor o igual a 4</div>
  @endif


<form class="form-horizontal" action="{{URL::current()}}">
<h1 class="titulo pais"> Agregar Anticipo </h1>

@if (count($errors) > 0)
  <div class="alert alert-danger">
      <ul>
          @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
      </ul>
  </div>
@endif


  <div class="col-lg-6">
     <div class="form-group">
       <label for="titulo" class="col-sm-4 control-label">Monto</label>
       <div class="col-sm-8">
         <input type="text" class="form-control" name="monto" value="{{Input::get('monto')}}" required>
       </div>
     </div>
 </div>

 <div class="col-lg-6">
   <div class="form-group">
     <label for="titulo" class="col-sm-4 control-label">Plazo(quincenas)</label>
     <div class="col-sm-8">
       <input type="text" class="form-control" name="plazo" value="{{Input::get('plazo')}}" required>
     </div>
   </div>
 </div>


  <div class="col-sm-4" style="float:right;">
    <button type="submit" class="btn btn-success" style="float:right; margin-bottom:1em;">
     <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Consultar</button>
  </div>

  <div class="col-lg-12">
     <hr>
 </div>

</form>

<form class="form-horizontal" role="form" method="POST" action="{{ url('prestamosadd') }}" enctype="multipart/form-data">

  {{ csrf_field() }}


       <div class="col-lg-6">
         <div class="form-group">
           <label for="titulo" class="col-sm-4 control-label">Socio</label>
             <div class="col-sm-8">
                   <input type="text" class="form-control2" name="nombresocio" placeholder="Búsqueda del Socio" style="width:300px;" value={{old('nombresocio')}}>
              </div>
            </div>
          </div>



  <div class="col-lg-6">
    <div class="form-group">
      <label for="titulo" class="col-sm-4 control-label">Comisión</label>
      <div class="col-sm-8">
        <input type="text" class="form-control" name="comision" value="{{$comision}}" readonly>
      </div>
    </div>
  </div>

  <input type="hidden" name="monto" value="{{Input::get('monto')}}">

  <input type="hidden" name="plazo" value="{{Input::get('plazo')}}">

  <input type="hidden" name="corte" value="{{Input::get('corte')}}">

  <input type="hidden" name="comision_id" value="{{$comisionid}}">


  <div class="col-lg-6">
    <div class="form-group">
      <label for="titulo" class="col-sm-4 control-label">Cant. cuotas</label>
      <div class="col-sm-8">
        <input type="text" class="form-control" name="cantcuotas" value="{{$cquincenal}}" readonly>
      </div>
    </div>
  </div>

  <div class="col-lg-6">
    <div class="form-group">
      <label for="titulo" class="col-sm-4 control-label">Cuota</label>
      <div class="col-sm-8">
        <input type="text" class="form-control" name="cuota" value="{{$cuota2}}" readonly>
      </div>
    </div>
  </div>

  @if(Input::get('corte') == 1)

  <div class="col-lg-6">
    <div class="form-group">
      <label for="titulo" class="col-sm-4 control-label">Pago Mensual</label>
      <div class="col-sm-8">
        <select name="pmensual" class="form-control" name="pmensual" required>
           <option></option>
             <option value="15">15</option>
             <option value="30">30</option>
         </select>
      </div>
    </div>
  </div>

@endif


  <div class="col-lg-6">
    <div class="form-group">
      <label for="titulo" class="col-sm-4 control-label">Num. de Recibo</label>
      <div class="col-sm-8">
        <input type="text" class="form-control" name="num_cheque"  placeholder="Ingrese el número del recibo" value={{old('num_cheque')}}>
      </div>
    </div>
  </div>


   <div class="col-sm-4" style="float:right;">
     <button class="btn btn-edit" style="float:right; margin-bottom:1em; margin-top:2em;">
      <span class="glyphicon glyphicon-send" aria-hidden="true"></span> Crear</button>
   </div>

</form>

<script type="text/javascript">
var path = "{{ route('autocomplete') }}";
var tds = '<tr>';
bindAutoComplete('form-control3');
bindAutoComplete2('form-control2');

function bindAutoComplete(classname){
$("."+classname).autocomplete({
        source: function (request, response) {
            $.ajax({
                url: 'http://127.0.0.1:8000/autocomplete',
                type: "GET",
                dataType: "json",
                data: { term: request.term },
                success: function (data) {
                    if (data != null) {
                        if (data.length > 0) {
                            response($.map(data, function (element) {
                                return element.name + ' ' + element.apellidos + ' ('+ "cod." + element.id + ')';

                            }))
                        }
                      /*  else {
                            response([{ label: 'No results found.' }]);
                        } */
                    }
               }
          })
      },
      select: function (event, ui) {
        var name = ui.item.value;
        var v = ui.item.id;
        $("#MessageTo").val(ui.item.id);
       }


 });

}

function bindAutoComplete2(classname){
$("."+classname).autocomplete({
        source: function (request, response) {
            $.ajax({
                url: 'http://127.0.0.1:8000/socioautocomplete',
                type: "GET",
                dataType: "json",
                data: { term: request.term },
                success: function (data) {
                    if (data != null) {
                        if (data.length > 0) {
                            response($.map(data, function (element) {
                                return element.name + ' ' + element.apellidos + ' ('+ "cod." + element.id + ')';

                            }))
                        }
                      /*  else {
                            response([{ label: 'No results found.' }]);
                        } */
                    }
               }
          })
      },
      select: function (event, ui) {
        var name = ui.item.value;
        var v = ui.item.id;
        $("#MessageTo").val(ui.item.id);
       }


 });

}

</script>


@endsection
