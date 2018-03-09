<table class="table table-hover">

<thead>
  <th>Id</th>
  <th>Nombre</th>
  <th>Cargo</th>
  <th>Acciones</th>
  <th></th>
</thead>

@foreach($consejo as $n)
  <tr>
    <td>{{ $n->id }}</td>
    <td>{{ $n->nombre }}</td>
    <td>
      {{ $n->cargo }}
    </td>

    <td>
      <a href="<?php echo  url('/');?>/mconsejo/{{ $n->id }}/edit" class="btn btn-primary" title="cambiar">
       <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
      </a>
    </td>

  </tr>
@endforeach

</table>
