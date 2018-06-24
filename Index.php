<!DOCTYPE html>
<html lang="en">
<head>
  <title>Gestione Turni</title>
  <link rel="stylesheet" type="text/css" href="css/layout.css?v={random number/string}"/>
  <!-- <style>
  .scroll{
    overflow:scroll;
    max-width:100%;
    position:relative;
  }
  </style> -->
  <script  src="js/jquery.js"></script>
  <script  src="js/colResizable-1.6.min.js"></script>
</head>
<body>
  <!-- <div id="titolo"> -->
  <!-- <h1>Vigili del Fuoco Arco</h1> -->
  <!-- </div> -->
  <div id="login">
    <?php
    if( isset($_POST['admin']) ) {
      $admin=$_POST['admin'];
    }
    else {
      $admin="false";
    }
    if ($admin == "true") {
      echo '<a href="logout.php">Logout</a>';
    }
    else {
      echo '<a href="login_form.php">Login</a>';
    }
    ?>
  </div>
  <div id="header">
    <h1>
      <?php
      if( isset($_POST['date']) ) {
        $date=$_POST['date'];
      }
      else {
        $date=date('Y-m-j');
      }

      list($year, $month, $day) = explode('-', $date);
      $time = mktime(0, 0, 0, $month, $day, $year);
      $settimana = date('W', $time);
      $anno = date('Y', $time);
      $time_prev = strtotime('- 1 week', $time);
      $date_prev = date('Y-m-d', $time_prev);
      $settimana_prev = date('W', $time_prev);
      $anno_prev = date('Y', $time_prev);
      $time_next = strtotime('+ 1 week', $time);
      $date_next = date('Y-m-d', $time_next);

      $gendate_start=new DateTime();
      $gendate_end=new DateTime();
      $gendate_start->setISODate($anno_prev,$settimana_prev,5); //year , week num , day
      $gendate_end->setISODate($anno,$settimana,4); //year , week num , day

      if( isset($_POST['action']) ) {
        $action=$_POST['action'];
      }
      else {
        $action='';
      }
      if( isset($_POST['squadra']) ) {
        $squadra=$_POST['squadra'];
      }
      if ($action == "aggiungisquadradefault"){
        require "connect_db.php";
        $query="BEGIN; ";
        $query=$query . "DELETE FROM public.t_calendario WHERE settimana = " . $settimana . " AND anno = " . $anno . ";";
        $query=$query . "INSERT INTO public.t_calendario(settimana, anno, matricola, cp, squadra)
        SELECT $settimana, $anno, matricola, cp, squadra
        FROM t_squadre_default WHERE squadra = " . $squadra . ";";
        $query=$query . "COMMIT;";
        $res = pg_exec($query);
        pg_close($conn);
      }
      require "connect_db.php";
      $query="SELECT DISTINCT cal.squadra FROM public.t_calendario AS cal
      WHERE settimana = " . $settimana .
      " AND anno = " . $anno . ";";
      $res = pg_exec($query);
      $nrows = pg_numrows($res);
      if($nrows != 0) {
        while ($row = pg_fetch_array($res)) {
          $squadra = $row[0];
        }
      }
      pg_close($conn);
      ?>
      <table>
        <tr>
          <td>Personale reperibile settimana: </td>
          <td><form action="Index.php" method="post"><input type="hidden" name="admin" value="<?php echo $admin ?>"><input type="hidden" name="date" value="<?php echo $date_prev; ?>"><input type="submit" class="button" value="<<" /></form></td>
          <td><label id="l_year"><?php echo "$settimana $anno"; ?> </label></td>
          <td><form action="Index.php" method="post"><input type="hidden" name="admin" value="<?php echo $admin ?>"><input type="hidden" name="date" value="<?php echo $date_next; ?>"><input type="submit" class="button" value=">>" /></form></td>
          <td> dal <?php echo $gendate_start->format('d-m-Y') ?> a <?php echo $gendate_end->format('d-m-Y') ?></td>
        </tr>
      </table>
    </h1>
  </div>
  <div id="navigation_menu">
    <table>
      <td>
        <form action="Index.php" method="post">
          <input type="hidden" name="admin" value="<?php echo $admin ?>">
          <input type="submit" class="button" style="background-color:Tomato;" value="Home">
        </form>
      </form>
    </td>
    <td>
      <?php
      if ($admin == "true") {
        echo '<form action="Turni_default.php" method="post">
        <input type="hidden" name="admin" value="' . $admin . '">
        <input type="submit" class="button" value="Definizione turni">
        </form>';
      }
      ?>
    </td>
    <td>
      <form action="OrganicoCorpo.php" method="post">
        <input type="hidden" name="admin" value="<?php echo $admin ?>">
        <input type="submit" class="button" value="Organico Corpo">
      </form>
    </td>
    <td>

      <?php
      if ($admin == "true") {
        echo '<form action="Settings.php" method="post">
        <input type="hidden" name="admin" value="' . $admin . '">
        <input type="submit" class="button" value="Settigs">
        </form>';
      }
      ?>
    </td>
  </table>
