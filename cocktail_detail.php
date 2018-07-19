<?php
# Einbindung der Datenbankverbindung
include("cocktail_dbconn.php");

# IDs von Cocktail, Basisalkohol und Suche empfangen
if (isset($_GET["cocktailId"])) {
	$cocktailId = $_GET["cocktailId"];
}
if (isset($_GET["basisId"])) {
	$basisId = $_GET["basisId"];
}
if (isset($_POST["suche"])) {
	$suche = trim($_POST["suche"]);
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
					<?php echo "<h1 id=\"pagetitle\"><a href=\"index.php\">Das Cocktail-Lexikon</a></h1>"; ?>
				</div>
				<!-- Hauptmenü für Cocktail-Basisalkohol -->
				<nav id="nav1">

<?php
 
// SQL für Cocktail-Basisalkohol
$sql = "SELECT * FROM basis ORDER BY basis";
// SQL an Datenbank übergeben und (Zeiger auf) Ergebnis merken
$zeiger = mysqli_query($conn, $sql);
// Datensätze holen, auf die Zeiger zeigt
echo "<ul>";
while ($datensatz = mysqli_fetch_assoc($zeiger)) {
	// Angeklickten Menüpunkt markieren 
	// Navigation
	if (isset($basisId)) {
		if ($basisId == $datensatz["id"]) {
			$linkclass = "class=\"navActive\"";
		} else {
			$linkclass = "";
		}
		echo "<li>";
		echo "<a $linkclass href=\"index.php?basisId=".$datensatz["id"]."\">".$datensatz["basis"]."</a>";
		echo "</li>\n";
	} else {
		echo "<li>";
		echo "<a href=\"index.php?basisId=".$datensatz["id"]."\">".$datensatz["basis"]."</a>";
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
						<form method="post" action="<?php echo $_SERVER["SCRIPT_NAME"]; ?>">
							<input id="searchfield" class="field" type="text" name="suche" placeholder="Cocktail">
							<input class="button" type="submit" name="button" value="suchen">
						</form>
					</div>
					<div id="nav2">
					</div>
				</div>
				<!-- Content für Inhalt -->
				<div id="contentDiv">


<?php
# Cocktail zu Basisalkohol anzeigen
if (!isset($cocktailId) && !isset($suche)) {
	echo "<h1 class=\"mainHL\">\"I only take a drink on two occasions:</br> when I’m thirsty and when I’m not.\"</h1>";
	// echo "<div class=\"searchDiv\">";
	// echo "<input action="
	echo "<div id=\"rezeptDiv\"><p>Ob geschüttelt oder gerührt, ob on the rocks oder mit Schirmchen – die Welt der Cocktails ist so vielseitig wie faszinierend. Und wie der irische Dichter Brendan Behan richtig bemerkte: für einen guten Drink gibt es immer einen guten Grund!</br>Auf dieser Seite finden Sie nicht nur das passende Rezept, sondern auch spannende Hintergrundinfos.</br></br>Viel Vergnügen!</p></div>";
}
if (isset($cocktailId)) {
	$sql = "SELECT c.id, c.name, c.bild, c.hintergrund, c.rezept, k.kategorie, g.geschmack, GROUP_CONCAT(concat(r.menge,' ',e.einheit,' ',z.zutat) SEPARATOR '<br>') ".
	"FROM cocktail c " .
	"INNER JOIN rezepte r ON r.cocktail_id = c.id " .
	"INNER JOIN einheiten e ON e.id = r.einheit_id " .
	"INNER JOIN zutaten z ON z.id = r.zutat_id ".
	"INNER JOIN geschmack g ON g.id = c.geschmack_id ".
	"INNER JOIN basis b ON b.id = c.basis_id ".
	"INNER JOIN kategorie k on k.id = c.kategorie_id ".
	"WHERE c.id = $cocktailId";

	$zeiger = mysqli_query($conn, $sql);

	while ($datensatz = mysqli_fetch_assoc($zeiger)) {
		echo "<h2 class=\"kategorieHL\">Kategorie: " . $datensatz["kategorie"] . "</h2>"; 
		echo "<h1 class=\"mainHL\">" . $datensatz["name"] . "</h1>";
		echo "<div class=\"introDiv\">";
		echo "<div class=\"imgDiv\"><img src=\"images/".$datensatz["bild"]."\"></div>";
		echo "<div id=\"rezeptDiv\"><h1 class=\"subHL\">" . "Zutaten: </h1>";
		echo "<p>" . $datensatz["GROUP_CONCAT(concat(r.menge,' ',e.einheit,' ',z.zutat) SEPARATOR '<br>')"] . "</p>";
		echo "<h2 class=\"subHL\">" . "Rezept: </h2>";
		echo "<p>" . $datensatz["rezept"] . "</p>";
		echo "<p>Geschmack: " . $datensatz["geschmack"] . "</p></div></div>";
		echo "<h2 class=\"subHL\">" . "Hintergrund: </h2>";
		echo "<p>" . $datensatz["hintergrund"] . "</p>";
	}
} else if (isset($suche)) {
	$sql = "SELECT c.id, c.basis_id, c.name, c.bild, c.hintergrund ".
	"FROM cocktail c ".
	"WHERE (c.name LIKE '%$suche%' OR c.hintergrund LIKE '%$suche%' OR c.rezept LIKE '%$suche%')";

	$zeiger = mysqli_query($conn,$sql);

	while ($datensatz = mysqli_fetch_assoc($zeiger)) {
		echo "<div class=\"listDiv\"><div class=\"imgSmall\"><img src=\"images/".$datensatz["bild"]."\"></div>";
		echo "<div class=\"listText\"><a class=\"cTitle\" href=\"".$_SERVER["SCRIPT_NAME"]."?cocktailId=".$datensatz["id"]."\">".$datensatz["name"]."</a>";
		echo "<p>".$datensatz["hintergrund"]."</p>";
		echo "<a class=\"cLink\" href=\"".$_SERVER["SCRIPT_NAME"]."?cocktailId=".$datensatz["id"]."\">Zum Artikel</a></div></div>";

	}
}

# Zeiger wieder freigeben
// mysqli_free_result($zeiger);

?>
				</div>
			</div>
			<!-- Container für Impressum -->
			<div id="bottomDiv">
				<footer id="footer">
					<a href="admin/cocktail_login.php"><span>Login</span> für Mitglieder</a>
				</footer>
			</div>
		</div>

<?php
# Datenbankverbindung schließen
mysqli_close($conn);
?>

	</body>
</html>