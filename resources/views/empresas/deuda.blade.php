@extends('layouts.app')

@section('content')


<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 20px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 20px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg .tg-yw4l{vertical-align:top}
</style>
<h1 class="titulo cargo"> Deuda de: {{$empresa->nombre}} </h1>

<table class="tg">
  <tr>
    <th class="tg-yw4l">Planilla</th>
    <th class="tg-yw4l">Ahorro</th>
    <th class="tg-yw4l">Afiliacion</th>
    <th class="tg-yw4l">Principal</th>
    <th class="tg-yw4l">Interes</th>
    <th class="tg-yw4l">Principal + Interes</th>
    <th class="tg-yw4l">Total</th>
    <th class="tg-yw4l">Ver Detalles</th>
  </tr>

    @foreach($deuda as $de)
     <tr>
        <td class="tg-yw4l">{{$de->created_at}}</td>
        <td class="tg-yw4l">{{$de->ahorro}}</td>
        <td class="tg-yw4l">{{$de->afiliacion}}</td>
        <td class="tg-yw4l">{{$de->principal}}</td>
        <td class="tg-yw4l">{{$de->intereses}}</td>
        <td class="tg-yw4l">{{$de->principal + $de->intereses}}</td>
        <td class="tg-yw4l">{{$de->total}}</td>
        <td class="tg-yw4l"><a href="<?php echo  url('/');?>/empresas/{{ $de->id }}/deudadetalle" class="btn btn-rose" title="Ver detalles">
         <span class="fas fa-archive" aria-hidden="true"></span>
        </a></td>

      </tr>
    @endforeach

</table>


@endsection
