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
      height: 20px;
      margin-bottom: 0;
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
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 20px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 20px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg .tg-yw4l{vertical-align:top}
</style>

<body>

  <header>

  <h1 style="text-align:center; font-size:1.4em; border-bottom: 2px solid #000; margin-bottom:0px; padding-bottom:0px;">Cartera de Prestamo</h1>
  </header>


<table class="tg" style="margin-top:-2em; padding-top: 0;">
  <tr>
    <th class="tg-yw4l">N.</th>
    <th class="tg-yw4l">Nombre</th>
    <th class="tg-yw4l">Empresa</th>
    <th class="tg-yw4l">Monto solicitado</th>
    <th class="tg-yw4l">Num. de Prestamo</th>
    <th class="tg-yw4l">Fecha de Vencimiento</th>
    <th class="tg-yw4l">Días faltante</th>
  </tr>

    @foreach($cartera as $de)
     <tr>
        <td class="tg-yw4l">{{$de['numero']}}</td>
        <td class="tg-yw4l">{{$de['nombre']}} {{$de['apellido']}}</td>
        <td class="tg-yw4l">{{$de['empresa']}}</td>
        <td class="tg-yw4l">${{$de['monto']}}</td>
        <td class="tg-yw4l">{{$de['referencia']}}</td>
        <td class="tg-yw4l">{{$de['vencimiento']}}</td>
        <td class="tg-yw4l">{{$de['diasvencimiento']}}</td>
      </tr>
    @endforeach

</table>

</body>
</html>
