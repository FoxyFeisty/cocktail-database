<?php

include("../cocktail_dbconn.php");

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Alle Cocktails</title>
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display" rel="stylesheet"> 
    <link rel="stylesheet" href="../cocktail.css">

  </head>
  <body>
    <div class="moveIn"><h1 class="mainHL">Alle Cocktails</h1></div>
    <div class="moveIn">
      <button type="button" id="newC" class="button">Neuer Cocktail-Eintrag</button>
    </div>
    	<div id="clist">
    		<?php
    		$sql = "SELECT c.id, c.name, k.kategorie, g.geschmack, b.basis ".
    		"FROM cocktail c " .
    		"INNER JOIN geschmack g ON g.id = c.geschmack_id ".
    		"INNER JOIN basis b ON b.id = c.basis_id ".
    		"INNER JOIN kategorie k on k.id = c.kategorie_id ".
    		"ORDER BY name";
    		$zeiger = mysqli_query($conn, $sql);

    		echo "<table id=\"myTable\">".
        "<thead><tr><th class=\"show\">Name</th><th>Basis</th>".
        "<th>Kategorie</th><th>Geschmack</th></tr></thead>".
        "<tbody>";

    		while ($datensatz = mysqli_fetch_assoc($zeiger)) {	
    			echo "<tr><td class=\"show\"><a class=\"cLink\" href=\"cocktail_form.php?cId=" . $datensatz["id"]."\">".$datensatz["name"]."</a></td><td>".$datensatz["basis"].
    			"</td><td>".$datensatz["kategorie"]."</td><td>".$datensatz["geschmack"]."</td></tr>";
    		}

    		echo "</tbody></table>";
        
    		mysqli_close($conn);
    		?>
  	</div>
    <div class="moveIn"><a href="../index.php"><span>Zurück zur Seite</span></a></div>
    <script type="text/javascript" src="testform.js"></script>
  </body>
</html>
    