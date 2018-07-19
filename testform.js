var cocktail = document.getElementById("cocktail"),
	cId = cocktail != null ? cocktail.getAttribute('data') : undefined,
	clist = document.getElementById("searchresults1"),
	basis = document.getElementById("basis"),
	kategorie = document.getElementById("kategorie"),
	btnImage = document.getElementById("image"),
	bildname = btnImage != null ? btnImage.getAttribute('value') : null,
	menge = document.getElementsByClassName("menge"),
	einheit = document.getElementsByClassName("einheit"),
	zutaten = document.getElementsByClassName("zutat"),
	zlist = document.getElementById("searchresults-0"),
	rezept = document.getElementById("rezept"),
	geschmack = document.getElementById("geschmack"),
	hintergrund = document.getElementById("hintergrund"),
	btnUpload = document.getElementById("btnUpload"),
	btnChange = document.getElementById("btnChange"),
	check = 0,
	check2 = null,
	btnItem = document.getElementById("addItem"),
	btnDelete = document.getElementById("btnDelete"),
	rezeptlist = document.getElementById("rezeptlist"),
	list = rezeptlist ? rezeptlist.childNodes : null,
	cnt = 0,
	cnt2 = 0,
	cnt3 = rezeptlist ? list.length-6 : null,
	cnt4 = 0,
	btnEdit = document.getElementById("editC"),
	btnDelC = document.getElementById("btnDelC"),
	btnNew = document.getElementById("newC"),
	dataPack = '',
	fehler = document.getElementById("fehler"),
	btnToForm = document.getElementById("btnToForm"),
	btnToList = document.getElementById("btnToList"),
	test = null;

// neue Zutat in Upload-Formular hinzufügen
function addItem(evt) {
	var div = rezeptlist.firstElementChild,
		cln = div.cloneNode(true);	// true = auch Unterknoten clonen
	// Index hochzählen bei input, datalist, options
	cnt += 1;
	cln.setAttribute('class', 'zutat-'+cnt);
	newInput = cln.lastElementChild.firstElementChild;
	newInput.setAttribute('list', 'searchresults-'+cnt);
	newDL = cln.lastElementChild.lastElementChild;
	newDL.setAttribute('id', 'searchresults-'+cnt);
	options = newDL.getElementsByTagName("OPTION");
	for (j=0; j<options.length; j++) {
		options[j].setAttribute('id', options[j].value+'-'+cnt);
	}
	count = rezeptlist.childElementCount;
	// data-id bei neuem Eingabefeld löschen
	newInput.setAttribute('data-id', '');
	newInput.value = '';	// kA warum, aber hilft anscheinend
	//	Neue Inputfelder auf '' setzen
	var mengeNeu = cln.getElementsByClassName('menge')[0],
		zutatNeu = cln.getElementsByClassName('zutat')[0],
		einheitNeu = cln.getElementsByClassName('einheit')[0];
	mengeNeu.value = zutatNeu.value = einheitNeu.value = '';
	// neues Eingabefeld vor Button einfügen
	rezeptlist.insertBefore(cln, btnItem);	
	// wenn nur noch 1 Zutat, dann Löschbutton ausblenden
	if (count = 4) {
		btnDelete.style.display="inline";
	}
	for (var i = 0; i < zutaten.length; i++) {
  		zutaten[i].addEventListener('change', showValue);
	}
}

