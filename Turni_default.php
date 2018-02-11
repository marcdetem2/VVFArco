<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="css/layout.css?v={random number/string}"/>
	<title>Turni Default</title>
	<style>
	select {
		/*width: 100%;*/
		padding: 16px 20px;
		border: none;
		border-radius: 4px;
		background-color: #f1f1f1;
	}
</style>
</head>
<body>
	<?php
	if( isset($_POST['squadra']) ) {
		$squadra=$_POST['squadra'];
	}
	else {
		$squadra="1";
	}
	if( isset($_POST['nuova_squadra']) ) {
		$squadra=$_POST['nuova_squadra'];
	}
	if( isset($_POST['cercapersone']) ) {
		$cercapersone=$_POST['cercapersone'];
	}
	if ( isset($_POST['matricola']) ) {
		$matricola=$_POST['matricola'];
		require "connect_db.php";
		if ( isset($_POST['operazione']) ) {
			$operazione=$_POST['operazione'];
			if ( $operazione == "aggiungi") {
				$query="INSERT INTO public.t_squadre_default(squadra, matricola, cp) VALUES (" . $squadra . ", " . $matricola . ", '" . $cercapersone . "');";
			}
			else if ( $operazione == "rimuovi") {
				$query='DELETE FROM public.t_squadre_default WHERE matricola=' . $matricola . ' AND squadra=' . $squadra . ';';
			}
		}
		$res = pg_exec($query);
		$nrows = pg_numrows($res);
		$check="true";
		if($nrows == 0) $check="false";
		while ($row = pg_fetch_array($res)) {
			if ($check=true){
				// aggiungere alert per successo o fallimento inserimento nel turno
				echo '<h1>Opearzione ' . $operazione . ' eseguita con successo</h1>';
			}
			else {
				echo '<h1>Errore durante operazione ' . $operazione .'</h1>';
			}
		}
		pg_close($conn);
	}
	?>
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
		<h1>Turno squadra <?php echo $squadra ?></h1>
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
				<input type="submit" class="button" style="background-color:Tomato;" value="Definizione turni">
				</form>';
			}
			?>
		</td>
		<td>
			<form action="OrganicoCorpo.php" method="post">
				<input type="hidden" name="admin" value="<?php echo "$admin"; ?>">
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


