


  @foreach($ahorro as $n)
    <table class="table table-hover">

      <thead>


        <th>Concepto</th>
        <th>ROC/CK</th>
        <th>debitos</th>
        <th>Creditos</th>
        <th>Saldo Final</th>
        <th>Fecha</th>

      </thead>
    @foreach($n->ahorrodetalles as $ah)
    <tr>


      <td>{{$ah->concepto->nombre}}</td>
      <td>{{$ah->rock_ck}}</td>
      <td>{{$ah->debitos}}</td>
      <td>{{$ah->creditos}}</td>
      <td>{{$ah->saldofinal}}</td>
      <td>{{$ah->fecha}}</td>

    </tr>
  @endforeach
  </table>
 @endforeach
