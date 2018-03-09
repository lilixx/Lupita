<table class="table table-hover">

<thead>
  <th>Id</th>
  <th>Socio</th>
  <th>Monto</th>
  <th>Plazo</th>
  <th>Acciones</th>

</thead>

@foreach($prestamo as $n)
  <tr>
    <td>{{ $n->id }}</td>
    <td>{{ $n->socio->nombres}} {{$n->socio->apellidos}}</td>
    <td>
      {{ $n->monto }}
    </td>
    <td>
      {{ $n->plazo }}
    </td>
  
    <td>

      <a href="<?php echo  url('/');?>/socios/{{ $n->socio->id }}/edit" class="btn btn-edit" title="Modificar Socio">
       <span class="fa fa-user-circle " aria-hidden="true"></span>
      </a>

    <form target="_blank" class="form-horizontal button" role="form" method="POST" action="{{ route('prestamos.planpago', $n->id ) }}" enctype="multipart/form-data">
        <input name="_method" type="hidden" value="PUT">
         {{ csrf_field() }}
         <button type="submit" class="btn btn-primary" title="Plan de pagos">
           <span class="fa fa-table" aria-hidden="true"></span>
         </button>
    </form>


      <form target="_blank" class="form-horizontal button" role="form" method="POST" action="{{ route('prestamos.resume', $n->id ) }}" enctype="multipart/form-data">
        <input name="_method" type="hidden" value="PUT">
         {{ csrf_field() }}
         <button type="submit" class="btn btn-warning" title="Resumen">
           <span class="fa fa-file-pdf-o" aria-hidden="true"></span>
         </button>
      </form>

    <form target="_blank" class="form-horizontal button" role="form" method="POST" action="{{ route('prestamos.contractof', $n->id ) }}" enctype="multipart/form-data">
      <input name="_method" type="hidden" value="PUT">
       {{ csrf_field() }}
       <button type="submit" class="btn btn-success" title="Contracto">
         <span class="fa fa-thumbs-o-up" aria-hidden="true"></span>
       </button>
    </form>

    </td>
  </tr>
@endforeach

</table>
