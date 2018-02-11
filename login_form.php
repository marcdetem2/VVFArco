<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" type="text/css" href="css/layout.css?v={random number/string}"/>
</head>
<body>
  <h1>Login</h1>
  <form action="login.php" method="post">

  <div class="container">
    <label><b>Username</b></label>
    <input type="text" placeholder="Nome utente" name="username" required>

    <label><b>Password</b></label>
    <input type="password" placeholder="Password" name="password" required>

    <input type="submit" class="button" value="Accedi">
  </div>
</form>
</body>
</html>
