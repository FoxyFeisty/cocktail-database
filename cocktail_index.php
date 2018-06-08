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
					<?php echo "<h1 id=\"pagetitle\"><a href=\"".$_SERVER["SCRIPT_NAME"].
					"\">Das Cocktail-Lexikon</a></h1>"; ?>
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
	// if ($basisId == $datensatz["id"]) {
	// 	$linkclass = "class=\"navActive\"";
	// } else {
	// 	$linkclass = "";
	// }
	// Navigation
	if (isset($basisId)) {
		if ($basisId == $datensatz["id"]) {
			$linkclass = "class=\"navActive\"";
		} else {
			$linkclass = "";
		}
		echo "<li>";
		echo "<a $linkclass href=\"".$_SERVER["SCRIPT_NAME"]."?basisId=".$datensatz["id"]."\">".$datensatz["name"]."</a>";
		echo "</li>\n";
	} else {
		echo "<li>";
		echo "<a href=\"".$_SERVER["SCRIPT_NAME"]."?basisId=".$datensatz["id"]."\">".$datensatz["name"]."</a>";
		echo "</li>\n";
	}
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
if (!isset($basisId)) {
	echo "<h1 class=\"mainHL\">\"I only take a drink on two occasions:</br> when I’m thirsty and when I’m not.\"</h1>";
	echo "<div id=\"rezeptDiv\"><p>Ob geschüttelt oder gerührt, ob on the rocks oder mit Schirmchen – die Welt der Cocktails ist so vielseitig wie faszinierend. Und wie der irische Dichter Brendan Behan richtig bemerkte: für einen guten Drink gibt es immer einen guten Grund!</br>Auf dieser Seite finden Sie nicht nur das passende Rezept, sondern auch spannende Hintergrundinfos.</br></br>Viel Vergnügen!</p></div>";
}
if (isset($basisId)) {
		# SQL Abfrage für Name, Bild, Hintergrund, Kategorie und Basis
		$sql = "SELECT c.id, c.name, c.bild, c.hintergrund, b.name basis, k.name kategorie ".
			"FROM cocktail c " .
			"INNER JOIN kategorie k ON k.id = c.kategorie_id ".
			"INNER JOIN basis b ON b.id = c.basis_id ".
			"WHERE basis_id = $basisId ";

		$zeiger = mysqli_query($conn,$sql);

		while ($datensatz = mysqli_fetch_assoc($zeiger)) {
			echo "<h1 class=\"kategorieHL\">Kategorie: " . $datensatz["kategorie"] . "</h1>"; 
			echo "<div class=\"introDiv\">" . $datensatz["bild"];
			echo "<h1 class=\"mainHL\">" . $datensatz["name"] . "</h1>";
			echo "<h1 class=\"subHL\">" . "Hintergrund: </h1>";
			echo "<p>" . $datensatz["hintergrund"] . "</p></div>";
			echo "<div id=\"rezeptDiv\"><h1 class=\"subHL\">" . "Zutaten: </h1><ul>";
		}
		# SQL Abfrage für Rezept
		$sql = "SELECT c.id, c.name, c.bild, c.hintergrund, c.rezept, b.name basis, k.name kategorie, r.einheit_id, r.menge, r.zutat_id, e.name einheit, z.name zutat ".
			"FROM cocktail c " .
			"INNER JOIN kategorie k ON k.id = c.kategorie_id ".
			"INNER JOIN basis b ON b.id = c.basis_id ".
			// "INNER JOIN geschmack g ON g.id = c.geschmack_id ".
			"RIGHT JOIN rezepte r ON r.cocktail_id = c.id ".
			"INNER JOIN einheiten e ON e.id = r.einheit_id ".
			"INNER JOIN zutaten z ON z.id = r.zutat_id ".
			"WHERE basis_id = $basisId ";

		$zeiger = mysqli_query($conn,$sql);

		while ($datensatz = mysqli_fetch_assoc($zeiger)) {
			echo "<li>" . $datensatz["menge"] . " " . $datensatz["einheit"] . " " . $datensatz["zutat"] . "</li>";
		}
		# SQL Abfrage für Rezeptbeschreibung und Geschmack
		$sql = "SELECT c.id, c.rezept, g.name geschmack ".
			"FROM cocktail c " .
			"INNER JOIN geschmack g ON g.id = c.geschmack_id ".
			"WHERE basis_id = $basisId ";

		$zeiger = mysqli_query($conn,$sql);

		while ($datensatz = mysqli_fetch_assoc($zeiger)) {
			echo "</ul><h1 class=\"subHL\">" . "Rezept: </h1>";
			echo "<p>" . $datensatz["rezept"] . "</p>";
			echo "<p>Geschmack: " . $datensatz["geschmack"] . "</p></div>";
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