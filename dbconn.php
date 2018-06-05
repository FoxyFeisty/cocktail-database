<?php
# Filmkatalog, Website mit Verbindung zur MySQL-Datenbank
# Verbindung zum MySQL-System herstellen und Datenbank auswählen
#
# Autor: Michael Hassel
# Email: hassel@mediakontur.de
# Stand: 03.12.2013
# Version: Basisversion
# für Schulungszwecke

# PHP-Warnungen und Fehler ausblenden
//error_reporting(0);
# PHP-Notizen ausblenden
error_reporting( E_ALL ^ E_NOTICE );

######## Datenbankverbindung herstellen ########

# Angaben zur Datenbankverbindung in Variablen speichern
$server = "localhost";
$username = "root";
$password = "root";
$database = "filmwebsite";

# Verbindung zur Datenbankserver herstellen
$conn = mysqli_connect($server, $username, $password) or die("Keine Verbindung") ;

# Datenbank auswählen
mysqli_select_db($conn, $database) or die("Datenbank nicht gefunden");

# alle Daten utf-8 codiert liefern
mysqli_set_charset( $conn, "utf8" );

?>
