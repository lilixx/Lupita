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

    p{
      margin-bottom: 0.25em;
    }

   h1{
      font-size: 1.2em;
      margin-top: 0;
      margin-bottom:0;
      padding-top: 0;

    }

    footer .page:after {
      content: counter(page);
    }

    .tg  {border-collapse:collapse;border-spacing:0;}
    .tg td{font-family:Arial, sans-serif;font-size:14px;padding:12px 20px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
    .tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:12px 20px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
    .tg .tg-s6z2{text-align:center}
    .tg .tg-yw4l{vertical-align:top}

    .col-lg-6.ah1 {
      width: 60%;
      float:left;
    }

    .col-lg-6.ah2 {
      width: 40%;
      float:left;
    }

    .tg td {
    padding: 3px 6px;
  }

  </style>

  <body>

    <header>
    <p>Cooperativa de Ahorro y Credito "LA GUADALUPANA, R.L."</p>
    <h1 style="text-align:center; font-size:1.4em; border-bottom: 2px solid #000; margin-bottom:0px; padding-bottom:0px;">Reporte de Cuenta de Ahorros Dólares US $.</h1>
    </header>

  <div class="col-lg-6 ah1">
     Titular: {{ $ahorro->socio->nombres }} {{ $ahorro->socio->apellidos }}<br/>
     Beneficiario: {{$ahorro->beneficiario->nombres}} {{$ahorro->beneficiario->apellidos}} <br/>
  </div>
  <div class="col-lg-6 ah2">
     Cedula: {{$ahorro->socio->num_cedula}} <br/>
     Empresa: {{$ahorro->socio->empresa->nombre}} <br/>
  </div>

  <table class="tg" style="margin-top:4em;">
  <tr>
    <th class="tg-s6z2" colspan="3">FECHA</th>
    <th class="tg-031e" rowspan="2">CONCEPTO</th>
    <th class="tg-031e" rowspan="2">ROC/CK</th>
    <th class="tg-031e" rowspan="2">DEBITOS</th>
    <th class="tg-031e" rowspan="2">CREDITOS</th>
    <th class="tg-031e" rowspan="2">SALDO FINAL</th>
  </tr>
  <tr>
    <td class="tg-031e">Día</td>
    <td class="tg-031e">Mes</td>
    <td class="tg-yw4l">Año</td>
  </tr>

@foreach($ahorrodet as $ad)
    <tr>
      <td class="tg-031e">{{date("d", strtotime($ad->fecha))}}</td>
      <td class="tg-031e">{{date("m", strtotime($ad->fecha))}}</td>
      <td class="tg-yw4l">{{date("Y", strtotime($ad->fecha))}}</td>
      <td class="tg-yw4l">{{$ad->concepto->nombre}}</td>
      <td class="tg-yw4l">{{$ad->rock_ck}}</td>
      <td class="tg-yw4l" style="text-align:right;">@if($ad->debitos != 0)${{$ad->debitos}}@endif</td>
      <td class="tg-yw4l" style="text-align:right;">@if($ad->creditos != 0)${{$ad->creditos}}@endif</td>
      <td class="tg-yw4l" style="text-align:right;">${{$ad->saldofinal}}</td>
    </tr>
@endforeach

</table>

<div style="margin-bottom: 2em;">&nbsp; </div>

</body>
</html>
