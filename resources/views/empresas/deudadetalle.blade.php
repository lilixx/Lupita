@extends('layouts.app')

@section('content')


<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 20px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 20px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg .tg-yw4l{vertical-align:top}
</style>
<h1 class="titulo cargo"> Detalle de la Planilla de la Empresa: {{$cartera->empresa->nombre}}  </h1>
Planilla: {{$cartera->created_at}}

<table class="tg">
  <tr>
    <th class="tg-yw4l">Socio</th>
    <th class="tg-yw4l">Ahorro</th>
    <th class="tg-yw4l">Afiliacion</th>
    <th class="tg-yw4l">Principal</th>
    <th class="tg-yw4l">Interes</th>
    <th class="tg-yw4l">Principal + Interes</th>
    <th class="tg-yw4l">Total</th>

  </tr>

    @foreach($deudaemp as $de)
     <tr>
        <td class="tg-yw4l">
          @if($de->prestamodetalle_id != null)
            {{$de->prestamodetalle->prestamo->socio->nombres}} {{$de->prestamodetalle->prestamo->socio->apellidos}}
          @elseif($de->afiliaciondetalle_id != null)
            {{$de->afiliaciondetalle->afiliacion->socio->nombres}} {{$de->afiliaciondetalle->afiliacion->socio->apellidos}}
          @else
            {{$de->ahorrodetalle->ahorro->socio->nombres}} {{$de->ahorrodetalle->ahorro->socio->apellidos}}
          @endif
        </td>
        <td class="tg-yw4l">@if($de->ahorrodetalle_id != null){{$de->ahorrodetalle->creditos}}@endif</td>
        <td class="tg-yw4l">@if($de->afiliaciondetalle_id != null){{$de->afiliaciondetalle->afiliacion->afiliacioncatalogo->valor}}@endif</td>
        <td class="tg-yw4l">@if($de->prestamodetalle_id != null){{$de->prestamodetalle->abonoprincipal}} @endif</td>
        <td class="tg-yw4l">@if($de->prestamodetalle_id != null){{$de->prestamodetalle->intereses}}@endif</td>
        <td class="tg-yw4l">@if($de->prestamodetalle_id != null){{$de->prestamodetalle->prestamo->cuota}}@endif</td>
        <td class="tg-yw4l"></td>

      </tr>
    @endforeach

    <tr>
      <td class="tg-yw4l">Total:</td>
      <td class="tg-yw4l">{{$cartera->ahorro}}</td>
      <td class="tg-yw4l">{{$cartera->afiliacion}}</td>
      <td class="tg-yw4l">{{$cartera->principal}}</td>
      <td class="tg-yw4l">{{$cartera->intereses}}</td>
      <td class="tg-yw4l">{{$cartera->principal + $cartera->intereses}}</td>
      <td class="tg-yw4l">{{$cartera->total}}</td>

    </tr>

</table>


@endsection
