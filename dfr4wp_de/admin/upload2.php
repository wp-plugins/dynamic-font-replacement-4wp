<?php

$bildnameneu = $_POST['bildnameneu'];

$grundriss = $_POST['grundriss'];

// Variabeln festlegen
$max_byte_size = 2097152;
$allowed_types = "(js|ttf|jpg|jpeg|gif|bmp|png)";

$target_path = "$bildnameneu";

// Formular wurde abgeschickt
if($_POST["submit"] == "Upload") {

// Wurde wirklich eine Datei hochgeladen?
if(is_uploaded_file($_FILES["file"]["tmp_name"])) {

// G�ltige Endung? ($ = Am Ende des Dateinamens) (/i = Gro�- Kleinschreibung nicht ber�cksichtigen)
if(preg_match("/\." . $allowed_types . "$/i", $_FILES["file"]["name"])) {

// Datei auch nicht zu gro�
if($_FILES["file"]["size"] <= $max_byte_size) {

// Alles OK -> Datei kopieren
if(copy($_FILES["file"]["tmp_name"], $target_path)) {

$u = $_SERVER['HTTP_REFERER'];
header("Location: $u");
}
else {

echo "Datei konnte nicht hochgeladen werden.";

}

}
else {

echo "Die Datei darf nur eine Gr��e von " . $max_byte_size . " Byte besitzen.";

}

}
else {

echo "Die Datei besitzt keine ung�ltige Endung.";

}

}
else {

echo "Keine Datei zum Hochladen angegeben.";

}

}
else {

echo "Bitte benutzen Sie das Upload Formular.";

}

?>