<div id="content" overflow="auto">
	<div id="content_menu">
		<table class="content_table" >
			<?php
			require "connect_db.php";
			$query="SELECT DISTINCT td.squadra FROM public.t_squadre_default AS td ORDER BY td.squadra ASC;";
			$res = pg_exec($query);
			$nrows = pg_numrows($res);
			if($nrows != 0) {
				while ($row = pg_fetch_array($res)) {
					if ($row[0] == $squadra) {
						echo '<td><form action="Turni_default.php" method="post">
						<input type="hidden" name="admin" value="' . $admin . '">
						<input type="submit" class="button" style="background-color:Tomato;" name="squadra" value="' . $row[0] . '">
						</form></td>';
					}
					else {
						echo '<td><form action="Turni_default.php" method="post">
						<input type="hidden" name="admin" value="' . $admin . '">
						<input type="submit" class="button" name="squadra" value="' . $row[0] . '">
						</form></td>';
					}
				}
			}
			pg_close($conn);
			if ( isset($_POST['nuova_squadra']) ) {
				echo '<td><form action="Turni_default.php" method="post">
				<input type="hidden" name="admin" value="' . $admin . '">
				<input type="submit" class="button" style="background-color:Tomato;" name="squadra" value="' . $squadra . '">
				</form></td>';
			}
			?>

			<?php
			require "connect_db.php";
			$query='SELECT min(squadra_mancante) FROM (SELECT s.i AS squadra_mancante
				FROM generate_series(1,100) s(i)
				LEFT OUTER JOIN public.t_squadre_default AS td ON (td.squadra = s.i)
				WHERE td.squadra IS NULL) as select_squadre_mancanti;';
				$res = pg_exec($query);
				$nrows = pg_numrows($res);
				while ($row = pg_fetch_array($res)) {
					if($nrows == 1) {
						$nuova_squadra=$row[0];
					}
					else {
						$nuova_squadra=1;
					}
				}
				echo '<td><form action="Turni_default.php" method="post">
				<input type="hidden" name="admin" value="' . $admin . '">
				<input type="hidden" name="nuova_squadra" value="' . $nuova_squadra . '">
				<input type="submit" class="button" value="Agguingi Turno">
				</form></td>';
				pg_close($conn);
				?>
			</table>
		</div>
		<br />
		<div id="more_content_SX">
			<h3>Turno</h3>
			<table id="table_turno" width="100%" border="1" cellpadding="0" cellspacing="0">
				<tr>
					<th class="th_content">Grado</th>
					<th class="th_content">Cognome</th>
					<th class="th_content">Nome</th>
					<th class="th_content">Cercapersone</th>
					<th class="th_content">Azione</th>
				</tr>
				<?php
				require "connect_db.php";
				$query="SELECT gr.descrizione, oc.cognome, oc.nome, oc.matricola, oc.id_grado, td.cp
				FROM public.t_organico_corpo AS oc, public.t_squadre_default AS td, public.t_gradi AS gr
				WHERE oc.matricola=td.matricola AND gr.id=oc.id_grado
				AND td.squadra=" . $squadra . " ORDER BY oc.id_grado, oc.cognome, oc.nome ASC;";
				$res = pg_exec($query);
				$nrows = pg_numrows($res);
				$ncols = pg_numfields($res);

				if($nrows != 0) {
					while ($row = pg_fetch_array($res)) {
						echo '<tr><td>' . $row[0] . '</td><td>' . $row[1] . '</td><td>' . $row[2] . '</td><td>' . $row[5] . '</td>
						<td><form action="Turni_default.php" method="post">
						<input type="hidden" name="admin" value="' . $admin . '">
						<input type="hidden" name="matricola" value="' . $row[3] . '">
						<input type="hidden" name="squadra" value="' . $squadra . '">
						<input type="hidden" name="operazione" value="rimuovi">
						<input type="submit" class="button_table" value="Rimuovi" />
						</form></td></tr>';
					}
				}
				pg_close($conn);
				?>
			</table>
		</div>
		<div id="more_content_DX">
			<h3>Organico</h3>
			<table id="table_organico" width="100%" border="1" cellpadding="0" cellspacing="0">
				<tr>
					<th class="th_content">Grado</th>
					<th class="th_content">Cognome</th>
					<th class="th_content">Nome</th>
					<th class="th_content">Azione</th>
					<th class="th_content">Cercapersone</th>
				</tr>
				<?php
				require "connect_db.php";
				$query="SELECT descrizione, cognome, nome, matricola
				FROM public.t_organico_corpo AS oc, public.t_gradi AS gr
				WHERE oc.id_grado=gr.id
				AND oc.id_grado <= 5
				AND oc.matricola NOT IN (SELECT sd.matricola FROM public.t_squadre_default AS sd
					WHERE squadra=" . $squadra . ") ORDER BY oc.id_grado, oc.cognome, oc.nome ASC;";
					$res = pg_exec($query);
					$nrows = pg_numrows($res);
					$ncols = pg_numfields($res);

					if($nrows == 0) die("Rows returned are 0 tabella organico!");
					while ($row = pg_fetch_array($res)) {
						echo '<tr><td>' . $row[0] . '</td><td>' . $row[1] . '</td><td>' . $row[2] . '</td>
						<td><form action="Turni_default.php" method="post">
						<input type="hidden" name="admin" value="' . $admin . '">
						<input type="hidden" name="matricola" value="' . $row[3] . '">
						<input type="hidden" name="squadra" value="' . $squadra . '">
						<input type="hidden" name="operazione" value="aggiungi">
						<input type="submit" class="button_table" value="Aggiungi" />';
						echo '<td><select id="cercapersone" name="cercapersone">';
						$query_cercapersone="SELECT * FROM (SELECT unnest(enum_range(NULL::public.cercapersone)) as cp
						EXCEPT ALL
						SELECT cp
						FROM public.t_squadre_default
						WHERE squadra=" . $squadra . ") AS cp
						UNION
						SELECT ''
						ORDER BY cp ASC";
						$res_cercapersone = pg_exec($query_cercapersone);
						$nrows_cercapersone = pg_numrows($res_cercapersone);
						if($nrows_cercapersone == 0) die("Rows returned are 0!");
						while ($row_cercapersone = pg_fetch_array($res_cercapersone)) {
							if ($row_cercapersone[0] == '') {
								echo '<option selected value=""></option>';
							}
							else {
								echo '<option value="' . $row_cercapersone[0] . '">' . $row_cercapersone[0] . '</option>';
							}
						}
						echo '</select></td>';

						echo '</form></td></tr>';
					}
					pg_close($conn);
					?>
				</table>
			</div>

		</div>
		<div id="organico_corpo">
		</div>
	</div>
	<div id="footer">
	</div>

</body>
</html>
