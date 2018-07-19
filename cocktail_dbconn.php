<?php

# Cocktaildatenbank (Website mit Verbindung zu mySQL-Datenbank)
# Autor: Ariane Feist

# Angaben zur Datenbankverbindung in Variablen speichern
$server = "localhost";
$username = "root";
$password = "root";
$database = "cocktails";

# Verbindung aufnehmen 
$conn = mysqli_connect($server, $username, $password) or die("Keine Verbindung");

# Datenbank auswählen 
mysqli_select_db($conn, $database) or die("Datenbank nicht gefunden");

# alle Daten utf-8 codiert liefern
mysqli_set_charset($conn, "utf-8");
mysqli_query($conn, "SET NAMES 'utf8'");

?>