<?php

session_start();
require_once('connection.php');

if (!isset($_SESSION['userID'])){
    die("A funkció használatához be kell jelentkezni!");
}


$db = new Database();

$db -> deleteProfilePicWhenModifyed();



$uid = $_SESSION['userID'];

$imgName = $_FILES['profile-picture']['name'];
$imgType = $_FILES['profile-picture']['type'];
$imgTmpName = $_FILES['profile-picture']['tmp_name'];
$imgSize = $_FILES['profile-picture']['size'];
$imgFormat = array("image/jpeg", "image/png", "image/jpg");



if (in_array($imgType, $imgFormat) && $imgSize < 16000000) {

        if (!file_exists("../profilePics\\" . $imgName)) {
            move_uploaded_file($imgTmpName, "../profilePics/" . $imgName);
            $resInsert = $db->profilePicsUpdate($uid, $imgName);

        } else{
            var_dump("Valami nem jó");
        }

}else {
    $sql_update = "UPDATE users SET picture = 'default.jpg' WHERE userid = $uid";
    $db -> mysqli -> query($sql_update);
    var_dump("Hiba! Nem megfelelő fájlformátum, vagy a fájl túl nagy!");

}


header("Location: ../profile.php");
?>
