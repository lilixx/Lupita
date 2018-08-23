
@extends('layouts.app')

@section('content')

   <h1 class="titulo pais"> Plazo fijo Inactivos </h1>


    <table class="table table-hover">

    <thead>
      <th>Id</th>
      <th>Socio</th>
      <th>Monto</th>
      <th>Total</th>
      <th>Acciones</th>

    </thead>

    @foreach($plazof as $n)
      <tr>
        <td>{{ $n->id }}</td>
        <td>{{ $n->socio->nombres}} {{$n->socio->apellidos}}</td>
        <td>{{ $n->monto}}</td>
        <td>
        {{$total = $n->monto + ($n->intereses - $n->ir)}}
        </td>

        <td>
         <form target="_blank" class="form-horizontal button" role="form" method="POST" action="{{ route('plazofijo.certificadopdf', $n->id ) }}" enctype="multipart/form-data">
            <input name="_method" type="hidden" value="PUT">
             {{ csrf_field() }}
             <button type="submit" class="btn btn-purple" title="Certificado">
               <span class="fas fa-certificate" aria-hidden="true"></span>
             </button>
          </form>

          <form target="_blank" class="form-horizontal button" role="form" method="POST" action="{{ route('plazofijo.repplazofijo', $n->id ) }}" enctype="multipart/form-data">
              <input name="_method" type="hidden" value="PUT">
               {{ csrf_field() }}
               <button type="submit" class="btn btn-primary" title="reporte de plazo fijo">
                 <span class="far fa-file-pdf" aria-hidden="true"></span>
               </button>
          </form>

        </td>
      </tr>
    @endforeach

    </table>


@endsection
