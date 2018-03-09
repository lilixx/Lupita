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
    <div class="alert alert-danger" role="alert">Error: no tiene suficiente dinero en su cuenta de ahorro o no posee cuenta de ahorro</div>
  @endif

<form class="form-horizontal" role="form" method="POST" action="{{ url('plazofijoadd') }}" enctype="multipart/form-data">
 {{ csrf_field() }}

 <h1 class="titulo"> Crear Plazo Fijo</h1>

 <div class="steps">
  <input id="step_1" type="radio" name="steps" checked="checked"/>
  <label class="step" for="step_1" data-title="Socio"><span>1</span></label>
  <input id="step_2" type="radio" name="steps"/>
  <label class="step" for="step_2" data-title="Monto"><span>2</span></label>
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

             <div class="col-lg-6">
               <div class="form-group">
                 <label for="titulo" class="col-sm-4 control-label">Num. Documento</label>
                 <div class="col-sm-8">
                   <input type="text" class="form-control" name="numdoc"  placeholder="Ingrese el número de  documento">
                 </div>
               </div>
             </div>


              <div class="col-lg-6">
                <div class="form-group">
                  <label for="titulo" class="col-sm-4 control-label">Vencimiento</label>
                    <div class="col-sm-8">
                      <select name="vencimiento" class="form-control" name="vencimiento">
                        <option value="0" selected="true" disabled="true">Indique el vencimiento</option>
                           <option value="anual">Anual</option>
                           <option value="semestral">Semestral</option>
                       </select>
                    </div>
                </div>
              </div>
</div>


<div class="content_2">

      <div class="col-lg-6">
        <div class="form-group">
          <label for="titulo" class="col-sm-4 control-label">Monto Capital</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" name="monto"  placeholder="Ingrese el monto">
          </div>
        </div>
      </div>


      <div class="col-lg-6">
         <div class="form-group">
           <label for="titulo" class="col-sm-4 control-label">Debito a la cuenta de ahorro</label>
           <div class="col-sm-8">
             <select name="debitoch" class="form-control" name="debitoch">
               <option value="0" selected="true" disabled="true">Indique si es debito a la cuenta de ahorro</option>
                  <option value="0">No</option>
                  <option value="1">Si</option>
              </select>
            </div>
         </div>
     </div>

     <div class="col-lg-6">
       <div class="form-group">
         <label for="titulo" class="col-sm-4 control-label">Nota de Debito</label>
         <div class="col-sm-8">
           <input type="text" class="form-control" name="rock_ck"  placeholder="Ingrese el numero de la nota">
         </div>
       </div>
     </div>


      <div class="col-lg-6">
        <div class="form-group">
          <label for="titulo" class="col-sm-4 control-label">Frecuencia de pago de interes</label>
              <div class="col-sm-8">
                  <select name="frecpagointere_id" class="form-control" name="frecpagointere_id">
                     <option value="0" selected="true" disabled="true">Seleccione la frecuencia</option>
                     @foreach ($frecuenciapago as $fp)
                       <option value="{{$fp->id}}">{{$fp->nombre}}</option>
                     @endforeach
                   </select>
                </div>
              </div>
           </div>


           <div class="col-lg-6">
             <div class="form-group">
               <label for="titulo" class="col-sm-4 control-label">Forma de pago de interes</label>
                   <div class="col-sm-8">
                       <select name="formapagointere_id" class="form-control" name="formapagointere_id">
                          <option value="0" selected="true" disabled="true">Seleccione la forma de pago</option>
                          @foreach ($formapago as $fpa)
                            <option value="{{$fpa->id}}">{{$fpa->nombre}}</option>
                          @endforeach
                        </select>
                     </div>
                   </div>
                </div>

        <div class="col-lg-6">
        <div class="form-group">
          <label for="titulo" class="col-sm-4 control-label">Tasa de interes Anual</label>
          <div class="col-sm-8">
            <div class="input-group">
              <span class="input-group-addon" id="basic-addon1">%</span>
              <input type="text" class="form-control" name="tasainteres">
            </div>
          </div>
        </div>
      </div>


</div>

