<table class="table table-hover">

<thead>
  <th>Id</th>
  <th>Valor</th>
  <th></th>
</thead>

@foreach($plazofijotasa as $n)
  <tr>
    <td>{{ $n->id }}</td>
    <td>
      {{ $n->valor }} %
    </td>
  </tr>
@endforeach

</table>
