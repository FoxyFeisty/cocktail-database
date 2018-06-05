<?php

# Filmkatalog, Website mit Verbindung zur MySQL-Datenbank
# Ausgabe der Filmtitel
#
# Autor: Michael Hassel
# Email: hassel@mediakontur.de
# Stand: 09.02.2015
# Version: Basisversion
# für Schulungszwecke

# Einbindung der Datenbankverbindung
include("dbconn.php");
# Einbindung von Zusatzfunktionen
include("funktionen.php");

# ID's von Genre oder Filmgesellschaft empfangen
$gid = $_GET["gid"];
$fgid = $_GET["fgid"];
# Suchfeld empfangen
$suche = trim($_POST["suche"]);

# Generierung des Seitentitel
# wird in <title> und <h3> benutzt
if($gid){
    # SQL Name des ausgewählten Genre
    $sql =  "SELECT Name FROM Genre WHERE id = $gid";
    $zeiger = mysqli_query($conn,$sql);
    $datensatz = mysqli_fetch_assoc($zeiger);
    $seitentitel = "Filmtitel aus dem Genre \"".$datensatz["Name"]."\"";
    mysqli_free_result($zeiger);

}elseif($fgid){

    # SQL Name der ausgewählten Filmgesellschaft
    $sql =  "SELECT Name FROM Filmgesellschaft WHERE id = $fgid";
    $zeiger = mysqli_query($conn,$sql);
    $datensatz = mysqli_fetch_assoc($zeiger);
    $seitentitel = "Filmtitel der Filmgesellschaft \"".$datensatz["Name"]."\"";
    mysqli_free_result($zeiger);

}elseif($suche){

    $seitentitel = "Filmtitel zum Suchbegriff \"".$suche."\"";

}else{

    $seitentitel = "Die 10 aktuellsten Filmtitel";

}


?>

<!DOCTYPE html>
<html lang="de">
<head>

    <meta charset="utf-8">
    <title><?php echo $seitentitel; ?></title>
    <link rel="stylesheet" type="text/css" href="css/film.css">  

</head>
<body>


<!-- ###Haupt-Container### -->
<div id="main">

    <!-- ###Oberer Container### -->
    <div id="topcontainer">

        <!-- ###Container für Seitentitel und Hintergrund### -->
        <div id="top">

            <h3 id="seitentitel"><?php echo $seitentitel; ?></h3>

        </div>

        <!-- ###Container für Genre### -->
        <nav id="menu">

        <!-- ###Alle Genre### -->

<?php
# SQL für alle Genre
$sql = "SELECT * FROM genre ORDER BY Name";
# SQL an Datenbanksystem übergeben und Zeiger aufs Ergebnis merken
$zeiger = mysqli_query($conn,$sql);
# Datensätze holen, auf die der Zeiger zeigt
echo "<ul>";
while($datensatz = mysqli_fetch_assoc($zeiger)){

    # angeklicktes Genre markieren
    if($gid == $datensatz["id"]) $linkclass = "class=\"menuactive\"";
    else $linkclass = "";

    echo "<li>";
    echo "<a $linkclass href=\"".$_SERVER["SCRIPT_NAME"]."?gid=".$datensatz["id"]."\">".$datensatz["Name"]."</a>";
    echo "</li>\n";

}
echo "</ul>";
# Ergebnis wieder freigeben
mysqli_free_result($zeiger);

?>
      
        </nav>

    </div>
    <!-- ###Oberer Container### Ende -->


    <!-- ###Mittlerer Container### -->
    <div id="middle">


        <!-- ###Haupt Container für Inhalt### -->
        <div id="contentcontainer">

<?php

if($gid){
  # SQL Filmtitel zu einem Genre
  $sql =  "SELECT f.id, f.Titel, f.Beschreibung, f.DauerInMinuten, f.Erscheinungsdatum, f.Bild, f.Preis, f.Freigabe, fg.Name Filmgesellschaft, g.Name Genre ".
          "FROM film f ".
          "INNER JOIN filmgesellschaft fg ON fg.id = f.Filmgesellschaft_id ".
          "INNER JOIN genre g ON g.id = f.Genre_id ".
          "WHERE g.id = $gid AND f.Freigabe = 1 ".
          "ORDER BY f.Titel";
  
}elseif($fgid){
  
  # SQL Filmtitel zu einer Filmgesellschaft
  $sql =  "SELECT f.id, f.Titel, f.Beschreibung, f.DauerInMinuten, f.Erscheinungsdatum, f.Bild, f.Preis, f.Freigabe, fg.Name Filmgesellschaft, g.Name Genre ".
          "FROM film f ".
          "INNER JOIN filmgesellschaft fg ON fg.id = f.Filmgesellschaft_id ".
          "INNER JOIN genre g ON g.id = f.Genre_id ".
          "WHERE fg.id = $fgid AND f.Freigabe = 1 ".
          "ORDER BY f.Titel";

}elseif($suche){

  # SQL Filmtitel zu einem Suchbegriff
  $sql =  "SELECT f.id, f.Titel, f.Beschreibung, f.DauerInMinuten, f.Erscheinungsdatum, f.Bild, f.Preis, f.Freigabe, fg.Name Filmgesellschaft, g.Name Genre ".
          "FROM film f ".
          "INNER JOIN filmgesellschaft fg ON fg.id = f.Filmgesellschaft_id ".
          "INNER JOIN genre g ON g.id = f.Genre_id ".
          "WHERE (f.Titel LIKE '%$suche%' OR f.Beschreibung LIKE '%$suche%') AND f.Freigabe = 1 ".
          "ORDER BY f.Titel";

}else{

  # SQL die 10 neusten Filmtitel
  $sql =  "SELECT f.id, f.Titel, f.Beschreibung, f.DauerInMinuten, f.Erscheinungsdatum, f.Bild, f.Preis, f.Freigabe, fg.Name Filmgesellschaft, g.Name Genre ".
          "FROM film f ".
          "INNER JOIN filmgesellschaft fg ON fg.id = f.Filmgesellschaft_id ".
          "INNER JOIN genre g ON g.id = f.Genre_id ".
          "WHERE f.Freigabe = 1 ".
          "ORDER BY f.Erscheinungsdatum DESC ".
          "LIMIT 10";

}

