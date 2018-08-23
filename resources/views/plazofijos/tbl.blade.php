

<div class="steps">
 <input id="step_1" type="radio" name="steps" checked="checked"/>
 <label class="step cp" for="step_1"><span>Mensual</span></label>
 <input id="step_2" type="radio" name="steps"/>
 <label class="step cp" for="step_2"><span>Trimestral</span></label>
 <input id="step_3" type="radio" name="steps"/>
 <label class="step cp" for="step_3"><span>Semestral</span></label>
 <input id="step_4" type="radio" name="steps"/>
 <label class="step cp" for="step_4"><span>Anual</span></label>


 <div class="content">

     <div class="content_1">

       <table class="table table-hover">

       <thead>
         <th>Id</th>
         <th>Socio</th>
         <th>Monto</th>
         <th>Total</th>
         <th>Acciones</th>

       </thead>

       @foreach($pfmensual as $n)
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

             @if($n->formapagointere_id == 2)
               @foreach($n->plazofijodetalles as $pd)
                 @if($pd->pagado == 0)
                   <a href="plazofijo/{{ $pd->id }}/payck" class="btn btn-success" title="Pago Cheque">
                   <span class="fas fa-check" aria-hidden="true"></span></a>
                 @endif
              @endforeach
            @endif

             <a href="plazofijo/{{ $n->id }}/finalizebefore" class="btn btn-orange" title="Finalizar antes CPF">
             <span class="fas fa-cut" aria-hidden="true"></span></a>


           </td>
         </tr>
       @endforeach

       </table>

     </div>

     <div class="content_2">
       <table class="table table-hover">

       <thead>
         <th>Id</th>
         <th>Socio</th>
         <th>Monto</th>
         <th>Total</th>
         <th>Pagos</th>
         <th>Acciones</th>

       </thead>

       @foreach($pftrimestral as $n)
         <tr>
           <td>{{ $n->id }}</td>
           <td>{{ $n->socio->nombres}} {{$n->socio->apellidos}}</td>
           <td>{{ $n->monto}}</td>
           <td>
           {{$total = $n->monto + ($n->intereses - $n->ir)}}
           </td>

           <td>

             {{$n->created_at->addMonth(3)->format('Y-m-d')}} <br/>
             {{$n->created_at->addMonth(6)->format('Y-m-d')}} <br/>
             {{$n->created_at->addMonth(9)->format('Y-m-d')}} <br/>
             {{$n->created_at->addMonth(12)->format('Y-m-d')}} <br/>
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

             @if($n->formapagointere_id == 2)
               @foreach($n->plazofijodetalles as $pd)
                 @if($pd->pagado == 0)
                   <a href="plazofijo/{{ $pd->id }}/payck" class="btn btn-success" title="Pago Cheque">
                   <span class="fas fa-check" aria-hidden="true"></span></a>
                 @endif
              @endforeach
            @endif

             <a href="plazofijo/{{ $n->id }}/finalizebefore" class="btn btn-orange" title="Finalizar antes CPF">
             <span class="fas fa-cut" aria-hidden="true"></span></a>


           </td>
         </tr>
       @endforeach

       </table>

     </div>

     <div class="content_3">
       <table class="table table-hover">

       <thead>
         <th>Id</th>
         <th>Socio</th>
         <th>Monto</th>
         <th>Total</th>
         <th>Acciones</th>

       </thead>

       @foreach($pfsemestral as $n)
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

             @if($n->formapagointere_id == 2)
               @foreach($n->plazofijodetalles as $pd)
                 @if($pd->pagado == 0)
                   <a href="plazofijo/{{ $pd->id }}/payck" class="btn btn-success" title="Pago Cheque">
                   <span class="fas fa-check" aria-hidden="true"></span></a>
                 @endif
              @endforeach
            @endif

             <a href="plazofijo/{{ $n->id }}/finalizebefore" class="btn btn-orange" title="Finalizar antes CPF">
             <span class="fas fa-cut" aria-hidden="true"></span></a>


           </td>
         </tr>
       @endforeach

       </table>

     </div>

     <div class="content_4">

       <table class="table table-hover">

       <thead>
         <th>Id</th>
         <th>Socio</th>
         <th>Monto</th>
         <th>Total</th>
         <th>Acciones</th>

       </thead>

       @foreach($pfanual as $n)
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

             @if($n->formapagointere_id == 2)
               @foreach($n->plazofijodetalles as $pd)
                 @if($pd->pagado == 0)
                   <a href="plazofijo/{{ $pd->id }}/payck" class="btn btn-success" title="Pago Cheque">
                   <span class="fas fa-check" aria-hidden="true"></span></a>
                 @endif
              @endforeach
            @endif

             <a href="plazofijo/{{ $n->id }}/finalizebefore" class="btn btn-orange" title="Finalizar antes CPF">
             <span class="fas fa-cut" aria-hidden="true"></span></a>


           </td>
         </tr>
       @endforeach

       </table>

     </div>

</div>