// Zutat in Upload-Formular löschen
function deleteItem(evt) {
	// bei Neu-Upload
	if (cId == undefined) {
		var lastDivPos = rezeptlist.childNodes.length - 5,
			lastDiv = rezeptlist.childNodes[lastDivPos],
			count = rezeptlist.childElementCount,
			btn = rezeptlist.lastElementChild;
		if (count > 4) {
			rezeptlist.removeChild(lastDiv); 
		}
		else if (count = 4) {
			rezeptlist.removeChild(lastDiv); 
			btnDelete.style.display="none";
		}
	} else {
		var allDiv = rezeptlist.getElementsByTagName("div"),
			lastDiv = allDiv[allDiv.length-4];	// letztes Zutat-Element
		if (allDiv.length > 4) {
			lastDiv.parentNode.removeChild(lastDiv);
		}
		// Löschbutton ausblenden, wenn nur noch 1 Zutat
		if (allDiv.length < 5) {
			btnDelete.style.display="none";
		} else {
			btnDelete.style.display="inline";
		}
	}
}
// Image-Upload
function imageHandler(evt) {
	var file = evt.target.files[0],     //  hole Bilddaten aus dem Dateneingabefeld
        reader = new FileReader();      //  erzeuge ein FileReader-Objekt zum auswerten der Bilddaten
    // Prüfung, ob die ausgwählte Datei ein JPG, PNG oder GIF ist
    if (file.type === "image/jpeg" || file.type === "image/png" || file.type === "image/gif") {
        //  Interpretiere die BildDaten als Daten-URL (verschlüsselte Rohdaten)
        reader.readAsDataURL(file);
    } else {
        //  Ansonsten Fehlermeldung
        alert('Bitte nur Bilddateien hochladen.')
    }
}

// Button EventListener 
if (btnItem) { 
	btnItem.addEventListener("click", addItem); 
}
if (btnDelete) { 
	btnDelete.addEventListener("click", deleteItem); 
}
if (btnEdit) { 
	btnEdit.addEventListener("click", function() { window.location.href="cocktail_form.php"; }); 
}
if (btnNew) { 
	btnNew.addEventListener("click", function() { window.location.href="cocktail_form.php"; }); 
}
if (btnToForm) {
	btnToForm.addEventListener("click", function() { window.location.href="cocktail_form.php"; });
}
if (btnToList) {
	btnToList.addEventListener("click", function() { window.location.href="cocktail_liste.php"; });
}
if (btnImage) {
	btnImage.addEventListener("change", imageHandler);
}
// Formular auslesen

// Anzeige der Zutaten in Liste
function showValue(evt) {
	var id = evt.currentTarget.getAttribute('list'),
		n = id.split('-')[1],
    	dl = document.getElementById(id),
    	zutatenID = undefined;
    	// wenn Eintrag vorhanden, dann Zutaten-ID übernehmen
    	for (var i = 0; i < dl.options.length; i++) {
    		var o = dl.options[i];
    		if(o.value === evt.currentTarget.value) {
    			zutatenID = o.getAttribute('data-value');
    		}
    	}
    	// wenn neuer Eintrag eingegeben wurde, dann "-1" als Zutat-ID setzen
    	zutatenID = zutatenID !== undefined ? zutatenID : '-1';
    	evt.currentTarget.setAttribute('data-id', zutatenID);
}
// Eventlistener für Änderung der Zutatenliste
for (var i = 0; i < zutaten.length; i++) {
  zutaten[i].addEventListener('change', showValue);
}

