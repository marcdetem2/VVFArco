<!DOCTYPE html>
<html lang="en">
<head>
  <title>Settings</title>
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
		<h1>
      Settings<br />
      <?php
      if( isset($_POST['patente']) ) {
        echo 'Patente OK: ' . $_POST['patente'] . '<br />';
      }
      else {
        echo '$_POST["patente"] non esiste';
      }
      ?>

		</h1>
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
          <input type="submit" class="button" value="Organico Corpo">
          </form>
      </td>
      <td>

        <?php
          if ($admin == "true") {
            echo '<form action="Settings.php" method="post">
            <input type="hidden" name="admin" value="' . $admin . '">
            <input type="submit" class="button" style="background-color:Tomato;" value="Settigs">
            </form>';
          }
          ?>
      </td>
    </table>
  </div>
  <div id="content" overflow="auto">
    <div id="content_menu">
    </div>
    <br />
    <div id="more_content_SX">
      <form action="Settings.php" method="post">
        <?php
        require "connect_db.php";
        $query="SELECT column_name FROM information_schema.columns
                        WHERE table_name='t_affiancamento';";
        $res = pg_exec($query);
        $nrows = pg_numrows($res);

        if($nrows == 0) die("Rows returned are 0!");
        while ($row = pg_fetch_array($res)) {
            echo '<input type="checkbox" name="' . $row[0] . '" value="True">' . $row[0] . '<br>';
          echo '<br />';
        }
        pg_close($conn);
        ?>
        <input type="submit" value="submit" /></form>
      </form>
    </div>
    <div id="more_content_MID">

    </div>
    <div id="more_content_DX">

    </div>
	</div>
  <div id="more_content">
    <div id="more_content_SX">
    </div>
    <div id="more_content_MID">
    </div>
    <div id="more_content_DX">
    </div>
  </div>
	<div id="footer">
	</div>

 </body>
 </html>
