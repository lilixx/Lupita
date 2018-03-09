<html>
<head>
  <style>
    body{
      font-family: sans-serif;
      text-align: justify;
    }

    header { position: fixed;
      left: 0px;
      top: -8px;
      right: 0px;
      height: 450px;
      text-align: justify;

    }
    @page {
      margin: 110px 60px;
    }
    div#content{
      margin-left: 2.5cm;
      margin-top:0;
      line-height:0.4cm;
    }
    div#content detalle{
      margin-left: 0.5cm!important;
    }

    .col_pago{
      float:right;
      width:40%;
    }

    .col_tasa{
      float:left;
      width:50%;
      margin-top:0.7cm;
      padding-left:2em;
    }

    p.pago.iva{
      margin-top:1em!important;
    }

    p.punto{
      line-height: 0;
      color:rgba(0,0,0,0);
    }

    h1{
      font-size: 1.2em;
      margin-top: 0;
      margin-bottom:0;
      padding-top: 0;

    }
    .col1_of_2{
      width:14cm;
      float:left;
      /*padding-right: 0.7em;*/
    }
    .col2_of_2{
      width:9cm;
      float: left;
    }
    .col1_of_3{
      width:6cm;
      float: left;
      padding-left:2em;
      margin-top:4em!important;
    }
    .col1_of_4{
      width:2.3cm;
      float: left;
    }
    .col2_of_4{
      width:2.5cm;
      float: left;
    }
    .col3_of_4{
      width:8.2cm;
      float: left;
    }
    .col4_of_4{
      width:3.7cm;
      float: left;
    }
    footer .page:after {
      content: counter(page);
    }

    .tg  {border-collapse:collapse;border-spacing:0;}
    .tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 20px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
    .tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 20px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
    .tg .tg-e3zv{font-weight:bold}
    .tg .tg-9hbo{font-weight:bold;vertical-align:top}
    .tg .tg-yw4l{vertical-align:top}


  </style>
    <header>hi</header>
<body>
    <h1 style="text-align:center; margin-top:0px; font-size:1.4em; border-bottom: 2px solid #000; margin-bottom:0px;
     padding-bottom:0px; margin-bottom:1em;">CONTRATO DE MUTUO</h1>

  <input name="_method" type="hidden" value="PUT">
   {{ csrf_field() }}

