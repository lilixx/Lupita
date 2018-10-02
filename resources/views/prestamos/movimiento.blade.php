<?php
 use Illuminate\Support\Facades\Input; ?>
@extends('layouts.app')

@section('content')

<style>

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

  <input name="_method" type="hidden" value="PUT">
   {{ csrf_field() }}

<h1 class="titulo pais"> Movimientos del @if ($prestamo->anticipo == 0) Prestamo @else Anticipo @endif </h1>

<h2>Socio: {{$prestamo->socio->nombres}} {{$prestamo->socio->apellidos}}</h2>


  <table class="tg">
  <tr>
    <th class="tg-e3zv" rowspan="2">No de Cuota</th>
    <th class="tg-e3zv" rowspan="2">Cuota</th>
    @if ($prestamo->anticipo == 0) <th class="tg-e3zv" rowspan="2">Intereses</th> @endif
    <th class="tg-e3zv" rowspan="2">Abono<br>Principal</th>
    <th class="tg-e3zv" rowspan="2">Saldo</th>
    <th class="tg-amwm" colspan="3">Fecha de Pago</th>
  </tr>
  <tr>
    <td class="tg-amwm">Día</td>
    <td class="tg-9hbo">Mes</td>
    <td class="tg-9hbo">Año</td>
  </tr>

@foreach($mov as $m)
  <tr>
    <td class="tg-yw4l">{{$m->numcuota}}</td>
    <td class="tg-yw4l">${{$m->prestamo->cuota}}</td>
  @if ($prestamo->anticipo == 0)  <td class="tg-yw4l">${{$m->intereses}}</td> @endif
    <td class="tg-yw4l">${{$m->abonoprincipal}}</td>
    <td class="tg-yw4l">${{$m->saldo}}</td>
    <td class="tg-baqh">{{ $m->created_at->format('d') }}</td>
    <td class="tg-yw4l">{{ $m->created_at->format('m') }}</td>
    <td class="tg-yw4l">{{ $m->created_at->format('Y') }}</td>
  </tr>
@endforeach


</table>


@endsection