</div>
<div id="content">
  <!-- <div id="content" overflow="auto"> -->
  <div id="content_menu">
    <table>
      <?php
      if ($admin == "true")
      {
        require "connect_db.php";
        $query="SELECT DISTINCT td.squadra FROM public.t_squadre_default AS td ORDER BY td.squadra ASC;";
        $res = pg_exec($query);
        $nrows = pg_numrows($res);
        if($nrows != 0) {
          while ($row = pg_fetch_array($res)) {
            echo '<td><form action="Index.php" method="post">
            <input type="hidden" name="admin" value="' . $admin . '">
            <input type="hidden" name="action" value="aggiungisquadradefault">
            <input type="hidden" name="date" value=' . $date . '>
            <input type="submit" class="button" ';
            if ($row[0] == $squadra) {
              echo 'style="background-color:Tomato;" ';
            }
            echo 'name="squadra" value="' . $row[0] . '"></form></td>';
          }
        }
        pg_close($conn);
      }
      else {
        echo '<h2>SQUADRA ' . $squadra . '</h2>';
      }
      ?>
    </table>
  </div>
  <br />
  <?php
  if ($admin == "true")
  {
    ?>
    <form action="AggiungiVigileCalendario.php" method="post">
      <input type="hidden" name="admin" value="<?php echo $admin ?>">
      <input type="hidden" name="settimana" value="<?php echo $settimana; ?>">
      <input type="hidden" name="anno" value="<?php echo $anno; ?>">
      <input type="submit" class="button_table" value="Aggiungi"/></form>
      <?php
    }
    ?>
    <div id="vigili_calendario">
	<div class="abilitazioni_scroll">
      <table id="table_vigili_calendario" class="content_table" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <th class="th_content">Cambia</th>
          <th class="th_content">N°</th>
          <th class="th_content">Cognome</th>
          <th class="th_content">Nome</th>
          <th class="th_content">Grado</th>
          <th class="th_content">Breve</th>
          <th class="th_content">Breve</th>
          <th class="th_content">Mostra</th>
        </tr>
        <?php
        require "connect_db.php";
        $query="SELECT cal.matricola, cal.cp, oc.cognome, oc.nome, gr.descrizione, oc.breve_cellulare, oc.breve_casa, cal.sostituito
        FROM public.t_calendario AS cal, public.t_organico_corpo AS oc, public.t_gradi AS gr
        WHERE gr.id=oc.id_grado AND cal.matricola=oc.matricola
        AND cal.settimana=" . $settimana . " AND cal.anno=" . $anno . "
        ORDER BY NULLIF(cal.cp, '') ASC NULLS LAST";
        $res = pg_exec($query);
        $nrows = pg_numrows($res);
        $ncols = pg_numfields($res);

        if($nrows == 0) die("Rows returned are 0!");
        while ($row = pg_fetch_array($res)) {
          if ($row['sostituito'] == "t")
          {
            echo '<tr style="background:#ffff66">';
          }
          else {
            echo '<tr>';
          }

          for($i=0;$i<$ncols-1;$i++){
            if ($i==0) {
              echo '<td class="td_content"><form action="CambiaTurno.php" method="post">
              <input type="hidden" name="admin" value="' . $admin . '">
              <input type="hidden" name="visualizza_solo_grado" value="true">
              <input type="hidden" name="matricola" value="' . $row[$i] . '">
              <input type="hidden" name="settimana" value="' . $settimana . '">
              <input type="hidden" name="anno" value="' . $anno . '">
              <input type="submit" class="button_table" value="Cambia" /></form></td>';
            }
            else {
              echo '<td class="td_content">' . $row[$i] . "</td>";
            }

          }
          echo '<td class="td_content"><form action="Index.php" method="post">
          <input type="hidden" name="admin" value="' . $admin . '">
          <input type="hidden" name="mostra_dettagli_matricola" value="' . $row[0] . '">
          <input type="hidden" name="date" value=' . $date . '>
          <input type="submit" class="button_table" value="Dettagli" /></form></td>';
          echo "</tr>";
        }
        pg_close($conn);
        ?>
      </table>
	  </div>
      <br />
      <h2>CERCAPERSONE FISSI</h2>
	  <div class="abilitazioni_scroll">
      <table id="table_vigili_calendario" class="content_table" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <th class="th_content">N°</th>
          <th class="th_content">Cognome</th>
          <th class="th_content">Nome</th>
          <th class="th_content">Grado</th>
          <th class="th_content">Breve</th>
          <th class="th_content">Breve</th>
          <th class="th_content">Mostra</th>
        </tr>
        <?php

        require "connect_db.php";
        $query="SELECT oc.matricola, cpf.cp, oc.cognome, oc.nome, gr.descrizione, oc.breve_cellulare, oc.breve_casa
        FROM public.t_organico_corpo AS oc, public.t_gradi AS gr, public.t_cercapersone_fissi AS cpf
        WHERE gr.id=oc.id_grado
        AND oc.matricola=cpf.matricola
        ORDER BY cpf.ordine ASC";
        $res = pg_exec($query);
        $nrows = pg_numrows($res);
        $ncols = pg_numfields($res);

        if($nrows == 0) die("Rows returned are 0!");
        while ($row = pg_fetch_array($res)) {
          echo "<tr>";
          for($i=1;$i<$ncols;$i++){
            echo '<td class="td_content">' . $row[$i] . "</td>";
          }
          echo '<td class="td_content"><form action="Index.php" method="post">
          <input type="hidden" name="admin" value="' . $admin . '">
          <input type="hidden" name="mostra_dettagli_matricola" value="' . $row[0] . '">
          <input type="hidden" name="date" value=' . $date . '>
          <input type="submit" class="button_table" value="Dettagli" /></form></td>';
        }
        echo "</tr>";
        ?>
      </table>
	  </div>
    </div>
    <div id="abilitazioni">
		<div id="abilitazioni_sup" class="abilitazioni_scroll">
		  <table id="table_abilitazioni" class="content_table" border="0" cellpadding="0" cellspacing="0">
			<tr>
			  <th class="th_content">Guida Em</th>
			  <th class="th_content">Pat B</th>
			  <th class="th_content">Pat C</th>
			  <th class="th_content">Scala</th>
			  <th class="th_content">DAE</th>
			  <th class="th_content">SAF</th>
			  <th class="th_content">APVR</th>
			  <th class="th_content">Gru</th>
			  <th class="th_content">Incidenti</th>
			  <th class="th_content">Incendio</th>
			  <th class="th_content">Mezzi leggeri</th>
			  <th class="th_content">Mezzi pesanti</th>
			  <th class="th_content">Trattore</th>
			  <th class="th_content">Muletto</th>
			  <th class="th_content">Sgombraneve</th>
			  <th class="th_content">Motoseghe</th>
			  <th class="th_content">Rimorchi</th>
			  <th class="th_content">Abi01</th>
			  <th class="th_content">Abi02</th>
			  <th class="th_content">Abi03</th>
			  <th class="th_content">Ref01</th>
			  <th class="th_content">Ref02</th>
			  <th class="th_content">Ref03</th>
			  <th class="th_content">Ref04</th>
			  <th class="th_content">Ref05</th>
			  <th class="th_content">Ref06</th>
			</tr>
			<?php
			require "connect_db.php";
			$query="SELECT ab.guida_emergenza, ab.patenteb, ab.patentec, ab.autoscala, ab.dae, ab.saf, ab.apvr, ab.gru, ab.incidenti,
			ab.incendio, ab.mezzi_leggeri, ab.mezzi_pesanti, ab.trattore, ab.muletto, ab.sgombraneve, ab.motoseghe, ab.rimorchi,
			ab.abi01, ab.abi02, ab.abi03, ref.referenza01, ref.referenza02, ref.referenza03, ref.referenza04, ref.referenza05, ref.referenza06
			FROM public.t_abilitazioni AS ab, public.t_calendario AS cal, public.t_referenze AS ref
			WHERE ab.matricola=cal.matricola AND cal.matricola=ref.matricola
			AND cal.settimana=" . $settimana . " AND cal.anno=" . $anno . "
			ORDER BY NULLIF(cal.cp, '') ASC NULLS LAST;";
			$res = pg_exec($query);
			$nrows = pg_numrows($res);
			$ncols = pg_numfields($res);

			if($nrows == 0) die("Rows returned are 0!");
			while ($row = pg_fetch_array($res)) {
			  echo "<tr>";
			  for($i=0;$i<$ncols-6;$i++){
				if ($row[$i] == "SI"){
				  echo '<td bgcolor="#00FF00" class="td_content">OK</td>';
				}
				else if ($row[$i] == "NO") {
				  echo '<td bgcolor="#FF0000" class="td_content">NO</td>';
				}
				else {
				  echo '<td bgcolor="#00FFFF" class="td_content">AFF</td>';
				}
			  }
			  for($i=$ncols-6;$i<$ncols;$i++){
				echo '<td class="td_content">' . $row[$i] . '</td>';
			  }
			  echo "</tr>";
			}
			pg_close($conn);
			?>
		  </table>
		</div>
      <br />
      <h2>CERCAPERSONE FISSI</h2>
	  <div id="abilitazioni_inf" class="abilitazioni_scroll">
      <table id="table_abilitazioni" class="content_table" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <th class="th_content">Guida Em</th>
          <th class="th_content">Pat B</th>
          <th class="th_content">Pat C</th>
          <th class="th_content">Scala</th>
          <th class="th_content">DAE</th>
          <th class="th_content">SAF</th>
          <th class="th_content">APVR</th>
          <th class="th_content">Gru</th>
          <th class="th_content">Incidenti</th>
          <th class="th_content">Incendio</th>
          <th class="th_content">Mezzi leggeri</th>
          <th class="th_content">Mezzi pesanti</th>
          <th class="th_content">Trattore</th>
          <th class="th_content">Muletto</th>
          <th class="th_content">Sgombraneve</th>
          <th class="th_content">Motoseghe</th>
          <th class="th_content">Rimorchi</th>
          <th class="th_content">Abi01</th>
          <th class="th_content">Abi02</th>
          <th class="th_content">Abi03</th>
          <th class="th_content">Ref01</th>
          <th class="th_content">Ref02</th>
          <th class="th_content">Ref03</th>
          <th class="th_content">Ref04</th>
          <th class="th_content">Ref05</th>
          <th class="th_content">Ref06</th>
        </tr>
        <?php
        require "connect_db.php";
        $query="SELECT ab.guida_emergenza, ab.patenteb, ab.patentec, ab.autoscala, ab.dae, ab.saf, ab.apvr, ab.gru, ab.incidenti,
        ab.incendio, ab.mezzi_leggeri, ab.mezzi_pesanti, ab.trattore, ab.muletto, ab.sgombraneve, ab.motoseghe, ab.rimorchi,
        ab.abi01, ab.abi02, ab.abi03, ref.referenza01, ref.referenza02, ref.referenza03, ref.referenza04, ref.referenza05, ref.referenza06
        FROM public.t_abilitazioni AS ab, public.t_cercapersone_fissi AS cpf, public.t_referenze AS ref
        WHERE ab.matricola=cpf.matricola AND cpf.matricola=ref.matricola
        ORDER BY cpf.ordine ASC";
        $res = pg_exec($query);
        $nrows = pg_numrows($res);
        $ncols = pg_numfields($res);

        if($nrows == 0) die("Rows returned are 0!");
        while ($row = pg_fetch_array($res)) {
          echo "<tr>";
          for($i=0;$i<$ncols-6;$i++){
            if ($row[$i] == "SI"){
              echo '<td bgcolor="#00FF00" class="td_content">OK</td>';
            }
            else if ($row[$i] == "NO") {
              echo '<td bgcolor="#FF0000" class="td_content">NO</td>';
            }
            else {
              echo '<td bgcolor="#00FFFF" class="td_content">AFF</td>';
            }
          }
          for($i=$ncols-6;$i<$ncols;$i++){
            echo '<td class="td_content">' . $row[$i] . '</td>';
          }
          echo "</tr>";
        }
        pg_close($conn);
        ?>
      </table>
	  </div>

    </div>
  </div>
  <!-- <div id="more_content">
    <form action="Index.php" method="post">
      <input type="hidden" name="admin" value="<?php echo $admin ?>">
      <input type="hidden" name="settimana" value='<?php echo $settimana ?>'>
      <input type="hidden" name="anno" value='<?php echo $anno ?>'>
      <input type="submit" class="button_table" value="Nacondi dettagli" /></form>
      <div id="more_content_SX">
        <?php
        if( isset($_POST['mostra_dettagli_matricola']) ) {
          require "connect_db.php";
          $query="SELECT oc.matricola, oc.cognome, oc.nome, gr.descrizione, oc.tel_cellulare, oc.breve_cellulare, oc.tel_casa, oc.breve_casa,
          oc.tel_lavoro, oc.breve_lavoro, oc.tel_servizio, oc.breve_servizio,
          oc.indirizzo_casa, oc.assunzione, oc.mansione, oc.email
          FROM public.t_organico_corpo AS oc, public.t_gradi AS gr
          WHERE oc.id_grado=gr.id
          AND oc.matricola=" . $_POST["mostra_dettagli_matricola"] . ";";
          $res = pg_exec($query);
          $row = pg_fetch_array($res);

          echo "<h2>Dati generali</h2>";
          echo "Matricola: " . $row[0] . "<br />";
          echo "Cognome: " . $row[1] . "<br />";
          echo "Nome: " . $row[2] . "<br />";
          echo "Grado: " . $row[3] . "<br />";
          echo "Cellulare: " . $row[4] . "<br />";
          echo "Breve Cellulare: " . $row[5] . "<br />";
          echo "Casa: " . $row[6] . "<br />";
          echo "Breve Casa: " . $row[7] . "<br />";
          echo "Lavoro: " . $row[8] . "<br />";
          echo "Breve Lavoro: " . $row[9] . "<br />";
          echo "Servizio: " . $row[10] . "<br />";
          echo "Breve Servizio: " . $row[11] . "<br />";
          echo "Indirizzo: " . $row[12] . "<br />";
          echo "Data assunzione: " . $row[13] . "<br />";
          echo "Mansione: " . $row[14] . "<br />";
          echo "Email: " . $row[15] . "<br />";
        }
        ?>
      </div>
      <div id="more_content_DX">
        <?php
        if( isset($_POST['mostra_dettagli_matricola']) ) {
          require "connect_db.php";
          $query="SELECT ab.guida_emergenza, ab.patenteb, ab.patentec, ab.autoscala, ab.dae, ab.saf, ab.apvr,
          ab.gru, ab.incidenti, ab.incendio, ab.mezzi_leggeri, ab.mezzi_pesanti, ab.trattore, ab.muletto, ab.sgombraneve,
          ab.motoseghe, ab.rimorchi, ab.abi01, ab.abi02, ab.abi03
          FROM public.t_abilitazioni AS ab
          WHERE matricola=" . $_POST["mostra_dettagli_matricola"] . ";";
          $res = pg_exec($query);
          $row = pg_fetch_array($res);
          $ncols = pg_numfields($res);
          for($i=0;$i<$ncols;$i++){
            if ($row[$i] == "AFF"){
              $row[$i] = "AFFIANCATO";
            }
          }
          echo "<h2>Abilitazioni</h2>";
          echo "Guida emergenza: " . $row[0] . "<br />";
          echo "Patente B: " . $row[1] . "<br />";
          echo "Patente C: " . $row[2] . "<br />";
          echo "Autoscala: " . $row[3] . "<br />";
          echo "DAE: " . $row[4] . "<br />";
          echo "SAF: " . $row[5] . "<br />";
          echo "APVR: " . $row[6] . "<br />";
          echo "Gru: " . $row[7] . "<br />";
          echo "Incidenti: " . $row[8] . "<br />";
          echo "Incendio: " . $row[9] . "<br />";
          echo "Mezzi leggeri: " . $row[10] . "<br />";
          echo "Mezzi pesanti: " . $row[11] . "<br />";
          echo "Trattore: " . $row[12] . "<br />";
          echo "Muletto: " . $row[13] . "<br />";
          echo "Sgombraneve: " . $row[14] . "<br />";
          echo "Motoseghe: " . $row[15] . "<br />";
          echo "Rimorchi: " . $row[16] . "<br />";
          echo "Abi01: " . $row[17] . "<br />";
          echo "Abi02: " . $row[18] . "<br />";
          echo "Abi03: " . $row[19] . "<br />";
        }
        ?>
      </div>
    </div>  -->
    <div id="footer">
    </div>

  </body>
  </html>
