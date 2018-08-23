<script
  src="https://code.jquery.com/jquery-2.0.2.min.js"
  integrity="sha256-TZWGoHXwgqBP1AF4SZxHIBKzUdtMGk0hCQegiR99itk="
  crossorigin="anonymous"></script>

<script src="https://code.jquery.com/ui/1.10.3/jquery-ui.min.js"></script>

<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />


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

<form class="form-horizontal" role="form" method="POST" action="{{ url('ahorroadd') }}" enctype="multipart/form-data">
 {{ csrf_field() }}

 <h1 class="titulo"> Crear Cuenta de Ahorro Especial </h1>

 @if (count($errors) > 0)
   <div class="alert alert-danger">
       <ul>
           @foreach ($errors->all() as $error)
               <li>{{ $error }}</li>
           @endforeach
       </ul>
   </div>
@endif

 <div class="steps">
  <input id="step_1" type="radio" name="steps" checked="checked"/>
  <label class="step" for="step_1" data-title="Socio"><span>1</span></label>
  <input id="step_2" type="radio" name="steps"/>
  <label class="step" for="step_2" data-title="Cantidad a Ahorrar"><span>2</span></label>
  <input id="step_3" type="radio" name="steps"/>
  <label class="step" for="step_3" data-title="Beneficiario"><span>3</span></label>


  <div class="content">

      <div class="content_1">


          <div class="col-lg-12">
            <div class="form-group">
              <label for="titulo" class="col-sm-2 control-label">Nombre del Socio</label>
                <div class="col-sm-8">
                     <input type="text" class="form-control2" name="nombresocio" placeholder="Búsqueda del Socio" style="width:300px;">
                 </div>
               </div>
             </div>

            <input type="hidden" name="especial" value="1"> 


           <div class="col-lg-6">
               <div class="form-group">
                 <label for="titulo" class="col-sm-4 control-label">Tasa - ahorro</label>
                 <div class="col-sm-8">
                   <select  class="form-control input-sm" name="ahorrotasa_id">
                      @foreach ($ahorrotasa as $at)
                        <option value="{{$at->id}}">{{$at->valor}}%</option>
                      @endforeach
                     </select>
                 </div>
               </div>
             </div>



              <div class="col-lg-6">
                 <div class="form-group">
                   <label for="titulo" class="col-sm-4 control-label">Deducción </label>
                   <div class="col-sm-8">
                     <select name="dolar" class="form-control" name="dolar">
                        <option value="0" selected="true" disabled="true">seleccione el tipo de deducción</option>
                          <option value="0">Córdoba</option>
                          <option value="1">Dólar</option>
                      </select>
                    </div>
                 </div>
             </div>

             <div class="col-lg-6">
               <div class="form-group">
                 <label for="titulo" class="col-sm-4 control-label">Retención IR</label>
                 <div class="col-sm-8">
                    <label class="radio-inline"><input type="radio" name="retencion" @if(old('retencion')=="Si")
                            checked="checked" @endif value="1">Si</label>
                    <label class="radio-inline"><input type="radio" @if(old('retencion')=="No")
                            checked="checked" @endif name="retencion" value="0">No</label>
                 </div>
               </div>
             </div>


              <div class="col-lg-6">
                <div class="form-group">
                  <label for="titulo" class="col-sm-4 control-label">Fecha de Inicio</label>
                    <div class="col-sm-8">
                      <div class="input-group">
                          <input type="text" class="form-control datepicker" name="fechainicio">
                          <div class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                          </div>
                      </div>
                    </div>
                </div>
              </div>
</div>


<div class="content_2">



      <div class="col-lg-6">
        <div class="form-group">
          <label for="titulo" class="col-sm-4 control-label">Día 15 deducir</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" name="dia15"  placeholder="Día 15 deducir">
          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="form-group">
          <label for="titulo" class="col-sm-4 control-label">Día 30 deducir</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" name="dia30"  placeholder="Día 30 deducir">
          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="form-group">
          <label for="titulo" class="col-sm-4 control-label">Deposito Inicial($)</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" name="depositoinicial"  placeholder="Deposito inicial">
          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="form-group">
          <label for="titulo" class="col-sm-4 control-label">Num. ROC</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" name="rock_ck"  placeholder="Ingrese el numero ROC">
          </div>
        </div>
      </div>


</div>

<div class="content_3">

     <h3 class="titulo">Verificación de Existencia</h3>

  <div class="col-lg-12">
    <div class="form-group">
      <label for="titulo" class="col-sm-2 control-label">Nombre del Beneficiario</label>
        <div class="col-sm-8">
             <input type="text" class="form-control" name="beneficiario" placeholder="Búsqueda del Beneficiario" style="width:300px;">
         </div>
       </div>
     </div>

     <div style="clear:both;"></div>



 <h3 class="titulo">Llenar solo si no existe</h3>

 <div class="col-lg-6">
   <div class="form-group">
     <label for="titulo" class="col-sm-4 control-label">Nombres</label>
     <div class="col-sm-8">
       <input type="text" class="form-control" name="nombreben"  placeholder="Ingrese el nombre del Beneficiario">
     </div>
   </div>
 </div>

 <div class="col-lg-6">
   <div class="form-group">
     <label for="titulo" class="col-sm-4 control-label">Apellidos</label>
     <div class="col-sm-8">
       <input type="text" class="form-control" name="apellidoben"  placeholder="Ingrese los apellidos del beneficiario">
     </div>
   </div>
 </div>

  <div class="col-lg-6">
    <div class="form-group">
      <label for="titulo" class="col-sm-4 control-label">Cédula</label>
      <div class="col-sm-8">
        <input type="text" class="form-control" name="cedulaben"  placeholder="cédula">
      </div>
    </div>
  </div>

  <div class="col-lg-6">
    <div class="form-group">
      <label for="titulo" class="col-sm-4 control-label">Parentesco</label>
      <div class="col-sm-8">
        <input type="text" class="form-control" name="parentescoben"  placeholder="parentesco">
      </div>
    </div>
  </div>

  <div class="col-lg-6">
    <div class="form-group">
      <label for="titulo" class="col-sm-4 control-label">Teléfono</label>
      <div class="col-sm-8">
        <input type="text" class="form-control" name="telefonoben"  placeholder="teléfono">
      </div>
    </div>
  </div>


      <div class="col-lg-12">
        <div class="form-group">
          <label for="titulo" class="col-sm-4 control-label">Comentarios</label>
          <div class="col-sm-8">
            <textarea class="form-control" rows="3" name="comentario"  placeholder="Comentarios"></textarea>
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
        minDate: 'today',
        autoclose: true
    });

</script>

<script type="text/javascript">
var path = "{{ route('autocomplete') }}";
var tds = '<tr>';
bindAutoComplete('form-control');
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
