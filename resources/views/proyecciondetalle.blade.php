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
    .tg td{font-family:Arial, sans-serif;font-size:14px;padding:2px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
    .tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:2px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
    .tg .tg-c3ow{border-color:inherit;text-align:center;vertical-align:top}
    .tg .tg-us36{vertical-align:top}

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
      <th class="tg-yw4l" colspan="4"></th>
      <th class="tg-c3ow" colspan="3">Dolares</th>
      <th class="tg-us36" colspan="3">Córdobas</th>
      <th class="tg-us36" colspan="3">Cuotas</th>
      <th class="tg-us36" rowspan="2">Saldo<br>Principal</th>
      <th class="tg-us36" rowspan="2">Total<br>Deducción</th>
    </tr>
    <tr>
      <td class="tg-yw4l">N.</td>
      <td class="tg-us36">Socio</td>
      <td class="tg-us36">Ahorro</td>
      <td class="tg-us36">Afiliación</td>
      <td class="tg-us36">Principal</td>
      <td class="tg-us36">Interes</td>
      <td class="tg-us36">Total</td>
      <td class="tg-us36">Principal</td>
      <td class="tg-us36">Interes</td>
      <td class="tg-us36">Total</td>
      <td class="tg-us36">Tot</td>
      <td class="tg-us36">Pag</td>
      <td class="tg-us36">Pen</td>
    </tr>


    @foreach($deuda as $de)

      <tr>
       <td class="tg-yw4l">{{$de['num']}}</td>
       <td class="tg-us36">{{$de['nombres']}} {{$de['apellidos']}}</td>
       <td class="tg-us36">C$ {{$de['ahorro']}}</td>
       <td class="tg-us36">C${{$de['afiliacion']}}</td>
       <td class="tg-us36">$ {{$de['principal']}}</td>
       <td class="tg-us36">$ {{$de['interes']}}</td>
       <td class="tg-us36">$ {{$de['cuota']}}</td>
       <td class="tg-us36">C$ {{number_format($de['principalc'], 2)}}</td>
       <td class="tg-us36">C$ {{$de['interesc']}}</td>
       <td class="tg-us36">C$ {{ number_format($de['cuotac'], 2)}}</td>
       <td class="tg-us36">{{$de['cantcuotas']}}</td>
       <td class="tg-us36">{{$de['numcuota']}}</td>
       <td class="tg-us36">{{$de['cuotap']}}</td>
       <td class="tg-us36">$ {{$de['saldoprincipal']}}</td>
       <td class="tg-us36">C$ {{ number_format($de['total'], 2)}}</td>
      </tr>

    @endforeach

    <tr>
      <td class="tg-us36"></td>
      <td class="tg-us36">Total:</td>
      <td class="tg-us36">C$ {{$totalah}}</td>
      <td class="tg-us36">C$ {{$totalaf}}</td>
      <td class="tg-us36">$ {{$totalpr}}</td>
      <td class="tg-us36">$ {{ number_format($totalin)}}</td>
      <td class="tg-us36">$ {{$totalcu}}</td>
      <td class="tg-us36">C$ {{ number_format($totalprincipalc, 2)}}</td>
      <td class="tg-us36">C$ {{$totalinc}}</td>
      <td class="tg-us36">C$ {{ number_format($totalcuotac, 2)}}</td>
      <td class="tg-us36"></td>
      <td class="tg-us36"></td>
      <td class="tg-us36"></td>
      <td class="tg-us36">$ {{$totalsaldoprincipal}}</td>
      <td class="tg-us36">C$ {{ number_format($totalt, 2)}}</td>
  </tr>


</table>


</body>
</html>
