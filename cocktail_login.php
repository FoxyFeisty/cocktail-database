<?php

session_start();

include("../cocktail_dbconn.php");

# Formulardaten empfangen
if (isset($_POST["bname"])) { $bname = $_POST["bname"]; }
if (isset($_POST["pw"])) { $pw = $_POST["pw"]; }
if (isset($_POST["btn"])) { $btn = $_POST["btn"]; }

# Variablen vorbelegen
$benutzername = "ari";
$passwort = "Kenshin29";

if (isset($btn)) {

  if ($bname == $benutzername && $pw == $passwort) {
    // Sitzungsvariablen definieren
    $_SESSION["bn"] = $bname;
    $_SESSION["login"] = true;
    // Weiterleitung zur Cocktailliste
    header("Location: cocktail_liste.php", true);
  } else {
    // Meldung ausgeben
    $meldung[] = "Benutzerdaten nicht korrekt";
    // Sitzung löschen
    session_destroy();
  }
}



?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display" rel="stylesheet"> 
    <link rel="stylesheet" href="../cocktail.css">
  </head>
  <body>
    <form id="login" action="<?php echo $_SERVER["SCRIPT_NAME"]; ?>" method="post">
        <h1 class="mainHL formHL">Login</h1>
      <div>
        <label for="bname">Benutzername</label><br>
          <input id="bname" name="bname" type="text">
      </div>
      <div>
        <label for="pw">Passwort</label><br>
          <input id="pw" name="pw" type="password">
      </div>
      <div>
        <button class="button" type="submit" name="btn" value="login">Anmelden</button>
         <p id="fehler"><?php if (isset($meldung)) echo implode($meldung, "<br>"); ?></p>
     </div>
  </body>
</html>
    