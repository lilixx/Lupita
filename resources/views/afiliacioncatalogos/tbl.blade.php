<table class="table table-hover">

<thead>
  <th>Id</th>
  <th>Cantidad</th>
  <th>Valor</th>
  <th></th>
</thead>

@foreach($afcat as $n)
  <tr>
    <td>{{ $n->id }}</td>
    <td>
      {{ $n->cantidad }}
    </td>
    <td>
      {{ $n->valor }}
    </td>
    <td>
    
      <a href="#" class="btn btn-danger" title="Dar de baja">
      <span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>

    </td>
  </tr>
@endforeach

</table>
