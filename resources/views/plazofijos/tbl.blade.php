<table class="table table-hover">

<thead>
  <th>Id</th>
  <th>Socio</th>
  <th>Monto</th>
  <th>Total</th>
  <th>Día 30</th>
  <th>Acciones</th>

</thead>

@foreach($plazofijo as $n)
  <tr>
    <td>{{ $n->id }}</td>
    <td>{{ $n->socio->nombres}} {{$n->socio->apellidos}}</td>
    <td>{{ $n->monto}}</td>
    <td>
    {{$total = $n->monto + ($n->interesven - $n->ir)}}
    </td>
    <td>
    {{$n->dia30}}
    </td>
    <td>


      <form target="_blank" class="form-horizontal button" role="form" method="POST" action="{{ route('plazofijo.certificadopdf', $n->id ) }}" enctype="multipart/form-data">
        <input name="_method" type="hidden" value="PUT">
         {{ csrf_field() }}
         <button type="submit" class="btn btn-warning" title="Certificado">
           <span class="fas fa-certificate" aria-hidden="true"></span>
         </button>
      </form>

    </td>
  </tr>
@endforeach

</table>
{!!$plazofijo->render()!!}
