<?php

# Einbindung der Datenbankverbindung
include("cocktail_dbconn.php");
# Einbindung von Zusatzfunktionen
	# TBD 

# IDs von Basisalkohol und Kategorie empfangen
$basisId = $_GET["basisId"];
$katId = $_GET["katId"];
# ID von Suche empfangen
$suche = trim($_POST["suche"]);

# Generierung des Seitentitels in <h1>
if ($basisId) {
	$sql = "SELECT name FROM basis WHERE id=$basisId";
	$zeiger = mysqli_query($conn,$sql);
	$datensatz = mysqli_fetch_assoc($zeiger);
	$seitentitel = "Cocktails auf der Basis von ".$datensatz["name"];
	mysqli_free_result($zeiger);
} else {
	$seitentitel = "Das Cocktail-Lexikon";
}



?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href=#>
	</head>
	<body>
		<!-- Hauptcontainer -->
		<div id="mainDiv">
			<!-- Header -->
			<div id="topDiv">
				<!-- Container für Seitentitel -->
				<div id="pagetitle">
					<h1 id="pagetitle"><?php echo $seitentitel; ?></h1>
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
	// Angeklickten Menüpunkt markieren / CSS
	// TBD
	echo "<li>";
	echo "<a href='.$_SERVER["SCRIPT_NAME"].'?basisId='.$datensatz["id"].'>".$datensatz["name"]."</a>";
	echo "</li>\n";
}
echo "</ul>";
// Ergebnis wieder freigeben
mysqli_free_result($zeiger);


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
				</div>
			</div>
			<!-- Container für Impressum -->
			<div id="bottomDiv">
				<!-- <footer id="footer">
					<a href=#>Impressum</a>
				</footer> -->
			</div>
		</div>
	</body>
</html>