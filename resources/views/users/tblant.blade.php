<table class="table table-hover">

<thead>
  <th>Id</th>
  <th>Nombre</th>
  <th>Email</th>
</thead>

@foreach($user as $n)
  <tr>
    <td>{{ $n->id }}</td>
    <td>
      {{ $n->name }}
    </td>
    <td>
      {{ $n->email }}
    </td>

  </tr>
@endforeach

</table>
