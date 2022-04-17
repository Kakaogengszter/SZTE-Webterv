<?php

session_start();

require_once("connection.php");

if(!isset($_POST["delete_user_by_admin"])){
    header("location: ../profile.php");
}

$db = new Database();


$username = trim($_POST["username"]);
$errors = [];


if(empty($username)){
    $errors[] = "Üres értéket adsz át!";
}

if(count($errors) == 0){
    $username_id = $db -> get_user_id($username);
    if(empty($username_id)){
        $errors[] = "Nincs meg a felhasználó!";
    }
}

if(count($errors) == 0){

    $sql_delete_user_comments = "DELETE FROM comments WHERE user_id = $username_id";
    $sql_delete_user = "DELETE FROM users where id=$username_id";
    $sql_delete_recipes = "DELETE FROM recipes where user_id = $username_id";
    $sql_delete_messages = "DELETE FROM inbox where sender_id = $username_id OR receiver_id = $username_id";


    $db -> mysqli -> query($sql_delete_user_comments);
    $db -> mysqli -> query($sql_delete_user);
    $db -> mysqli -> query($sql_delete_recipes);
    $db -> mysqli -> query($sql_delete_messages);


    header("location: ../profile.php?siker_delete");
}else{
    header("location: ../profile.php");
}

$_SESSION["ban_error"] = $errors;



