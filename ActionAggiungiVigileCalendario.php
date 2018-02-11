<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Agguinta/Modifica vigile al calendario</title>
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
	$query="INSERT INTO public.t_calendario(settimana, anno, matricola, cp, squadra) ";
	$query=$query . "VALUES (" . $_POST["settimana"] . ", " . $_POST["anno"] . ", " . $_POST["matricola"] . ", '" . $_POST["cercapersone"] . "', ";
	$query=$query . "(SELECT DISTINCT squadra FROM public.t_calendario ";
	$query=$query . "WHERE settimana=" . $_POST["settimana"] . " AND anno=" . $_POST["anno"] . "));";
	$res = pg_exec($query);
	pg_close($conn);
	?>
	<form action="Index.php" method="post">
		<input type="hidden" name="admin" value="<?php echo $admin ?>">
				<input type="submit" class="button" value="HOME" />
	</form>
</body>
</html>