// Zutaten aus Formular auslesen
function addCocktail() {
	// Array für Zutatenliste: Menge, Einheit, Zutat, ZutatId
	var mengeArr = new Array (),
		einheitArr = new Array (),
		zutatArr = new Array (),
		zutatIdArr = new Array();
	// Data-Id bei Cocktail-Update bestehenden Zutaten hinzufügen
	for (i=0;i<zutaten.length;i++) {
		for (j=0; j<zlist.children.length; j++) {
			if (!zutaten[i].getAttribute('data-id')) {
				if (zutaten[i].value.match(zlist.children[j].value) != null) {
					newId = zlist.children[i].getAttribute('data-value');
					zutaten[i].setAttribute('data-id', newId);
				} 
			}
		}
	}
	// Array-Werte hinzufügen
	for (i=0; i<menge.length; i++) {
		mengeArr.push(menge[i].value);
		einheitArr.push(einheit[i].value);
		zutatArr.push(zutaten[i].value);
		// wenn neue Zutat ohne data-id, dann "-1" eintragen
		if (zutaten[i].getAttribute("data-id") != null) {
			zutatIdArr.push(zutaten[i].getAttribute("data-id"));
		} else {
			zutatIdArr.push(-1);
		}
	}
	// Objekt erstellen
	dataPack = {
		"name" : cocktail.value,
		"basis" : basis.value,
		"kategorie" : kategorie.value,
		"rezept" : rezept.value,
		"hintergrund" : hintergrund.value,
		"geschmack" : geschmack.value,
		"mengeAll" : mengeArr,
		"einheitAll" : einheitArr,
		"zutatAll" : zutatArr,
		"zutatAllId" : zutatIdArr,
		"test" : test,
		"cId" : cId,
		"bildname" : bildname
	}
	dataPack = JSON.stringify(dataPack);
}
function uploadCocktail() {
	// Formulardaten hochladen
	cocktailData = new FormData();
	cocktailData.set('data', dataPack);
	if (btnImage.files.length > 0) {
		var file = btnImage.files[0];
		cocktailData.set('image', file, file.name);
	}
    ajaxhttp.open("POST", "uploadtest.php", true);
    ajaxhttp.send(cocktailData);
}
// Check bei Klick auf Upload-Button
function checkForm() {
	check = 0;
	check2 = null;
	if (fehler.firstElementChild !== null) {
		for (i=0;i<fehler.childNodes.length;i++) {
			fehler.childNodes[i].innerHTML = "";
		}
	} 

	// Überprüfen, ob Formularfelder leer sind
	function checkVal(item, val) {
		var css = "";
		if (item.value == val) {
			check += 1;
			css = "2px solid red";
		} else {
			css = "none";
		}
		item.style.border = css;
	}
	// Darstellen der Fehlermeldung
	function errorMessage(str) {
		var p = document.createElement("P");
		var t = document.createTextNode(str);
		p.appendChild(t);
		fehler.appendChild(p);
	} 
	// Überprüfen, ob Menge gültigen Werten entspricht
	var regex = /^[0-9.,\-]+$/;
	for (i=0; i<menge.length; i++) {
		if (regex.test(menge[i].value) == false && menge[i].value !== "") {
			menge[i].style.border = "2px solid red";
			check2 = 1;
		}
	}
	// Markierung der nicht ausgefüllten Inputfelder
	checkVal(cocktail, "");
	checkVal(rezept, "");
	checkVal(hintergrund, "");
	checkVal(basis, 0);
	checkVal(kategorie, 0);
	checkVal(geschmack, 0);
	checkVal(image, null);
	for (var i=0;i<zutaten.length;i++) {
		checkVal(zutaten[i], 0);
		checkVal(einheit[i], 0);
	}
	// Ausgabe der Fehlermeldung bei nicht ausgefüllten Inputfeldern
	if (check !== 0) {
		errorMessage("Bitte füllen Sie das Formular vollständig aus.");
	} 
	// Prüfung der Mengenfelder
	if (check2 !== null ) {
		errorMessage("Unerlaubte Eingabe bei Menge.");
	}	
	// Überprüfung, ob bei Neu-Upload Cocktailname bereits vergeben ist
	if (cocktail.value !== "") {
		for (i=0;i<clist.children.length;i++) {
			if ((clist.children[i].value === cocktail.value) && (test == null)) {
				errorMessage("Dieser Cocktailname exisitiert bereits.");
				check += 1;
			} 
		} 
	}
	if (check == 0 && check2 == null) {
		// Upload des Cocktails
		addCocktail();
		uploadCocktail();
	}
}
// AJAX
var ajaxhttp = new XMLHttpRequest();
ajaxhttp.onreadystatechange = function() {
	if (this.readyState == 4 && this.status == 200) {
		console.log(ajaxhttp.responseText);
		if (ajaxhttp.responseText.match("Cocktail-Eintrag hochgeladen.")) window.location.href="after_upload.php";
		if (ajaxhttp.responseText.match("Datenbank aktualisiert.")) window.location.href="after_update.php";
	}
};
// bei Neu-Upload von Cocktail
if (btnUpload != null) {
	btnUpload.onclick = function() {
	checkForm();
	};
}
// bei Aktualisierung von Cocktail
if (btnChange != null) {
	btnChange.onclick = function() {
	test = 1;
	checkForm();
	};
}
// bei Löschen eines bestehenden Cocktails
if (btnDelC != null) {
	btnDelC.onclick = function() {
		var box = window.confirm("Wollen Sie den Eintrag wirklich löschen?");
		if (box==true) {
			test = 2;
			checkForm();
		} else {
			console.log("Löschen abgebrochen");
		}
	}
}