Nosotros, la COOPERATIVA DE AHORRO Y CREDITO “LA GUADALUPANA”  R.L., quien en adelante se denominará LA COOPERATIVA, representada por María Elsa Cross Vogl, mayor de edad, abogado, casada, de este domicilio, quien se identifica con cédula de identidad número cero cero uno guión dos cinco uno uno siete tres guión cero cero dos cero T (001-251173-0020T).- LA COOPERATIVA obtuvo su personalidad jurídica en Resolución número mil trescientos  sesenta  y  siete  guión  noventa  y  seis   (1367-96)  de  la  Dirección  del  Registro Nacional de Cooperativas que fue publicada  de la  página  novecientos ochenta y dos (982) a la novecientos ochenta y tres (983) de La Gaceta Diario Oficial número doscientos cincuenta (250) el día veintitrés de Diciembre del año mil novecientos noventa y ocho.- María Elsa Cross Vogl demuestra su representación con Certificado del INSTITUTO NICARAGÜENSE DE FOMENTO COOPERATIVO, INFOCOOP que íntegra y literalmente dice: <span style="font-weight:bold;">INSTITUTO NICARAGUENSE DE FOMENTO COOPERATIVO INFOCOOP.</span> El Instituto Nicaragüense de Fomento Cooperativo a través del Registro Nacional de Cooperativas, con base en la Ley 499 (Ley General de Cooperativas): <span style="font-weight:bold;">CERTIFICA</span> No. 24888 Que en el Registro Nacional de Cooperativa del Instituto Nicaragüense de Fomento Cooperativo (INFOCOOP) consta Acta No. 16 con fecha 24 de Septiembre del año dos mil once, inscrita en los folios 127 al 137, del libro de actas y acuerdos de Asamblea General de carácter Extraordinaria, que lleva la <span style="text-decoration: underline; font-weight:bold;">COOPERATIVA DE AHORRO Y CREDITO LA GUADALUPANA R.L., (LA GUADALUPANA R.L.)</span> del Municipio de Managua, Departamento de Managua; Donde se eligió al Consejo de Administración y Junta de Vigilancia, por un periodo de tres (3) años, de conformidad a los artículos 55 inciso b) y 68 de sus estatutos. <span style="text-decoration:underline; font-weight:bold;">En dicha acta aparecen registrados como miembros del Consejo de Administración:</span> <span style="font-weight:bold;">{{$cpresidente}}:</span> {{$presidente}}. <span style="font-weight:bold;">{{$cvicepresidente}}:</span> {{$vicepresidente}}. <span style="font-weight:bold;">{{$csecretario}}:</span> {{$secretario}}. <span style="font-weight:bold;">{{$ctesorero}}:</span> {{$tesorero}}. <span style="font-weight:bold;">{{$cvocal1}}:</span> {{$vocal1}}. <span style="text-decoration:underline; font-weight:bold;">Junta de Vigilancia:</span><span style="font-weight:bold;"> {{$ccoordinador}}:</span> {{$coordinador}}. <span style="font-weight:bold;">{{$csecretario2}}:</span> {{$secretario2}}. <span style="font-weight:bold;">{{$cvocal2}}:</span> {{$vocal2}}.- Ultima línea. Se extiende la presente a solicitud de parte interesada, a los dieciocho días del mes de Octubre del año dos mil once. (un sello: REGISTRO NACIONAL DE COOPERATIVAS. INFOCOOP. Managua, Nicaragua. (firma ilegible) Lic. Indiana Pravia Orozco. Directora Registro Nacional de Cooperativas. SN/MM Roc. 48059. NOTA: ESTA CERTIFICACION NO ES VALIDA SI LLEVA MANCHONES, ENMIENDAS, BORRONES, ENTRELINEADO Y TESTADO.>> y el miembro de la cooperativa: {{$prestamo->socio->nombres}} {{$prestamo->socio->apellidos}}, mayor de edad,  @if($prestamo->socio->estado_civil == 'casado' || $prestamo->socio->estado_civil == 'casada')en unión de hecho estable,
@else {{$prestamo->socio->estado_civil}}, @endif del domicilio de @if($prestamo->socio->ciudad != "Managua")
   {{$prestamo->socio->ciudad}} y de tránsito por esta ciudad, @else {{$prestamo->socio->ciudad}}, @endif quien se identifica con cédula de identidad {{$prestamo->socio->num_cedula}} y quien en adelante se denominará EL ASOCIADO, hemos convenido celebrar el presente contrato el que se regirá por las siguientes cláusulas: <span style="font-weight:bold">PRIMERA:</span> (Monto financiado). EL ASOCIADO reconoce por medio del presente contrato que a la fecha le debe a LA COOPERATIVA la cantidad de {{$numletras}}  (C$ {{$numero}}), que al tipo de cambio libre del Córdoba respecto al Dólar de los Estados Unidos de América del día de hoy que es de (C${{$tasac}}) por cada dólar, equivalen a <span style="font-weight:bold;">{{$numletrasc}} (US$ {{$cuotan}})</span> cifra que incluye intereses y principal.- <span style="font-weight:bold;">SEGUNDA:</span> (Mantenimiento de valor) .EL ASOCIADO declara que el Adeudo antes señalado lo reconoce con cláusula de mantenimiento de valor del Córdoba con respecto al Dólar de los Estados Unidos de América, y que asume los riesgos por las variaciones cambiarias y por cualquier devaluación ordinaria o extraordinaria que se produzca y declara que en cada fecha de pago si no pudiera conseguir los Dólares, pagará los Córdobas necesarios para adquirir el valor de los Dólares en el mercado libre. <span style="font-weight:bold;">TERCERA:</span> (Forma de pago) La suma antes mencionada EL ASOCIADO se obliga a pagarla en {{$cantl}} ({{$cantn}}) cuotas mensuales del equivalente en Córdobas a <span style="font-weight:bold;"> {{$numletrasc}} (US$ {{$cuotan}})</span> cada una, debiendo pagar la primera cuota el {{$finiciol}} y concluyendo el día {{$ffinl}}. EL ASOCIADO autoriza expresamente a la COOPERATIVA a deducir la cuota de los ahorros generados por el certificado a plazo fijo que tiene en la cooperativa, o de los intereses que dichos ahorros generan o en su defecto EL ASOCIADO se obliga a pagarlas directamente a LA COOPERATIVA.CUARTA: (Intereses moratorios).En los cuotas antes dichas ya están incluidos principal e intereses corrientes, pero cuando incurra en mora, la que acaecerá por el sólo transcurso del tiempo sin necesidad de requerimiento alguno, EL ASOCIADO se obliga a pagar una tasa adicional de intereses penales del ocho por ciento (8%) anual sobre las sumas en mora desde la fecha de cada vencimiento hasta la de su efectivo pago. QUINTA: (Vencimiento anticipado) En caso de que EL ASOCIADO incumpliera cualquiera de sus obligaciones establecidas en este contrato, LA COOPERATIVA podrá dar por vencido el plazo de este contrato y exigir el pago de todo lo adeudado, sin perjuicio de los demás derechos que le corresponden. SEXTA: (Estipulaciones Especiales) En relación con las obligaciones y la garantía que aquí se constituyen, LA COOPERATIVA, y EL ASOCIADO convenimos: a) que para los efectos de dar por vencido el plazo y acreditar el incumplimiento de EL ASOCIADO con relación a cualquier obligación nacida de este contrato, bastará la sola declaración que formule LA COOPERATIVA, su representante o apoderado en el escrito de demanda; b) que en caso de ejecución EL ASOCIADO acepta como saldo adeudado la cantidad que demande LA COOPERATIVA, a través de su representante o apoderado en el escrito de la demanda; y que LA COOPERATIVA podrá reclamar los daños y perjuicios y los gastos y honorarios judiciales o extrajudiciales, deferidos a la promesa estimatoria de LA COOPERATIVA; c) que EL ASOCIADO reconocerá los costos y gastos en que incurriere LA COOPERATIVA, para la defensa de los derechos del crédito; d)  que la cooperativa puede vender, ceder o traspasar este crédito en los términos que estime conveniente, sin necesidad de notificación; y e) el asociado y el fiador solidario autorizan expresamente a que la información relacionada con este crédito sea compartida y publicada en las centrales de riesgos.

Leído que fue el presente contrato por EL ASOCIADO, y LA COOPERATIVA lo encontramos conforme, ratificamos y firmamos dos tantos de un mismo tenor en la Ciudad de Managua, {{$dtoday}}.

 <div style="clear:both;"></div>





<div class="col1_of_2" style="padding-top:4em;">
      ----------------------------
    <br/>     EL ASOCIADO
</div>



<div class="col1_of_2" style="padding-top:4em;">
  ---------------------------
<br/>  LA COOPERATIVA
</div>






</body>
</html>