<div class="content_3">

 <h3 class="titulo">Primer Beneficiario - Verificación de Existencia</h3>

  <div class="col-lg-12">
    <div class="form-group">
      <label for="titulo" class="col-sm-2 control-label">Nombre del Beneficiario</label>
        <div class="col-sm-8">
             <input type="text" class="form-control3" name="beneficiario[]" placeholder="Búsqueda del Beneficiario" style="width:300px;">
         </div>
       </div>
     </div>

     <div class="col-lg-6">
     <div class="form-group">
       <label for="titulo" class="col-sm-4 control-label">Porcentaje de Beneficio </label>
       <div class="col-sm-8">
         <div class="input-group">
           <span class="input-group-addon" id="basic-addon1">%</span>
           <input type="text" class="form-control" name="porcentajeaut[]">
         </div>
       </div>
     </div>
   </div>

     <div style="clear:both;"></div>



 <h3 class="titulo">Primer Beneficiario - Llenar solo si no existe</h3>

 <div class="col-lg-6">
   <div class="form-group">
     <label for="titulo" class="col-sm-4 control-label">Nombres</label>
     <div class="col-sm-8">
       <input type="text" class="form-control" name="nombreben[]"  placeholder="Ingrese el nombre del Beneficiario">
     </div>
   </div>
 </div>

 <div class="col-lg-6">
   <div class="form-group">
     <label for="titulo" class="col-sm-4 control-label">Apellidos</label>
     <div class="col-sm-8">
       <input type="text" class="form-control" name="apellidoben[]"  placeholder="Ingrese los apellidos del beneficiario">
     </div>
   </div>
 </div>

  <div class="col-lg-6">
    <div class="form-group">
      <label for="titulo" class="col-sm-4 control-label">Cédula</label>
      <div class="col-sm-8">
        <input type="text" class="form-control" name="cedulaben[]"  placeholder="cédula">
      </div>
    </div>
  </div>

  <div class="col-lg-6">
  <div class="form-group">
    <label for="titulo" class="col-sm-4 control-label">Porcentaje de Beneficio </label>
    <div class="col-sm-8">
      <div class="input-group">
        <span class="input-group-addon" id="basic-addon1">%</span>
        <input type="text" class="form-control" name="porcentajema[]">
      </div>
    </div>
  </div>
