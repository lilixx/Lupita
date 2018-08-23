<html>
<head>
  <style>
    body{
      font-family: sans-serif;
    }
    @page {
      margin: 110px 60px;
    }
    header { position: fixed;
      left: 0px;
      top: -88px;
      right: 0px;
      height: 50px;
      text-align: center;

    }
    header h1{
      margin: 0 0;
    }
    header h2{
      margin: 0 0 5px 0;
    }


.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 20px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 20px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg .tg-yw4l{vertical-align:top}
</style>
<body>
  <header>
  <p>Cooperativa de Ahorro y Credito "LA GUADALUPANA, R.L."</p>
  <h1 style="text-align:center; font-size:1.4em; border-bottom: 2px solid #000; margin-bottom:0px; padding-bottom:0px;">Detalle de Planilla de la Empresa: {{$empresa->nombre}} </h1>
  </header>
  <input name="_method" type="hidden" value="PUT">
   {{ csrf_field() }}

  <h1 style="text-align:center; margin-top: 0px; padding-top: 0px; padding-bottom: 0.5em; ">Planilla: {{$today}} </h1>

  <div style="clear:both"></div>



<table class="tg">
  <tr>
    <th class="tg-us36">Socio</th>
    <th class="tg-us36">Ahorro</th>
    <th class="tg-us36">Afiliacion</th>
    <th class="tg-us36">Prestamo</th>
    <th class="tg-us36">Total</th>

  </tr>

    @foreach($deuda as $de)

      <tr>
       <td class="tg-us36">{{$de['nombres']}} {{$de['apellidos']}}</td>
       <td class="tg-us36">{{$de['ahorro']}}</td>
       <td class="tg-us36">{{$de['afiliacion']}}</td>
       <td class="tg-us36">{{$de['prestamo']}}</td>
       <td class="tg-us36">{{$de['total']}}</td>
      </tr>

    @endforeach

    <tr>
      <td class="tg-us36">Total:</td>
      <td class="tg-us36">{{$totalah}}</td>
      <td class="tg-us36">{{$totalaf}}</td>
      <td class="tg-us36">{{$totalpr}}</td>
      <td class="tg-us36">{{$totalt}}</td>
  </tr>


</table>


</body>
</html>
