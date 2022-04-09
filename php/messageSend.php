<?php
session_start();
require_once("connection.php");

if (!isset($_POST["send_message"])){
    echo "Halál";
    die();
}

$db = new Database();

$userID = $_SESSION["userID"];
$addressee = trim($_POST["cimzett"]);
$content = trim($_POST["content"]);

$sql_get_addressee_id = "SELECT userID FROM users where username = '$addressee'";


$res = $db -> mysqli ->query($sql_get_addressee_id);
$row = $res -> fetch_assoc();

$addressee_ID = (int)$row["userID"];


$db ->insertMessageToDB($userID,$addressee_ID,$content);


header("Location: ../inbox.php");
