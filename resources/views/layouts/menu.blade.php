<link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,900' rel='stylesheet' type='text/css'>
<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
<dropdown>
  <input id="toggle1" type="checkbox" checked>
  <label for="toggle1" class="animate">Menú<i class="fa fa-list float-right"></i></label>

  <ul class="animate">

    <a class="m10" href="<?php echo  url('/');?>/users">
      <li class="animate">
        Usuarios<i class="fa fa-users float-right"></i>
      </li>
    </a>

    <a class="m4" href="<?php echo  url('/');?>/mconsejo">
      <li class="animate">
        Miembros del consejo<i class="fa fa-user-secret float-right"></i>
      </li>
    </a>

       <a class="m1" href="<?php echo  url('/');?>/socios">
         <li class="animate">
           Socios<i class="fas fa-user-circle float-right fa-3"></i>
         </li>
      </a>
      <ul><a class="m1" href="<?php echo  url('/');?>/afiliacioncat">
         <li class="subm"><i class="fa fa-book float-right"></i>Catálogo Afiliación</li></a>
      </ul>


     <a class ="m2" href="<?php echo  url('/');?>/empresas">
       <li class="animate">
          Empresas<i class="fa fa-user-circle-o float-right"></i>
       </li>
     </a>
     <ul><a class="m2" href="<?php echo  url('/');?>/month">
        <li class="subm"><i class="fa fa-calendar float-right"></i>Deuda</li></a>
     </ul>

     <a class ="m3" href="<?php echo  url('/');?>/prestamos">
       <li class="animate">
          Prestamos<i class="fa fa-money float-right"></i>
       </li>
     </a>
     <ul><a class="m3" href="<?php echo  url('/');?>/comisiones">
        <li class="subm"><i class="fa fa-percent float-right"></i>Comisión</li></a>
     </ul>

     <a class ="m6" href="<?php echo  url('/');?>/ahorros">
       <li class="animate">
          Ahorros<i class="fa fa-bitbucket float-right"></i>
       </li>
     </a>

     <a class ="m7" href="<?php echo  url('/');?>/plazofijo">
       <li class="animate">
          Plazo Fijo<i class="fa fa-lock float-right"></i>
       </li>
     </a>

     <a class="m5" href="<?php echo  url('/');?>/tasacambios">
        <li class="subm"><i class="fa fa-balance-scale float-right"></i>Tasa de Cambio</li>
    </a>



  </ul>
</dropdown>
