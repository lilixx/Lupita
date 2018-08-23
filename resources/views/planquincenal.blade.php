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
    div#content{
      margin-left: 2.5cm;
      margin-top:0.7cm;
      line-height:0.4cm;
    }
    div#content detalle{
      margin-left: 0.5cm!important;
    }
    .detalle{
      left: 0px;
      right: 0px;
      height: 11cm;
      background-color: red;
    }
    .detalle p {
      margin-left:0.6cm;
    }
    p.pago{
      padding-right:2em;
      text-align:right;
      font-size: 14px;
    }

    p{
      margin-bottom: 0.25em;
    }

    .col_pago{
      float:right;
      width:40%;
    }

    .col_tasa{
      float:left;
      width:50%;
      margin-top:0.7cm;
      padding-left:2em;
    }

    p.pago.iva{
      margin-top:1em!important;
    }

    p.punto{
      line-height: 0;
      color:rgba(0,0,0,0);
    }

    h1{
      font-size: 1.2em;
      margin-top: 0;
      margin-bottom:0;
      padding-top: 0;

    }
    .col1_of_2{
      width:12cm;
      float:left;
      /*padding-right: 0.7em;*/
    }
    .col2_of_2{
      width:9cm;
      float: left;
    }
    .col1_of_4{
      width:2.3cm;
      float: left;
    }
    .col2_of_4{
      width:2.5cm;
      float: left;
    }
    .col3_of_4{
      width:8.2cm;
      float: left;
    }
    .col4_of_4{
      width:3.7cm;
      float: left;
    }
    footer .page:after {
      content: counter(page);
    }

    .tg  {border-collapse:collapse;border-spacing:0;}
  .tg td{font-family:Arial, sans-serif;font-size:14px;padding:5px 22px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
  .tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:5px 22px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
  .tg .tg-baqh{text-align:center;vertical-align:top}
  .tg .tg-e3zv{font-weight:bold}
  .tg .tg-amwm{font-weight:bold;text-align:center;vertical-align:top}
  .tg .tg-9hbo{font-weight:bold;vertical-align:top}
  .tg .tg-yw4l{vertical-align:top}


  </style>
<body>
  <header>
  <p>Cooperativa de Ahorro y Credito "LA GUADALUPANA, R.L."</p>
  <h1 style="text-align:center; font-size:1.4em; border-bottom: 2px solid #000; margin-bottom:0px; padding-bottom:0px;">Plan de Pagos</h1>
  </header>
  <input name="_method" type="hidden" value="PUT">
   {{ csrf_field() }}

  <h1 style="text-align:center; margin-top: 0px; padding-top: 0px;">Datos del Socio</h1>
  <div class="col1_of_2">
    <p>Nombre del Socio: {{$prestamo->socio->nombres}} {{$prestamo->socio->apellidos}}<br/>
    Codigo del Socio: {{$prestamo->socio->num_cedula}}<br/></p>
  </div>
    <div class="col2_of_2">
    <p>  Empresa: {{$prestamo->socio->empresa->nombre}}<br/>
     No. de Solicitud: {{$prestamo->id}}<br/> </p>
  </div>

<h1 style="text-align:center;">Detalle del Financiamiento</h1>
  <div class="col1_of_2">
    <p>Prestamo(Dólares): {{$prestamo->monto}}<br/>
    Tasa de Interés Mensual: 2.00%<br/>
    Plazo(meses): {{$prestamo->plazo}}<br/></p>
  </div>
  <div class="col1_of_2">
  <p>  Cuotas Quincenales: {{$prestamo->cantcuotas}}<br/>
  Cuota quincenal (Dólares): {{$prestamo->cuota}}<br/>
  Fecha del Primer Pago: {{$dia}}/{{$mes}}/{{$año}}<br/></p>
</div>





  </div>

  <div style="clear:both"></div>

<h1 style="text-align:center;">Detalle de Cuotas</h1>


  <table class="tg">
  <tr>
    <th class="tg-e3zv" rowspan="2">No de Cuota</th>
    <th class="tg-e3zv" rowspan="2">Cuota</th>
    <th class="tg-e3zv" rowspan="2">Intereses</th>
    <th class="tg-e3zv" rowspan="2">Abono<br>Principal</th>
    <th class="tg-e3zv" rowspan="2">Saldo</th>
    <th class="tg-amwm" colspan="3">Fecha de Pago</th>
  </tr>
  <tr>
    <td class="tg-amwm">Día</td>
    <td class="tg-9hbo">Mes</td>
    <td class="tg-9hbo">Año</td>
  </tr>

  <tr>
    <td class="tg-yw4l"></td>
    <td class="tg-yw4l"></td>
    <td class="tg-yw4l"></td>
    <td class="tg-yw4l"></td>
    <td class="tg-yw4l">{{$saldo}}</td>
    <td class="tg-baqh"></td>
    <td class="tg-yw4l"></td>
    <td class="tg-yw4l"></td>
  </tr>

  @while ($saldo >= 0 && $i <= $prestamo->cantcuotas)
    <tr>
      <td class="tg-yw4l">{{$i}}</td>
      <td class="tg-yw4l">{{$prestamo->cuota}}</td>
      <td class="tg-yw4l">{{number_format($interes = $saldo * 0.01, 2)}}</td>
      <td class="tg-yw4l">@if($i == $prestamo->cantcuotas) {{number_format($principal = $saldo, 2)}}
      @else{{number_format($principal = $prestamo->cuota - $interes, 2)}} @endif</td>
      <td class="tg-yw4l">{{number_format($saldo = $saldo - $principal, 2)}}</td> <span style="display:none;"> @if($i > 1 && $dia == 30 || $dia == 28){{$mes = $mes+1}} @endif</span>
      <td class="tg-baqh">@if ($i == 1)
        {{$dia}} @elseif($mes == 2 && $dia == 15) {{$dia = 28}} @elseif($dia == 30 || $dia == 28) {{$dia = 15}} @elseif($dia == 15 && $mes != 2) {{$dia = 30}} @endif </td>
      <td class="tg-yw4l">@if ($i == 1){{$mes}} @elseif($mes > 12) {{$mes = 1}} @elseif($mes <= 12) {{$mes}} @endif</td>
      <td class="tg-yw4l">@if($mes == 1 && $dia == 15){{$año = $año + 1}} @else {{$año}} @endif</td>
    </tr>
    <div style ="display:none;">{{$i = $i+1}}</div>
@endwhile


</table>


</body>
</html>
