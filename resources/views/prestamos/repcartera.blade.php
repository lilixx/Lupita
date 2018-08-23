@extends('layouts.app')

@section('content')


<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 20px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 20px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg .tg-yw4l{vertical-align:top}
</style>
<h1 class="titulo cargo"> Cartera de Prestamo  </h1>

<table class="tg">
  <tr>
    <th class="tg-yw4l">N.</th>
    <th class="tg-yw4l">Nombre</th>
    <th class="tg-yw4l">Empresa</th>
    <th class="tg-yw4l">Monto solicitado</th>
    <th class="tg-yw4l">Referencia Prestamo</th>
    <th class="tg-yw4l">Fecha de Vencimiento</th>
    <th class="tg-yw4l">Días para el vencimiento</th>
  </tr>

    @foreach($cartera as $de)
     <tr>
        <td class="tg-yw4l">{{$de['numero']}}</td>
        <td class="tg-yw4l">{{$de['nombre']}} {{$de['apellido']}}</td>
        <td class="tg-yw4l">{{$de['empresa']}}</td>
        <td class="tg-yw4l">{{$de['monto']}}</td>
        <td class="tg-yw4l">{{$de['referencia']}}</td>
        <td class="tg-yw4l">{{$de['vencimiento']}}</td>
        <td class="tg-yw4l">{{$de['diasvencimiento']}}</td>
      </tr>
    @endforeach

</table>


@endsection
