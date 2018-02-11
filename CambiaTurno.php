<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>CambiaTurno</title>
	<link rel="stylesheet" type="text/css" href="css/layout.css?v={random number/string}"/>
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
    <?php
    if( isset($_POST['matricola']) ) {
      $matricola=$_POST['matricola'];
    }
    if( isset($_POST['anno']) ) {
      $anno=$_POST['anno'];
    }
    if( isset($_POST['settimana']) ) {
      $settimana=$_POST['settimana'];
    }

		require "connect_db.php";
    $query='SELECT cognome, nome, id_grado	FROM public.t_organico_corpo WHERE matricola=' . $matricola . ';';
    $res = pg_exec($query);
    $nrows = pg_numrows($res);
    $ncols = pg_numfields($res);

    if($nrows == 0) die("Rows returned are 0!");
    while ($row = pg_fetch_array($res)) {
        $cognome=$row[0];
        $nome=$row[1];
        $grado=$row[2];
    }
    echo "<h1>Sostituzione di: " . $cognome . " " . $nome . " in settimana: " . $settimana . " " . $anno . "</h1>";
    pg_close($conn);
    ?>
	</div>
	<div id="navigation_menu">
		<form action="Index.php" method="post">
            <input type="hidden" name="admin" value="<?php echo $admin ?>">
            <input type="submit" class="button" value="HOME" />
        </form>
	</div>
    <div id="content_menu">
    </div>
	<div id="turno_attuale">
    <table id="table_vigile" width="100%" border="1" cellpadding="0" cellspacing="0">
      <tr><th>Grado</th><th>Cognome</th><th>Nome</th><th>Azione</th>
				<!-- <th>Cercapersone</th> -->
			</tr>
  		<?php
			require "connect_db.php";

            $query='SELECT descrizione, cognome, nome, matricola ';
    		$query=$query . 'FROM public.t_organico_corpo AS oc, public.t_gradi AS gr ';
    		$query=$query . 'WHERE NOT EXISTS ( SELECT 1 FROM public.t_calendario AS cal ';
    		$query=$query . 'WHERE settimana = ' . $settimana . ' ';
    		$query=$query . 'AND anno = ' . $anno . ' ';
    		$query=$query . 'AND cal.matricola = oc.matricola) ';
    		$query=$query . 'AND oc.id_grado=gr.id ';
				if ($grado == 0) {
					$query=$query . 'AND (oc.id_grado=0 OR oc.id_grado=1 OR oc.id_grado=2) ';
				}
				if ($grado == 1) {
					$query=$query . 'AND (oc.id_grado=0 OR oc.id_grado=1 OR oc.id_grado=2) ';
				}
				if ($grado == 2) {
					$query=$query . 'AND (oc.id_grado=2 OR oc.id_grado=3) ';
				}
				if ($grado == 3) {
					$query=$query . 'AND (oc.id_grado=2 OR oc.id_grado=3) ';
				}
				if ($grado == 4) {
					$query=$query . 'AND oc.id_grado=4 ';
				}
				if ($grado == 5) {
					$query=$query . 'AND (oc.id_grado=4 OR oc.id_grado=5) ';
				}
    		$query=$query . 'ORDER BY oc.id_grado, oc.cognome, oc.nome ASC;';
        // echo $query;
  			$res = pg_exec($query);
  			$nrows = pg_numrows($res);
  			$ncols = pg_numfields($res);

            if($nrows != 0) {
                while ($row = pg_fetch_array($res)) {
                    echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] . '</td>
                    <td><form action="ActionCambiaTurno.php" method="post">
                    <input type="hidden" name="admin" value="' . $admin . '">
                    <input type="hidden" name="anno" value="' . $anno . '">
                    <input type="hidden" name="settimana" value="' . $settimana . '">
                    <input type="hidden" name="matricola_old" value="' . $matricola . '">
                    <input type="hidden" name="matricola_new" value="' . $row[3] . '">
                    <input type="submit" class="button" value="Cambia" ></form></td>';
                //     <td><select id="cercapersone" name="cercapersone">';
                //     $query_cp='SELECT * FROM (SELECT unnest(enum_range(NULL::public.cercapersone)) as cp
                //                 EXCEPT ALL
                //                 SELECT cp FROM public.t_calendario AS cal
                //                     WHERE anno=' . $anno . ' AND settimana=' . $settimana . ') AS cp
                //                 UNION
                //                 SELECT cp FROM public.t_calendario WHERE anno=' . $anno . ' AND settimana=' . $settimana . ' AND matricola=' . $matricola . "
                //                 UNION
                //                 SELECT ''
                //                 ORDER BY cp ASC";
                //     $res_cp = pg_exec($query_cp);
          			// $nrows_cp = pg_numrows($res_cp);
                //     if($nrows_cp == 0) die("Rows returned are 0!");
                //     while ($row_cp = pg_fetch_array($res_cp)) {
                //         if ($row_cp[0] == '') {
                //             echo '<option selected value=""></option>';
                //         }
                //         else {
                //             echo '<option value="' . $row_cp[0] . '">' . $row_cp[0] . '</option>';
                //         }
                //     }
                //     echo '</select></td>
                    echo '</tr>';
      			}
            }
  			pg_close($conn);
  		?>
    </table>
	</div>
</body>
</html>
