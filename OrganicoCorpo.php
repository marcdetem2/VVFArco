<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="css/layout.css?v={random number/string}"/>
	<title>Turni Default</title>
	<style>
      .scroll{
          overflow:scroll;
          max-width:100%;
          position:relative;
      }
  </style>
</head>
<body>
  <div id="top" style="text-align:right">
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
		<h1>Organico corpo</h1>
	</div>
	<div id="navigation_menu">
    <table>
      <td>
          <form action="Index.php" method="post">
            <input type="hidden" name="admin" value="<?php echo "$admin"; ?>">
            <input type="submit" class="button" value="Home">
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
          <input type="hidden" name="admin" value="<?php echo "$admin"; ?>">
          <input type="submit" class="button" style="background-color:Tomato;" value="Organico Corpo">
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
		<div id="content_menu">
      <table>
          <?php
          if ($admin == "true")
          {
            echo '<td><form action="AggiungiVigile.php" method="post">
            <input type="hidden" name="admin" value="' . $admin . '">
            <input type="hidden" name="azione" value="aggiungi" />
            <input type="submit" class="button" value="Agguingi Vigile" />
            </form></td>';
          }
          else {
            echo "<h2>Organico completo del corpo</h2>";
          }
          ?>
      </table>
		</div>
    <div id="organico_corpo_DX">
      <table id="table_organico_corpo" width="100%" border="1" cellpadding="0" cellspacing="0">
  			<tr>
        <?php
        if ($admin == "true")
        {
          echo '<th class="th_content">Modifica</th>';
        }
        ?>
        <th class="th_content">Cognome</th>
        <th class="th_content">Nome</th>
      </tr>
			<?php
			require "connect_db.php";
			$query="SELECT oc.cognome, oc.nome, oc.matricola, oc.id_grado
							FROM public.t_organico_corpo as oc
    					ORDER BY id_grado, cognome, nome;";
			$res = pg_exec($query);
			$nrows = pg_numrows($res);
			$ncols = pg_numfields($res);
			if($nrows != 0) {
				while ($row = pg_fetch_array($res)) {
					echo "<tr>";
          if ($admin == "true")
          {
					echo '<td class="td_content"><form action="AggiungiVigile.php" method="post">
					<input type="hidden" name="admin" value="' . $admin . '">
					<input type="hidden" name="matricola" value="' . $row['matricola'] . '">
					<input type="hidden" name="azione" value="modifica">
						<input type="submit" class="button_table" value="Modifica"></form></td>';
          }
          echo '<td class="td_content">' . $row['cognome'] . "</td>";
          echo '<td class="td_content">' . $row['nome'] . "</td>";
					echo "</tr>";
				}
			}
			pg_close($conn);
			?>
		</table>

    </div>
    <div id="organico_corpo_SX">
		<table id="table_organico_corpo" width="100%" border="1" cellpadding="0" cellspacing="0">
			<thead>
			<tr>
        <th class="th_content">Matricola</th>
				<th class="th_content">Grado</th>
				<th class="th_content">Cellulare</th>
				<th class="th_content">Breve cell</th>
				<th class="th_content">Casa</th>
				<th class="th_content">Breve casa</th>
				<th class="th_content">Lavoro</th>
				<th class="th_content">Breve lavoro</th>
				<th class="th_content">Servizio</th>
				<th class="th_content">Breve servizio</th>
				<th class="th_content">Indirizzo</th>
				<th class="th_content">Assunzione</th>
				<th class="th_content">Mansione</th>
				<th class="th_content">Email</th>

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

        <th class="th_content">Referenza01</th>
        <th class="th_content">Referenza02</th>
        <th class="th_content">Referenza03</th>
        <th class="th_content">Referenza04</th>
        <th class="th_content">Referenza05</th>
        <th class="th_content">Referenza06</th>
			</tr>
			</thead>
			<?php
			require "connect_db.php";
			$query="SELECT oc.matricola, gr.descrizione, oc.tel_cellulare, oc.breve_cellulare, oc.tel_casa, oc.breve_casa, oc.tel_lavoro, oc.breve_lavoro, oc.tel_servizio,
											oc.breve_servizio, oc.indirizzo_casa, oc.assunzione, oc.mansione, oc.email,
                      ab.guida_emergenza, ab.patenteb, ab.patentec, ab.autoscala, ab.dae, ab.saf, ab.apvr, ab.gru, ab.incidenti,
	                    ab.incendio, ab.mezzi_leggeri, ab.mezzi_pesanti, ab.trattore, ab.muletto, ab.sgombraneve, ab.motoseghe, ab.rimorchi,
                      ab.abi01, ab.abi02, ab.abi03, ref.referenza01, ref.referenza02, ref.referenza03, ref.referenza04, ref.referenza05, ref.referenza06
							FROM public.t_organico_corpo as oc, public.t_gradi AS gr, public.t_abilitazioni AS ab, public.t_referenze AS ref
    					WHERE oc.id_grado=gr.id
							AND oc.matricola=ab.matricola
              AND oc.matricola=ref.matricola
    					ORDER BY id_grado, cognome, nome;";

			$res = pg_exec($query);
			$nrows = pg_numrows($res);
			$ncols = pg_numfields($res);
			echo '<tbody  style="overflow-y: auto">';
			if($nrows != 0) {
				while ($row = pg_fetch_array($res)) {
					echo "<tr>";
					for($i=0;$i<$ncols;$i++){
						if ($i == 11) {
							list($year, $month, $day) = explode('-', $row[$i]);
							$time = mktime(0, 0, 0, $month, $day, $year);
							$assunzione = date('d-m-Y', $time);
							echo '<td class="td_content">' . $assunzione . "</td>";
						}
						else {
							if ($row[$i] == 'SI') {
								echo '<td bgcolor="#00FF00" class="td_content">' . $row[$i] . "</td>";
							}
							else if ($row[$i] == 'NO') {
								echo '<td bgcolor="#FF0000" class="td_content">' . $row[$i] . "</td>";
							}
							else if ($row[$i] == 'AFF') {
								echo '<td bgcolor="#00FFFF" class="td_content">' . $row[$i] . "</td>";
							}
							else {
								echo '<td class="td_content">' . $row[$i] . "</td>";
							}
						}
					}
					echo "</tr>";
				}
			}
			pg_close($conn);
			echo "</tbody>";
			?>
		</table>
	</div>

	<div id="more_content">

	</div>

	<div id="footer">

	</div>

</body>
</html>
