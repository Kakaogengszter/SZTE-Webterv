<?php

session_start();
require_once('connection.php');

if (!isset($_SESSION['userID'])){
    die("A funkció használatához be kell jelentkezni!");
}


$db = new Database();

$id = $_SESSION['userID'];

$sqlselect = "SELECT * FROM users WHERE userID = $id";
$resSelect = $db -> mysqli -> query($sqlselect);

$row = $resSelect -> fetch_assoc();

$currentProfilePicture = $row["picture"];
$username = $row["username"];

$fileName = "../profilePics/$currentProfilePicture";

if($currentProfilePicture != "default.jpg"){
    unlink($fileName);
}



$uid = $_SESSION['userID'];

$imgName = $_FILES['profile-picture']['name'];
$imgType = $_FILES['profile-picture']['type'];
$imgTmpName = $_FILES['profile-picture']['tmp_name'];
$imgSize = $_FILES['profile-picture']['size'];
$uploadError = $_FILES['profile-picture']['error'];
$imgFormat = array("image/jpeg", "image/png", "image/jpg");



if (in_array($imgType, $imgFormat) && $imgSize < 16000000) {

        if (!file_exists("../profilePics\\" . $imgName)) {
            move_uploaded_file($imgTmpName, "../profilePics/" . $imgName);
            $resInsert = $db->profilePicsUpdate($uid, $imgName);

        } else{
            var_dump("Valami hatalmas hiba történt!");
        }

}else {
    var_dump("Hiba! Nem megfelelő fájlformátum, vagy a fájl túl nagy!");

}




header("Location: ../profile.php");
?>