</div>

  <div class="col-lg-6">
    <div class="form-group">
      <label for="titulo" class="col-sm-4 control-label">Parentesco</label>
      <div class="col-sm-8">
        <input type="text" class="form-control" name="parentescoben[]"  placeholder="cédula">
      </div>
    </div>
  </div>

  <div class="col-lg-6">
    <div class="form-group">
      <label for="titulo" class="col-sm-4 control-label">Teléfono</label>
      <div class="col-sm-8">
        <input type="text" class="form-control" name="telefonoben[]"  placeholder="teléfono">
      </div>
    </div>
  </div>

  <div style="clear:both;"></div>


  <h3 class="titulo">Segundo Beneficiario - Verificación de Existencia</h3>

   <div class="col-lg-12">
     <div class="form-group">
       <label for="titulo" class="col-sm-2 control-label">Nombre del Beneficiario</label>
         <div class="col-sm-8">
              <input type="text" class="form-control3" name="beneficiario[]" placeholder="Búsqueda del Beneficiario" style="width:300px;">
          </div>
        </div>
      </div>

      <div class="col-lg-6">
      <div class="form-group">
        <label for="titulo" class="col-sm-4 control-label">Porcentaje de Beneficio </label>
        <div class="col-sm-8">
          <div class="input-group">
            <span class="input-group-addon" id="basic-addon1">%</span>
            <input type="text" class="form-control" name="porcentajeaut[]">
          </div>
        </div>
      </div>
    </div>

      <div style="clear:both;"></div>



  <h3 class="titulo">Segundo Beneficiario - Llenar solo si no existe</h3>

  <div class="col-lg-6">
    <div class="form-group">
      <label for="titulo" class="col-sm-4 control-label">Nombres</label>
      <div class="col-sm-8">
        <input type="text" class="form-control" name="nombreben[]"  placeholder="Ingrese el nombre del Beneficiario">
      </div>
    </div>
  </div>

  <div class="col-lg-6">
    <div class="form-group">
      <label for="titulo" class="col-sm-4 control-label">Apellidos</label>
      <div class="col-sm-8">
        <input type="text" class="form-control" name="apellidoben[]"  placeholder="Ingrese los apellidos del beneficiario">
      </div>
    </div>
  </div>

   <div class="col-lg-6">
     <div class="form-group">
       <label for="titulo" class="col-sm-4 control-label">Cédula</label>
       <div class="col-sm-8">
         <input type="text" class="form-control" name="cedulaben[]"  placeholder="cédula">
       </div>
     </div>
   </div>

   <div class="col-lg-6">
   <div class="form-group">
     <label for="titulo" class="col-sm-4 control-label">Porcentaje de Beneficio </label>
     <div class="col-sm-8">
       <div class="input-group">
         <span class="input-group-addon" id="basic-addon1">%</span>
         <input type="text" class="form-control" name="porcentajema[]">
       </div>
     </div>
   </div>
 </div>

   <div class="col-lg-6">
     <div class="form-group">
       <label for="titulo" class="col-sm-4 control-label">Parentesco</label>
       <div class="col-sm-8">
         <input type="text" class="form-control" name="parentescoben[]"  placeholder="cédula">
       </div>
     </div>
   </div>

   <div class="col-lg-6">
     <div class="form-group">
       <label for="titulo" class="col-sm-4 control-label">Teléfono</label>
       <div class="col-sm-8">
         <input type="text" class="form-control" name="telefonoben[]"  placeholder="teléfono">
       </div>
     </div>
   </div>

   <div style="clear:both;"></div>

   <h3 class="titulo">Tercer Beneficiario - Verificación de Existencia</h3>

    <div class="col-lg-12">
      <div class="form-group">
        <label for="titulo" class="col-sm-2 control-label">Nombre del Beneficiario</label>
          <div class="col-sm-8">
               <input type="text" class="form-control3" name="beneficiario[]" placeholder="Búsqueda del Beneficiario" style="width:300px;">
           </div>
         </div>
       </div>

       <div class="col-lg-6">
       <div class="form-group">
         <label for="titulo" class="col-sm-4 control-label">Porcentaje de Beneficio </label>
         <div class="col-sm-8">
           <div class="input-group">
             <span class="input-group-addon" id="basic-addon1">%</span>
             <input type="text" class="form-control" name="porcentajeaut[]">
           </div>
         </div>
       </div>
     </div>

       <div style="clear:both;"></div>



   <h3 class="titulo">Tercer Beneficiario - Llenar solo si no existe</h3>

   <div class="col-lg-6">
     <div class="form-group">
       <label for="titulo" class="col-sm-4 control-label">Nombres</label>
       <div class="col-sm-8">
         <input type="text" class="form-control" name="nombreben[]"  placeholder="Ingrese el nombre del Beneficiario">
       </div>
     </div>
   </div>

   <div class="col-lg-6">
     <div class="form-group">
       <label for="titulo" class="col-sm-4 control-label">Apellidos</label>
       <div class="col-sm-8">
         <input type="text" class="form-control" name="apellidoben[]"  placeholder="Ingrese los apellidos del beneficiario">
       </div>
     </div>
   </div>

    <div class="col-lg-6">
      <div class="form-group">
        <label for="titulo" class="col-sm-4 control-label">Cédula</label>
        <div class="col-sm-8">
          <input type="text" class="form-control" name="cedulaben[]"  placeholder="cédula">
        </div>
      </div>
    </div>

    <div class="col-lg-6">
    <div class="form-group">
      <label for="titulo" class="col-sm-4 control-label">Porcentaje de Beneficio </label>
      <div class="col-sm-8">
        <div class="input-group">
          <span class="input-group-addon" id="basic-addon1">%</span>
          <input type="text" class="form-control" name="porcentajema[]">
        </div>
      </div>
    </div>
  </div>

    <div class="col-lg-6">
      <div class="form-group">
        <label for="titulo" class="col-sm-4 control-label">Parentesco</label>
        <div class="col-sm-8">
          <input type="text" class="form-control" name="parentescoben[]"  placeholder="cédula">
        </div>
      </div>
    </div>

    <div class="col-lg-6">
      <div class="form-group">
        <label for="titulo" class="col-sm-4 control-label">Teléfono</label>
        <div class="col-sm-8">
          <input type="text" class="form-control" name="telefonoben[]"  placeholder="teléfono">
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
