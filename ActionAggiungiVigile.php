<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Agguinta/Modifica vigile</title>
	<link rel="stylesheet" type="text/css" href="css/layout.css?v={random number/string}"/>
</head>
<body>
	<?php
	if( isset($_POST['admin']) ) {
		$admin=$_POST['admin'];
	}
	if( isset($_POST['azione']) ) {
		$azione=$_POST['azione'];
	}
	if( isset($_POST['assunzione']) ) {
		$assunzione = $_POST['assunzione'];
		if( $assunzione == 'YYYY-mm-dd' ) {
			echo '<h2>Data non nel formato corretto.</h2><br />';
			echo '<h2>Tornare indietro di una pagina e modificare.</h2><br />';
			die("Operazone annullata<br>");
		}
	}
	if( $azione == "aggiungi" ) {
		$query="BEGIN;";
		$query=$query . "INSERT INTO public.t_organico_corpo(matricola, cognome, nome, id_grado, tel_cellulare, breve_cellulare, tel_casa, breve_casa, ";
		$query=$query . "tel_lavoro, breve_lavoro, tel_servizio, breve_servizio, indirizzo_casa, assunzione, mansione, email) ";
		$query=$query . "VALUES (" . $_POST["matricola"] . ",'" . $_POST["cognome"] . "','" . $_POST["nome"] . "', " . $_POST["grado"] . ", '" . $_POST["tel_cellulare"];
		$query=$query . "', '" . $_POST["breve_cellulare"] . "', '" . $_POST["tel_casa"] . "', '" . $_POST["breve_casa"] . "', '" . $_POST["tel_lavoro"] . "', '" . $_POST["breve_lavoro"];
		$query=$query . "', '" . $_POST["tel_servizio"] . "', '" . $_POST["breve_servizio"] . "', '" . $_POST["indirizzo"];
		$query=$query . "', '" . $_POST["assunzione"] . "', '" . $_POST["mansione"] . "', '" . $_POST["email"] . "');";

		$query=$query . "INSERT INTO public.t_abilitazioni(matricola, guida_emergenza, patenteb, patentec, autoscala, dae, saf, apvr, gru, incidenti, incendio, mezzi_leggeri, ";
		$query=$query . "mezzi_pesanti, trattore, muletto, sgombraneve, motoseghe, rimorchi, abi01, abi02, abi03) ";
		$query=$query . "VALUES (" . $_POST["matricola"] . ", '" . $_POST["guida_emergenza"] . "', '" . $_POST["patenteb"] . "', '" . $_POST["patentec"] . "', '" . $_POST["autoscala"];
		$query=$query . "', '" . $_POST["dae"] . "', '" . $_POST["saf"] . "', '" . $_POST["apvr"] . "', '" . $_POST["gru"] . "', '" . $_POST["incidenti"] . "', '" . $_POST["incendio"];
		$query=$query . "', '" . $_POST["mezzi_leggeri"] . "', '" . $_POST["mezzi_pesanti"] . "', '" . $_POST["trattore"] . "', '" . $_POST["muletto"] . "', '" . $_POST["sgombraneve"];
		$query=$query . "', '" . $_POST["motoseghe"] . "', '" . $_POST["rimorchi"] . "', '" . $_POST["abi01"] . "', '" . $_POST["abi02"] . "', '" . $_POST["abi03"] . "');";

		$query=$query . "INSERT INTO public.t_referenze(matricola, referenza01, referenza02, referenza03, referenza04, referenza05, referenza06) ";
		$query=$query . "VALUES ('" . $_POST["matricola"] . "', '" . $_POST["referenza01"] . "', '" . $_POST["referenza02"] . "', '" . $_POST["referenza03"];
		$query=$query . "', '" . $_POST["referenza04"] . "', '" . $_POST["referenza05"] . "', '" . $_POST["referenza06"] . "');";
		$query=$query . "COMMIT;";
		echo '<h2>Vigile inserito</h2><br />';
	}
	else if ($azione == "modifica") {
		$query="BEGIN;";
		$query=$query . "UPDATE public.t_organico_corpo ";
		$query=$query . "SET matricola=" . $_POST["matricola"] . ", cognome='" . $_POST["cognome"] . "', nome='" . $_POST["nome"] . "', id_grado=" . $_POST["grado"];
		$query=$query . ", tel_cellulare='" . $_POST["tel_cellulare"] . "', breve_cellulare='" . $_POST["breve_cellulare"] . "', tel_casa='" . $_POST["tel_casa"];
		$query=$query . "', breve_casa='" . $_POST["breve_casa"] . "', tel_lavoro='" . $_POST["tel_lavoro"] . "', breve_lavoro='" . $_POST["breve_lavoro"];
		$query=$query . "', tel_servizio='" . $_POST["tel_servizio"] . "', breve_servizio='" . $_POST["breve_servizio"] . "', indirizzo_casa='" . $_POST["indirizzo"];
		$query=$query . "', assunzione='" . $_POST["assunzione"] . "', mansione='" . $_POST["mansione"] . "', email='" . $_POST["email"];
		$query=$query . "' WHERE matricola=" . $_POST["matricola_old"] . ";";

		$query=$query . "UPDATE public.t_abilitazioni ";
		$query=$query . "SET matricola=" . $_POST["matricola"] . ", guida_emergenza='" . $_POST["guida_emergenza"] . "', patenteb='" . $_POST["patenteb"] . "', patentec='" . $_POST["patentec"];
		$query=$query . "', autoscala='" . $_POST["autoscala"] . "', dae='" . $_POST["dae"] . "', saf='" . $_POST["saf"] . "', apvr='" . $_POST["apvr"];
		$query=$query . "', gru='" . $_POST["gru"] . "', incidenti='" . $_POST["incidenti"] . "', incendio='" . $_POST["incendio"];
		$query=$query . "', mezzi_leggeri='" . $_POST["mezzi_leggeri"] . "', mezzi_pesanti='" . $_POST["mezzi_pesanti"] . "', trattore='" . $_POST["trattore"] . "', muletto='" . $_POST["muletto"];
		$query=$query . "', sgombraneve='" . $_POST["sgombraneve"] . "', motoseghe='" . $_POST["motoseghe"] . "', rimorchi='" . $_POST["rimorchi"] . "', abi01='" . $_POST["abi01"] . "', abi02='" . $_POST["abi02"] . "', abi03='" . $_POST["abi03"];
		$query=$query . "' WHERE matricola=" . $_POST["matricola_old"] . ";";

		$query=$query . "UPDATE public.t_referenze ";
		$query=$query . "SET matricola=" . $_POST["matricola"] . ", referenza01='" . $_POST["referenza01"] . "', referenza02='" . $_POST["referenza02"];
		$query=$query . "', referenza03='" . $_POST["referenza03"] . "', referenza04='" . $_POST["referenza04"];
		$query=$query . "', referenza05='" . $_POST["referenza05"] . "', referenza06='" . $_POST["referenza06"];
		$query=$query . "' WHERE matricola=" . $_POST["matricola_old"] . ";";

		if ($_POST["matricola_old"] != $_POST["matricola"]) {
			$query=$query . "UPDATE public.t_calendario SET matricola=" . $_POST["matricola"] . " WHERE matricola=" . $_POST["matricola_old"] . ";";
			$query=$query . "UPDATE public.t_squadre_default SET matricola=" . $_POST["matricola"] . " WHERE matricola=" . $_POST["matricola_old"] . ";";
		}
		$query=$query . "COMMIT;";
		echo '<h2>Vigile modificato</h2><br />';
	}

	require "connect_db.php";
	$res = pg_exec($query);

	pg_close($conn);
	?>
	<form action="OrganicoCorpo.php" method="post">
			<input type="hidden" name="admin" value="<?php echo $admin ?>">
				<input type="submit" class="button" value="Organico Corpo" />
	</form>
</body>
</html>
