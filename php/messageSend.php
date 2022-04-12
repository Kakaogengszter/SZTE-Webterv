<?php
session_start();
require_once("connection.php");




$db = new Database();
$userID = $_SESSION["userID"];
$addressee = trim($_POST["cimzett"]);
$content = trim($_POST["content"]);
$addressee_ID = $db->get_user_id($addressee);
$errors = [];


if(isset($_POST["send_message"])){

    $db ->insertMessageToDB($userID,$addressee_ID,$content);
    header("Location: ../inbox.php");

}else if(isset($_POST["user_check"])){

    $sql_check_user = "SELECT id FROM users WHERE id = $addressee_ID";

    $res = $db -> mysqli ->query($sql_check_user);
    $row = $res -> fetch_assoc();

    if(is_null($row)){
        $errors[] = "Nincs ilyen felhasználó!";
        header("LOCATION: ../inbox.php");
    }else{
        header("LOCATION: ../inbox.php?siker");
    }

    $_SESSION["error"] = $errors;
}
















