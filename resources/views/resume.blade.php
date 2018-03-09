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
    .tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 20px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
    .tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 20px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
    .tg .tg-e3zv{font-weight:bold}
    .tg .tg-9hbo{font-weight:bold;vertical-align:top}
    .tg .tg-yw4l{vertical-align:top}


  </style>
<body>
  <header>
  <p>Cooperativa de Ahorro y Credito "LA GUADALUPANA, R.L."</p>
  <h1 style="text-align:center; font-size:1.4em; border-bottom: 2px solid #000; margin-bottom:0px; padding-bottom:0px;">Resumen de Prestamo</h1>
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


  <div style="clear:both"></div>

<h1 style="text-align:center; padding-top: 1em; margin-bottom: 0.5em;">Información Adicional</h1>

<table class="tg" style="width:100%;">
<tr>
  <th class="tg-e3zv" rowspan="2">Prestamo Solicitado</th>
  <th class="tg-e3zv" rowspan="2">{{$prestamo->monto}}</th>
</tr>
<tr>
</tr>
<tr>
  <td class="tg-9hbo">Plazo Solicitado (Meses)</td>
  <td class="tg-yw4l">{{$prestamo->plazo}}</td>
</tr>
<tr>
  <td class="tg-9hbo">Porcentaje de Comisión</td>
  <td class="tg-yw4l">{{$prestamo->comision->valor/100}}</td>
</tr>
<tr>
  <td class="tg-9hbo">Comision</td>
  <td class="tg-yw4l">{{$comision}}</td>
</tr>
<tr>
  <td class="tg-9hbo">Prestamo Total</td>
  <td class="tg-yw4l">{{$ptotal}}</td>
</tr>
<tr>
  <td class="tg-9hbo">Intereses</td>
  <td class="tg-yw4l">{{$prestamo->intereses}}</td>
</tr>
<tr>
  <td class="tg-9hbo">Deuda Total Dolares</td>
  <td class="tg-yw4l">{{$deudad = $ptotal + $prestamo->intereses}}</td>
</tr>
<tr>
  <td class="tg-9hbo">Deuda Total Córdobas</td>
  <td class="tg-yw4l">{{number_format($deudac = $deudad * $tasac, 2)}}</td>
</tr>
<tr>
  <td class="tg-9hbo">Tasa de Cambio</td>
  <td class="tg-yw4l">{{$tasac}}</td>
</tr>
<tr>
  <td class="tg-9hbo">Cuota @if($prestamo->mensual == 0) Quincenal @else Mensual @endif US$</td>
  <td class="tg-yw4l">{{$prestamo->cuota}}</td>
</tr>
<tr>
  <td class="tg-9hbo">Cuota @if($prestamo->mensual == 0) Quincenal @else Mensual @endif C$</td>
  <td class="tg-yw4l">{{number_format($cuotac = $prestamo->cuota * $tasac, 2)}}</td>
</tr>
@if($prestamo->mensual == 0)
<tr>
  <td class="tg-9hbo">Salario Mensual</td>
  <td class="tg-yw4l">C$ {{$prestamo->socio->sueldo}}</td>
</tr>
<tr>
  <td class="tg-9hbo">Porcentaje Cuota</td>
  <td class="tg-yw4l">{{number_format($cuotac * 2 / $prestamo->socio->sueldo, 2)}}</td>
</tr>
@endif
</table>

</body>
</html>
