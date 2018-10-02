<table class="table table-hover">

<thead>
  <th>Id</th>
  <th>Ingreso</th>
  <th>Egreso</th>
  <th>Total</th>
  <th></th>
</thead>

@foreach($cajachica as $n)
  <tr>
    <td>{{ $n->id }}</td>
    <td>
      {{ $n->ingreso }}
    </td>
    <td>
      {{ $n->egreso }}
    </td>
    <td>
      {{ $n->total }}
    </td>
    <td>


    </td>
  </tr>
@endforeach

</table>
