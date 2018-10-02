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
           Socios<i class="fas fa-user-circle float-right"></i>
         </li>
      </a>

      <ul><a class="m1" href="<?php echo  url('/');?>/searchsocio">
         <li class="subm"><i class="fa fa-search float-right"></i>Búsqueda del Socio</li></a>
      </ul>

      <ul><a class="m1" href="<?php echo  url('/');?>/afiliacioncat">
         <li class="subm"><i class="fa fa-book float-right"></i>Catálogo Afiliación</li></a>
      </ul>


     <a class ="m2" href="<?php echo  url('/');?>/empresas">
       <li class="animate">
          Empresas<i class="fas fa-building float-right"></i>
       </li>
     </a>

     <a class ="m3" href="<?php echo  url('/');?>/prestamos">
       <li class="animate">
          Prestamos<i class="fas fa-money-bill-alt float-right"></i>
       </li>
     </a>
     <ul><a class="m3" href="<?php echo  url('/');?>/comisiones">
        <li class="subm"><i class="fa fa-percent float-right"></i>Comisión</li></a>
     </ul>

     <a class ="m3" href="<?php echo  url('/');?>/anticipo">
       <li class="animate">
          Adelanto de Salario<i class="fas fa-external-link-alt float-right"></i>
       </li>
     </a>



     <a class ="m6" href="<?php echo  url('/');?>/ahorros">
       <li class="animate">
          Ahorros<i class="fab fa-bitbucket float-right"></i>
       </li>
     </a>
     <ul><a class="m6" href="<?php echo  url('/');?>/ahorrotasas">
        <li class="subm"><i class="fas fa-coffee float-right"></i>Tasas de ahorro</li></a>
     </ul>


     <a class ="m7" href="<?php echo  url('/');?>/plazofijo">
       <li class="animate">
          Plazo Fijo<i class="fa fa-lock float-right"></i>
       </li>
     </a>
     <ul><a class="m7" href="<?php echo  url('/');?>/plazoinactivo">
        <li class="subm"><i class="far fa-calendar-times float-right"></i>Inactivos</li></a>
     </ul>

     <a class ="m7" href="<?php echo  url('/');?>/cajachica">
       <li class="animate">
          Caja Chica<i class="fas fa-briefcase float-right"></i>
       </li>
     </a>

     <a class ="m2" href="<?php echo  url('/');?>/reportes">
       <li class="animate">
          Reportes<i class="fas fa-file-pdf float-right"></i>
       </li>
     </a>

     <a class="m5" href="<?php echo  url('/');?>/tasacambios">
        <li class="subm"><i class="fa fa-balance-scale float-right"></i>Tasa de Cambio</li>
    </a>





  </ul>
</dropdown>