# Ausgabe der SQL-Anweisung zum testen
//echo $sql;

# SQL ans Datenbanksystem übergeben und Zeiger aufs Ergenis merken
$zeiger = mysqli_query($conn,$sql);

####Infobereich####
# Anzahl der Datensätze ermitteln
$anzahl = mysqli_num_rows($zeiger);
# Anzahl der Datensätze ausgeben
echo "<div id=\"info\">";
if($anzahl > 0) echo "$anzahl Filmtitel gefunden";
else echo "Keine Filmtitel gefunden";
echo "</div>\n";

###Inhalts Container###
echo "<article id=\"content\">";


# Datensätze des Zeigers auslesen
while($datensatz = mysqli_fetch_assoc($zeiger)){

    # Filmtitel ausgeben
    echo  "<section class=\"film\">\n".

          "<h3>".$datensatz["Titel"]."</h3>\n".
          "<h4>Genre: ".$datensatz["Genre"]."</h4>\n".
          "<h4>Filmgesellschaft: ".$datensatz["Filmgesellschaft"]."</h4>\n".
          "<h4>Erscheinungsdatum: ".mysqldate_to_german($datensatz["Erscheinungsdatum"])."</h4>\n".
          "<h4>Dauer: ".$datensatz["DauerInMinuten"]." Minuten</h4>\n".

          "<p>\n".
          return_img("bilder/".$datensatz["Bild"])."\n".
          $datensatz["Beschreibung"]."\n".
          "</p>\n".

          "<p>\n".
          "Preis: ".str_replace(".",",",$datensatz["Preis"])." &euro;\n".
          "</p>\n";

          if($datensatz["Bild"] && file_exists("bilder/".$datensatz["Bild"])){
            echo "<div class=\"contentclearer\"></div>\n";
          }

          echo "</section>\n";

}
# Zeiger wieder freigeben
mysqli_free_result($zeiger);

?>

          
            </article>
            <!-- ###Inhalts Container### Ende -->

        </div>
        <!-- ###Haupt Container für Inhalt### Ende -->

        <!-- ###Linker Container### -->
        <div id="leftcontainer">

        <!-- ###Container für Suche### -->
        <div id="search">

            <form method="post" action="<?php echo $_SERVER["SCRIPT_NAME"]?>">
                <input class="field" type="text" name="suche" value="<?php echo $suche; ?>">
                <input class="button" type="submit" name="button" value="suchen">
            </form>

        </div>

        <!-- ###Container für Filmgesellschaften### -->
        <nav id="menu2">

            <!-- ###Alle Filmgesellschaften### -->

<?php
# SQL für alle Filmgesellschaften
$sql = "SELECT * FROM filmgesellschaft ORDER BY Name";
# SQL an Datenbanksystem übergeben und Zeiger aufs Ergebnis merken
$zeiger = mysqli_query($conn,$sql);
# Datensätze holen, auf die der Zeiger zeigt
echo "<ul>";
while($datensatz = mysqli_fetch_assoc($zeiger)){

    # angeklickte Filmgesellschaft markieren
    if($fgid == $datensatz["id"]) $linkclass = "class=\"menu2active\"";
    else $linkclass = "";

    echo "<li>";
    echo "<a $linkclass href=\"".$_SERVER["SCRIPT_NAME"]."?fgid=".$datensatz["id"]."\">".$datensatz["Name"]."</a>";
    echo "</li>\n";

}
echo "</ul>";
# Ergebnis wieder freigeben
mysqli_free_result($zeiger);

?>
        
        </nav>

        <!-- ###Container für weitere Links### -->
        <nav id="menu3">
                ###weitere Links###
        </nav>

	</div>
	<!-- ###Linker Container Ende### -->

    </div>
    <!-- ###Mittlerer Container### Ende -->

    <!-- ###Fuss Container### -->
    <footer id="footer">
            Footer
    </footer>


</div>
<!-- ###Haupt-Container### Ende -->

<?php
# Datenbankverbindung schließen
mysqli_close($conn);
?>

</body>
</html>
