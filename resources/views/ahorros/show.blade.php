@extends('layouts.app')

@section('content')

  @if(session()->has('msj'))
    <div class="alert alert-info" role="alert">{{ session('msj') }}</div>
  @endif
  @if(session()->has('errormsj'))
    <div class="alert alert-danger" role="alert">Error al guardar los datos</div>
  @endif


  <h1 class="titulo huesped"> Ahorros del Socio: {{ $ahorro->socio->nombres }} {{ $ahorro->socio->apellidos }} </h1>

  <div class="col-lg-6 ah">
     Titular : {{ $ahorro->socio->nombres }} {{ $ahorro->socio->apellidos }}<br/>
     Beneficiario: {{$ahorro->beneficiario->nombres}} {{$ahorro->beneficiario->apellidos}} <br/>
  </div>
  <div class="col-lg-6 ah">
     Cedula: {{$ahorro->socio->num_cedula}} <br/>
     Empresa: {{$ahorro->socio->empresa->nombre}} <br/>
  </div>

  <table class="tg">
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

@foreach($ahorro->ahorrodetalles as $ad)
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







@endsection
