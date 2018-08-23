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
      padding:0.8em;
      /*padding-right: 0.7em;*/
    }
    .col2_of_2{
      width:9cm;
      float: left;
    }
    .col1_of_4{
      width:6.5cm;
      float: left;
        padding:0.8em;
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
    .tg td{font-family:Arial, sans-serif;font-size:14px;padding:2px 20px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
    .tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:2px 20px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}


  </style>
<body>


  <input name="_method" type="hidden" value="PUT">
   {{ csrf_field() }}

<div style="border: 2px solid #000; margin-bottom:2em; height: 470px;">
<div style="background-color:#ccc; padding:0.8em;">
<h1>COOPERATIVA DE AHORRO Y CRÉDITO LA GUADALUPANA, R.L</h1>

<p style="text-align:right;">Déposito a Plazo Fijo <br>
Dólares</p>
</div>

<div class="col1_of_2">
Documento: <br>
Nombre del titular: <br>
Beneficiario: <br>
</div>

<div class="col1_of_2">
  {{$plazo->numdoc}} <br>
  {{$plazo->socio->nombres}} {{$plazo->socio->apellidos}}<br>
  @foreach($plazo->beneficiarios as $ben)
  {{$ben->nombres}} {{$ben->apellidos}} - {{$ben->pivot->porcentaje}}% <br>
  @endforeach
</div>

<div style="clear:both;"></div>

<div>
  <div style="margin-bottom:0;padding-bottom:0; height:1px; background-color:#ccc;">&nbsp;</div>
  <p style="text-align:center; margin-top:0; background-color:#ccc; font-size: 2em;">  US ${{$plazo->monto}}</p>
</div>

<div class="col1_of_4">
Monto Capital: <br>
Intereses: <br>
Monto al Vencimiento: <br>
Frecuencia de Pago de Intereses: <br>
Forma de Pago de Intereses: <br>
</div>

<div class="col1_of_4">
{{$plazo->monto}} <br>
{{$plazo->intereses}} <br>
{{$montven = $plazo->monto + $plazo->intereses}}<br>
{{$plazo->frecpagointere->nombre}}<br>
{{$plazo->formapagointere->nombre}}<br>
</div>

<div class="col1_of_4">
Fecha de Emisión: <br>
Fecha de Vencimiento: <br>
Tasa de Interes Anual: <br>
Plazo(Días): <br>
</div>

<div class="col1_of_4">
{{$plazo->created_at->toDateString()}} <br>
{{$plazo->vencimiento}} <br>
{{$plazo->tasainteres}}% <br>
{{$plazo->diaplazo}} <br>
</div>

<div style="clear:both"></div>

<div style="padding-top: 1em; width:400px; float:left; padding-left:12em;">
______________ <br>
Elaborado
</div>

<div style="padding-top: 1em; width:400px; float:right;">
_______________ <br>
Firma Autorizada
</div>
</div>

</div>

   <table class="tg">
     <tr>
       <th class="tg-031e">Principal</th>
       <th class="tg-031e">${{$plazo->monto}}</th>
     </tr>
     <tr>
       <td class="tg-031e">Intereses Vencimiento</td>
       <td class="tg-031e">${{$plazo->intereses}} </td>
     </tr>
     <tr>
       <td class="tg-031e">Retención IR</td>
       <td class="tg-031e">${{$plazo->ir}}</td>
     </tr>
     <tr>
       <td class="tg-031e">Total a Recibir</td>
       <td class="tg-031e">${{$totalrec=$plazo->monto + $plazo->intereses - $plazo->ir}}</td>
     </tr>
   </table>


</body>
</html>
