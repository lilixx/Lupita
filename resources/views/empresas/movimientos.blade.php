@extends('layouts.app')

@section('content')


<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 20px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 20px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg .tg-yw4l{vertical-align:top}
table.tg {
    margin-top: 0.5em;
    margin-bottom: 2em;
}
</style>

<h1 class="titulo cargo">Movimiento de la Empresa: {{$empresa->nombre}} </h1>

@foreach($carteras as $ct)
  Cartera: {{$ct->created_at}} <br/>
  Total: {{$ct->total}} <br/>
  <table class="tg">
    <tr>
      <th class="tg-yw4l">Fecha del Movimiento</th>
      <th class="tg-yw4l">Abono</th>
      <th class="tg-yw4l">Saldo Pendiente</th>
      <th class="tg-yw4l">Número del recibo</th>
    </tr>
    @foreach($ct->carteradetalles as $cdet)
      <tr>
         <td class="tg-yw4l">{{$cdet->created_at}}</td>
         <td class="tg-yw4l">{{$cdet->abono}}</td>
         <td class="tg-yw4l">{{$cdet->saldo}}</td>
         <td class="tg-yw4l">{{$cdet->recibo}}</td>
     </tr>

    @endforeach
    </table>

@endforeach

@endsection
