<?php
session_start();
require_once("connection.php");

if (!isset($_POST["register"])){
    die();
}

$db = new Database();

$user = trim($_POST["username"]);
$email = trim($_POST["email"]);
$pwd = trim($_POST["password"]);
$pwdc = trim($_POST["password-check"]);
$bdate = trim($_POST["birthday"]);



if (($pwd == $pwdc) && ($user != $pwd) && (strlen($user) > 6 ) && (strlen($pwd) > 6)){
    $hash = password_hash($pwd, PASSWORD_DEFAULT);
    $db ->insertUsersToDB($user,$email,$hash,$bdate);
    if ($db -> mysqli -> connect_errno == 0){
        $_SESSION['register'] = "Sikeres regisztráció!";

    } else {
        $_SESSION['register'] = "A regisztráció sikertelen!";
    }


}
header("Location: ../login.php");