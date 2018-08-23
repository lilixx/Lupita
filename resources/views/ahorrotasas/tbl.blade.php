<table class="table table-hover">

<thead>
  <th>Id</th>
  <th>Valor</th>
  <th>Especial</th>
  <th></th>
</thead>

@foreach($ahorrotasa as $n)
  <tr>
    <td>{{ $n->id }}</td>
    <td>
      {{ $n->valor }} %
    </td>
    <td>@if($n->especial ==1) Si @else No @endif</td>


  </tr>
@endforeach

</table>
