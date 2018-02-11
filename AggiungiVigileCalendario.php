<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="css/layout.css?v={random number/string}"/>
	<title>Turni Default</title>
</head>
<body>
	<?php
	if( isset($_POST['admin']) ) {
		$admin=$_POST['admin'];
	}
	else {
		$admin="false";
	}
		if( isset($_POST['settimana']) ) {
			$settimana=$_POST['settimana'];
		}
		if( isset($_POST['anno']) ) {
			$anno=$_POST['anno'];
		}
		// if ( isset($_POST['matricola']) ) {
		// 	$matricola=$_POST['matricola'];
		// 	if(!$conn = pg_connect("host=localhost port=5432 user=postgres password=root dbname=VVFF")) {die("Connessione fallita !<br>");}
		// 	if ( isset($_POST['aggiungi']) ) {
		// 		$query='SELECT public.f_aggiungi_vigile_turni_default(' . $squadra . ', ' . $matricola . ');';
		// 		$operazione=$_POST['aggiungi'];
		// 	}
		// 	else if ( isset($_POST['rimuovi']) ) {
		// 		$query='SELECT public.f_rimuovi_vigile_turni_default(' . $squadra . ', ' . $matricola . ');';
		// 		$operazione=$_POST['rimuovi'];
		// 	}
		// 	$res = pg_exec($query);
		// 	$nrows = pg_numrows($res);
		// 	if($nrows == 0) die("Rows returned are 0!");
		// 	while ($row = pg_fetch_array($res)) {
		// 		if ($row[0]=true){
		// 			// aggiungere alert per successo o fallimento inserimento nel turno
		// 			echo '<h1>Opearzione ' . $operazione . ' eseguita con successo</h1>';
		// 		}
		// 		else {
		// 			echo '<h1>Errore durante operazione ' . $operazione .'</h1>';
		// 		}
		// 	}
		// 	pg_close($conn);
		// }
	?>

	<div id="header">
		<h1>Aggiungi vigile al calendario <?php echo $settimana . ' ' . $anno ?></h1>
	</div>
	<div id="navigation_menu">
		<form action="Index.php" method="post">
					<input type="hidden" name="admin" value="<?php echo $admin ?>">
    			<input type="submit" class="button" value="Home">
		</form>
	</div>



	<div id="content">
		<div id="turno_attuale">
						<table id="table_organico" width="100%" border="0" cellpadding="0" cellspacing="0">
						 <tr><th>Grado</th><th>Cognome</th><th>Nome</th><th>Matricola</th><th>Cercapersone</th></tr>
						 <?php
						 require "connect_db.php";
								$query='SELECT descrizione, cognome, nome, matricola ';
								$query=$query . 'FROM public.t_organico_corpo AS oc, public.t_gradi AS gr ';
								$query=$query . 'WHERE NOT EXISTS ( SELECT 1 FROM public.t_calendario AS cal ';
								$query=$query . 'WHERE settimana = ' . $settimana . ' ';
								$query=$query . 'AND anno = ' . $anno . ' ';
								$query=$query . 'AND cal.matricola = oc.matricola) ';
								$query=$query . 'AND oc.id_grado=gr.id ';
								$query=$query . 'ORDER BY oc.id_grado, oc.cognome, oc.nome ASC;';
							 $res = pg_exec($query);
							 $nrows = pg_numrows($res);
							 $ncols = pg_numfields($res);

							 if($nrows == 0) {
								 echo "Nessun vigile da poter aggiongere";
							 }
							 else {
								 while ($row = pg_fetch_array($res)) {
										echo '<tr><form action="ActionAggiungiVigileCalendario.php" method="post">
										<td>' . $row[0] . '</td><td>' . $row[1] . '</td><td>' . $row[2] . '</td>
										<td>
										<input type="hidden" name="admin" value="' . $admin . '">
										<input type="hidden" name="settimana" value="' . $settimana . '">
										<input type="hidden" name="anno" value="' . $anno . '">
										<input type="hidden" name="matricola" value="' . $row[3] . '">
										<input type="submit" value="Aggiungi">
										</td>
										<td><select id="cercapersone" name="cercapersone">';
                    $query_cp="SELECT * FROM (SELECT unnest(enum_range(NULL::public.cercapersone)) as cp
                                EXCEPT ALL
                                SELECT cp FROM public.t_calendario AS cal WHERE anno=" . $anno . " AND settimana=" . $settimana . ") AS cp
																UNION
																SELECT ''
                                ORDER BY cp ASC";
                    $res_cp = pg_exec($query_cp);
          			$nrows_cp = pg_numrows($res_cp);
                    if($nrows_cp == 0) die("Rows returned are 0!");
                    while ($row_cp = pg_fetch_array($res_cp)) {
                        if ($row_cp[0] == '') {
                            echo '<option selected value=""></option>';
                        }
                        else {
                            echo '<option value="' . $row_cp[0] . '">' . $row_cp[0] . '</option>';
                        }
                    }
                    echo '</select></td></form></tr>';
								}
							 }
							 pg_close($conn);
						 ?>
			</table>

		</div>
		<div id="organico_corpo">
		</div>
	</div>
	<div id="footer">
	</div>

</body>
</html>
