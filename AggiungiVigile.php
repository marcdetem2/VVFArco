<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Aggiungi Vigile</title>
	<link rel="stylesheet" type="text/css" href="css/layout.css?v={random number/string}"/>

</head>
<body>
	<?php
	if( isset($_POST['admin']) ) {
		$admin=$_POST['admin'];
	}
	if( isset($_POST['azione']) ) {
		$azione=$_POST['azione'];
		if( isset($_POST['matricola']) ) {
			$matricola_old=$_POST['matricola'];
			}
	}
	?>
	<div id="header">
		<h1>Agguingi Vigile</h1>
	</div>
	<div id="navigation_menu">
		<table>
			<td>
				<form action="Index.php">
					<input type="hidden" name="admin" value="<?php echo $admin ?>">
					<input type="submit" class="button" value="Home" />
				</form>
			</td>
			<td>
				<form action="Turni_default.php">
					<input type="hidden" name="admin" value="<?php echo $admin ?>">
					<input type="submit" class="button" value="Definizione turni">
				</form>
			</td>
			<td>
				<form action="OrganicoCorpo.php">
					<input type="hidden" name="admin" value="<?php echo $admin ?>">
					<input type="submit" class="button" value="Organico Corpo">
				</form>
			</td>
			<td>
				<form action="Settings.php">
					<input type="hidden" name="admin" value="<?php echo $admin ?>">
					<input type="submit" class="button" value="Settigs">
				</form>
			</td>
		</table>
	</div>
	<div id="content">
		<div id="content_menu">
			<table>
				<td>
	        <form action="OrganicoCorpo.php" method="post">
						<input type="hidden" name="admin" value="<?php echo $admin ?>">
						<input type="submit" class="button" value="Annulla">
				</form>
	      </td>
		</table>
		</div>
		<br />
	  <form action="ActionAggiungiVigile.php" method="post">
			<div id="more_content_3SX">
				<?php
				require "connect_db.php";
					$query="SELECT matricola, cognome, nome, id_grado, tel_cellulare, breve_cellulare, tel_casa, breve_casa, tel_lavoro, breve_lavoro, tel_servizio,
													breve_servizio, indirizzo_casa, assunzione, mansione, email
									FROM public.t_organico_corpo
		    					WHERE matricola=" . $matricola_old . ";";

					$res = pg_exec($query);
					$nrows = pg_numrows($res);
					if($nrows != 0){
						while ($row = pg_fetch_array($res)) {
							$matricola=$row[0];
							$cognome=$row[1];
							$nome=$row[2];
							$id_grado=$row[3];
							$tel_cellulare=$row[4];
							$breve_cellulare=$row[5];
							$tel_casa=$row[6];
							$breve_casa=$row[7];
							$tel_lavoro=$row[8];
							$breve_lavoro=$row[9];
							$tel_servizio=$row[10];
							$breve_servizio=$row[11];
							$indirizzo=$row[12];
							$assunzione=$row[13];
							$mansione=$row[14];
							$email=$row[15];
						}
					}
					else {
						$matricola="";
						$cognome="";
						$nome="";
						$id_grado=10;
						$tel_cellulare="";
						$breve_cellulare="";
						$tel_casa="";
						$breve_casa="";
						$tel_lavoro="";
						$breve_lavoro="";
						$tel_servizio="";
						$breve_servizio="";
						$indirizzo="";
						$assunzione="";
						$mansione="";
						$email="";
					}
					pg_close($conn);
				?>
	    <label for="matricola">Matricola:</label>
	    <input type="text" id="matricola" name="matricola" placeholder="inserisci matricola..." value="<?php echo $matricola ?>">
			<br>
	    <label for="cognome">Cognome:</label>
	    <input type="text" id="cognome" name="cognome" placeholder="inserisci cognome..." value="<?php echo $cognome ?>">
			<br>
	    <label for="nome">Nome:</label>
	    <input type="text" id="nome" name="nome" placeholder="inserisci nome..." value="<?php echo $nome ?>">
			<br>
	    <label for="grado">Grado:</label>
	    <select id="grado" name="grado">
			<?php
							require "connect_db.php";
        			$query='SELECT GR."id", GR."descrizione" FROM public."t_gradi" as GR ORDER BY GR."id" ASC;';
        			$res = pg_exec($query);
        			$nrows = pg_numrows($res);
        			$ncols = pg_numfields($res);

        			if($nrows == 0) die("Rows returned are 0!");
        			while ($row = pg_fetch_array($res)) {
								if ($row[0] == $id_grado) {
        			    echo '<option selected value="' . $row[0] . '">' . $row[1] . '</option>';
								}
								else {
									echo '<option value="' . $row[0] . '">' . $row[1] . '</option>';
								}
        			}
        			pg_close($conn);
			?>
	    </select>
			<br>
			<label for="nome">Data assunzione:</label>
			<?php
				//list($year, $month, $day) = explode('-', $assunzione);
				//$time = mktime(0, 0, 0, $month, $day, $year);
				//$assunzione = date('Y-m-d', $time);
				if ($assunzione == "") {
					echo '<input type="date" name="assunzione" value="YYYY-mm-dd">';
				}
				else {
					echo '<input type="date" name="assunzione" value="' . $assunzione . '">';
				}
			?>
			<!-- <input type="date" name="assunzione" value="<?php echo $assunzione ?>"> -->
			<br>
			<label for="nome">Mansione:</label>
	    <input type="text" id="mansione" name="mansione" placeholder="inserisci mansione..." value="<?php echo $mansione ?>">
			<br>
			<label for="nome">Cellulare:</label>
	    <input type="text" id="tel_cellulare" name="tel_cellulare" placeholder="inserisci tel_cellulare..." value="<?php echo $tel_cellulare ?>">
			<br>
			<label for="nome">Cellulare Breve:</label>
	    <input type="text" id="breve_cellulare" name="breve_cellulare" placeholder="inserisci breve_cellulare..." value="<?php echo $breve_cellulare ?>">
			<br>
			<label for="nome">Casa:</label>
	    <input type="text" id="tel_casa" name="tel_casa" placeholder="inserisci tel_casa..." value="<?php echo $tel_casa ?>">
			<br>
			<label for="nome">Casa Breve:</label>
	    <input type="text" id="breve_casa" name="breve_casa" placeholder="inserisci breve_casa..." value="<?php echo $breve_casa ?>">
			<br>
			<label for="nome">Lavoro:</label>
	    <input type="text" id="tel_lavoro" name="tel_lavoro" placeholder="inserisci tel_lavoro..." value="<?php echo $tel_lavoro ?>">
			<br>
			<label for="nome">Lavoro Breve:</label>
	    <input type="text" id="breve_lavoro" name="breve_lavoro" placeholder="inserisci breve_lavoro..." value="<?php echo $breve_lavoro ?>">
			<br>
			<label for="nome">Servizio:</label>
	    <input type="text" id="tel_servizio" name="tel_servizio" placeholder="inserisci tel_servizio..." value="<?php echo $tel_servizio ?>">
			<br>
			<label for="nome">Servizio Breve:</label>
	    <input type="text" id="breve_servizio" name="breve_servizio" placeholder="inserisci breve_servizio..." value="<?php echo $breve_servizio ?>">
			<br>
			<label for="nome">Indirizzo:</label>
	    <input type="text" id="indirizzo" name="indirizzo" placeholder="inserisci indirizzo..." value="<?php echo $indirizzo ?>">
			<br>
			<label for="nome">Email:</label>
	    <input type="text" id="email" name="email" placeholder="inserisci indirizzo email..." value="<?php echo $email ?>">
			</div>
			<div id="more_content_3MID">
				<?php
				require "connect_db.php";

								$array_colonne = array("guida_emergenza", "patenteb", "patentec", "autoscala", "dae", "saf", "apvr", "gru", "incidenti",
																"incendio", "mezzi_leggeri", "mezzi_pesanti","trattore", "muletto", "sgombraneve", "motoseghe", "rimorchi",
																"abi01", "abi02", "abi03");

								$query='SELECT ';
								for($i=0;$i<count($array_colonne)-1;$i++){
									$query=$query . $array_colonne[$i] . ', ';
								}
								$query=$query . $array_colonne[count($array_colonne)-1] . ' ';
								$query=$query . 'FROM public.t_abilitazioni
												WHERE matricola=' . $matricola_old . ';';

	        			$res = pg_exec($query);
	        			$nrows = pg_numrows($res);
	        			$ncols = pg_numfields($res);

	        			if($nrows == 0) {
									for($i=0;$i<count($array_colonne);$i++){
										echo '<label for="nome">' . $array_colonne[$i] . ':</label>';
										echo '<select id="' . $array_colonne[$i] . '" name="' . $array_colonne[$i] . '">';
										$query_abilitazione='SELECT unnest(enum_range(NULL::public.abilitazione))';
										$res_abilitazione = pg_exec($query_abilitazione);
										$nrows_abilitazione = pg_numrows($res_abilitazione);
										if($nrows_abilitazione == 0) die("Rows returned are 0!");
										while ($row_abilitazione = pg_fetch_array($res_abilitazione)) {
											if ($row_abilitazione[0] == 'NO') {
												echo '<option selected value="NO">NO</option>';
											}
											else {
												echo '<option value="' . $row_abilitazione[0] . '">' . $row_abilitazione[0] . '</option>';
											}
										}
										echo '</select><br />';
									}
								}
								else {
									while ($row = pg_fetch_array($res)) {
										for($i=0;$i<count($array_colonne);$i++){
											echo '<label for="nome">' . $array_colonne[$i] . ':</label>';
											echo '<select id="' . $array_colonne[$i] . '" name="' . $array_colonne[$i] . '">';
											$query_abilitazione='SELECT unnest(enum_range(NULL::public.abilitazione))';
											$res_abilitazione = pg_exec($query_abilitazione);
											$nrows_abilitazione = pg_numrows($res_abilitazione);
											if($nrows_abilitazione == 0) die("Rows returned are 0!");
											while ($row_abilitazione = pg_fetch_array($res_abilitazione)) {
												if ($row_abilitazione[0] == $row[$i]) {
													echo '<option selected value="' . $row_abilitazione[0] . '">' . $row_abilitazione[0] . '</option>';
												}
												else {
													echo '<option value="' . $row_abilitazione[0] . '">' . $row_abilitazione[0] . '</option>';
												}
											}
											echo '</select><br />';
										}
		        			}
								}
	        			pg_close($conn);
				?>
			</div>
			<div id="more_content_3DX">
				<?php
				require "connect_db.php";

					$query="SELECT referenza01, referenza02, referenza03, referenza04, referenza05, referenza06 ";
					$query=$query . "FROM public.t_referenze WHERE matricola=" . $matricola_old . ";";
					$res = pg_exec($query);
					$nrows = pg_numrows($res);
					$ncols = pg_numfields($res);

					if ($nrows == 0) {
						for($i=1;$i<7;$i++){
							echo '<label for="nome">Referenza ' . $i . ':</label>';
							echo '<input type="text" id="referenza0' . $i . '" name="referenza0' . $i . '" placeholder="inserisci referenza..." value="" style="width:300px">';
							echo '<br>';
						}
					}
					while ($row = pg_fetch_array($res)) {
						for($i=0;$i<$ncols;$i++){
							$j=$i+1;
							echo '<label for="nome">Referenza ' . $j . ':</label>';
							echo '<input type="text" id="referenza0' . $j . '" name="referenza0' . $j . '" placeholder="inserisci referenza..." value="' . $row[$i] . '" style="width:300px">';
							echo '<br>';
						}
					}
					pg_close($conn);
				?>
		</div>
			<div id="footer">
				<input type="hidden" name="matricola_old" value="<?php echo $matricola_old ?>">
				<input type="hidden" name="azione" value="<?php echo $azione ?>">
				<input type="hidden" name="admin" value="<?php echo $admin ?>">
				<input type="reset" class="button" value="Azzera campi">
		    <input type="submit" class="button" value="Salva">
			</div>
	  </form>
	</div>
</body>
</html>
