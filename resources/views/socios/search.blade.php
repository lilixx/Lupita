<script
  src="https://code.jquery.com/jquery-2.0.2.min.js"
  integrity="sha256-TZWGoHXwgqBP1AF4SZxHIBKzUdtMGk0hCQegiR99itk="
  crossorigin="anonymous"></script>

<script src="https://code.jquery.com/ui/1.10.3/jquery-ui.min.js"></script>

<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />


@extends('layouts.app')

@section('content')


  <form class="form-horizontal" role="form" method="POST" action="{{ route('consultsocio') }}" enctype="multipart/form-data">
  <input name="_method" type="hidden" value="PUT">
   {{ csrf_field() }}



<h1 class="titulo cargo"> Búsqueda del Socio </h1>


          <div class="col-lg-12">
            <div class="form-group">
              <label for="titulo" class="col-sm-2 control-label">Nombre del Socio</label>
                <div class="col-sm-8">
                     <input type="text" class="form-control2" name="nombresocio" placeholder="Búsqueda del Socio" style="width:300px;">
                 </div>
               </div>
             </div>



      <div class="col-sm-4" style="float:right;">
        <button type="submit" class="btn btn-success" style="float:right; margin-bottom:1em;">
         <span class="glyphicon glyphicon-star" aria-hidden="true"></span>  Consultar</button>
      </div>

  </div>


</div> <!-- End content -->

</form>


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
