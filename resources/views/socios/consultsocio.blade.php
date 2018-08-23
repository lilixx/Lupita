@extends('layouts.app')

@section('content')

  <h1 class="titulo pais"> Socio: {{$socio->nombres}} {{$socio->apellidos}} </h1>

<!-- Ahorros -->

<h1 class="titulo sub"> Ahorros </h1>

<table class="table table-hover">

<thead>
  <th>Socio</th>
  <th>Tipo de Cuenta</th>
  <th>Día 15</th>
  <th>Día 30</th>
  <th>Estado</th>
  <th>Acciones</th>

</thead>

@forelse($ahorro as $n)
  <tr>
    <td>{{$n->socio->nombres}}  {{$n->socio->apellidos}}</td>
    <td>@if($n->dolar == 1) Dólar @else Córdoba @endif</td>
    <td>
    {{$n->dia15}}
    </td>
    <td>
    {{$n->dia30}}
    </td>
    <td>@if($n->activo == 1) Activo @else Inactivo @endif</td>
    <td>

      <a href="ahorros/{{ $n->id }}/show" class="btn btn-success" title="Ver movimientos">
      <span class="glyphicon glyphicon-search" aria-hidden="true"></span></a>

      <form target="_blank" class="form-horizontal button" role="form" method="POST" action="{{ route('ahorros.repch', $n->id ) }}" enctype="multipart/form-data">
          <input name="_method" type="hidden" value="PUT">
           {{ csrf_field() }}
           <button type="submit" class="btn btn-primary" title="reporte cuenta">
             <span class="far fa-file-pdf" aria-hidden="true"></span>
           </button>
      </form>

    @if($n->activo == 1)
          <a href="<?php echo  url('/');?>/ahorros/{{ $n->id }}/movimiento" class="btn btn-edit" title="Crear Movimiento">
           <span class="fas fa-sign-out-alt" aria-hidden="true"></span>
          </a>


        @if($n->pausada == 0)
          <form class="form-horizontal button" role="form" method="POST" action="{{ route('ahorros.pausar', $n->id ) }}" enctype="multipart/form-data"
             onsubmit="return confirm('¿Está seguro de Pausar la Cuenta de ahorro?')">
            <input name="_method" type="hidden" value="PUT">
             {{ csrf_field() }}
             <button type="submit" class="btn btn-danger" title="Pausar">
               <span class="fas fa-pause" aria-hidden="true"></span>
             </button>
          </form>
        @else
          <form class="form-horizontal button" role="form" method="POST" action="{{ route('ahorros.continuar', $n->id ) }}" enctype="multipart/form-data"
             onsubmit="return confirm('¿Está seguro de Quitar la pausa a la Cuenta de ahorro?')">
            <input name="_method" type="hidden" value="PUT">
             {{ csrf_field() }}
             <button type="submit" class="btn btn-success" title="Pausar">
               <span class="fas fa-play" aria-hidden="true"></span>
             </button>
          </form>
        @endif
    @endif    

    </td>
  </tr>
@empty
  <tr><td> No hay ahorros</td> </tr>
@endforelse

</table>


<!-- Prestamos -->

<h1 class="titulo sub"> Prestamos </h1>

<table class="table table-hover">

<thead>
  <th>Socio</th>
  <th>Monto</th>
  <th>Plazo</th>
  <th>Estado</th>
  <th>Acciones</th>

</thead>

