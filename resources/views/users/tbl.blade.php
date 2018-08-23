<table class="table table-hover">

<thead>
  <th>Id</th>
  <th>Nombre</th>
  <th>Email</th>
  <th>Rol</th>
  <th></th>
</thead>

@foreach($usuario as $n)
  <tr>
    <td>{{ $n->id }}</td>
    <td>
      {{ $n->name }}
    </td>
    <td>
      {{ $n->email }}
    </td>
    <td>
      @foreach($n->roles as $rol)
        {{$rol->nombre}}
      @endforeach
    </td>

    <td>
      <a href="<?php echo  url('/');?>/users/{{ $n->id }}/edit" class="btn btn-primary" title="Modificar">
       <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
      </a>

      <form class="form-horizontal button" role="form" method="POST" action="{{ route('users.out', $n->id ) }}" enctype="multipart/form-data"
        onsubmit="return confirm('¿Está seguro de dar de baja?')">
       <input name="_method" type="hidden" value="PUT">
       {{ csrf_field() }}
        <button type="submit" class="btn btn-danger">
          <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
        </button>
     </form>

    </td>

  </tr>
@endforeach

</table>
