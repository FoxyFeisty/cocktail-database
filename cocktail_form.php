<?php
# Datenverbindung öffnen
include("../cocktail_dbconn.php");

if (isset($_GET["cId"])) {
  $cId = $_GET["cId"];
  $test = true;

  $sql = "SELECT c.id, c.name, c.bild, c.hintergrund, c.rezept, c.basis_id, c.kategorie_id, c.geschmack_id, b.basis, k.kategorie, g.geschmack, GROUP_CONCAT(concat(r.menge) SEPARATOR '|') AS menge, GROUP_CONCAT(concat(e.einheit)), GROUP_CONCAT(concat(e.id)), GROUP_CONCAT(concat(z.zutat)), GROUP_CONCAT(concat(r.zutat_id))".
  "FROM cocktail c " .
  "INNER JOIN rezepte r ON r.cocktail_id = c.id " .
  "INNER JOIN einheiten e ON e.id = r.einheit_id " .
  "INNER JOIN zutaten z ON z.id = r.zutat_id ".
  "INNER JOIN geschmack g ON g.id = c.geschmack_id ".
  "INNER JOIN basis b ON b.id = c.basis_id ".
  "INNER JOIN kategorie k on k.id = c.kategorie_id ".
  "WHERE c.id = $cId";

  $zeiger = mysqli_query($conn, $sql);

  while ($dsatz = mysqli_fetch_assoc($zeiger)) {
    $cocktail = $dsatz["name"];
    $bildname = $dsatz["bild"];
    $hintergrund = $dsatz["hintergrund"];
    $rezept = $dsatz["rezept"];
    $kategorie = $dsatz["kategorie"];
    $katId = $dsatz["kategorie_id"];
    $basis = $dsatz["basis"];
    $basisId = $dsatz["basis_id"];
    $geschmack = $dsatz["geschmack"];
    $gId = $dsatz["geschmack_id"];
    $mengeArr = explode("|", $dsatz["menge"]);
    $einheitArr = explode(",", $dsatz["GROUP_CONCAT(concat(e.einheit))"]);
    $einIdArr = explode(",", $dsatz["GROUP_CONCAT(concat(e.id))"]);
    $zutatArr = explode(",", $dsatz["GROUP_CONCAT(concat(z.zutat))"]);
    $zIdArr = explode(",", $dsatz["GROUP_CONCAT(concat(r.zutat_id))"]);
  }
} else {
  $zutatArr = array(0);
}

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display" rel="stylesheet"> 
    <link rel="stylesheet" href="../cocktail.css">
    <title>Upload-Formular</title>
  </head>
  <body>    
    <!-- Formular -->
    <form id="upload" action="<?php echo $_SERVER["SCRIPT_NAME"] ?>" method="POST" enctype="multipart/form-data">
      <h1 class="mainHL formHL">Upload-Formular</h1>
      <div>
          <div class="break">
              <label>Cocktail<br>
                <input id="cocktail" <?php if(isset($cId)) echo "data=\"".$cId."\""; ?>name="cocktail" type="text" placeholder="Auswählen oder neu eingeben" list="searchresults1" 
                <?php if(isset($test)) echo "value=\"".$cocktail."\""; ?>>
                  <datalist id="searchresults1">
                  <?php
                  $sql = "SELECT * FROM cocktail ORDER BY name";
                  $zeiger = mysqli_query($conn, $sql);
                  while ($datensatz = mysqli_fetch_assoc($zeiger)) {
                    echo "<option>".$datensatz["name"]."</option>";
                  }
                  mysqli_free_result($zeiger);
                  ?>
                  </datalist>
              </label>
          </div>
          <div class="break">
              <input type="file" name="image" id="image" accept="image/*" <?php if (isset($test)) echo "value=\"".$bildname."\""; else echo "value=null"; ?>><?php if (isset($test)) echo "<div style=\"display:inline-block\">Aktuelles Bild: <mark>".$bildname."</mark></div>"; ?>
          </div>
      </div>
      <div>
        <div class="break">
          <label>Basis<select name="basis" id="basis" type="select">
            <?php 
            if (!isset($test)) echo "<option value=\"0\">Bitte auswählen</option>"; 
            else echo "<option value=\"".$basisId."\">".$basis."</option>"; 
            $sql = "SELECT * FROM basis ORDER BY basis";
            $zeiger = mysqli_query($conn, $sql);
            while ($datensatz = mysqli_fetch_assoc($zeiger)) {
              if ($datensatz["id"] == $basis) $selected = "selected=\"selected\"";
              else $selected = "";
              echo "<option value=\"".$datensatz["id"]."\">".$datensatz["basis"]."</option>";
            }
            mysqli_free_result($zeiger);
            ?>
            </select>
        </div>
        <div class="break">
          <label>Kategorie<select name="kategorie" id="kategorie" type="select">
            <?php 
            if (!isset($test)) echo "<option value=\"0\">Bitte auswählen</option>";
            else echo "<option value=\"".$katId."\">".$kategorie."</option>"; 
            $sql = "SELECT * FROM kategorie ORDER BY kategorie";
            $zeiger = mysqli_query($conn, $sql);
            while ($datensatz = mysqli_fetch_assoc($zeiger)) {
              if ($datensatz["id"] == $kategorie) $selected = "selected=\"selected\"";
              else $selected = "";
              echo "<option value=\"".$datensatz["id"]."\">".$datensatz["kategorie"]."</option>";
            }
            mysqli_free_result($zeiger);
            ?>
            </select>
        </div>
      </div>  
       <fieldset id="rezeptlist">

        <?php for ($i=0;$i<count($zutatArr);$i++) { ?>

        <div class="zutat-<?php echo $zutatArr[$i]."\""; ?>>
          <!-- zutat-0 -->
          <div class="break">
            <label>Menge<input name="menge" class="menge" <?php if (isset($test)) echo "value=".$mengeArr[$i]; ?>>
            </label>
          </div>
          <div class="break">
            <label>Einheit<select name="einheit" class="einheit" type="select">
                <?php 
                if (!isset($test)) echo "<option value=\"0\">Bitte auswählen</option>";
                else echo "<option value=\"".$einIdArr[$i]."\">".$einheitArr[$i]."</option>"; 
                $sql = "SELECT * FROM einheiten ORDER BY einheit";
                $zeiger = mysqli_query($conn, $sql);
                while ($datensatz = mysqli_fetch_assoc($zeiger)) {
                  if ($datensatz["id"] == $einheit) $selected = "selected=\"selected\"";
                  else $selected = "";
                  echo "<option value=\"".$datensatz["id"]."\">".$datensatz["einheit"]."</option>";
                }
                mysqli_free_result($zeiger);
                ?>
                </select>
            </label>
          </div>
          <div class="break">
            <label>Zutat
                <input class="zutat" name="zutat" type="text" 
                <?php 
                if (!isset($test)) echo "placeholder=\"Auswählen oder neu eingeben\""; 
                else echo "value=\"".$zutatArr[$i]."\""; ?> list="searchresults-0">
                  <datalist id="searchresults-0">
                  <?php
                  $sql = "SELECT * FROM zutaten ORDER BY zutat";
                  $zeiger = mysqli_query($conn, $sql);
                  while ($datensatz = mysqli_fetch_assoc($zeiger)) {
                    echo "<option id=\"".$datensatz["zutat"]."-0\" data-value=\"".$datensatz["id"]."\" value=\"".$datensatz["zutat"]."\"></option>";
                  }
                  mysqli_free_result($zeiger);
                  ?>
                  </datalist>
            </label>
          </div>
        </div>
       
        <?php } ?>

        <button type="button" id="addItem">Weitere Zutat</button>
        <button type="button" id="btnDelete" <?php if (!isset($test)) echo "style=\"display:none;\"";?>">Zutat entfernen</button>
      </fieldset>
      <div>
        <label>Rezept<br>
            <textarea id="rezept" name="rezept" rows="20" cols="35" placeholder="1., 2., 3. ..."><?php if (isset($test)) echo $rezept; ?></textarea>
        </label>
      </div>
      <div>
        <label>Geschmack
              <select name="geschmack" id="geschmack" type="select">
              <?php 
              if (!isset($test)) echo "<option value=\"0\">Bitte auswählen</option>"; 
              else echo "<option value=\"".$gId."\">".$geschmack."</option>"; 
              $sql = "SELECT * FROM geschmack ORDER BY geschmack";
              $zeiger = mysqli_query($conn, $sql);
              while ($datensatz = mysqli_fetch_assoc($zeiger)) {
                echo "<option value=\"".$datensatz["id"]."\">".$datensatz["geschmack"]."</option>";
              }
              mysqli_free_result($zeiger);
              ?>
              </select>
      </div>
      <div>
        <label>Hintergrund<br>
          <textarea id="hintergrund" name="hintergrund" placeholder="Entstehungsgeschichte beschreiben" rows="20" cols="35"><?php if (isset($test)) echo $hintergrund; ?></textarea>
        </label>
      </div>
      <div>
        <button type="button" class="button" name="upload" <?php if(!isset($test)) echo "id=\"btnUpload\""; else echo "id=\"btnChange\""; ?>>
          <?php if(!isset($test)) echo "Hochladen"; else echo "Aktualisieren"; ?></button>
         <button class="button" id="btnToList" type="button">Abbrechen</button>
         <?php if (isset($test)) echo "<button class=\"button\" id=\"btnDelC\" type=\"button\">Löschen</button>"; ?>
      </div>
      <p id="fehler"></p>
    </form>
    <script src="testform.js" type="text/javascript"></script>
  </body>
</html>