@forelse($prestamo as $n)
  <tr>
    <td>{{ $n->socio->nombres}} {{$n->socio->apellidos}}</td>
    <td>
      {{ $n->monto }}
    </td>
    <td>
      {{ $n->plazo }}
    </td>
    <td>@if($n->activo == 1) Activo @else Inactivo @endif</td>

    <td>

      <a href="<?php echo  url('/');?>/socios/{{ $n->socio->id }}/edit" class="btn btn-purple" title="Modificar Socio">
       <span class="fa fa-user-circle " aria-hidden="true"></span>
      </a>

      <a href="<?php echo  url('/');?>/prestamos/{{ $n->id }}/movimiento" class="btn btn-rose" title="Ver movimientos">
       <span class="fas fa-archive" aria-hidden="true"></span>
      </a>

      <form target="_blank" class="form-horizontal button" role="form" method="POST" action="{{ route('prestamos.repprestamo', $n->id ) }}" enctype="multipart/form-data">
          <input name="_method" type="hidden" value="PUT">
           {{ csrf_field() }}
           <button type="submit" class="btn btn-primary" title="reporte prestamo">
             <span class="far fa-file-pdf" aria-hidden="true"></span>
           </button>
      </form>

    <form target="_blank" class="form-horizontal button" role="form" method="POST" action="{{ route('prestamos.planpago', $n->id ) }}" enctype="multipart/form-data">
        <input name="_method" type="hidden" value="PUT">
         {{ csrf_field() }}
         <button type="submit" class="btn btn-orange" title="Plan de pagos">
           <span class="fa fa-table" aria-hidden="true"></span>
         </button>
    </form>


      <form target="_blank" class="form-horizontal button" role="form" method="POST" action="{{ route('prestamos.resume', $n->id ) }}" enctype="multipart/form-data">
        <input name="_method" type="hidden" value="PUT">
         {{ csrf_field() }}
         <button type="submit" class="btn btn-blue" title="Resumen">
           <span class="fas fa-list-ul" aria-hidden="true"></span>
         </button>
      </form>

    <form target="_blank" class="form-horizontal button" role="form" method="POST" action="{{ route('prestamos.contractof', $n->id ) }}" enctype="multipart/form-data">
      <input name="_method" type="hidden" value="PUT">
       {{ csrf_field() }}
       <button type="submit" class="btn btn-success" title="Contracto">
         <span class="far fa-handshake" aria-hidden="true"></span>
       </button>
    </form>

    </td>
  </tr>
@empty
  <tr><td> No hay prestamos</td> </tr>
@endforelse

</table>

<!--Plazo Fijo -->

<h1 class="titulo sub"> Plazo Fijo </h1>

<table class="table table-hover">

<thead>
  <th>Socio</th>
  <th>Monto</th>
  <th>Total</th>
  <th>Estado</th>
  <th>Acciones</th>

</thead>

@forelse($plazofijo as $n)
  <tr>
    <td>{{ $n->socio->nombres}} {{$n->socio->apellidos}}</td>
    <td>{{ $n->monto}}</td>
    <td>
    {{$total = $n->monto + ($n->intereses - $n->ir)}}
    </td>
    <td>@if($n->activo == 1) Activo @else Inactivo @endif</td>

    <td>
     <form target="_blank" class="form-horizontal button" role="form" method="POST" action="{{ route('plazofijo.certificadopdf', $n->id ) }}" enctype="multipart/form-data">
        <input name="_method" type="hidden" value="PUT">
         {{ csrf_field() }}
         <button type="submit" class="btn btn-purple" title="Certificado">
           <span class="fas fa-certificate" aria-hidden="true"></span>
         </button>
      </form>

      <form target="_blank" class="form-horizontal button" role="form" method="POST" action="{{ route('plazofijo.repplazofijo', $n->id ) }}" enctype="multipart/form-data">
          <input name="_method" type="hidden" value="PUT">
           {{ csrf_field() }}
           <button type="submit" class="btn btn-primary" title="reporte de plazo fijo">
             <span class="far fa-file-pdf" aria-hidden="true"></span>
           </button>
      </form>

      @if($n->formapagointere_id == 2)
        @foreach($n->plazofijodetalles as $pd)
          @if($pd->pagado == 0)
            <a href="plazofijo/{{ $pd->id }}/payck" class="btn btn-success" title="Pago Cheque">
            <span class="fas fa-check" aria-hidden="true"></span></a>
          @endif
       @endforeach
     @endif

      @if($n->activo == 1)
        <a href="plazofijo/{{ $n->id }}/finalizebefore" class="btn btn-orange" title="Finalizar antes CPF">
        <span class="fas fa-cut" aria-hidden="true"></span></a>
      @endif

    </td>
  </tr>
@empty
  <tr><td> No hay plazo fijo</td> </tr>
@endforelse

</table>





@endsection
