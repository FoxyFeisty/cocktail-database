<?php
# Einbindung der Datenbankverbindung
include("cocktail_dbconn.php");
# IDs von Basisalkohol und Kategorie empfangen
if (isset($_GET["basisId"])) {
	$basisId = $_GET["basisId"];
}
# ID von Suche empfangen
if (isset($_POST["suche"])) {
	$suche = trim($_POST["suche"]);
}
if (isset($_GET["cocktailId"])) {
	$cocktailId = $_GET["cocktailId"];
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
		echo "<a $linkclass href=\"".$_SERVER["SCRIPT_NAME"]."?basisId=".$datensatz["id"]."\">".$datensatz["basis"]."</a>";
		echo "</li>\n";
	} else {
		echo "<li>";
		echo "<a href=\"".$_SERVER["SCRIPT_NAME"]."?basisId=".$datensatz["id"]."\">".$datensatz["basis"]."</a>";
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
if (!isset($basisId) && !isset($suche)) {
	echo "<h1 class=\"mainHL\">\"I only take a drink on two occasions:</br> when I’m thirsty and when I’m not.\"</h1>";
	// echo "<div class=\"searchDiv\">";
	// echo "<input action="
	echo "<div id=\"rezeptDiv\"><p>Ob geschüttelt oder gerührt, ob on the rocks oder mit Schirmchen – die Welt der Cocktails ist so vielseitig wie faszinierend. Und wie der irische Dichter Brendan Behan richtig bemerkte: für einen guten Drink gibt es immer einen guten Grund!</br>Auf dieser Seite finden Sie nicht nur das passende Rezept, sondern auch spannende Hintergrundinfos.</br></br>Viel Vergnügen!</p></div>";
}
if (isset($basisId)) {
	$sql = "SELECT c.id, c.basis_id, c.name, c.bild, c.hintergrund ".
	"FROM cocktail c ".
	"WHERE basis_id = $basisId";

	$zeiger = mysqli_query($conn,$sql);

	while ($datensatz = mysqli_fetch_assoc($zeiger)) {
		echo "<div class=\"listDiv\"><div class=\"imgSmall\"><img src=\"images/".$datensatz["bild"]."\"></div>";
		echo "<div class=\"listText\"><a class=\"cTitle\" href=\"cocktail_detail.php?cocktailId=".$datensatz["id"]."\">".$datensatz["name"]."</a>";
		echo "<p>".$datensatz["hintergrund"]."</p>";
		echo "<a class=\"cLink listHide\" href=\"cocktail_detail.php?cocktailId=".$datensatz["id"]."\">Zum Artikel</a></div></div>";
	}
} else if (isset($suche)) {
	$sql = "SELECT c.id, c.basis_id, c.name, c.bild, c.hintergrund ".
	"FROM cocktail c ".
	"WHERE (c.name LIKE '%$suche%' OR c.hintergrund LIKE '%$suche%' OR c.rezept LIKE '%$suche%')";

	$zeiger = mysqli_query($conn,$sql);

	while ($datensatz = mysqli_fetch_assoc($zeiger)) {
		echo "<div class=\"listDiv\"><div class=\"imgSmall\"><img src=\"images/".$datensatz["bild"]."\"></div>";
		echo "<div class=\"listText\"><a class=\"cTitle\" href=\"cocktail_detail.php?cocktailId=".$datensatz["id"]."\">".$datensatz["name"]."</a>";
		echo "<p>".$datensatz["hintergrund"]."</p>";
		echo "<a class=\"cLink\" href=\"cocktail_detail.php?cocktailId=".$datensatz["id"]."\">Zum Artikel</a></div></div>";
	}
}
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