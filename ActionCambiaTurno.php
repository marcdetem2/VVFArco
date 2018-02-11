<html>
<head>
	<meta charset="UTF-8">
	<title>Action Cambio turno</title>
	<link rel="stylesheet" type="text/css" href="css/layout.css?v={random number/string}"/>
</head>
<body>
	<?php
	if( isset($_POST['admin']) ) {
		$admin=$_POST['admin'];
	}
	else {
		$admin="false";
	}

	require "connect_db.php";
	$query='UPDATE public.t_calendario
		SET matricola=' . $_POST['matricola_new'] . ', sostituito=TRUE
		WHERE settimana=' . $_POST['settimana'] . ' AND anno=' . $_POST['anno'] . '
    	AND matricola=' . $_POST['matricola_old'] . ';';
	$res = pg_exec($query);
	pg_close($conn);
	?>
	<h2>Sostituzione avvenuta</h2>
	<form action="Index.php" method="post">
		<input type="hidden" name="admin" value="<?php echo $admin ?>">
		<input type="submit" class="button" value="HOME" />
	</form>

</body>
</html>
