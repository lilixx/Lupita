<table class="table table-hover">

<thead>
  <th>Id</th>
  <th>Nombre</th>
  <th>Valor</th>
  <th>Acciones</th>
  <th></th>
</thead>

@foreach($comision as $n)
  <tr>
    <td>{{ $n->id }}</td>
    <td>{{ $n->nombre }}</td>
    <td>
      {{ $n->valor }} %
    </td>
    <td>
      <a href="<?php echo  url('/');?>/comisiones/{{ $n->id }}/edit" class="btn btn-primary" title="cambiar">
       <span class="fa fa-share" aria-hidden="true"></span>
      </a>
    </td>

  </tr>
@endforeach

</table>
