<table class="table table-hover">

<thead>
  <th>Id</th>
  <th>Nombres</th>
  <th>Apellidos</th>
  <th>Fecha de Nac.</th>
  <th>Nacionalidad</th>
  <th>Acciones</th>
  <th></th>
</thead>

@foreach($socio as $h)
  <tr>
    <td>{{ $h->id }}</td>
    <td>
      {{ $h->nombres }}
    </td>
    <td>
      {{ $h->apellidos }}
    </td>
    <td>
      {{ $h->fecha_nac }}
    </td>
    <td>
      {{ $h->nombre }}
    </td>
    <td>
      <a href="huespedes/{{ $h->id }}/show" class="btn btn-success" title="Ver">
      <span class="glyphicon glyphicon-search" aria-hidden="true"></span></a>

      <a href="<?php echo  url('/');?>/socios/{{ $h->id }}/edit" class="btn btn-primary" title="Modificar">
       <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
      </a>

      <a href="#" class="btn btn-danger" title="Dar de baja">
      <span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>

    </td>
  </tr>
@endforeach

</table>
