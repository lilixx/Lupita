<table class="table table-hover">

<thead>
  <th>Id</th>
  <th>Socio</th>
  <th>Monto</th>
  <th>Plazo</th>
  <th>Mensual</th>
  <th>Acciones</th>

</thead>

@foreach($anticipo as $n)
  <tr>
    <td>{{ $n->id }}</td>
    <td>{{ $n->socio->nombres}} {{$n->socio->apellidos}}</td>
    <td>
      {{ $n->monto }}
    </td>
    <td>
      {{ $n->plazo }}
    </td>
    <td>
      @if($n->mensual == 1)
        Si - día de corte: {{$n->pmensual}}
      @else
        No
      @endif
    </td>

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
           <button type="submit" class="btn btn-primary" title="reporte anticipo">
             <span class="far fa-file-pdf" aria-hidden="true"></span>
           </button>
      </form>


    @if($n->pausa == 0)
      <a href="prestamos/{{ $n->id }}/pausa" class="btn btn-danger" title="Poner pausa">
      <span class="fas fa-pause" aria-hidden="true"></span></a>
    @else
      <form class="form-horizontal button" role="form" method="POST" action="{{ route('prestamos.continuar', $n->id ) }}" enctype="multipart/form-data">
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
{{ $anticipo->links() }}
