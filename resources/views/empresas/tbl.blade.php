<table class="table table-hover">

<thead>
  <th>Id</th>
  <th>Nombre</th>
  <th></th>
</thead>

@foreach($empresa as $n)
  <tr>
    <td>{{ $n->id }}</td>
    <td>
      {{ $n->nombre }}
    </td>
    <td>
      <a href="<?php echo  url('/');?>/empresas/{{ $n->id }}/edit" class="btn btn-primary" title="Modificar">
       <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
      </a>

      <a href="empresas/{{ $n->id }}/deuda" class="btn btn-success" title="Deuda">
      <span class="fa fa-calendar" aria-hidden="true"></span></a>

      <a href="empresas/{{ $n->id }}/pago" class="btn btn-purple" title="Pago">
      <span class="fas fa-bullhorn" aria-hidden="true"></span></a>

      <a href="empresas/{{ $n->id }}/proyplanilla" class="btn btn-rose" title="Proyeccion de Planilla">
      <span class="fas fa-chart-line" aria-hidden="true"></span></a>

      <a href="empresas/{{ $n->id }}/movimiento" class="btn btn-orange" title="Ver Movimientos">
      <span class="fas fa-eye" aria-hidden="true"></span></a>

    </td>
  </tr>
@endforeach

</table>
