<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display" rel="stylesheet"> 
    <link rel="stylesheet" href="../cocktail.css">
    <title>Upload</title>
  </head>
  <body>
    
    <!-- Formular -->
    <form id="upload" action="<?php echo $_SERVER["SCRIPT_NAME"] ?>" method="POST" enctype="multipart/form-data">
      <h1 class="mainHL formHL">Upload-Formular</h1>
      <div>
        <label>Cocktail<br>
              <input id="cocktail" name="cocktail" type="text" placeholder="Auswählen oder neu eingeben" list="searchresults1">
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
        <input type="file" name="image" id="image" accept="image/*">
      </div>
      <div>
      <label>Basis
              <select name="basis" id="basis" type="select">
              <?php 
              echo "<option value=\"".$name."\"></option>";
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
              <label>Kategorie
              <select name="kategorie" id="kategorie" type="select">
              <?php 
              echo "<option value=\"".$kategorie."\"></option>";
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
       <fieldset id="rezeptlist">
        <div><?php echo $zutaten ?></div>
        <div class="zutat-0">
          <label>Menge
              <input type="number" name="menge" class="menge">
          </label>
          <label>Einheit
              <select name="einheit" class="einheit" type="select">
              <?php 
              echo "<option value=\"0\">Bitte auswählen</option>";
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
          <label>Zutat
              <input class="zutat" name="zutat" type="text" placeholder="Auswählen oder neu eingeben" list="searchresults-0">
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
        <button type="button" id="addItem">Weitere Zutat</button>
        <button type="button" id="btnDelete" style="display:none">Zutat entfernen</button>
      </fieldset>
      <div>
        <label>Rezept<br>
            <textarea id="rezept" name="rezept" rows=10 cols="40" value="<?php echo $rezept; ?>"></textarea>
        </label>
      </div>
      <div>
        <label>Geschmack
              <select name="geschmack" id="geschmack" type="select">
              <?php 
              echo "<option value=\"0\">Bitte auswählen</option>";
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
          <textarea id="hintergrund" name="hintergrund" rows=10 cols=40 value="<?php echo $hintergrund; ?>"></textarea>
        </label>
      </div>
      <div>
        <button type="submit" class="button" name="upload" id="upload">Hochladen</button>
      </div>
      <!-- <p id="fehler"><?php if (isset($meldung)) echo implode($meldung, "<br>"); ?></p> -->
    </form>
    <script src="../cocktail.js" type="text/javascript"></script>
  </body>
</html>

