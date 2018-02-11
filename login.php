<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" type="text/css" href="css/layout.css?v={random number/string}"/>
</head>
<body>
  <?php
  require "connect_db.php";
    $query="select ((SELECT pwd FROM public.t_login WHERE username='" . $_POST["username"] . "') =
            crypt('" . $_POST["password"] . "', (SELECT pwd FROM public.t_login WHERE username='" . $_POST["username"] . "'))
            ) as matched;";
    $res = pg_exec($query);
    $nrows = pg_numrows($res);
    if($nrows != 0) {
      while ($row = pg_fetch_array($res)) {
        if ($row[0] == "t") {
          $admin = "true";
          echo "<h1>password OK</h1>";
        }
        else {
          $admin = "false";
          echo "<h1>Password non OK</h1>";
        }
      }
    }
    else {
      $admin = "false";
      echo "<h1>Nessuna riga in uscita</h1>";
    }
    pg_close($conn);

   ?>
  <br />
  <form action="Index.php" method="post">
    <input type="hidden" name="admin" value="<?php echo $admin ?>">
    <input type="submit" class="button" value="Home"></form>
</body>
</html>
