<table class="table table-hover">

<thead>
  <th>Id</th>
  <th>Socio</th>
  <th>Especial</th>
  <th>Deducción</th>
  <th>Día 15</th>
  <th>Día 30</th>
  <th>Acciones</th>

</thead>

@foreach($ahorro as $n)
  <tr>
    <td>{{ $n->id }}</td>
    <td>{{$n->socio->nombres}}  {{$n->socio->apellidos}}</td>
    <td>@if($n->especial == 1)Si @else No @endif</td>
    <td>@if($n->dolar == 1) Dólar @else Córdoba @endif</td>
    <td>
    {{$n->dia15}}
    </td>
    <td>
    {{$n->dia30}}
    </td>
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
         <button type="submit" class="btn btn-success" title="Quitar la pausa">
           <span class="fas fa-play" aria-hidden="true"></span>
         </button>
      </form>
    @endif

    </td>
  </tr>
@endforeach

</table>
