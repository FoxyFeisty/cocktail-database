<?php

# Einbindung der Datenbankverbindung
include("cocktail_dbconn.php");
# Einbindung von Zusatzfunktionen
	# TBD 

# IDs von Basisalkohol und Kategorie empfangen
if (isset($_GET["basisId"])) {
$basisId = $_GET["basisId"];
}
// $katId = $_GET["katId"];
// # ID von Suche empfangen
// $suche = trim($_POST["suche"]);

# Generierung des Seitentitels in <h1>
if (isset($basisId)) {
	$sql = "SELECT name FROM basis WHERE id=$basisId";
	$zeiger = mysqli_query($conn,$sql);
	$datensatz = mysqli_fetch_assoc($zeiger);
	$seitentitel = "Cocktails auf der Basis von: ".$datensatz["name"];
	mysqli_free_result($zeiger);
// } else {
// 	$seitentitel = "Das Cocktail-Lexikon";
}

?>


<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="https://fonts.googleapis.com/css?family=Playfair+Display" rel="stylesheet"> 
		<link rel="stylesheet" href="cocktail.css">
	</head>
	<body>
		<!-- Hauptcontainer -->
		<div id="mainDiv">
			<!-- Header -->
			<div id="topDiv">
				<!-- Container für Seitentitel -->
				<div>
					<h1 id="pagetitle">Das Cocktail-Lexikon</h1>
				</div>
				<!-- Hauptmenü für Cocktail-Basisalkohol -->
				<nav id="nav1">

<?php
 
// SQL für Cocktail-Basisalkohol
$sql = "SELECT * FROM basis ORDER BY name";
// SQL an Datenbank übergeben und (Zeiger auf) Ergebnis merken
$zeiger = mysqli_query($conn, $sql);
// Datensätze holen, auf die Zeiger zeigt
echo "<ul>";
while ($datensatz = mysqli_fetch_assoc($zeiger)) {
	// Angeklickten Menüpunkt markieren 
	if ($basisId == $datensatz["id"]) {
		$linkclass = "class=\"navActive\"";
	} else {
		$linkclass = "";
	}
	// Navigation
	echo "<li>";
	echo "<a $linkclass href=\"".$_SERVER["SCRIPT_NAME"]."?basisId=".$datensatz["id"]."\">".$datensatz["name"]."</a>";
	echo "</li>\n";
}
echo "</ul>";
// Ergebnis wieder freigeben
mysqli_free_result($zeiger);

?>
				</nav>
			</div>
			<!-- Container für Untermenü und Inhalt -->
			<div id="middleDiv">
				<!-- Seitenleiste mit Suche und Untermenü -->
				<div id="sideDiv">
					<div id="search">
					</div>
					<div id="nav2">
					</div>
				</div>
				<!-- Content für Inhalt -->
				<div id="contentDiv">

<?php
# Cocktail zu Basisalkohol anzeigen
if (isset($basisId)) {
	$c_array = array();
	$sql = "SELECT * FROM cocktail WHERE basis_id = $basisId";
	$zeiger = mysqli_query($conn, $sql);
	while ($datensatz = mysqli_fetch_assoc($zeiger)) {
		# Cocktail-Datensatz auslesen 
		$cocktail["name"] = $datensatz["name"];
		$cocktail["kategorie_id"] = $datensatz["kategorie_id"];
		$cocktail["bild"] = $datensatz["bild"];
		$cocktail["hintergrund"] = $datensatz["hintergrund"];
		$cocktail["zutaten"] = $datensatz["zutaten_sammlung"];
		$cocktail["zutaten"] = explode("/", $cocktail["zutaten"]);
		for($i = 0; $i < count($cocktail["zutaten"]); $i += 1) {
			$cocktail["zutaten"][$i] = explode(",", $cocktail["zutaten"][$i]);
		}
		$cocktail["rezept"] = $datensatz["rezept"];
		$cocktail["geschmack_id"] = $datensatz["geschmack_id"];
		# Cocktail-Datensatz in Gesamt-Array speichern
		array_push($c_array, $cocktail);
	}
	for ($i = 0; $i < count($c_array); $i++) {
		$c = $c_array[$i];
		# Array mit Menge, einheit_id und zutaten_id
		$zutaten = $c["zutaten"];
		# Array für Zutaten
		$z_array = array();
		# Array für Einheiten
		$e_array = array();
		# Array für Menge
		$m_array = array();
		for ($j = 0; $j < count($zutaten); $j++) {
			$menge = $zutaten[$j][0];
			array_push($m_array, $menge);
		}
		# Namen der Zutaten aus Tabelle 'zutaten' auslesen
		for ($j = 0; $j < count($zutaten); $j++) {
			$zutatenId = intval($zutaten[$j][2]);
			$sql = "SELECT name FROM zutaten WHERE id = $zutatenId";
			$zeiger = mysqli_query($conn, $sql);
			while ($datensatz = mysqli_fetch_assoc($zeiger)) {
				$zutatenName = $datensatz["name"];
				array_push($z_array, $zutatenName);
			}
		}
		# Einheiten aus Tabelle 'einheiten' auslesen
		for ($j = 0; $j < count($zutaten); $j++) {
			$einheitenId = intval($zutaten[$j][1]);
			$sql = "SELECT name FROM einheiten WHERE id = $einheitenId";
			$zeiger = mysqli_query($conn, $sql);
			while ($datensatz = mysqli_fetch_assoc($zeiger)) {
				$einheit = $datensatz["name"];
				array_push($e_array, $einheit);
			}
		}
		# Kategorie aus Tabelle 'kategorie' auslesen
		$katId = $c["kategorie_id"];
		$sql = "SELECT name FROM kategorie WHERE id = $katId";
		$zeiger = mysqli_query($conn, $sql);
		while ($datensatz = mysqli_fetch_assoc($zeiger)) {
			$kategorie = $datensatz["name"];
		}
		# Geschmack aus Tabelle 'geschmack' auslesen
		$gId = $c["geschmack_id"];
		$sql = "SELECT name FROM geschmack WHERE id = $gId";
		$zeiger = mysqli_query($conn, $sql);
		while ($datensatz = mysqli_fetch_assoc($zeiger)) {
			$geschmack = $datensatz["name"];
		}
		// echo "<h4>" . $seitentitel . "</h4>"; 
		echo "<h1 class=\"kategorieHL\">Kategorie: " . $kategorie . "</h4>"; 
		echo "<div class=\"introDiv\">" . $cocktail["bild"];
		echo "<h1 class=\"mainHL\">" . $cocktail["name"] . "</h1>";
		echo "<h1 class=\"subHL\">" . "Hintergrund: </h2>";
		echo "<p>" . $cocktail["hintergrund"] . "</p></div>";
		echo "<div id=\"rezeptDiv\"><h1 class=\"subHL\">" . "Zutaten: </h2><ul>";
		for ($j = 0; $j < count($e_array); $j++) {
			$str = $m_array[$j] . " " . $e_array[$j] . " " . $z_array[$j];
			echo "<li>" . $str . "</li>";
		}
		echo "</ul>";
		echo "<h1 class=\"subHL\">" . "Rezept: </h2>";
		echo "<p>" . $cocktail["rezept"] . "</p>";
		echo "<p>Geschmack: " . $geschmack . "</p></div>";
	}
}

?>
				</div>
			</div>
			<!-- Container für Impressum -->
			<div id="bottomDiv">
				<!-- <footer id="footer">
					<a href=#>Impressum</a>
				</footer> -->
			</div>
		</div>

<?php
# Datenbankverbindung schließen
mysqli_close($conn);
?>

	</body>
</html>
