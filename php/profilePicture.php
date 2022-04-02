<?php

session_start();
require_once('connection.php');

if (!isset($_SESSION['userID'])){
    die("A funkció használatához be kell jelentkezni!");
}
if (!isset($_POST['upload'])){
    die("Nem kattintottál a feltöltés gombra!" );
}

$db = new Database();

$uid = $_SESSION['userID'];

$imgName = $_FILES['fajl']['name'];
$imgType = $_FILES['fajl']['type'];
$imgTmpName = $_FILES['fajl']['tmp_name'];
$imgSize = $_FILES['fajl']['size'];
$uploadError = $_FILES['fajl']['error'];
$imgFormat = array("image/jpeg", "image/png", "image/jpg");

if (in_array($imgType, $imgFormat) && $imgSize < 16000000){
    if (!file_exists("C:\xampp\htdocs\SZTE-Webterv\profilePics\\".$imgName)) {
        move_uploaded_file($imgTmpName, "profilePics/".$imgName);
        $res = $db -> profilePicsInsertDB($uid,$imgName);

    } else {
        $res = $db -> profilePicsUpdate($uid,$imgName);
    }
} else {
    echo "Nem engedélyezett fájltípus, vagy túl nagy néretű!";
}
header("Location: ../profilszerkesztes/profil_modositasa.php");

?>
